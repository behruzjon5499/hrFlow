/* global L, turf */
/* jshint esversion: 6 */

(function () {
    'use strict';

    // ---------------------------------------------------------------
    // State
    // ---------------------------------------------------------------
    var map, drawnItems, drawControl;
    var currentLayer        = null;
    var currentPolygonId    = null;
    var isNewPolygon        = false;
    var allNeighborhoods    = [];
    var selectedColor       = '#1e40af';
    var selectedZone        = 'residential';
    var notifyTimer         = null;
    var similarTags         = [];   // [{id, text}]
    var isSimilarSelectMode = false;

    // ---------------------------------------------------------------
    // Bootstrap
    // ---------------------------------------------------------------
    document.addEventListener('DOMContentLoaded', function () {
        initMap();
        initPanel();
        initSearch();
        loadPolygons();
    });

    // ---------------------------------------------------------------
    // Map initialisation
    // ---------------------------------------------------------------
    function initMap() {
        map = L.map('map', {
            center: [41.2995, 69.2401],
            zoom: 12,
            zoomControl: true
        });

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© <a href="https://www.openstreetmap.org/copyright" target="_blank">OpenStreetMap</a>',
            maxZoom: 19
        }).addTo(map);

        drawnItems = new L.FeatureGroup();
        map.addLayer(drawnItems);

        drawControl = new L.Control.Draw({
            position: 'topright',
            draw: {
                polygon: {
                    allowIntersection: false,
                    showArea: false,
                    shapeOptions: {
                        color: selectedColor,
                        fillColor: selectedColor,
                        fillOpacity: 0.25,
                        weight: 2
                    }
                },
                polyline:     false,
                rectangle:    false,
                circle:       false,
                marker:       false,
                circlemarker: false
            },
            edit: {
                featureGroup: drawnItems,
                remove: false
            }
        });
        map.addControl(drawControl);

        map.on(L.Draw.Event.CREATED, onPolygonCreated);
        map.on(L.Draw.Event.EDITED,  onPolygonEdited);

        map.on('click', function () {
            if (isSimilarSelectMode) {
                exitSimilarSelectMode();
                return;
            }
            if (isNewPolygon && currentLayer) return;
            closePanel();
        });
    }

    // ---------------------------------------------------------------
    // Load existing polygons from server
    // ---------------------------------------------------------------
    function loadPolygons() {
        fetch(window.mapUrls.list, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(function (r) { return r.json(); })
            .then(function (data) {
                if (data && data.features) {
                    data.features.forEach(addFeatureToMap);
                }
            })
            .catch(function () {
                showNotification('Polygonlarni yuklashda xatolik', 'error');
            });
    }

    function addFeatureToMap(feature) {
        var props = feature.properties;
        var color = props.color || '#1e40af';

        var geoLayer = L.geoJSON(feature, {
            style: function () {
                return {
                    color:       color,
                    fillColor:   color,
                    fillOpacity: 0.25,
                    weight:      2
                };
            }
        });

        geoLayer.eachLayer(function (layer) {
            layer._polygonId   = props.id;
            layer._polygonData = props;
            layer.on('click', onPolygonLayerClick);
            drawnItems.addLayer(layer);
        });
    }

    // ---------------------------------------------------------------
    // Draw events
    // ---------------------------------------------------------------
    function onPolygonCreated(e) {
        currentLayer     = e.layer;
        currentPolygonId = null;
        isNewPolygon     = true;

        if (checkOverlap(currentLayer, null)) {
            setTimeout(function () { map.removeLayer(currentLayer); currentLayer = null; }, 0);
            showNotification('Polygon boshqa polygon bilan kesishmoqda!', 'error');
            return;
        }

        drawnItems.addLayer(currentLayer);
        applyStyle(currentLayer, selectedColor);
        currentLayer.on('click', onPolygonLayerClick);
        openPanelForNew();
    }

    function onPolygonEdited(e) {
        e.layers.eachLayer(function (layer) {
            if (!layer._polygonId) return;
            var coords = layer.toGeoJSON().geometry.coordinates;
            fetch(window.mapUrls.save, {
                method: 'POST',
                headers: {
                    'Content-Type':    'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    id:                       layer._polygonId,
                    color:                    layer._polygonData.color,
                    zone_category:            layer._polygonData.zone_category,
                    region_id:                layer._polygonData.region_id,
                    district_id:              layer._polygonData.district_id,
                    primary_neighborhood_id:  layer._polygonData.primary_neighborhood_id,
                    similar_neighborhood_ids: layer._polygonData.similar_neighborhood_ids || [],
                    coordinates:              JSON.stringify(coords)
                })
            })
            .then(function (r) { return r.json(); })
            .then(function (res) {
                if (res.success) {
                    showNotification('Geometriya yangilandi', 'success');
                } else {
                    showNotification('Yangilashda xatolik: ' + (res.message || ''), 'error');
                }
            });
        });
    }

    // ---------------------------------------------------------------
    // Polygon click — dual-mode handler
    // ---------------------------------------------------------------
    function onPolygonLayerClick(e) {
        L.DomEvent.stopPropagation(e);

        if (isSimilarSelectMode) {
            onPolygonClickInSimilarMode(e.target);
            return;
        }

        currentLayer     = e.target;
        currentPolygonId = currentLayer._polygonId;
        isNewPolygon     = false;
        openPanelForExisting(currentLayer._polygonData);
    }

    // ---------------------------------------------------------------
    // Similar-select mode: click another polygon to add its mahalla
    // ---------------------------------------------------------------
    function onPolygonClickInSimilarMode(layer) {
        if (layer === currentLayer) {
            showNotification('Joriy polygonni o\'zini qo\'shib bo\'lmaydi', 'error');
            return;
        }

        var data = layer._polygonData;
        if (!data || !data.primary_neighborhood_id) {
            showNotification('Bu polygonda asosiy mahalla belgilanmagan', 'error');
            return;
        }

        var nId   = data.primary_neighborhood_id;
        var nName = data.primary_neighborhood_name || ('Mahalla #' + nId);

        addSimilarTag(nId, nName);
        exitSimilarSelectMode();
        showNotification('\'' + nName + '\' qo\'shildi', 'success');
    }

    // ---------------------------------------------------------------
    // Overlap detection using Turf.js
    // ---------------------------------------------------------------
    function checkOverlap(newLayer, excludeId) {
        var newGeoJson = newLayer.toGeoJSON();
        var overlaps   = false;

        drawnItems.eachLayer(function (layer) {
            if (overlaps) return;
            if (layer === newLayer) return;
            if (excludeId !== null && layer._polygonId === excludeId) return;

            try {
                var intersection = turf.intersect(newGeoJson, layer.toGeoJSON());
                if (intersection) overlaps = true;
            } catch (err) { /* ignore malformed geometries */ }
        });

        return overlaps;
    }

    // ---------------------------------------------------------------
    // Panel management
    // ---------------------------------------------------------------
    function initPanel() {
        id('select-region').addEventListener('change', function () {
            populateDistricts(this.value, null);
            clearNeighborhoodSelects();
            updateAddressDisplay();
        });

        id('select-district').addEventListener('change', function () {
            if (this.value) {
                fetchNeighborhoods(this.value, null, []);
            } else {
                clearNeighborhoodSelects();
            }
            updateAddressDisplay();
        });

        id('select-primary').addEventListener('change', function () {
            updateAddressDisplay();
        });
    }

    function openPanelForNew() {
        resetPanelFields();
        id('btn-delete').classList.add('hidden');
        id('btn-discard').classList.remove('hidden');
        id('panel-title-text').textContent = 'Yangi polygon';
        id('polygon-panel').classList.remove('hidden');
    }

    function openPanelForExisting(data) {
        resetPanelFields();

        selectColor(data.color || '#1e40af');
        selectZone(data.zone_category || 'residential');

        id('select-region').value = data.region_id || '';

        populateDistricts(data.region_id, data.district_id, function () {
            if (data.district_id) {
                fetchNeighborhoods(
                    data.district_id,
                    data.primary_neighborhood_id,
                    [],
                    function () { updateAddressDisplay(); }
                );
            } else {
                updateAddressDisplay();
            }
        });

        // Populate similar tags from saved names
        similarTags = [];
        var ids   = data.similar_neighborhood_ids   || [];
        var names = data.similar_neighborhood_names || [];
        ids.forEach(function (sid, i) {
            similarTags.push({ id: sid, text: names[i] || ('Mahalla #' + sid) });
        });
        renderSimilarTags();

        id('btn-delete').classList.remove('hidden');
        id('btn-discard').classList.add('hidden');
        id('panel-title-text').textContent = 'Polygon tafsilotlari';
        id('polygon-panel').classList.remove('hidden');
    }

    function closePanel() {
        exitSimilarSelectMode();
        id('polygon-panel').classList.add('hidden');
        currentLayer     = null;
        currentPolygonId = null;
        isNewPolygon     = false;
    }

    function resetPanelFields() {
        selectColor('#1e40af');
        selectZone('residential');
        id('select-region').value = '';
        populateDistricts(null, null);
        clearNeighborhoodSelects();
        similarTags = [];
        renderSimilarTags();
        updateAddressDisplay();
    }

    // ---------------------------------------------------------------
    // Address display
    // ---------------------------------------------------------------
    function updateAddressDisplay() {
        var parts      = [];
        var regionSel  = id('select-region');
        var districtSel = id('select-district');
        var primarySel = id('select-primary');

        if (regionSel.value && regionSel.selectedIndex >= 0) {
            parts.push(regionSel.options[regionSel.selectedIndex].text.trim());
        }
        if (districtSel.value && districtSel.selectedIndex >= 0) {
            parts.push(districtSel.options[districtSel.selectedIndex].text.trim());
        }
        if (primarySel.value && primarySel.selectedIndex >= 0) {
            parts.push(primarySel.options[primarySel.selectedIndex].text.trim());
        }

        id('address-display').value = parts.join(', ');
    }

    // ---------------------------------------------------------------
    // Color
    // ---------------------------------------------------------------
    function selectColor(color) {
        selectedColor = color;
        document.querySelectorAll('.color-btn').forEach(function (btn) {
            btn.classList.toggle('active', btn.dataset.color === color);
        });
        id('custom-color').value = color;
        if (currentLayer) applyStyle(currentLayer, color);
    }

    function applyStyle(layer, color) {
        if (layer && typeof layer.setStyle === 'function') {
            layer.setStyle({ color: color, fillColor: color, fillOpacity: 0.25 });
        }
    }

    // ---------------------------------------------------------------
    // Zone
    // ---------------------------------------------------------------
    function selectZone(zone) {
        selectedZone = zone;
        document.querySelectorAll('.zone-btn').forEach(function (btn) {
            btn.classList.toggle('active', btn.dataset.zone === zone);
        });
    }

    // ---------------------------------------------------------------
    // Districts (static data from window.mapData)
    // ---------------------------------------------------------------
    function populateDistricts(regionId, selectedDistrictId, callback) {
        var sel = id('select-district');
        sel.innerHTML = '<option value="">— Tumanni tanlang —</option>';

        if (!regionId) {
            if (callback) callback();
            return;
        }

        var districts = (window.mapData && window.mapData.districts)
            ? window.mapData.districts.filter(function (d) {
                return String(d.region_id) === String(regionId);
              })
            : [];

        districts.forEach(function (d) {
            var opt = new Option(d.title, d.id, false, String(d.id) === String(selectedDistrictId));
            sel.add(opt);
        });

        if (callback) callback();
    }

    // ---------------------------------------------------------------
    // Neighborhoods (fetched per district)
    // ---------------------------------------------------------------
    function fetchNeighborhoods(districtId, primaryId, similarIds, callback) {
        fetch(window.mapUrls.neighborhoods + '?district_id=' + districtId, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(function (r) { return r.json(); })
        .then(function (data) {
            allNeighborhoods = data;
            renderNeighborhoodSelects(primaryId);
            if (callback) callback();
        })
        .catch(function () {
            clearNeighborhoodSelects();
            if (callback) callback();
        });
    }

    function renderNeighborhoodSelects(primaryId) {
        var primarySel = id('select-primary');
        primarySel.innerHTML = '<option value="">— Mahallani tanlang —</option>';

        allNeighborhoods.forEach(function (n) {
            var isPrimary = primaryId && String(n.id) === String(primaryId);
            primarySel.add(new Option(n.text, n.id, false, isPrimary));
        });
    }

    function clearNeighborhoodSelects() {
        allNeighborhoods = [];
        id('select-primary').innerHTML = '<option value="">— Mahallani tanlang —</option>';
    }

    // ---------------------------------------------------------------
    // Similar tags
    // ---------------------------------------------------------------
    function addSimilarTag(tagId, tagText) {
        for (var i = 0; i < similarTags.length; i++) {
            if (String(similarTags[i].id) === String(tagId)) return; // already added
        }
        similarTags.push({ id: tagId, text: tagText });
        renderSimilarTags();
    }

    function removeSimilarTag(tagId) {
        similarTags = similarTags.filter(function (t) {
            return String(t.id) !== String(tagId);
        });
        renderSimilarTags();
    }

    function renderSimilarTags() {
        var container = id('similar-tags-container');
        container.innerHTML = '';

        if (similarTags.length === 0) {
            container.innerHTML = '<span class="similar-tags-empty">Hech narsa tanlanmagan</span>';
            return;
        }

        similarTags.forEach(function (tag) {
            var chip = document.createElement('span');
            chip.className = 'similar-tag';
            chip.innerHTML =
                '<span class="similar-tag-text">' + escHtml(tag.text) + '</span>' +
                '<button class="similar-tag-remove" title="O\'chirish" ' +
                        'onclick="window.mapPolygon.removeSimilarTag(\'' + String(tag.id) + '\')">' +
                    '&times;' +
                '</button>';
            container.appendChild(chip);
        });
    }

    // ---------------------------------------------------------------
    // Similar select mode
    // ---------------------------------------------------------------
    function enterSimilarSelectMode() {
        if (!currentLayer) {
            showNotification('Avval polygon tanlang', 'error');
            return;
        }
        isSimilarSelectMode = true;
        id('map').classList.add('map-similar-select-mode');
        id('btn-add-similar').textContent = '✕ Bekor qilish';
        id('btn-add-similar').classList.add('selecting');
        id('similar-select-hint').classList.remove('hidden');
    }

    function exitSimilarSelectMode() {
        isSimilarSelectMode = false;
        id('map').classList.remove('map-similar-select-mode');
        var btn = id('btn-add-similar');
        if (btn) {
            btn.textContent = '+ Xaritadan tanlash';
            btn.classList.remove('selecting');
        }
        var hint = id('similar-select-hint');
        if (hint) hint.classList.add('hidden');
    }

    // ---------------------------------------------------------------
    // Save
    // ---------------------------------------------------------------
    function savePolygon() {
        if (!currentLayer) {
            showNotification('Polygon tanlanmagan', 'error');
            return;
        }

        var coords     = currentLayer.toGeoJSON().geometry.coordinates;
        var similarIds = similarTags.map(function (t) { return parseInt(t.id, 10); });

        var primaryName = '';
        var primarySel  = id('select-primary');
        if (primarySel.value && primarySel.selectedIndex >= 0) {
            primaryName = primarySel.options[primarySel.selectedIndex].text.trim();
        }

        var payload = {
            id:                       currentPolygonId,
            color:                    selectedColor,
            zone_category:            selectedZone,
            region_id:                id('select-region').value   || null,
            district_id:              id('select-district').value || null,
            primary_neighborhood_id:  primarySel.value            || null,
            similar_neighborhood_ids: similarIds,
            coordinates:              JSON.stringify(coords)
        };

        fetch(window.mapUrls.save, {
            method: 'POST',
            headers: {
                'Content-Type':    'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(payload)
        })
        .then(function (r) { return r.json(); })
        .then(function (result) {
            if (result.success) {
                currentLayer._polygonId   = result.id;
                currentLayer._polygonData = Object.assign({}, payload, {
                    id: result.id,
                    primary_neighborhood_name:   primaryName,
                    similar_neighborhood_names:  similarTags.map(function (t) { return t.text; })
                });
                applyStyle(currentLayer, selectedColor);
                showNotification('Polygon saqlandi!', 'success');
                closePanel();
            } else {
                showNotification('Xatolik: ' + (result.message || 'Noma\'lum xatolik'), 'error');
            }
        })
        .catch(function () {
            showNotification('Server bilan bog\'lanishda xatolik', 'error');
        });
    }

    // ---------------------------------------------------------------
    // Delete
    // ---------------------------------------------------------------
    function deletePolygon() {
        if (!currentPolygonId) return;
        if (!confirm('Polygonni o\'chirishni tasdiqlaysizmi?')) return;

        fetch(window.mapUrls.delete, {
            method: 'POST',
            headers: {
                'Content-Type':    'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ id: currentPolygonId })
        })
        .then(function (r) { return r.json(); })
        .then(function (result) {
            if (result.success) {
                drawnItems.removeLayer(currentLayer);
                showNotification('Polygon o\'chirildi', 'success');
                closePanel();
            } else {
                showNotification('O\'chirishda xatolik: ' + (result.message || ''), 'error');
            }
        })
        .catch(function () {
            showNotification('Server bilan bog\'lanishda xatolik', 'error');
        });
    }

    // ---------------------------------------------------------------
    // Discard unsaved new polygon
    // ---------------------------------------------------------------
    function discardPolygon() {
        if (isNewPolygon && currentLayer) {
            drawnItems.removeLayer(currentLayer);
        }
        closePanel();
    }

    // ---------------------------------------------------------------
    // Toast notification
    // ---------------------------------------------------------------
    function showNotification(message, type) {
        var el = id('map-notification');
        el.textContent = message;
        el.className   = 'map-notification ' + type + ' show';
        if (notifyTimer) clearTimeout(notifyTimer);
        notifyTimer = setTimeout(function () {
            el.classList.remove('show');
        }, 3000);
    }

    // ---------------------------------------------------------------
    // Helpers
    // ---------------------------------------------------------------
    function id(elId) {
        return document.getElementById(elId);
    }

    function escHtml(str) {
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g,  '&lt;')
            .replace(/>/g,  '&gt;')
            .replace(/"/g,  '&quot;');
    }

    // ---------------------------------------------------------------
    // Search (Nominatim geocoding)
    // ---------------------------------------------------------------
    var searchDebounceTimer = null;
    var searchMarker        = null;
    var searchMarkerTimer   = null;
    var searchResults       = [];
    var searchActiveIndex   = -1;

    var NOMINATIM_URL = 'https://nominatim.openstreetmap.org/search';
    var NOMINATIM_PARAMS = 'format=json&limit=6&addressdetails=1&countrycodes=uz' +
        '&viewbox=55.9,37.1,73.1,45.6&bounded=0&accept-language=uz,ru';

    function initSearch() {
        var inp = id('map-search-input');

        inp.addEventListener('input', function () {
            var q = this.value.trim();
            id('map-search-clear').classList.toggle('hidden', q === '');
            clearTimeout(searchDebounceTimer);
            if (q.length < 2) {
                hideSearchResults();
                return;
            }
            searchDebounceTimer = setTimeout(function () { doSearch(q); }, 380);
        });

        inp.addEventListener('keydown', function (e) {
            if (e.key === 'ArrowDown') {
                e.preventDefault();
                setSearchActive(Math.min(searchActiveIndex + 1, searchResults.length - 1));
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                setSearchActive(Math.max(searchActiveIndex - 1, 0));
            } else if (e.key === 'Enter') {
                e.preventDefault();
                if (searchActiveIndex >= 0 && searchResults[searchActiveIndex]) {
                    selectSearchResult(searchResults[searchActiveIndex]);
                } else if (searchResults.length > 0) {
                    selectSearchResult(searchResults[0]);
                }
            } else if (e.key === 'Escape') {
                hideSearchResults();
                inp.blur();
            }
        });

        id('map-search-clear').addEventListener('click', function () {
            inp.value = '';
            this.classList.add('hidden');
            hideSearchResults();
            inp.focus();
        });

        // Close results when clicking outside
        document.addEventListener('click', function (e) {
            if (!id('map-search').contains(e.target)) {
                hideSearchResults();
            }
        });

        // Prevent map click from closing panel when clicking on search
        id('map-search').addEventListener('click', function (e) {
            e.stopPropagation();
        });
    }

    function doSearch(query) {
        var list = id('map-search-results');
        list.innerHTML = '<li class="map-search-loading"><span class="map-search-spinner"></span>Qidirilmoqda…</li>';
        list.classList.remove('hidden');

        var url = NOMINATIM_URL + '?' + NOMINATIM_PARAMS + '&q=' + encodeURIComponent(query);

        fetch(url, {
            headers: { 'Accept-Language': 'uz,ru', 'User-Agent': 'evalue-map/1.0' }
        })
        .then(function (r) { return r.json(); })
        .then(function (data) {
            searchResults    = data || [];
            searchActiveIndex = -1;
            renderSearchResults(searchResults);
        })
        .catch(function () {
            list.innerHTML = '<li class="map-search-empty">Qidiruvda xatolik yuz berdi</li>';
        });
    }

    function renderSearchResults(results) {
        var list = id('map-search-results');
        list.innerHTML = '';

        if (!results.length) {
            list.innerHTML = '<li class="map-search-empty">Natija topilmadi</li>';
            return;
        }

        results.forEach(function (item, i) {
            var name   = item.name || item.display_name.split(',')[0];
            var detail = buildResultDetail(item);

            var li = document.createElement('li');
            li.className = 'map-search-item';
            li.setAttribute('data-index', i);
            li.innerHTML =
                '<svg class="map-search-item-icon" xmlns="http://www.w3.org/2000/svg" width="14" height="14"' +
                '     fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">' +
                '  <path stroke-linecap="round" stroke-linejoin="round"' +
                '        d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>' +
                '  <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>' +
                '</svg>' +
                '<div class="map-search-item-body">' +
                '  <div class="map-search-item-name">' + escHtml(name) + '</div>' +
                '  <div class="map-search-item-detail">' + escHtml(detail) + '</div>' +
                '</div>';

            li.addEventListener('click', function () { selectSearchResult(item); });
            li.addEventListener('mouseover', function () {
                searchActiveIndex = i;
                highlightSearchItems();
            });
            list.appendChild(li);
        });
    }

    function buildResultDetail(item) {
        var addr = item.address || {};
        var parts = [];
        if (addr.city)          parts.push(addr.city);
        else if (addr.town)     parts.push(addr.town);
        else if (addr.village)  parts.push(addr.village);
        if (addr.state)         parts.push(addr.state);
        if (addr.country)       parts.push(addr.country);
        if (!parts.length) {
            var segs = item.display_name.split(',');
            return segs.slice(1, 4).map(function (s) { return s.trim(); }).join(', ');
        }
        return parts.join(', ');
    }

    function selectSearchResult(item) {
        var lat  = parseFloat(item.lat);
        var lon  = parseFloat(item.lon);
        var name = item.name || item.display_name.split(',')[0];
        var bbox = item.boundingbox; // [south, north, west, east]

        id('map-search-input').value = name;
        id('map-search-clear').classList.remove('hidden');
        hideSearchResults();

        // Fly to location
        if (bbox && bbox.length === 4) {
            map.fitBounds([
                [parseFloat(bbox[0]), parseFloat(bbox[2])],
                [parseFloat(bbox[1]), parseFloat(bbox[3])]
            ], { maxZoom: 16, animate: true, duration: 0.8 });
        } else {
            map.flyTo([lat, lon], 15, { animate: true, duration: 0.8 });
        }

        // Temporary marker
        if (searchMarker) {
            map.removeLayer(searchMarker);
        }
        if (searchMarkerTimer) {
            clearTimeout(searchMarkerTimer);
        }

        searchMarker = L.marker([lat, lon], {
            icon: L.divIcon({
                className: '',
                html: '<div class="search-marker-pin"></div>',
                iconSize:   [24, 36],
                iconAnchor: [12, 36],
                popupAnchor: [0, -36]
            })
        }).addTo(map);

        searchMarker.bindPopup(
            '<strong>' + escHtml(name) + '</strong><br>' +
            '<small>' + escHtml(buildResultDetail(item)) + '</small>',
            { closeButton: false, offset: [0, -4] }
        ).openPopup();

        searchMarkerTimer = setTimeout(function () {
            if (searchMarker) {
                map.removeLayer(searchMarker);
                searchMarker = null;
            }
        }, 6000);
    }

    function setSearchActive(index) {
        searchActiveIndex = index;
        highlightSearchItems();
        var items = id('map-search-results').querySelectorAll('.map-search-item');
        if (items[index]) {
            items[index].scrollIntoView({ block: 'nearest' });
        }
    }

    function highlightSearchItems() {
        id('map-search-results').querySelectorAll('.map-search-item').forEach(function (li, i) {
            li.classList.toggle('active', i === searchActiveIndex);
        });
    }

    function hideSearchResults() {
        var list = id('map-search-results');
        list.classList.add('hidden');
        list.innerHTML = '';
        searchResults     = [];
        searchActiveIndex = -1;
    }

    // ---------------------------------------------------------------
    // Expose to HTML onclick attributes
    // ---------------------------------------------------------------
    window.mapPolygon = {
        selectColor:            selectColor,
        selectZone:             selectZone,
        savePolygon:            savePolygon,
        deletePolygon:          deletePolygon,
        discardPolygon:         discardPolygon,
        closePanel:             closePanel,
        removeSimilarTag:       removeSimilarTag,
        enterSimilarSelectMode: enterSimilarSelectMode,
        exitSimilarSelectMode:  exitSimilarSelectMode
    };

})();
