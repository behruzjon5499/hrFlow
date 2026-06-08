<?php
/** Adminer - Compact database management
 * @link https://www.adminer.org/
 * @author Jakub Vrana, https://www.vrana.cz/
 * @copyright 2007 Jakub Vrana
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
 * @version 4.8.1
 */
function
adminer_errors($Ac, $Cc)
{
    return !!preg_match('~^(Trying to access array offset on value of type null|Undefined array key)~', $Cc);
}

error_reporting(6135);
set_error_handler('adminer_errors', E_WARNING);
$Yc = !preg_match('~^(unsafe_raw)?$~', ini_get("filter.default"));
if ($Yc || ini_get("filter.default_flags")) {
    foreach (array('_GET', '_POST', '_COOKIE', '_SERVER') as $X) {
        $Fi = filter_input_array(constant("INPUT$X"), FILTER_UNSAFE_RAW);
        if ($Fi) $$X = $Fi;
    }
}
if (function_exists("mb_internal_encoding")) mb_internal_encoding("8bit");
function
connection()
{
    global $g;
    return $g;
}

function
adminer()
{
    global $b;
    return $b;
}

function
version()
{
    global $ia;
    return $ia;
}

function
idf_unescape($v)
{
    if (!preg_match('~^[`\'"]~', $v)) return $v;
    $ne = substr($v, -1);
    return
        str_replace($ne . $ne, $ne, substr($v, 1, -1));
}

function
escape_string($X)
{
    return
        substr(q($X), 1, -1);
}

function
number($X)
{
    return
        preg_replace('~[^0-9]+~', '', $X);
}

function
number_type()
{
    return '((?<!o)int(?!er)|numeric|real|float|double|decimal|money)';
}

function
remove_slashes($qg, $Yc = false)
{
    if (function_exists("get_magic_quotes_gpc") && get_magic_quotes_gpc()) {
        while (list($z, $X) = each($qg)) {
            foreach ($X
                     as $fe => $W) {
                unset($qg[$z][$fe]);
                if (is_array($W)) {
                    $qg[$z][stripslashes($fe)] = $W;
                    $qg[] =& $qg[$z][stripslashes($fe)];
                } else$qg[$z][stripslashes($fe)] = ($Yc ? $W : stripslashes($W));
            }
        }
    }
}

function
bracket_escape($v, $Ma = false)
{
    static $ri = array(':' => ':1', ']' => ':2', '[' => ':3', '"' => ':4');
    return
        strtr($v, ($Ma ? array_flip($ri) : $ri));
}

function
min_version($Wi, $Ae = "", $h = null)
{
    global $g;
    if (!$h) $h = $g;
    $kh = $h->server_info;
    if ($Ae && preg_match('~([\d.]+)-MariaDB~', $kh, $C)) {
        $kh = $C[1];
        $Wi = $Ae;
    }
    return (version_compare($kh, $Wi) >= 0);
}

function
charset($g)
{
    return (min_version("5.5.3", 0, $g) ? "utf8mb4" : "utf8");
}

function
script($vh, $qi = "\n")
{
    return "<script" . nonce() . ">$vh</script>$qi";
}

function
script_src($Ki)
{
    return "<script src='" . h($Ki) . "'" . nonce() . "></script>\n";
}

function
nonce()
{
    return ' nonce="' . get_nonce() . '"';
}

function
target_blank()
{
    return ' target="_blank" rel="noreferrer noopener"';
}

function
h($P)
{
    return
        str_replace("\0", "&#0;", htmlspecialchars($P, ENT_QUOTES, 'utf-8'));
}

function
nl_br($P)
{
    return
        str_replace("\n", "<br>", $P);
}

function
checkbox($D, $Y, $cb, $ke = "", $rf = "", $gb = "", $le = "")
{
    $I = "<input type='checkbox' name='$D' value='" . h($Y) . "'" . ($cb ? " checked" : "") . ($le ? " aria-labelledby='$le'" : "") . ">" . ($rf ? script("qsl('input').onclick = function () { $rf };", "") : "");
    return ($ke != "" || $gb ? "<label" . ($gb ? " class='$gb'" : "") . ">$I" . h($ke) . "</label>" : $I);
}

function
optionlist($xf, $dh = null, $Oi = false)
{
    $I = "";
    foreach ($xf
             as $fe => $W) {
        $yf = array($fe => $W);
        if (is_array($W)) {
            $I .= '<optgroup label="' . h($fe) . '">';
            $yf = $W;
        }
        foreach ($yf
                 as $z => $X) $I .= '<option' . ($Oi || is_string($z) ? ' value="' . h($z) . '"' : '') . (($Oi || is_string($z) ? (string)$z : $X) === $dh ? ' selected' : '') . '>' . h($X);
        if (is_array($W)) $I .= '</optgroup>';
    }
    return $I;
}

function
html_select($D, $xf, $Y = "", $qf = true, $le = "")
{
    if ($qf) return "<select name='" . h($D) . "'" . ($le ? " aria-labelledby='$le'" : "") . ">" . optionlist($xf, $Y) . "</select>" . (is_string($qf) ? script("qsl('select').onchange = function () { $qf };", "") : "");
    $I = "";
    foreach ($xf
             as $z => $X) $I .= "<label><input type='radio' name='" . h($D) . "' value='" . h($z) . "'" . ($z == $Y ? " checked" : "") . ">" . h($X) . "</label>";
    return $I;
}

function
select_input($Ha, $xf, $Y = "", $qf = "", $cg = "")
{
    $Vh = ($xf ? "select" : "input");
    return "<$Vh$Ha" . ($xf ? "><option value=''>$cg" . optionlist($xf, $Y, true) . "</select>" : " size='10' value='" . h($Y) . "' placeholder='$cg'>") . ($qf ? script("qsl('$Vh').onchange = $qf;", "") : "");
}

function
confirm($Ke = "", $eh = "qsl('input')")
{
    return
        script("$eh.onclick = function () { return confirm('" . ($Ke ? js_escape($Ke) : 'Are you sure?') . "'); };", "");
}

function
print_fieldset($u, $se, $Zi = false)
{
    echo "<fieldset><legend>", "<a href='#fieldset-$u'>$se</a>", script("qsl('a').onclick = partial(toggle, 'fieldset-$u');", ""), "</legend>", "<div id='fieldset-$u'" . ($Zi ? "" : " class='hidden'") . ">\n";
}

function
bold($Ta, $gb = "")
{
    return ($Ta ? " class='active $gb'" : ($gb ? " class='$gb'" : ""));
}

function
odd($I = ' class="odd"')
{
    static $t = 0;
    if (!$I) $t = -1;
    return ($t++ % 2 ? $I : '');
}

function
js_escape($P)
{
    return
        addcslashes($P, "\r\n'\\/");
}

function
json_row($z, $X = null)
{
    static $Zc = true;
    if ($Zc) echo "{";
    if ($z != "") {
        echo ($Zc ? "" : ",") . "\n\t\"" . addcslashes($z, "\r\n\t\"\\/") . '": ' . ($X !== null ? '"' . addcslashes($X, "\r\n\"\\/") . '"' : 'null');
        $Zc = false;
    } else {
        echo "\n}\n";
        $Zc = true;
    }
}

function
ini_bool($Sd)
{
    $X = ini_get($Sd);
    return (preg_match('~^(on|true|yes)$~i', $X) || (int)$X);
}

function
sid()
{
    static $I;
    if ($I === null) $I = (SID && !($_COOKIE && ini_bool("session.use_cookies")));
    return $I;
}

function
set_password($Vi, $M, $V, $F)
{
    $_SESSION["pwds"][$Vi][$M][$V] = ($_COOKIE["adminer_key"] && is_string($F) ? array(encrypt_string($F, $_COOKIE["adminer_key"])) : $F);
}

function
get_password()
{
    $I = get_session("pwds");
    if (is_array($I)) $I = ($_COOKIE["adminer_key"] ? decrypt_string($I[0], $_COOKIE["adminer_key"]) : false);
    return $I;
}

function
q($P)
{
    global $g;
    return $g->quote($P);
}

function
get_vals($G, $e = 0)
{
    global $g;
    $I = array();
    $H = $g->query($G);
    if (is_object($H)) {
        while ($J = $H->fetch_row()) $I[] = $J[$e];
    }
    return $I;
}

function
get_key_vals($G, $h = null, $nh = true)
{
    global $g;
    if (!is_object($h)) $h = $g;
    $I = array();
    $H = $h->query($G);
    if (is_object($H)) {
        while ($J = $H->fetch_row()) {
            if ($nh) $I[$J[0]] = $J[1]; else$I[] = $J[0];
        }
    }
    return $I;
}

function
get_rows($G, $h = null, $n = "<p class='error'>")
{
    global $g;
    $wb = (is_object($h) ? $h : $g);
    $I = array();
    $H = $wb->query($G);
    if (is_object($H)) {
        while ($J = $H->fetch_assoc()) $I[] = $J;
    } elseif (!$H && !is_object($h) && $n && defined("PAGE_HEADER")) echo $n . error() . "\n";
    return $I;
}

function
unique_array($J, $x)
{
    foreach ($x
             as $w) {
        if (preg_match("~PRIMARY|UNIQUE~", $w["type"])) {
            $I = array();
            foreach ($w["columns"] as $z) {
                if (!isset($J[$z])) continue
                2;
                $I[$z] = $J[$z];
            }
            return $I;
        }
    }
}

function
escape_key($z)
{
    if (preg_match('(^([\w(]+)(' . str_replace("_", ".*", preg_quote(idf_escape("_"))) . ')([ \w)]+)$)', $z, $C)) return $C[1] . idf_escape(idf_unescape($C[2])) . $C[3];
    return
        idf_escape($z);
}

function
where($Z, $p = array())
{
    global $g, $y;
    $I = array();
    foreach ((array)$Z["where"] as $z => $X) {
        $z = bracket_escape($z, 1);
        $e = escape_key($z);
        $I[] = $e . ($y == "sql" && is_numeric($X) && preg_match('~\.~', $X) ? " LIKE " . q($X) : ($y == "mssql" ? " LIKE " . q(preg_replace('~[_%[]~', '[\0]', $X)) : " = " . unconvert_field($p[$z], q($X))));
        if ($y == "sql" && preg_match('~char|text~', $p[$z]["type"]) && preg_match("~[^ -@]~", $X)) $I[] = "$e = " . q($X) . " COLLATE " . charset($g) . "_bin";
    }
    foreach ((array)$Z["null"] as $z) $I[] = escape_key($z) . " IS NULL";
    return
        implode(" AND ", $I);
}

function
where_check($X, $p = array())
{
    parse_str($X, $ab);
    remove_slashes(array(&$ab));
    return
        where($ab, $p);
}

function
where_link($t, $e, $Y, $tf = "=")
{
    return "&where%5B$t%5D%5Bcol%5D=" . urlencode($e) . "&where%5B$t%5D%5Bop%5D=" . urlencode(($Y !== null ? $tf : "IS NULL")) . "&where%5B$t%5D%5Bval%5D=" . urlencode($Y);
}

function
convert_fields($f, $p, $L = array())
{
    $I = "";
    foreach ($f
             as $z => $X) {
        if ($L && !in_array(idf_escape($z), $L)) continue;
        $Fa = convert_field($p[$z]);
        if ($Fa) $I .= ", $Fa AS " . idf_escape($z);
    }
    return $I;
}

function
cookie($D, $Y, $ve = 2592000)
{
    global $ba;
    return
        header("Set-Cookie: $D=" . urlencode($Y) . ($ve ? "; expires=" . gmdate("D, d M Y H:i:s", time() + $ve) . " GMT" : "") . "; path=" . preg_replace('~\?.*~', '', $_SERVER["REQUEST_URI"]) . ($ba ? "; secure" : "") . "; HttpOnly; SameSite=lax", false);
}

function
restart_session()
{
    if (!ini_bool("session.use_cookies")) session_start();
}

function
stop_session($ed = false)
{
    $Ni = ini_bool("session.use_cookies");
    if (!$Ni || $ed) {
        session_write_close();
        if ($Ni && @ini_set("session.use_cookies", false) === false) session_start();
    }
}

function&get_session($z)
{
    return $_SESSION[$z][DRIVER][SERVER][$_GET["username"]];
}

function
set_session($z, $X)
{
    $_SESSION[$z][DRIVER][SERVER][$_GET["username"]] = $X;
}

function
auth_url($Vi, $M, $V, $l = null)
{
    global $ic;
    preg_match('~([^?]*)\??(.*)~', remove_from_uri(implode("|", array_keys($ic)) . "|username|" . ($l !== null ? "db|" : "") . session_name()), $C);
    return "$C[1]?" . (sid() ? SID . "&" : "") . ($Vi != "server" || $M != "" ? urlencode($Vi) . "=" . urlencode($M) . "&" : "") . "username=" . urlencode($V) . ($l != "" ? "&db=" . urlencode($l) : "") . ($C[2] ? "&$C[2]" : "");
}

function
is_ajax()
{
    return ($_SERVER["HTTP_X_REQUESTED_WITH"] == "XMLHttpRequest");
}

function
redirect($B, $Ke = null)
{
    if ($Ke !== null) {
        restart_session();
        $_SESSION["messages"][preg_replace('~^[^?]*~', '', ($B !== null ? $B : $_SERVER["REQUEST_URI"]))][] = $Ke;
    }
    if ($B !== null) {
        if ($B == "") $B = ".";
        header("Location: $B");
        exit;
    }
}

function
query_redirect($G, $B, $Ke, $Ag = true, $Hc = true, $Rc = false, $di = "")
{
    global $g, $n, $b;
    if ($Hc) {
        $Ch = microtime(true);
        $Rc = !$g->query($G);
        $di = format_time($Ch);
    }
    $yh = "";
    if ($G) $yh = $b->messageQuery($G, $di, $Rc);
    if ($Rc) {
        $n = error() . $yh . script("messagesPrint();");
        return
            false;
    }
    if ($Ag) redirect($B, $Ke . $yh);
    return
        true;
}

function
queries($G)
{
    global $g;
    static $vg = array();
    static $Ch;
    if (!$Ch) $Ch = microtime(true);
    if ($G === null) return
        array(implode("\n", $vg), format_time($Ch));
    $vg[] = (preg_match('~;$~', $G) ? "DELIMITER ;;\n$G;\nDELIMITER " : $G) . ";";
    return $g->query($G);
}

function
apply_queries($G, $S, $Dc = 'table')
{
    foreach ($S
             as $Q) {
        if (!queries("$G " . $Dc($Q))) return
            false;
    }
    return
        true;
}

function
queries_redirect($B, $Ke, $Ag)
{
    list($vg, $di) = queries(null);
    return
        query_redirect($vg, $B, $Ke, $Ag, false, !$Ag, $di);
}

function
format_time($Ch)
{
    return
        sprintf('%.3f s', max(0, microtime(true) - $Ch));
}

function
relative_uri()
{
    return
        str_replace(":", "%3a", preg_replace('~^[^?]*/([^?]*)~', '\1', $_SERVER["REQUEST_URI"]));
}

function
remove_from_uri($Nf = "")
{
    return
        substr(preg_replace("~(?<=[?&])($Nf" . (SID ? "" : "|" . session_name()) . ")=[^&]*&~", '', relative_uri() . "&"), 0, -1);
}

function
pagination($E, $Nb)
{
    return " " . ($E == $Nb ? $E + 1 : '<a href="' . h(remove_from_uri("page") . ($E ? "&page=$E" . ($_GET["next"] ? "&next=" . urlencode($_GET["next"]) : "") : "")) . '">' . ($E + 1) . "</a>");
}

function
get_file($z, $Vb = false)
{
    $Xc = $_FILES[$z];
    if (!$Xc) return
        null;
    foreach ($Xc
             as $z => $X) $Xc[$z] = (array)$X;
    $I = '';
    foreach ($Xc["error"] as $z => $n) {
        if ($n) return $n;
        $D = $Xc["name"][$z];
        $li = $Xc["tmp_name"][$z];
        $Bb = file_get_contents($Vb && preg_match('~\.gz$~', $D) ? "compress.zlib://$li" : $li);
        if ($Vb) {
            $Ch = substr($Bb, 0, 3);
            if (function_exists("iconv") && preg_match("~^\xFE\xFF|^\xFF\xFE~", $Ch, $Gg)) $Bb = iconv("utf-16", "utf-8", $Bb); elseif ($Ch == "\xEF\xBB\xBF") $Bb = substr($Bb, 3);
            $I .= $Bb . "\n\n";
        } else$I .= $Bb;
    }
    return $I;
}

function
upload_error($n)
{
    $He = ($n == UPLOAD_ERR_INI_SIZE ? ini_get("upload_max_filesize") : 0);
    return ($n ? 'Unable to upload a file.' . ($He ? " " . sprintf('Maximum allowed file size is %sB.', $He) : "") : 'File does not exist.');
}

function
repeat_pattern($Zf, $te)
{
    return
        str_repeat("$Zf{0,65535}", $te / 65535) . "$Zf{0," . ($te % 65535) . "}";
}

function
is_utf8($X)
{
    return (preg_match('~~u', $X) && !preg_match('~[\0-\x8\xB\xC\xE-\x1F]~', $X));
}

function
shorten_utf8($P, $te = 80, $Jh = "")
{
    if (!preg_match("(^(" . repeat_pattern("[\t\r\n -\x{10FFFF}]", $te) . ")($)?)u", $P, $C)) preg_match("(^(" . repeat_pattern("[\t\r\n -~]", $te) . ")($)?)", $P, $C);
    return
        h($C[1]) . $Jh . (isset($C[2]) ? "" : "<i>â€¦</i>");
}

function
format_number($X)
{
    return
        strtr(number_format($X, 0, ".", ','), preg_split('~~u', '0123456789', -1, PREG_SPLIT_NO_EMPTY));
}

function
friendly_url($X)
{
    return
        preg_replace('~[^a-z0-9_]~i', '-', $X);
}

function
hidden_fields($qg, $Hd = array(), $ig = '')
{
    $I = false;
    foreach ($qg
             as $z => $X) {
        if (!in_array($z, $Hd)) {
            if (is_array($X)) hidden_fields($X, array(), $z); else {
                $I = true;
                echo '<input type="hidden" name="' . h($ig ? $ig . "[$z]" : $z) . '" value="' . h($X) . '">';
            }
        }
    }
    return $I;
}

function
hidden_fields_get()
{
    echo(sid() ? '<input type="hidden" name="' . session_name() . '" value="' . h(session_id()) . '">' : ''), (SERVER !== null ? '<input type="hidden" name="' . DRIVER . '" value="' . h(SERVER) . '">' : ""), '<input type="hidden" name="username" value="' . h($_GET["username"]) . '">';
}

function
table_status1($Q, $Sc = false)
{
    $I = table_status($Q, $Sc);
    return ($I ? $I : array("Name" => $Q));
}

function
column_foreign_keys($Q)
{
    global $b;
    $I = array();
    foreach ($b->foreignKeys($Q) as $r) {
        foreach ($r["source"] as $X) $I[$X][] = $r;
    }
    return $I;
}

function
enum_input($T, $Ha, $o, $Y, $xc = null)
{
    global $b;
    preg_match_all("~'((?:[^']|'')*)'~", $o["length"], $Ce);
    $I = ($xc !== null ? "<label><input type='$T'$Ha value='$xc'" . ((is_array($Y) ? in_array($xc, $Y) : $Y === 0) ? " checked" : "") . "><i>" . 'empty' . "</i></label>" : "");
    foreach ($Ce[1] as $t => $X) {
        $X = stripcslashes(str_replace("''", "'", $X));
        $cb = (is_int($Y) ? $Y == $t + 1 : (is_array($Y) ? in_array($t + 1, $Y) : $Y === $X));
        $I .= " <label><input type='$T'$Ha value='" . ($t + 1) . "'" . ($cb ? ' checked' : '') . '>' . h($b->editVal($X, $o)) . '</label>';
    }
    return $I;
}

function
input($o, $Y, $s)
{
    global $U, $b, $y;
    $D = h(bracket_escape($o["field"]));
    echo "<td class='function'>";
    if (is_array($Y) && !$s) {
        $Da = array($Y);
        if (version_compare(PHP_VERSION, 5.4) >= 0) $Da[] = JSON_PRETTY_PRINT;
        $Y = call_user_func_array('json_encode', $Da);
        $s = "json";
    }
    $Kg = ($y == "mssql" && $o["auto_increment"]);
    if ($Kg && !$_POST["save"]) $s = null;
    $nd = (isset($_GET["select"]) || $Kg ? array("orig" => 'original') : array()) + $b->editFunctions($o);
    $Ha = " name='fields[$D]'";
    if ($o["type"] == "enum") echo
        h($nd[""]) . "<td>" . $b->editInput($_GET["edit"], $o, $Ha, $Y); else {
        $xd = (in_array($s, $nd) || isset($nd[$s]));
        echo (count($nd) > 1 ? "<select name='function[$D]'>" . optionlist($nd, $s === null || $xd ? $s : "") . "</select>" . on_help("getTarget(event).value.replace(/^SQL\$/, '')", 1) . script("qsl('select').onchange = functionChange;", "") : h(reset($nd))) . '<td>';
        $Ud = $b->editInput($_GET["edit"], $o, $Ha, $Y);
        if ($Ud != "") echo $Ud; elseif (preg_match('~bool~', $o["type"])) echo "<input type='hidden'$Ha value='0'>" . "<input type='checkbox'" . (preg_match('~^(1|t|true|y|yes|on)$~i', $Y) ? " checked='checked'" : "") . "$Ha value='1'>";
        elseif ($o["type"] == "set") {
            preg_match_all("~'((?:[^']|'')*)'~", $o["length"], $Ce);
            foreach ($Ce[1] as $t => $X) {
                $X = stripcslashes(str_replace("''", "'", $X));
                $cb = (is_int($Y) ? ($Y >> $t) & 1 : in_array($X, explode(",", $Y), true));
                echo " <label><input type='checkbox' name='fields[$D][$t]' value='" . (1 << $t) . "'" . ($cb ? ' checked' : '') . ">" . h($b->editVal($X, $o)) . '</label>';
            }
        } elseif (preg_match('~blob|bytea|raw|file~', $o["type"]) && ini_bool("file_uploads")) echo "<input type='file' name='fields-$D'>";
        elseif (($bi = preg_match('~text|lob|memo~i', $o["type"])) || preg_match("~\n~", $Y)) {
            if ($bi && $y != "sqlite") $Ha .= " cols='50' rows='12'"; else {
                $K = min(12, substr_count($Y, "\n") + 1);
                $Ha .= " cols='30' rows='$K'" . ($K == 1 ? " style='height: 1.2em;'" : "");
            }
            echo "<textarea$Ha>" . h($Y) . '</textarea>';
        } elseif ($s == "json" || preg_match('~^jsonb?$~', $o["type"])) echo "<textarea$Ha cols='50' rows='12' class='jush-js'>" . h($Y) . '</textarea>';
        else {
            $Je = (!preg_match('~int~', $o["type"]) && preg_match('~^(\d+)(,(\d+))?$~', $o["length"], $C) ? ((preg_match("~binary~", $o["type"]) ? 2 : 1) * $C[1] + ($C[3] ? 1 : 0) + ($C[2] && !$o["unsigned"] ? 1 : 0)) : ($U[$o["type"]] ? $U[$o["type"]] + ($o["unsigned"] ? 0 : 1) : 0));
            if ($y == 'sql' && min_version(5.6) && preg_match('~time~', $o["type"])) $Je += 7;
            echo "<input" . ((!$xd || $s === "") && preg_match('~(?<!o)int(?!er)~', $o["type"]) && !preg_match('~\[\]~', $o["full_type"]) ? " type='number'" : "") . " value='" . h($Y) . "'" . ($Je ? " data-maxlength='$Je'" : "") . (preg_match('~char|binary~', $o["type"]) && $Je > 20 ? " size='40'" : "") . "$Ha>";
        }
        echo $b->editHint($_GET["edit"], $o, $Y);
        $Zc = 0;
        foreach ($nd
                 as $z => $X) {
            if ($z === "" || !$X) break;
            $Zc++;
        }
        if ($Zc) echo
        script("mixin(qsl('td'), {onchange: partial(skipOriginal, $Zc), oninput: function () { this.onchange(); }});");
    }
}

function
process_input($o)
{
    global $b, $m;
    $v = bracket_escape($o["field"]);
    $s = $_POST["function"][$v];
    $Y = $_POST["fields"][$v];
    if ($o["type"] == "enum") {
        if ($Y == -1) return
            false;
        if ($Y == "") return "NULL";
        return +$Y;
    }
    if ($o["auto_increment"] && $Y == "") return
        null;
    if ($s == "orig") return (preg_match('~^CURRENT_TIMESTAMP~i', $o["on_update"]) ? idf_escape($o["field"]) : false);
    if ($s == "NULL") return "NULL";
    if ($o["type"] == "set") return
        array_sum((array)$Y);
    if ($s == "json") {
        $s = "";
        $Y = json_decode($Y, true);
        if (!is_array($Y)) return
            false;
        return $Y;
    }
    if (preg_match('~blob|bytea|raw|file~', $o["type"]) && ini_bool("file_uploads")) {
        $Xc = get_file("fields-$v");
        if (!is_string($Xc)) return
            false;
        return $m->quoteBinary($Xc);
    }
    return $b->processInput($o, $Y, $s);
}

function
fields_from_edit()
{
    global $m;
    $I = array();
    foreach ((array)$_POST["field_keys"] as $z => $X) {
        if ($X != "") {
            $X = bracket_escape($X);
            $_POST["function"][$X] = $_POST["field_funs"][$z];
            $_POST["fields"][$X] = $_POST["field_vals"][$z];
        }
    }
    foreach ((array)$_POST["fields"] as $z => $X) {
        $D = bracket_escape($z, 1);
        $I[$D] = array("field" => $D, "privileges" => array("insert" => 1, "update" => 1), "null" => 1, "auto_increment" => ($z == $m->primary),);
    }
    return $I;
}

function
search_tables()
{
    global $b, $g;
    $_GET["where"][0]["val"] = $_POST["query"];
    $gh = "<ul>\n";
    foreach (table_status('', true) as $Q => $R) {
        $D = $b->tableName($R);
        if (isset($R["Engine"]) && $D != "" && (!$_POST["tables"] || in_array($Q, $_POST["tables"]))) {
            $H = $g->query("SELECT" . limit("1 FROM " . table($Q), " WHERE " . implode(" AND ", $b->selectSearchProcess(fields($Q), array())), 1));
            if (!$H || $H->fetch_row()) {
                $mg = "<a href='" . h(ME . "select=" . urlencode($Q) . "&where[0][op]=" . urlencode($_GET["where"][0]["op"]) . "&where[0][val]=" . urlencode($_GET["where"][0]["val"])) . "'>$D</a>";
                echo "$gh<li>" . ($H ? $mg : "<p class='error'>$mg: " . error()) . "\n";
                $gh = "";
            }
        }
    }
    echo ($gh ? "<p class='message'>" . 'No tables.' : "</ul>") . "\n";
}

function
dump_headers($Fd, $Se = false)
{
    global $b;
    $I = $b->dumpHeaders($Fd, $Se);
    $Jf = $_POST["output"];
    if ($Jf != "text") header("Content-Disposition: attachment; filename=" . $b->dumpFilename($Fd) . ".$I" . ($Jf != "file" && preg_match('~^[0-9a-z]+$~', $Jf) ? ".$Jf" : ""));
    session_write_close();
    ob_flush();
    flush();
    return $I;
}

function
dump_csv($J)
{
    foreach ($J
             as $z => $X) {
        if (preg_match('~["\n,;\t]|^0|\.\d*0$~', $X) || $X === "") $J[$z] = '"' . str_replace('"', '""', $X) . '"';
    }
    echo
        implode(($_POST["format"] == "csv" ? "," : ($_POST["format"] == "tsv" ? "\t" : ";")), $J) . "\r\n";
}

function
apply_sql_function($s, $e)
{
    return ($s ? ($s == "unixepoch" ? "DATETIME($e, '$s')" : ($s == "count distinct" ? "COUNT(DISTINCT " : strtoupper("$s(")) . "$e)") : $e);
}

function
get_temp_dir()
{
    $I = ini_get("upload_tmp_dir");
    if (!$I) {
        if (function_exists('sys_get_temp_dir')) $I = sys_get_temp_dir(); else {
            $q = @tempnam("", "");
            if (!$q) return
                false;
            $I = dirname($q);
            unlink($q);
        }
    }
    return $I;
}

function
file_open_lock($q)
{
    $ld = @fopen($q, "r+");
    if (!$ld) {
        $ld = @fopen($q, "w");
        if (!$ld) return;
        chmod($q, 0660);
    }
    flock($ld, LOCK_EX);
    return $ld;
}

function
file_write_unlock($ld, $Pb)
{
    rewind($ld);
    fwrite($ld, $Pb);
    ftruncate($ld, strlen($Pb));
    flock($ld, LOCK_UN);
    fclose($ld);
}

function
password_file($i)
{
    $q = get_temp_dir() . "/adminer.key";
    $I = @file_get_contents($q);
    if ($I || !$i) return $I;
    $ld = @fopen($q, "w");
    if ($ld) {
        chmod($q, 0660);
        $I = rand_string();
        fwrite($ld, $I);
        fclose($ld);
    }
    return $I;
}

function
rand_string()
{
    return
        md5(uniqid(mt_rand(), true));
}

function
select_value($X, $A, $o, $ci)
{
    global $b;
    if (is_array($X)) {
        $I = "";
        foreach ($X
                 as $fe => $W) $I .= "<tr>" . ($X != array_values($X) ? "<th>" . h($fe) : "") . "<td>" . select_value($W, $A, $o, $ci);
        return "<table cellspacing='0'>$I</table>";
    }
    if (!$A) $A = $b->selectLink($X, $o);
    if ($A === null) {
        if (is_mail($X)) $A = "mailto:$X";
        if (is_url($X)) $A = $X;
    }
    $I = $b->editVal($X, $o);
    if ($I !== null) {
        if (!is_utf8($I)) $I = "\0"; elseif ($ci != "" && is_shortable($o)) $I = shorten_utf8($I, max(0, +$ci));
        else$I = h($I);
    }
    return $b->selectVal($I, $A, $o, $X);
}

function
is_mail($uc)
{
    $Ga = '[-a-z0-9!#$%&\'*+/=?^_`{|}~]';
    $hc = '[a-z0-9]([-a-z0-9]{0,61}[a-z0-9])';
    $Zf = "$Ga+(\\.$Ga+)*@($hc?\\.)+$hc";
    return
        is_string($uc) && preg_match("(^$Zf(,\\s*$Zf)*\$)i", $uc);
}

function
is_url($P)
{
    $hc = '[a-z0-9]([-a-z0-9]{0,61}[a-z0-9])';
    return
        preg_match("~^(https?)://($hc?\\.)+$hc(:\\d+)?(/.*)?(\\?.*)?(#.*)?\$~i", $P);
}

function
is_shortable($o)
{
    return
        preg_match('~char|text|json|lob|geometry|point|linestring|polygon|string|bytea~', $o["type"]);
}

function
count_rows($Q, $Z, $ae, $qd)
{
    global $y;
    $G = " FROM " . table($Q) . ($Z ? " WHERE " . implode(" AND ", $Z) : "");
    return ($ae && ($y == "sql" || count($qd) == 1) ? "SELECT COUNT(DISTINCT " . implode(", ", $qd) . ")$G" : "SELECT COUNT(*)" . ($ae ? " FROM (SELECT 1$G GROUP BY " . implode(", ", $qd) . ") x" : $G));
}

function
slow_query($G)
{
    global $b, $ni, $m;
    $l = $b->database();
    $ei = $b->queryTimeout();
    $sh = $m->slowQuery($G, $ei);
    if (!$sh && support("kill") && is_object($h = connect()) && ($l == "" || $h->select_db($l))) {
        $ie = $h->result(connection_id());
        echo '<script', nonce(), '>
var timeout = setTimeout(function () {
	ajax(\'', js_escape(ME), 'script=kill\', function () {
	}, \'kill=', $ie, '&token=', $ni, '\');
}, ', 1000 * $ei, ');
</script>
';
    } else$h = null;
    ob_flush();
    flush();
    $I = @get_key_vals(($sh ? $sh : $G), $h, false);
    if ($h) {
        echo
        script("clearTimeout(timeout);");
        ob_flush();
        flush();
    }
    return $I;
}

function
get_token()
{
    $yg = rand(1, 1e6);
    return ($yg ^ $_SESSION["token"]) . ":$yg";
}

function
verify_token()
{
    list($ni, $yg) = explode(":", $_POST["token"]);
    return ($yg ^ $_SESSION["token"]) == $ni;
}

function
lzw_decompress($Qa)
{
    $ec = 256;
    $Ra = 8;
    $ib = array();
    $Mg = 0;
    $Ng = 0;
    for ($t = 0; $t < strlen($Qa); $t++) {
        $Mg = ($Mg << 8) + ord($Qa[$t]);
        $Ng += 8;
        if ($Ng >= $Ra) {
            $Ng -= $Ra;
            $ib[] = $Mg >> $Ng;
            $Mg &= (1 << $Ng) - 1;
            $ec++;
            if ($ec >> $Ra) $Ra++;
        }
    }
    $dc = range("\0", "\xFF");
    $I = "";
    foreach ($ib
             as $t => $hb) {
        $tc = $dc[$hb];
        if (!isset($tc)) $tc = $kj . $kj[0];
        $I .= $tc;
        if ($t) $dc[] = $kj . $tc[0];
        $kj = $tc;
    }
    return $I;
}

function
on_help($pb, $ph = 0)
{
    return
        script("mixin(qsl('select, input'), {onmouseover: function (event) { helpMouseover.call(this, event, $pb, $ph) }, onmouseout: helpMouseout});", "");
}

function
edit_form($Q, $p, $J, $Ii)
{
    global $b, $y, $ni, $n;
    $Oh = $b->tableName(table_status1($Q, true));
    page_header(($Ii ? 'Edit' : 'Insert'), $n, array("select" => array($Q, $Oh)), $Oh);
    $b->editRowPrint($Q, $p, $J, $Ii);
    if ($J === false) echo "<p class='error'>" . 'No rows.' . "\n";
    echo '<form action="" method="post" enctype="multipart/form-data" id="form">
';
    if (!$p) echo "<p class='error'>" . 'You have no privileges to update this table.' . "\n"; else {
        echo "<table cellspacing='0' class='layout'>" . script("qsl('table').onkeydown = editingKeydown;");
        foreach ($p
                 as $D => $o) {
            echo "<tr><th>" . $b->fieldName($o);
            $Wb = $_GET["set"][bracket_escape($D)];
            if ($Wb === null) {
                $Wb = $o["default"];
                if ($o["type"] == "bit" && preg_match("~^b'([01]*)'\$~", $Wb, $Gg)) $Wb = $Gg[1];
            }
            $Y = ($J !== null ? ($J[$D] != "" && $y == "sql" && preg_match("~enum|set~", $o["type"]) ? (is_array($J[$D]) ? array_sum($J[$D]) : +$J[$D]) : (is_bool($J[$D]) ? +$J[$D] : $J[$D])) : (!$Ii && $o["auto_increment"] ? "" : (isset($_GET["select"]) ? false : $Wb)));
            if (!$_POST["save"] && is_string($Y)) $Y = $b->editVal($Y, $o);
            $s = ($_POST["save"] ? (string)$_POST["function"][$D] : ($Ii && preg_match('~^CURRENT_TIMESTAMP~i', $o["on_update"]) ? "now" : ($Y === false ? null : ($Y !== null ? '' : 'NULL'))));
            if (!$_POST && !$Ii && $Y == $o["default"] && preg_match('~^[\w.]+\(~', $Y)) $s = "SQL";
            if (preg_match("~time~", $o["type"]) && preg_match('~^CURRENT_TIMESTAMP~i', $Y)) {
                $Y = "";
                $s = "now";
            }
            input($o, $Y, $s);
            echo "\n";
        }
        if (!support("table")) echo "<tr>" . "<th><input name='field_keys[]'>" . script("qsl('input').oninput = fieldChange;") . "<td class='function'>" . html_select("field_funs[]", $b->editFunctions(array("null" => isset($_GET["select"])))) . "<td><input name='field_vals[]'>" . "\n";
        echo "</table>\n";
    }
    echo "<p>\n";
    if ($p) {
        echo "<input type='submit' value='" . 'Save' . "'>\n";
        if (!isset($_GET["select"])) {
            echo "<input type='submit' name='insert' value='" . ($Ii ? 'Save and continue edit' : 'Save and insert next') . "' title='Ctrl+Shift+Enter'>\n", ($Ii ? script("qsl('input').onclick = function () { return !ajaxForm(this.form, '" . 'Saving' . "â€¦', this); };") : "");
        }
    }
    echo($Ii ? "<input type='submit' name='delete' value='" . 'Delete' . "'>" . confirm() . "\n" : ($_POST || !$p ? "" : script("focus(qsa('td', qs('#form'))[1].firstChild);")));
    if (isset($_GET["select"])) hidden_fields(array("check" => (array)$_POST["check"], "clone" => $_POST["clone"], "all" => $_POST["all"]));
    echo '<input type="hidden" name="referer" value="', h(isset($_POST["referer"]) ? $_POST["referer"] : $_SERVER["HTTP_REFERER"]), '">
<input type="hidden" name="save" value="1">
<input type="hidden" name="token" value="', $ni, '">
</form>
';
}

if (isset($_GET["file"])) {
    if ($_SERVER["HTTP_IF_MODIFIED_SINCE"]) {
        header("HTTP/1.1 304 Not Modified");
        exit;
    }
    header("Expires: " . gmdate("D, d M Y H:i:s", time() + 365 * 24 * 60 * 60) . " GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header("Cache-Control: immutable");
    if ($_GET["file"] == "favicon.ico") {
        header("Content-Type: image/x-icon");
        echo
        lzw_decompress("\0\0\0` \0„\0\n @\0´C„è\"\0`EãQ¸àÿ‡?ÀtvM'”JdÁd\\Œb0\0Ä\"™ÀfÓˆ¤îs5›ÏçÑAXPaJ“0„¥‘8„#RŠT©‘z`ˆ#.©ÇcíXÃþÈ€?À-\0¡Im? .«M¶€\0È¯(Ì‰ýÀ/(%Œ\0");
    } elseif ($_GET["file"] == "default.css") {
        header("Content-Type: text/css; charset=utf-8");
        echo
        lzw_decompress("\n1Ì‡“ÙŒÞl7œ‡B1„4vb0˜Ífs‘¼ên2BÌÑ±Ù˜Þn:‡#(¼b.\rDc)ÈÈa7E„‘¤Âl¦Ã±”èi1ÌŽs˜´ç-4™‡fÓ	ÈÎi7†³¹¤Èt4…¦ÓyèZf4°i–AT«VVéf:Ï¦,:1¦QÝ¼ñb2`Ç#þ>:7Gï—1ÑØÒs°™L—XD*bv<ÜŒ#£e@Ö:4ç§!fo·Æt:<¥Üå’¾™oâÜ\niÃÅð',é»a_¤:¹iï…´ÁBvø|Nû4.5Nfi¢vpÐh¸°l¨ê¡ÖšÜO¦‰î= £OFQÐÄk\$¥Óiõ™ÀÂd2Tã¡pàÊ6„‹þ‡¡-ØZ€Žƒ Þ6½£€ðh:¬aÌ,Ž£ëî2#8Ð±#’˜6nâî†ñJˆ¢h«t…Œ±Šä4O42ô½okÞ¾*r ©€@p@†!Ä¾ÏÃôþ?Ð6À‰r[ðLÁð‹:2Bˆj§!HbóÃPä=!1V‰\"ˆ²0…¿\nSÆÆÏD7ÃìDÚ›ÃC!†!›à¦GÊŒ§ È+’=tCæ©.C¤À:+ÈÊ=ªªº²¡±å%ªcí1MR/”EÈ’4„© 2°ä± ã`Â8(áÓ¹[WäÑ=‰ySb°=Ö-Ü¹BS+É¯ÈÜý¥ø@pL4Ydã„qŠøã¦ðê¢6£3Ä¬¯¸AcÜŒèÎ¨Œk‚[&>ö•¨ZÁpkm]—u-c:Ø¸ˆNtæÎ´pÒŒŠ8è=¿#˜á[.ðÜÞ¯~ mËy‡PPá|IÖ›ùÀìQª9v[–Q•„\n–Ùrô'g‡+áTÑ2…­VÁõzä4£8÷(	¾Ey*#j¬2]­•RÒÁ‘¥)ƒÀ[N­R\$Š<>:ó­>\$;–> Ì\r»„ÎHÍÃTÈ\nw¡N åwØ£¦ì<ïËGwàöö¹\\Yó_ Rt^Œ>Ž\r}ŒÙS\rzé4=µ\nL”%Jã‹\",Z 8¸ž™i÷0u©?¨ûÑô¡s3#¨Ù‰ :ó¦ûã½–ÈÞE]xÝÒs^8Ž£K^É÷*0ÑÞwÞàÈÞ~ãö:íÑiØþv2w½ÿ±û^7ãò7£cÝÑu+U%Ž{PÜ*4Ì¼éLX./!¼‰1CÅßqx!H¹ãFdù­L¨¤¨Ä Ï`6ëè5®™f€¸Ä†¨=Høl ŒV1“›\0a2×;Ô6†àöþ_Ù‡Ä\0&ôZÜS d)KE'’€nµ[X©³\0ZÉŠÔF[P‘Þ˜@àß!‰ñYÂ,`É\"Ú·Â0Ee9yF>ËÔ9bº–ŒæF5:üˆ”\0}Ä´Š‡(\$žÓ‡ë€37Hö£è M¾A°²6R•ú{MqÝ7G ÚC™Cêm2¢(ŒCt>[ì-tÀ/&C›]êetGôÌ¬4@r>ÇÂå<šSq•/åú”QëhmšÀÐÆôãôLÀÜ#èôKË|®™„6fKPÝ\r%tÔÓV=\" SH\$} ¸)w¡,W\0F³ªu@Øb¦9‚\rr°2Ã#¬DŒ”Xƒ³ÚyOIù>»…n†Ç¢%ãù'‹Ý_Á€t\rÏ„zÄ\\1˜hl¼]Q5Mp6k†ÐÄqhÃ\$£H~Í|ÒÝ!*4ŒñòÛ`Sëý²S tíPP\\g±è7‡\n-Š:è¢ªp´•”ˆl‹Bž¦î”7Ó¨cƒ(wO0\\:•Ðw”Áp4ˆ“ò{TÚújO¤6HÃŠ¶rÕ¥q\n¦É%%¶y']\$‚”a‘ZÓ.fcÕq*-êFWºúk„zƒ°µj‘Ž°lgáŒ:‡\$\"ÞN¼\r#ÉdâÃ‚ÂÿÐscá¬Ì „ƒ\"jª\rÀ¶–¦ˆÕ’¼Ph‹1/‚œDA) ²Ý[ÀknÁp76ÁY´‰R{áM¤Pû°ò@\n-¸a·6þß[»zJH,–dl B£ho³ìò¬+‡#Dr^µ^µÙeš¼E½½– ÄœaP‰ôõJG£zàñtñ 2ÇXÙ¢´Á¿V¶×ßàÞÈ³‰ÑB_%K=E©¸bå¼¾ßÂ§kU(.!Ü®8¸œüÉI.@ŽKÍxnþ¬ü:ÃPó32«”míH		C*ì:vâTÅ\nR¹ƒ•µ‹0uÂíƒæîÒ§]Î¯˜Š”P/µJQd¥{L–Þ³:YÁ2b¼œT ñÊ3Ó4†—äcê¥V=¿†L4ÎÐrÄ!ßBðY³6Í­MeLŠªÜçœöùiÀoÐ9< G”¤Æ•Ð™Mhm^¯UÛNÀŒ·òTr5HiM”/¬nƒí³T [-<__î3/Xr(<‡¯Š†®Éô“ÌuÒ–GNX20å\r\$^‡:'9è¶O…í;×k¼†µf –N'a¶”Ç­bÅ,ËV¤ô…«1µïHI!%6@úÏ\$ÒEGÚœ¬1(mUªå…rÕ½ïßå`¡ÐiN+Ãœñ)šœä0lØÒf0Ã½[UâøVÊè-:I^ ˜\$Øs«b\re‡‘ugÉhª~9Ûßˆb˜µôÂÈfä+0¬Ô hXrÝ¬©!\$—e,±w+„÷ŒëŒ3†Ì_âA…kšù\nkÃrõÊ›cuWdYÿ\\×={.óÄ˜¢g»‰p8œt\rRZ¿vJ:²>þ£Y|+Å@À‡ƒÛCt\r€jt½6²ð%Â?àôÇŽñ’>ù/¥ÍÇðÎ9F`×•äòv~K¤áöÑRÐW‹ðz‘êlmªwLÇ9Y•*q¬xÄzñèSe®Ý›³è÷£~šDàÍá–÷x˜¾ëÉŸi7•2ÄøÑOÝ»’û_{ñú53âút˜›_ŸõzÔ3ùd)‹C¯Â\$?KÓªP%ÏÏT&þ˜&\0P×NAŽ^­~¢ƒ pÆ öÏœ“Ôõ\r\$ÞïÐÖìb*+D6ê¶¦ÏˆÞíJ\$(ÈolÞÍh&”ìKBS>¸‹ö;z¶¦xÅoz>íœÚoÄZð\nÊ‹[Ïvõ‚ËÈœµ°2õOxÙVø0fû€ú¯Þ2BlÉbkÐ6ZkµhXcdê0*ÂKTâ¯H=­•Ï€‘p0ŠlVéõèâ\r¼Œ¥nŽm¦ï)((ô:#¦âòE‰Ü:C¨CàÚâ\r¨G\rÃ©0÷…iæÚ°þ:`Z1Q\n:€à\r\0àçÈq±°ü:`¿-ÈM#}1;èþ¹‹q‘#|ñS€¾¢hl™DÄ\0fiDpëL ``™°çÑ0y€ß1…€ê\rñ=‘MQ\\¤³%oq–­\0Øñ£1¨21¬1°­ ¿±§Ñœbi:“í\r±/Ñ¢› `)šÄ0ù‘@¾Â›±ÃI1«NàCØàŠµñO±¢Zñã1±ïq1 òÑüà,å\rdIÇ¦väjí‚1 tÚBø“°â’0:…0ðð“1 A2V„ñâ0 éñ%²fi3!&Q·Rc%Òq&w%Ñì\ràVÈ#Êø™Qw`‹% ¾„Òm*r…Òy&iß+r{*²»(rg(±#(2­(ðå)R@i›-  ˆž•1\"\0Û²Rêÿ.e.rëÄ,¡ry(2ªCàè²bì!BÞ3%Òµ,R¿1²Æ&èþt€äbèa\rL“³-3á Ö ó\0æóBp—1ñ94³O'R°3*²³=\$à[£^iI;/3i©5Ò&’}17²# Ñ¹8 ¿\"ß7Ñå8ñ9*Ò23™!ó!1\\\0Ï8“­rk9±;S…23¶àÚ“*Ó:q]5S<³Á#383Ý#eÑ=¹>~9Sèž³‘rÕ)€ŒT*aŸ@Ñ–ÙbesÙÔ£:-ó€éÇ*;, Ø™3!i´›‘LÒ²ð#1 +nÀ «*²ã@³3i7´1©ž´_•F‘S;3ÏF±\rA¯é3õ>´x:ƒ \r³0ÎÔ@’-Ô/¬ÓwÓÛ7ñ„ÓS‘J3› ç.Fé\$O¤B’±—%4©+tÃ'góLq\rJt‡JôËM2\rôÍ7ñÆT@“£¾)â“£dÉ2€P>Î°€Fià²´þ\nr\0ž¸bçk(´D¶¿ãKQƒ¤´ã1ã\"2t”ôôºPè\rÃÀ,\$KCtò5ôö#ôú)¢áP#Pi.ÎU2µCæ~Þ\"ä");
    } elseif ($_GET["file"] == "functions.js") {
        header("Content-Type: text/javascript; charset=utf-8");
        echo
        lzw_decompress("f:›ŒgCI¼Ü\n8œÅ3)°Ë7œ…†81ÐÊx:\nOg#)Ðêr7\n\"†è´`ø|2ÌgSi–H)N¦S‘ä§\r‡\"0¹Ä@ä)Ÿ`(\$s6O!ÓèœV/=Œ' T4æ=„˜iS˜6IO G#ÒX·VCÆs¡ Z1.Ðhp8,³[¦Häµ~Cz§Éå2¹l¾c3šÍés£‘ÙI†bâ4\néF8Tà†I˜Ý©U*fz¹är0žEÆÀØyŽ¸ñfŽY.:æƒIŒÊ(Øc·áÎ‹!_l™í^·^(¶šN{S–“)rËqÁY“–lÙ¦3Š3Ú\n˜+G¥Óêyºí†Ëi¶ÂîxV3w³uhã^rØÀº´aÛ”ú¹cØè\r“¨ë(.ÂˆºChÒ<\r)èÑ£¡`æ7£íò43'm5Œ£È\nPÜ:2£P»ªŽ‹q òÿÅC“}Ä«ˆúÊÁê38‹BØ0ŽhR‰Èr(œ0¥¡b\\0ŒHr44ŒÁB!¡pÇ\$ŽrZZË2Ü‰.Éƒ(\\Ž5Ã|\nC(Î\"€P…ðø.ÐNÌRTÊÎ“Àæ>HN…8HPá\\¬7Jp~„Üû2%¡ÐOC¨1ã.ƒ§C8Î‡HÈò*ˆj°…á÷S(¹/¡ì¬6KUœÊ‡¡<2‰pOI„ôÕ`Ôäâ³ˆdOH Þ5-üÆ4ŒãpX25-Ò¢òÛˆ°z7£¸\"(°P \\32:]UÚèíâß…!]¸<·AÛÛ¤’ÐßiÚ°‹l\rÔ\0v²Î#J8«ÏwmžíÉ¤¨<ŠÉ æü%m;p#ã`XDŒø÷iZøN0Œ•È9ø¨å Áè`…ŽwJD¿¾2Ò9tŒ¢*øÎyìËNiIh\\9ÆÕèÐ:ƒ€æáxï­µyl*šÈˆÎæY Ü‡øê8’W³â?µŽÞ›3ÙðÊ!\"6å›n[¬Ê\r­*\$¶Æ§¾nzxÆ9\rì|*3×£pÞï»¶ž:(p\\;ÔËmz¢ü§9óÐÑÂŒü8N…Áj2½«Î\rÉHîH&Œ²(Ãz„Á7iÛk£ ‹Š¤‚c¤‹eòžý§tœÌÌ2:SHóÈ Ã/)–xÞ@éåt‰ri9¥½õëœ8ÏÀËïyÒ·½°ŽVÄ+^WÚ¦­¬kZæY—l·Ê£Œ4ÖÈÆ‹ª¶À¬‚ð\\EÈ{î7\0¹p†€•D€„i”-TæþÚû0l°%=Á ÐËƒ9(„5ð\n\n€n,4‡\0èa}Üƒ.°öRsï‚ª\02B\\Ûb1ŸS±\0003,ÔXPHJspåd“Kƒ CA!°2*WŸÔñÚ2\$ä+Âf^\n„1Œ´òzEƒ Iv¤\\äœ2É .*A°™”E(d±á°ÃbêÂÜ„Æ9‡‚â€ÁDh&­ª?ÄH°sQ˜2’x~nÃJ‹T2ù&ãàeRœ½™GÒQŽTwêÝ‘»õPˆâã\\ )6¦ôâœÂòsh\\3¨\0R	À'\r+*;RðHà.“!Ñ[Í'~­%t< çpÜK#Â‘æ!ñlßÌðLeŒ³œÙ,ÄÀ®&á\$	Á½`”–CXš‰Ó†0Ö­å¼û³Ä:Méh	çÚœGäÑ!&3 D<!è23„Ã?h¤J©e Úðhá\r¡m•˜ðNi¸£´Ž’†ÊNØHl7¡®v‚êWIå.´Á-Ó5Ö§ey\rEJ\ni*¼\$@ÚRU0,\$U¿E†¦ÔÔÂªu)@(tÎSJkáp!€~­‚àd`Ì>¯•\nÃ;#\rp9†jÉ¹Ü]&Nc(r€ˆ•TQUª½S·Ú\08n`«—y•b¤ÅžLÜO5‚î,¤òž‘>Ž‚†xââ±fä´’âØ+–\"ÑI€{kMÈ[\r%Æ[	¤eôaÔ1! èÿí³Ô®©F@«b)RŸ£72ˆî0¡\nW¨™±L²ÜœÒ®tdÕ+íÜ0wglø0n@òêÉ¢ÕiíM«ƒ\nA§M5nì\$E³×±NÛál©ÝŸ×ì%ª1 AÜûºú÷ÝkñrîiFB÷Ïùol,muNx-Í_ Ö¤C( fél\r1p[9x(i´BÒ–²ÛzQlüº8CÔ	´©XU Tb£ÝIÝ`•p+V\0î‹Ñ;‹CbÎÀXñ+Ï’sïü]H÷Ò[ák‹x¬G*ô†]·awnú!Å6‚òâÛÐmSí¾“IÞÍKË~/Ó¥7ÞùeeNÉòªS«/;dåA†>}l~žÏê ¨%^´fçØ¢pÚœDEîÃa·‚t\nx=ÃkÐŽ„*dºêðT—ºüûj2ŸÉjœ\n‘ É ,˜e=‘†M84ôûÔa•j@îTÃsÔänf©Ý\nî6ª\rdœ¼0ÞíôYŠ'%Ô“íÞ~	Ò¨†<ÖË–Aî‹–H¿G‚8ñ¿Îƒ\$z«ð{¶»²u2*†àa–À>»(wŒK.bP‚{…ƒoý”Â´«zµ#ë2ö8=É8>ª¤³A,°e°À…+ìCè§xõ*ÃáÒ-b=m‡™Ÿ,‹a’Ãlzkï\$Wõ,mJiæÊ§á÷+‹èý0°[¯ÿ.RÊsKùÇäXçÝZLËç2`Ì(ïCàvZ¡ÜÝÀ¶è\$×¹,åD?H±ÖNxXôó)’îŽM¨‰\$ó,Í*\nÑ£\$<qÿÅŸh!¿¹S“âƒÀŸxsA!˜:´K¥Á}Á²“ù¬£œRþšA2k·XŽp\n<÷þ¦ýëlì§Ù3¯ø¦È•VV¬}£g&YÝ!†+ó;<¸YÇóŸYE3r³ÙŽñ›Cío5¦Åù¢Õ³Ïkkþ…ø°ÖÛ£«Ït÷’Uø…­)û[ýßÁî}ïØu´«lç¢:DŸø+Ï _oãäh140ÖáÊ0ø¯bäK˜ã¬’ öþé»lGª„#ªš©êŽ†¦©ì|Udæ¶IK«êÂ7à^ìà¸@º®O\0HÅðHiŠ6\r‡Û©Ü\\cg\0öãë2ŽBÄ*eà\n€š	…zr!nWz& {H–ð'\$X  w@Ò8ëDGr*ëÄÝHå'p#ŽÄ®€¦Ô\ndü€÷,ô¥—,ü;g~¯\0Ð#€ÌŽ²EÂ\rÖI`œî'ƒð%EÒ. ]`ÊÐ›…î%&Ðîm°ý\râÞ%4S„vð#\n žfH\$%ë-Â#­ÆÑqBâíæ ÀÂQ-ôc2Š§‚&ÂÀÌ]à™ èqh\rñl]à®s ÐÑhä7±n#±‚‚Ú-àjE¯Frç¤l&dÀØÙåzìF6¸ˆÁ\" ž“|¿§¢s@ß±®åz)0rpÚ\0‚X\0¤Ùè|DL<!°ôo„*‡D¶{.B<Eª‹‹0nB(ï Ž|\r\nì^©à h³!‚Öêr\$§’(^ª~èÞÂ/pq²ÌB¨ÅOšˆðú,\\µ¨#RRÎ%ëäÍdÐHjÄ`Â ô®Ì­ Vå bS’d§iŽE‚øïoh´r<i/k\$-Ÿ\$o”¼+ÆÅ‹ÎúlÒÞO³&evÆ’¼iÒjMPA'u'ŽÎ’( M(h/+«òWD¾So·.n·.ðn¸ìê(œ(\"­À§hö&p†¨/Ë/1DÌŠçjå¨¸EèÞ&â¦€,'l\$/.,Äd¨…‚W€bbO3óB³sH :J`!“.€ª‚‡Àû¥ ,FÀÑ7(‡ÈÔ¿³û1Šlås ÖÒŽ‘²—Å¢q¢X\rÀš®ƒ~Ré°±`®Òžó®Y*ä:R¨ùrJ´·%LÏ+n¸\"ˆø\r¦ÎÍ‡H!qb¾2âLi±%ÓÞÎ¨Wj#9ÓÔObE.I:…6Á7\0Ë6+¤%°.È…Þ³a7E8VSå?(DG¨Ó³Bë%;ò¬ùÔ/<’´ú¥À\r ì´>ûMÀ°@¶¾€H DsÐ°Z[tH£Enx(ðŒ©R xñû@¯þGkjW”>ÌÂÚ#T/8®c8éQ0Ëè_ÔIIGII’!¥ðŠYEdËE´^tdéthÂ`DV!Cæ8Ž¥\r­´Ÿb“3©!3â@Ù33N}âZBó3	Ï3ä30ÚÜM(ê>‚Ê}ä\\Ñtê‚f fŒËâI\r®€ó337 XÔ\"tdÎ,\nbtNO`Pâ;­Ü•Ò­ÀÔ¯\$\n‚žßäZÑ­5U5WUµ^hoýàætÙPM/5K4Ej³KQ&53GX“Xx)Ò<5D…\rûVô\nßr¢5bÜ€\\J\">§è1S\r[-¦ÊDuÀ\rÒâ§Ã)00óYõÈË¢·k{\nµÄ#µÞ\r³^·‹|èuÜ»Uå_nïU4ÉUŠ~YtÓ\rIšÃ@ä³™R ó3:ÒuePMSè0TµwW¯XÈòòD¨ò¤KOUÜà•‡;Uõ\n OYéYÍQ,M[\0÷_ªDšÍÈW ¾J*ì\rg(]à¨\r\"ZC‰©6uê+µYóˆY6Ã´0ªqõ(Ùó8}ó3AX3T h9j¶jàfõMtåPJbqMP5>ðÈø¶©Y‡k%&\\‚1d¢ØE4À µYnÊí\$<¥U]Ó‰1‰mbÖ¶^Òõš ê\"NVéßp¶ëpõ±eMÚÞ×WéÜ¢î\\ä)\n Ë\nf7\n×2´õr8‹—=Ek7tVš‡µž7P¦¶LÉía6òòv@'‚6iàïj&>±â;­ã`Òÿa	\0pÚ¨(µJÑë)«\\¿ªnûòÄ¬m\0¼¨2€ôeqJö­PôtŒë±fjüÂ\"[\0¨·†¢X,<\\Œî¶×â÷æ·+md†å~âàš…Ñs%o°´mn×),×„æÔ‡²\r4¶Â8\r±Î¸×mE‚H]‚¦˜üÖHW­M0Dïß€—å~Ë˜K˜îE}ø¸´à|fØ^“Ü×\r>Ô-z]2s‚xD˜d[s‡tŽS¢¶\0Qf-K`­¢‚tàØ„wT¯9€æZ€à	ø\nB£9 Nb–ã<ÚBþI5o×oJñpÀÏJNdåË\rhÞÃ2\"àxæHCàÝ–:øý9Yn16Æôzr+z±ùþ\\’÷•œôm Þ±T öò ÷@Y2lQ<2O+¥%“Í.Óƒhù0AÞñ¸ŠÃZ‹2R¦À1£Š/¯hH\r¨X…ÈaNB&§ ÄM@Ö[xŒ‡Ê®¥ê–â8&LÚVÍœvà±*šj¤ÛšGHåÈ\\Ù®	™²¶&sÛ\0Qš \\\"èb °	àÄ\rBs›Éw‚	ÙážBN`š7§Co(ÙÃà¨\nÃ¨“¨1š9Ì*E˜ ñS…ÓU0Uº tš'|”m™°Þ?h[¢\$.#É5	 å	p„àyBà@Rô]£…ê@|„§{™ÀÊP\0xô/¦ w¢%¤EsBd¿§šCUš~O×·àPà@Xâ]Ô…¨Z3¨¥1¦¥{©eLY‰¡ŒÚ¢\\’(*R` 	à¦\n…ŠàŽºÌQCFÈ*Ž¹¹àéœ¬Úp†X|`N¨‚¾\$€[†‰’@ÍU¢àð¦¶àZ¥`Zd\"\\\"…‚¢£)«‡Iˆ:ètšìoDæ\0[²¨à±‚-©“ gí³‰™®*`hu%£,€”¬ãIµ7Ä«²Hóµm¤6Þ}®ºNÖÍ³\$»MµUYf&1ùŽÀ›e]pz¥§ÚI¤Åm¶G/£ ºw Ü!•\\#5¥4I¥d¹EÂhq€å¦÷Ñ¬kçx|Úk¥qDšb…z?§º‰>úƒ¾:†“[èLÒÆ¬Z°Xš®:ž¹„·ÚÇjßw5	¶Y¾0 ©Â“­¯\$\0C¢†dSg¸ë‚ {@”\n`ž	ÀÃüC ¢·»Mºµâ»²# t}xÎN„÷º‡{ºÛ°)êûCƒÊFKZÞj™Â\0PFY”BäpFk–›0<Ú>ÊD<JE™šg\rõ.“2–ü8éU@*Î5fkªÌJDìÈÉ4•TDU76É/´è¯@·‚K+„ÃöJ®ºÃÂí@Ó=ŒÜWIOD³85MšNº\$Rô\0ø5¨\ràù_ðªœìEœñÏI«Ï³Nçl£Òåy\\ô‘ˆÇqU€ÐQû ª\n@’¨€ÛºÃpš¬¨PÛ±«7Ô½N\rýR{*qmÝ\$\0R”×Ô“ŠÅåqÐÃˆ+U@ÞB¤çOf*†CË¬ºMCŽä`_ èüò½ËµNêæTâ5Ù¦C×»© ¸à\\WÃe&_XŒ_Øhå—ÂÆBœ3ÀŒÛ%ÜFW£û|™GÞ›'Å[¯Å‚À°ÙÕV Ð#^\rç¦GR€¾˜€P±ÝFg¢ûî¯ÀYi û¥Çz\nâ¨Þ+ß^/“¨€‚¼¥½\\•6èßb¼dmh×â@qíÕAhÖ),J­×W–Çcm÷em]ŽÓeÏkZb0ßåþžYñ]ymŠè‡fØe¹B;¹ÓêOÉÀwŸapDWûŒÉÜÓ{›\0˜À-2/bN¬sÖ½Þ¾Ra“Ï®h&qt\n\"ÕiöRmühzÏeø†àÜFS7µÐPPòä–¤âÜ:B§ˆâÕsm¶­Y düÞò7}3?*‚túòéÏlTÚ}˜~€„€ä=cžý¬ÖÞÇ	žÚ3…;T²LÞ5*	ñ~#µA•¾ƒ‘sŽx-7÷Žf5`Ø#\"NÓb÷¯G˜Ÿ‹õ@Üeü[ïø¤Ìs‘˜€¸-§˜M6§£qqš h€e5…\0Ò¢À±ú*àbøISÜÉÜFÎ®9}ýpÓ-øý`{ý±É–kP˜0T<„©Z9ä0<Õš\r­€;!Ãˆgº\r\nKÔ\n•‡\0Á°*½\nb7(À_¸@,îe2\rÀ]–K…+\0Éÿp C\\Ñ¢,0¬^îMÐ§šº©“@Š;X\r•ð?\$\r‡j’+ö/´¬BöæP ½‰ù¨J{\"aÍ6˜ä‰œ¹|å£\n\0»à\\5“Ð	156ÿ† .Ý[ÂUØ¯\0dè²8Yç:!Ñ²‘=ºÀX.²uCªŠŒö!Sº¸‡o…pÓBÝüÛ7¸­Å¯¡Rh­\\h‹E=úy:< :u³ó2µ80“si¦ŸTsBÛ@\$ Íé@Çu	ÈQº¦.ô‚T0M\\/ê€d+Æƒ\n‘¡=Ô°dŒÅëA¢¸¢)\r@@Âh3€–Ù8.eZa|.â7YkÐcÀ˜ñ–'D#‡¨Yò@Xq–=M¡ï44šB AM¤¯dU\"‹Hw4î(>‚¬8¨²ÃC¸?e_`ÐÅX:ÄA9Ã¸™ôp«GÐä‡Gy6½ÃF“Xr‰¡l÷1¡½Ø»B¢Ã…9Rz©õhB„{ž€™\0ëå^‚Ã-â0©%Dœ5F\"\"àÚÜÊÂ™úiÄ`ËÙnAf¨ \"tDZ\"_àV\$Ÿª!/…D€áš†ð¿µ‹´ˆÙ¦¡Ì€F,25Éj›Tëá—y\0…N¼x\rçYl¦#‘ÆEq\nÍÈB2œ\nìà6·…Ä4Ó×”!/Â\nóƒ‰Q¸½*®;)bR¸Z0\0ÄCDoŒËžŽ48À•´µ‡Ðe‘\nã¦S%\\úPIk‡(0ÁŒu/™‹G²Æ¹ŠŒ¼\\Ë} 4Fp‘žGû_÷G?)gÈotº[vžÖ\0°¸?bÀ;ªË`(•ÛŒà¶NS)\nãx=èÐ+@êÜ7ƒjú0—,ð1Ã…z™“­>0ˆ‰GcðãL…VXôƒ±ÛðÊ%À…Á„Q+øŽéoÆFõÈéÜ¶Ð>Q-ãc‘ÚÇl‰¡³¤wàÌz5G‘ê‚@(h‘cÓHõÇr?ˆšNbþ@É¨öÇø°îlx3‹U`„rwª©ÔUÃÔôtØ8Ô=Àl#òõlÿä¨‰8¥E\"Œƒ˜™O6\n˜Â1e£`\\hKf—V/Ð·PaYKçOÌý éàx‘	‰Oj„ór7¥F;´êB»‘ê£íÌ’‡¼>æÐ¦²V\rÄ–Ä|©'Jµz«¼š”#’PBä’Y5\0NC¤^\n~LrR’Ô[ÌŸRÃ¬ñgÀeZ\0x›^»i<Qã/)Ó%@Ê’™fB²HfÊ{%Pà\"\"½ø@ªþ)ò’‘“DE(iM2‚S’*ƒyòSÁ\"âñÊeÌ’1Œ«×˜\n4`Ê©>¦Q*¦Üy°n”’ž¥TäuÔâä”Ñ~%+W²XK‹Œ£Q¡[Ê”žàlPYy#DÙ¬D<«FLú³Õ@Á6']Æ‹‡û\rFÄ`±!•%\n0cÐôÀË©%c8WrpGƒ.TœDo¾UL2Ø*é|\$¬:çXt5ÆXYâIˆp#ñ ²^\nê„:‚#Dú@Ö1\r*ÈK7à@D\0Ž¸C’C£xBhÉEnKè,1\"õ*y[á#!ó×™âÙ™©Ê°l_¢/€öxË\0àÉÚ5ÐZÇÿ4\0005JÆh\"2ˆŒ‡%Y…¦a®a1SûO4ˆÊ%niøšPŒàß´qî_Ê½6¤š•~ŠÈI\\¾š‘d‰údÑøŒ®—DÜÈ”€µ3g^ãü@^6Õ„îå_ÀHD·.ksL´Ô@ÂùÉˆæn­I¦ÄÑ~Ä\r“b @¸Ó€•Nžt\0séÂ]:uðÎX€b@^°1\0½©¥2?èTÀó6dLNeÉ›+ê\0Ç:©Ð²l¡ƒz6q=Ìºx“§çN6 ÜO,%@s›0\næ\\)ÒL<òCÊ|·ž¦P¶b¢˜¼ÎA>I‹…á\"	ŒÜ^K4ü‹gIXi@P…jE©&/1@æfÜ	ÔNáºx0coaß§Áª‰ó,C'Üy#6F@¡Ð ‰H0Ç{z3t–|cXMJ.*BÐ)ZDQðå\0°ñ“T-v¥Xža*”Ý,*Ã<bÁ•Ë#xÑ˜Ýd€PÆòKG8—Æ y“K	\\#=è)ígÈ‘hŒ&È8])½CÅ\nÃ´ñÀ9¼zˆW\\’gþM 7Šˆ!Ê•¡óÆŠ–¬,Åò9ñ²Š©©\$T\"£,Š¨%.F!Ëš A»-àé”ø¹-àg¨âŠ\0002R>KEˆ'ØUÙ_IÐ÷ì³9³Ë¼¡j(Q°@Ë@ò4/¬7ô˜“'J.â‡RT…\0]KS¹D‡–Ap5¼\rÂH0!ä›Â´e	d@RÒÒà¸´Ê9¢S©;7žH‘BÀbxóJèÖ_žviÑU`@ˆµÃSAM…¯XËÏGØXiÙÓU*¬Úö€ÊõûÍ'øÝ:VòWJv£D¾ÿN'\$ìzh\$d_y§œ“Z]•™­óYÊ°³8Ø”þ¡æ]¨Pìœ*hžÔÖ§e;€ºpeû¢\$kæw§ì*7N²DTx_ÔÔ§½Giô&PÿÔ†žtÍ†¨bè\\EÆH\$iE\"cr½å0l‰?>ÁñŒ‘C(ŠW@3ÈÁ•22a´“IÁà¹Õ¡{¥B`ÜÚ³iÅ¸Go^6E\r¡ºG˜M¤p1iÙI¼¤Xª\0003Ž2ÇKü§ÓôÝzl&Ö†‰'ILÖ\\Î\"’7¤>¬j(>ãjôFG_âä& 10IÆA31=h q\0ÆFŠ«–„Ä·ŠÝ_ÂJªŒ„Ô³VÎ–º‡Ü†qÙÕš¢Ù	Âà(/¾dOC_sm§<g˜x\0’°\"ð\n@EkH\0¡Jˆ­®8€(¬¨¯km[‰‘ì¿ÁS4ð\nY40›«+L\nŠ¦À“‘ì#BÓ«bçÀ%RÖ–°µ×­‘ÀR:Æ<\$!Û¥r;œ…Ç	%|Ê¨á(€|«H‡\0àð‘ÁÐŒ°…]ÂcÒ¡=0¯íZá¨\"\"=ÖX•˜)½fëNŸ6V}FÕÚ=[Éžà§¢huô-ø±\0t¥åbW~ºõQ•ÕiJŠö—Lñ5×­q#kbž ÝWn««ÍQøTƒ!ëÂeõncSÑ[+Ö´E¯<-‡–a]ÅƒˆìYbÓ\n\nJ~ä|JÉƒ8® ìLpŸ™Áæoñ €Nä©Ü¨…J.ùÅƒSÈ¡2c9Ãj©yŸ-`a\0Äö*ìÖˆ@\0+´ØmgÉÚ6°1¤ÔMe\0ªËQ ‰_„}!Iö’GL€f)ÃXño,“ShxÂ\0000\"hð+L¥MÔÉ ªÑ˜±ÊZ	j—\0¶ µ/˜\$’¨>u*—Z9”îZå®eõ«+Jœ‰™¸tzÈËûÈþR¨KÔ¯ÐÑâDyŽÞÙqá0C—-f¢Åm‚¶¹ªBIí|’¹HB‰œsQlÀX°ƒ.ÝÅöÔ|¸cˆªÀ[–óZhZåÃl˜¨ÛxÂ@'µ ml²KrQ¶26½•]¯Ò·n§d[ÝöñŽ©‡dþ€‘\"GJ9uòûBƒo“©Zß–Õa¥²n@Áªn°lW|*gX´\nn2åF¬|x`Dk›„uPP!Q\rr‹™`W/¹ŒŸ	1æ[-o,71bUs˜¢©çN¸7²ËÉÛGq¸.\\Q\"CCT\"æ‘à–ÄÒ*?u¨ts¶‰”°Ç]áÙ©Pz[¥[YFÏ¹¢›FD3¤\"–ºÇ]uÛ)wz­:#¶ÍÝIiwŠêpÉ›»ñ{¯oÖ0nð¶Û;Õâ\\éx¸°Ø\0q·måãíª&Ø~Âîî—”7²øÀ¹9[¤HéqdL•Oº2´v|B¯tæŠ\\Æ¤‰Hd¦ëâH‘\" òìN\n\0·©GÅgÎF ¸Fˆ}\"ì­&QEK¾‘{}\ryÇŽ¾˜r×›t›Àž„ï†7ÔNuÃ³[Aøgh;S¥.Ò ‚š±Â¥|yùÏ[Õ†_bòÈ¨¬!+RñèZXù@0NééþÁP€Þì%¡jD£Â¯z	þà—[øU\"¶{e’8ôŸ>”EL4JÐ½…0›¡¦è7 €´d·¬ ÀQ^`0`œ•¯]cð<g@Ž²hy8˜íp.ef\nóÎeh‡ƒaXÚÃømSßßjBÚ˜Q\"‡\rë×ÇK3†=>ÇªAX”[,,\"'<µ›–%¶a€«Ó´Ãµ.\$ñ\0ç%\0ásV¤îËp M\$¼@já×ð>¤­}VeÄ\$@—Í„#§ªÐ(3:ø`‚UðšYÌ¶uæ¨ûˆÏâÎ@ÄV#E‰G/¸üXD\$ˆhµƒav–¼xS\"]k18a¯Ñ9dJROÓŠs‘`EJ°½§øUo³m{l¹B8¥ˆÁ(\n}ei±büø, ; N”ªÍ‡øQØ\\èÇ¸I5yR¼\$!>\\Ê‰ŒgÂuj*?n°MÓÞ²hÝø\r%Á³àU(d€¦Nµd#}špA:¬¨ý•-\\èA»*Ä4€2I€®è\rÖ£»… 0h@\\ÔµÉÀ8ð3‚rq]òùd8\"ðQ ŒÿîÆ™:cÆàyÇ4	Ïá‘šdaÂ€‡Î 6>UÛAÚÑ:½@˜2‹Ûÿ\$òeh2´ûF»§É™Ná+’ŒŸ\rþÔ€(îAr‚°d*ü\0[®#cjŠû´>!(SðÈéLˆeýTÉÆM	9\0W:™BDýø‚3JŒ¬Õ_@sÇárue‡ø¦ð»ý¬ +º'B«É}\"B\"üz2Žî‹rël»xF[èLÙË²Ea9 Êcdb½¾^,ÔUC=/2»×ò¼øì/\$CÆ#Ú÷8¡}DÀÛ×6Ï`^;6B0U7ó·_=	,ª1âj1V[¨.	H9(1ï±Æ±ÒLz¢C¸	Ç\$.AÊfhã–«¾ÍàïDrY	ýHØe~o—r19æ—Ù…\\šß„P’)\"ÃQ¹´,ÑeòöL¾”w0Ï\0§—š–Ï;wìX³Ç¨‰çqo¹ï¾~Ÿ«öçø>9ô>}²òºdc¿\0åÊg¾¶fÎùq–&9—¹-ýJ#¤Š¸ª3^4m/Ì™¯\0\0006À¦n8£·>äˆ´.Ó—é’cph±ËÙù•››º_A@[‰•7«|9\$pMh >‰ŒÁ5°K¥úÃE=hþšAÒtŠ^âV×	©\"	c£B;¤öÞi…ÕQÒ t¬›òé@,\nØ)­óˆsÓ`Ÿ™°°;Ñ4´—‚„Ií£©‘íùèy€ -¤0yeÊ¨—U‚”Bî©v³¥3H™PÇGË5êï’s|·º\rðžÐ\$0ãèò•ò1½©l3€é(*oF~PK´ª.ý,'·J/Ó²tð‹d:š—n§\n©ðj†Y«zê(Æó’ü“w°Ý Zì#ZÊ	Io•@1ÆÎ»\$ïò±¦=VWz•	nŽBøaú›A»µqª@™´I€p	@Ñ5Ó–lH{UºÜoXõ¿fðŽÓ¿\\zµ×.§š²,-\\Ú—^y n^Å×ÊBq·þ…¤zXã‰¡ƒ\$¨*J72ÕD4.†Õ…!¤M0¶óDëìFŠàóã G¡ÏLˆmØc*mïcI£å5ÉŒ»^—t¿ª’jlŒ7æ›¿S¶Q ¢.i’éÖÔh¨õLÐÚ±B6Ô„h˜&ïJ …l\\‰ðWeªcÎf%kj™Á ¦pÃR=Œäi’@.õ¥(ä2klHUW\"™o¥j½§’p!S5Æè­pL'`\0¤O *¦Q3XÂ“‰ÞlJ\08\n…\r·²¸*€añüë–ž¼ûr™`<¤&ÚXBhÖ8!xš®&äBht¥\$ÿ‡þ]Énß†éóÉcL€€[Æµ©d¸á<`œ®\0œ€¢Ï‚ÞawæO%;‘õBC»…Q’\rÌ­ÓìŒì€pŠ¤«ØPQ¶Z’¸úZÁAu=N&Ðia\nÑmK6I}Ñ×n	šÅt\nd)í®ÐÈ÷bpÎ€\"žðg'¦0œ7ÃuÈ&@â7å8X NÀxÄáö­ú\$BùßZB/¶M¯gB»i¦ÖÑ§¶\\âmƒmIÌÄ€Êç;5=#&4˜ÌçþPÕ‰½éðqí’A™ä›\\…,q¤cÞŸ\ncâB–‚¾×úw\0BgjD‹@;=0m“k®Ä\rÄ²‹`À¤'5¤•¶k-Œ{¢‰\0¯_›Muîøƒ2“Ò×†§»£Àqø‰¬ð>)9ÈW\näd+…ÔÔ§ÀG\rýÃn4„‹äOØ:5ö†Þ8»1µ:Îš?¥‡(yGgWK\rÝ7­²“—m5.œ‚eŒHÙhJ«Ak#»ÓL¶..›\\Î=ÕñUÙÐ„˜ƒÓ:Ð>7ºW+^yD‚“œb­üG¡‘OZÍ4ïŠr(|xµÆýPr¸£,yŽ©Ð8qaÜ©O2µkªn˜Š#p2¾ûÇˆºØ”.¼£c’–U—c”öäëÅ‚jó\$ôí8Ä¬~š7ZR:ð×†8­9Î¨w(a”L¤%­-,ÔÈì¿Œ#ôfƒ%8þÉ|Þc‡‘¬œÚ×%X‘WÂ\n}6’‘HìÿñæËž¤¡#¹&J,'z“MüM…¢‰Œààº‘Ü†² ‘˜®/y6YQ¯‘ì¶ÚºdÓ™dÁÞóÏ:õãô£EƒŒp2gŸgÁ/î,ÒËäÚÕˆ'8ì^;´UWN…ÑÅÞÕ{ÉOCò…Ñ¤ô¢zÉiKX¢’Ú”NŒdG£RCJYõ’‘i²’×y#>zS²MUc£õƒ¨ûÿêRORÔ¾¡0)Ø0Êú]:=Ïž™tƒ‘Áëé'\$™sÒrFŽöÙ67	=\$BÄÓ!qs	1\"ü¬vÆ÷%‘ŒI•l<Êb!Û®6(Cd-Ê^<H`~2¹KìÍzKÝÙœ€Ô±­ÙÕy,qAá*º\0}‚ÝC¨pb€\\ÓSå5ÝßùÚ'(›áÓí|»Mëð„ÀWÚÀ5;\$5µT|ºò;kõñÈtîñ@ò‘â;9³)½ò;i.Û;›·í_¥ê×ÌF¶=ñœDä¥M`HÞ“ƒ\0ˆ	 N @°%w‡ªdèPbð\$H|kÆ[¾ÜdCI!:lÅü,§¨ý<÷”uòt”ô¼NeÏW^¡wè'6•ŒD¿áfýu ¬ihI÷Z:ŸÑ~ý÷Ï£r¾…ÈzÄ3õ+¯uoC·s2ÕbÆua”XðwWK£	HÔ¶27>âWÏÍÝyÃ£¬ÝMëJ£rpT¼”Lð‰|`f™…:ÊõšA²täŠd|i½³[wüèj„ŠW˜ 7‘¤£au‹© úëe ò•šA5­Q' Ê\0È 3‹Ò¾\$ÂçýŒ\rk)a; óæH=ù™Ö~óIGŠIæ°<ù´•\"ù¬ÉI1'è ™¢Gcm\0P\nïwèü#Í>Œ½ÛxB\"ñÒEm|…ù2Š\$}<3PYXgo£dß¶€<Ôþ£¿qE\"`×úÈ4ág«8r£]\nˆ¡—õ:ø›qVbTì£Òm°•…9K&Ò“Ä¤ÃmÔ7)@¨ÀQz›ÃÓ=¢½ßµÅ±íŸH\nÔëö}Oçi}»\rÙ£.¢¹v‹®p¾JW&ßu×550	Ô5ÀîPËIŒÁ\n½Ûí¸³Ææ­l\0O5*=Þú	…P-¢éÊH\0óf×%Ìtãº*¥S:±tÏ› €€?øÈ‚Hâñ÷ºq4ˆÐKÍ”§@€Ô¬»Ü‚.O(±ëü Z¡\$ÏÊÓ]¼‚Åo¿€n‹z«A±!€t85<WñR2[„8ò‚¶ùn5\$IÝµæµ•Z¤Àéó]'}ET\nŸú†Šä.˜í¤&ä7¦ÏVË@¤_ÀD”oÈý&J6°ß4iÃj\$ÈÒEL¢äþu“Üt¢‰Ëä+I¡Ð¢¢šûØ£~üS±SZTXÒ ¾PYz½Å\"\$VÇ_]ÿM(§ã7òƒºü·ÚÌáÃÀ‡t_´S‰óˆÃê/­ßt…½“Ä‚ü¿âmHä:\0»5à- _Z'#ö¥Á1‡P¿é´,}(Ÿ°~¸\0ì‹þ!Ò–`-þP\neùy (¿Êˆ `9OËú!Á;5‰\n½\$ê{úŸ¯þðìUAü¨7ùá!¿çò€[ý ¸Yý¿ÅFæ¿´ÿƒý¯ð>è8&€›Þÿ!CLà¦ÿH€¯õ(”\0'Ç2ûìd\r%‚;àkæŠ4ûÀ_OÏ>þ5³öà@DýÒ¼ÏÞ\0VÃA€6' AY¬¢¶ýS°¿‚££rÔ¾´4š+h@bÿãõ­¾´þ‚Oá”M\0Àå˜ÀrÌ›ú@ÿ\rJùÓm0\08ùOò€ìÿ;kÓ ÊëþA(6£|	`8 ß\0ˆ°&¿²EÐVÏå\0VþãñÏï€wk…NÀ°KùÁ—¡xdpÀÒÿsìAL§â«A¾Xëkÿ‘u\0Œïþ„Ít ÀÔ¢ò.‰>(N’ÅK'flï¢ªdúAŠ‚â?++ðN“Œ~‚ ÿ²˜úkæ€¾²€ªPR\0èúx¡ØãûèÊ‘ô”‹BK]¦bUÃÑ\\Ì›¸€„d\0S@¿ä«QÀïÍ‰šb™\0\0b„„Ö\0_\\¡@\nN—î äOÎA„PfÁ„€ Œ¶ôÔAj ¨ÂM4<¤9“°Ú+çÀ¿¨Ÿ`S‰‹ ìü”Èw3Tð¬„7âX»Â†T!\0eïPAIÈb 1!\0€ž4³åà'¹ @ ! 8\0’Ë/ïˆ º!:K•,ØCASðX‘f®e©ÎMùý.:˜¼:òÆtŸ»¡àÃÌ._ºd„ÿ‹°81v`B\"ä‚Å!.^Ú*åáN.^‡š\n„&\r(Ÿš.Á©§îO0Š«@÷ÙPŠ¹njÒàŽÚ—#¡¼îäÓå&¹‚rHØ<¨†  ¢!à’3¶Ü(i @ÜAaÁÅ{õ Â¬#ÉS©½†6ð¨˜¶F@©Ô¦ãY[Oœƒ( .‡¬/„BüËñÇó)L02BØˆÌ-ÁÆ€Øùqp¹‹J<¤.Ð‘\0\nçï\0ÐÔ/@8C¤4PÀÇ\r	PÂ•°)üðFâå\$q.]¬\"B#‹Å	œ#\\£Â84\$Ãs:.(*Oi>™|#T'`—Bu«a/ˆ€ãCÀÂTØKaêX8Î`p ¸ÚÕÁ\0`Ê\0");
    } elseif ($_GET["file"] == "jush.js") {
        header("Content-Type: text/javascript; charset=utf-8");
        echo
        lzw_decompress("v0œF£©ÌÐ==˜ÎFS	ÐÊ_6MÆ³˜èèr:™E‡CI´Êo:C„”Xc‚\ræØ„J(:=ŸE†¦a28¡xð¸?Ä'ƒi°SANN‘ùðxs…NBáÌVl0›ŒçS	œËUl(D|Ò„çÊP¦À>šE†ã©¶yHchäÂ-3Eb“å ¸b½ßpEÁpÿ9.Š˜Ì~\nŽ?Kb±iw|È`Ç÷d.¼x8EN¦ã!”Í2™‡3©ˆá\r‡ÑYŽÌèy6GFmYŽ8o7\n\r³0¤÷\0DbcÓ!¾Q7Ð¨d8‹Áì~‘¬N)ùEÐ³`ôNsßð`ÆS)ÐOé—·ç/º<xÆ9Žo»ÔåµÁì3n«®2»!r¼:;ã+Â9ˆCÈ¨®‰Ã\n<ñ`Èó¯bè\\š?`†4\r#`È<¯BeãB#¤N Üã\r.D`¬«jê4ÿŽŽpéar°øã¢º÷>ò8Ó\$Éc ¾1Écœ ¡c êÝê{n7ÀÃ¡ƒAðNÊRLi\r1À¾ø!£(æjÂ´®+Âê62ÀXÊ8+Êâàä.\rÍÎôƒÎ!x¼åƒhù'ãâˆ6Sð\0RïÔôñOÒ\n¼…1(W0…ãœÇ7qœë:NÃE:68n+ŽäÕ´5_(®s \rã”ê‰/m6PÔ@ÃEQàÄ9\n¨V-‹Áó\"¦.:åJÏ8weÎq½|Ø‡³XÐ]µÝY XÁeåzWâü Ž7âûZ1íhQfÙãu£jÑ4Z{p\\AUËJ<õ†káÁ@¼ÉÃà@„}&„ˆL7U°wuYhÔ2¸È@ûu  Pà7ËA†hèÌò°Þ3Ã›êçXEÍ…Zˆ]­lá@MplvÂ)æ ÁÁHW‘‘Ôy>Y-øYŸè/«›ªÁî hC [*‹ûFã­#~†!Ð`ô\r#0PïCË—f ·¶¡îÃ\\î›¶‡É^Ã%B<\\½fˆÞ±ÅáÐÝã&/¦O‚ðL\\jF¨jZ£1«\\:Æ´>N¹¯XaFÃAÀ³²ðÃØÍf…h{\"s\n×64‡ÜøÒ…¼?Ä8Ü^p\"ë°ñÈ¸\\Úe(¸PƒNµìq[g¸Árÿ&Â}PhÊà¡ÀWÙí*Þír_sËP‡hà¼àÐ\nÛËÃomõ¿¥Ãê—Ó#§¡.Á\0@épdW ²\$Òº°QÛ½Tl0† ¾ÃHdHë)š‡ÛÙÀ)PÓÜØHgàýUþ„ªBèe\r†t:‡Õ\0)\"Åtô,´œ’ÛÇ[(DøO\nR8!†Æ¬ÖšðÜlAüV…¨4 hà£Sq<žà@}ÃëÊgK±]®àè]â=90°'€åâøwA<‚ƒÐÑaÁ~€òWšæƒD|A´††2ÓXÙU2àéyÅŠŠ=¡p)«\0P	˜s€µn…3îr„f\0¢F…·ºvÒÌG®ÁI@é%¤”Ÿ+Àö_I`¶ÌôÅ\r.ƒ N²ºËKI…[”Ê–SJò©¾aUf›Szûƒ«M§ô„%¬·\"Q|9€¨Bc§aÁq\0©8Ÿ#Ò<a„³:z1Ufª·>îZ¹l‰‰¹ÓÀe5#U@iUGÂ‚™©n¨%Ò°s¦„Ë;gxL´pPš?BçŒÊQ\\—b„ÿé¾’Q„=7:¸¯Ý¡Qº\r:ƒtì¥:y(Å ×\nÛd)¹ÐÒ\nÁX; ‹ìŽêCaA¬\ráÝñŸP¨GHù!¡ ¢@È9\n\nAl~H úªV\nsªÉÕ«Æ¯ÕbBr£ªö„’­²ßû3ƒ\ržP¿%¢Ñ„\r}b/‰Î‘\$“5§PëCä\"wÌB_çŽÉUÕgAtë¤ô…å¤…é^QÄåUÉÄÖj™Áí Bvhì¡„4‡)¹ã+ª)<–j^<Lóà4U* õBg ëÐæè*nÊ–è-ÿÜõÓ	9O\$´‰Ø·zyM™3„\\9Üè˜.oŠ¶šÌë¸E(iåàžœÄÓ7	tßšé-&¢\nj!\rÀyœyàD1gðÒö]«ÜyRÔ7\"ðæ§·ƒˆ~ÀíàÜ)TZ0E9MåYZtXe!Ýf†@ç{È¬yl	8‡;¦ƒR{„ë8‡Ä®ÁeØ+ULñ'‚F²1ýøæ8PE5-	Ð_!Ô7…ó [2‰JËÁ;‡HR²éÇ¹€8pç—²Ý‡@™£0,Õ®psK0\r¿4”¢\$sJ¾Ã4ÉDZ©ÕI¢™'\$cL”R–MpY&ü½Íiçz3GÍzÒšJ%ÁÌPÜ-„[É/xç³T¾{p¶§z‹CÖvµ¥Ó:ƒV'\\–’KJa¨ÃMƒ&º°£Ó¾\"à²eo^Q+h^âÐiTð1ªORäl«,5[Ý˜\$¹·)¬ôjLÆU`£SË`Z^ð|€‡r½=Ð÷nç™»–˜TU	1Hyk›Çt+\0váD¿\r	<œàÆ™ìñjG”ž­tÆ*3%k›YÜ²T*Ý|\"CŠülhE§(È\rÃ8r‡×{Üñ0å²×þÙDÜ_Œ‡.6Ð¸è;ãü‡„rBjƒO'Ûœ¥¥Ï>\$¤Ô`^6™Ì9‘#¸¨§æ4Xþ¥mh8:êûc‹þ0ø×;Ø/Ô‰·¿¹Ø;ä\\'( î„tú'+™òý¯Ì·°^]­±NÑv¹ç#Ç,ëvð×ÃOÏiÏ–©>·Þ<SïA\\€\\îµü!Ø3*tl`÷u\0p'è7…Pà9·bsœ{Àv®{·ü7ˆ\"{ÛÆrîaÖ(¿^æ¼ÝE÷úÿë¹gÒÜ/¡øžUÄ9g¶î÷/ÈÔ`Ä\nL\n)À†‚(Aúað\" žçØ	Á&„PøÂ@O\nå¸«0†(M&©FJ'Ú! …0Š<ïHëîÂçÆù¥*Ì|ìÆ*çOZím*n/bî/ö®Ôˆ¹.ìâ©o\0ÎÊdnÎ)ùŽi:RŽÎëP2êmµ\0/vìOX÷ðøFÊ³ÏˆîŒè®\"ñ®êöî¸÷0õ0ö‚¬©í0bËÐgjðð\$ñné0}°	î@ø=MÆ‚0nîPŸ/pæotì€÷°¨ð.ÌÌ½g\0Ð)o—\n0È÷‰\rF¶é€ b¾i¶Ão}\n°Ì¯…	NQ°'ðxòFaÐJîÎôLõéðÐàÆ\rÀÍ\r€Öö‘0Åñ'ð¬Éd	oepÝ°4DÐÜÊ¦q(~ÀÌ ê\r‚E°ÛprùQVFHœl£‚Kj¦¿äN&­j!ÍH`‚_bh\r1Ž ºn!ÍÉŽ­z™°¡ð¥Í\\«¬\rŠíŠÃ`V_kÚÃ\"\\×‚'Vˆ«\0Ê¾`ACúÀ±Ï…¦VÆ`\r%¢’ÂÅì¦\rñâƒ‚k@NÀ°üBñíš™¯ ·!È\n’\0Z™6°\$d Œ,%à%laíH×\n‹#¢S\$!\$@¶Ý2±„I\$r€{!±°J‡2HàZM\\ÉÇhb,‡'||cj~gÐr…`¼Ä¼º\$ºÄÂ+êA1ðœE€ÇÀÙ <ÊL¨Ñ\$âY%-FDªŠd€Lç„³ ª\n@’bVfè¾;2_(ëôLÄÐ¿Â²<%@Úœ,\"êdÄÀN‚erô\0æƒ`Ä¤Z€¾4Å'ld9-ò#`äóÅ–…à¶Öãj6ëÆ£ãv ¶àNÕÍf Ö@Ü†“&’B\$å¶(ðZ&„ßó278I à¿àP\rk\\§—2`¶\rdLb@Eöƒ2`P( B'ã€¶€º0²& ô{Â•“§:®ªdBå1ò^Ø‰*\r\0c<K|Ý5sZ¾`ºÀÀO3ê5=@å5ÀC>@ÂW*	=\0N<g¿6s67Sm7u?	{<&LÂ.3~DÄê\rÅš¯x¹í),rîinÅ/ åO\0o{0kÎ]3>m‹”1\0”I@Ô9T34+Ô™@e”GFMCÉ\rE3ËEtm!Û#1ÁD @‚H(‘Ón ÃÆ<g,V`R]@úÂÇÉ3Cr7s~ÅGIói@\0vÂÓ5\rVß'¬ ¤ Î£PÀÔ\râ\$<bÐ%(‡Ddƒ‹PWÄîÐÌbØfO æx\0è} Üâ”lb &‰vj4µLS¼¨Ö´Ô¶5&dsF Mó4ÌÓ\".HËM0ó1uL³\"ÂÂ/J`ò{Çþ§€ÊxÇYu*\"U.I53Q­3Qô»J„”g ’5…sàúŽ&jÑŒ’Õu‚Ù­ÐªGQMTmGBƒtl-cù*±þ\rŠ«Z7Ôõó*hs/RUV·ðôªBŸNËˆ¸ÃóãêÔŠài¨Lk÷.©´Ätì é¾©…rYi”Õé-Sµƒ3Í\\šTëOM^­G>‘ZQjÔ‡™\"¤Ž¬i”ÖMsSãS\$Ib	f²âÑuæ¦´™å:êSB|i¢ YÂ¦ƒà8	vÊ#é”Dª4`‡†.€Ë^óHÅM‰_Õ¼ŠuÀ™UÊz`ZJ	eçºÝ@Ceíëa‰\"mób„6Ô¯JRÂÖ‘T?Ô£XMZÜÍÐ†ÍòpèÒ¶ªQv¯jÿjV¶{¶¼ÅCœ\rµÕ7‰TÊžª úí5{Pö¿]’\rÓ?QàAAÀèŽ‹’Í2ñ¾ “V)Ji£Ü-N99f–l JmÍò;u¨@‚<FþÑ ¾e†j€ÒÄ¦I‰<+CW@ðçÀ¿Z‘lÑ1É<2ÅiFý7`KG˜~L&+NàYtWHé£‘w	Ö•ƒòl€Òs'gÉãq+Lézbiz«ÆÊÅ¢Ð.ÐŠÇzW²Ç ùzd•W¦Û÷¹(y)vÝE4,\0Ô\"d¢¤\$Bã{²Ž!)1U†5bp#Å}m=×È@ˆwÄ	P\0ä\rì¢·‘€`O|ëÆö	œÉüÅõûYôæJÕ‚öE×ÙOuž_§\n`F`È}MÂ.#1á‚¬fì*´Õ¡µ§  ¿zàucû€—³ xfÓ8kZR¯s2Ê‚-†’§Z2­+ŽÊ·¯(åsUõcDòÑ·Êì˜ÝX!àÍuø&-vPÐØ±\0'LïŒX øLÃ¹Œˆo	Ýô>¸ÕŽÓ\r@ÙPõ\rxF×üE€ÌÈ­ï%Àãì®ü=5NÖœƒ¸?„7ùNËÃ…©wŠ`ØhX«98 Ìø¯q¬£zãÏd%6Ì‚tÍ/…•˜ä¬ëLúÍl¾Ê,ÜKa•N~ÏÀÛìú,ÿ'íÇ€M\rf9£w˜!x÷x[ˆÏ‘ØG’8;„xA˜ù-IÌ&5\$–D\$ö¼³%…ØxÑ¬Á”ÈÂ´ÀÂŒ]›¤õ‡&o‰-39ÖLù½zü§y6¹;u¹zZ èÑ8ÿ_•Éx\0D?šX7†™«’y±OY.#3Ÿ8 ™Ç€˜e”Q¨=Ø€*˜™GŒwm ³Ú„Y‘ù ÀÚ]YOY¨F¨íšÙ)„z#\$eŠš)†/Œz?£z;™—Ù¬^ÛúFÒZg¤ù• Ì÷¥™§ƒš`^Úe¡­¦º#§“Øñ”©Žú?œ¸e£€M£Ú3uÌåƒ0¹>Ê\"?Ÿö@×—Xv•\"ç”Œ¹¬¦*Ô¢\r6v~‡ÃOV~&×¨^gü šÄ‘Ùž‡'Î€f6:-Z~¹šO6;zx²;&!Û+{9M³Ù³d¬ \r,9Öí°ä·WÂÆÝ­:ê\rúÙœùã@ç‚+¢·]œÌ-ž[gž™Û‡[s¶[ižÙiÈq››y›éxé+“|7Í{7Ë|w³}„¢›£E–ûW°€Wk¸|JØ¶å‰xmˆ¸q xwyjŸ»˜#³˜e¼ø(²©‰¸ÀßžÃ¾™†ò³ {èßÚ y“ »M»¸´@«æÉ‚“°Y(gÍš-ÿ©º©äí¡š¡ØJ(¥ü@ó…;…yÂ#S¼‡µY„Èp@Ï%èsžúoŸ9;°ê¿ôõ¤¹+¯Ú	¥;«ÁúˆZNÙ¯Âº§„š k¼V§·u‰[ñ¼x…|q’¤ON?€ÉÕ	…`uœ¡6|­|X¹¤­—Ø³|Oìx!ë:¨œÏ—Y]–¬¹Ž™c•¬À\r¹hÍ9nÎÁ¬¬ë€Ï8'—ù‚êà Æ\rS.1¿¢USÈ¸…¼X‰É+ËÉz]ÉµÊ¤?œ©ÊÀCË\r×Ë\\º­¹ø\$Ï`ùÌ)UÌ|Ë¤|Ñ¨x'ÕœØÌäÊ<àÌ™eÎ|êÍ³ç—â’Ìé—LïÏÝMÎy€(Û§ÐlÐº¤O]{Ñ¾×FD®ÕÙ}¡yu‹ÑÄ’ß,XL\\ÆxÆÈ;U×ÉWt€vŸÄ\\OxWJ9È’×R5·WiMi[‡Kˆ€f(\0æ¾dÄšÒè¿©´\rìMÄáÈÙ7¿;ÈÃÆóÒñçÓ6‰KÊ¦Iª\rÄÜÃxv\r²V3ÕÛßÉ±.ÌàRùÂþÉá|Ÿá¾^2‰^0ß¾\$ QÍä[ã¿D÷áÜ£å>1'^X~t1\"6Lþ›+þ¾Aàžeá“æÞåI‘ç~Ÿåâ³â³@ßÕ­õpM>Óm<´ÒSKÊç-HÉÀ¼T76ÙSMfg¨=»ÅGPÊ°›PÖ\r¸é>Íö¾¡¥2Sb\$•C[Ø×ï(Ä)žÞ%Q#G`uð°ÇGwp\rkÞKe—zhjÓ“zi(ôèrO«óÄÞÓþØT=·7³òî~ÿ4\"ef›~íd™ôíVÿZ‰š÷U•-ëb'VµJ¹Z7ÛöÂ)T‘£8.<¿RMÿ\$‰žôÛØ'ßbyï\n5øƒÝõ_ŽàwñÎ°íUð’`eiÞ¿J”b©gðuSÍë?Íå`öážì+¾Ïï Mïgè7`ùïí\0¢_Ô-ûŸõ_÷–?õF°\0“õ¸X‚å´’[²¯Jœ8&~D#Áö{P•Øô4Ü—½ù\"›\0ÌÀ€‹ý§ý@Ò“–¥\0F ?* ^ñï¹å¯wëÐž:ð¾uàÏ3xKÍ^ów“¼¨ß¯‰y[Ôž(žæ–µ#¦/zr_”g·æ?¾\0?€1wMR&M¿†ù?¬St€T]Ý´Gõ:I·à¢÷ˆ)‡©Bïˆ‹ vô§’½1ç<ôtÈâ6½:W{ÀŠôx:=Èî‘ƒŒÞšóø:Â!!\0x›Õ˜£÷q&áè0}z\"]ÄÞo•z¥™ÒjÃw×ßÊÚÁ6¸ÒJ¢PÛž[\\ }ûª`S™\0à¤qHMë/7B’€P°ÂÄ]FTã•8S5±/IÑ\rŒ\n îO¯0aQ\n >Ã2­j…;=Ú¬ÛdA=­p£VL)Xõ\nÂ¦`e\$˜TÆ¦QJÎk´7ª*Oë .‰ˆ…òÄ¡\röµš\$#pÝWT>!ªªv|¿¢}ë× .%˜Á,;¨ê›å…­Úf*?«ç„˜ïô„\0¸ÄpD›¸! ¶õ#:MRcúèB/06©­®	7@\0V¹vg€ ØÄhZ\nR\"@®ÈF	‘Êä¼+Êš°EŸIÞ\n8&2ÒbXþPÄ¬€Í¤=h[§¥æ+ÕÊ‰\r:ÄÍFû\0:*åÞ\r}#úˆ!\"¤c;hÅ¦/0ƒ·Þ’òEj®íÁ‚Î]ñZ’Žˆ‘—\0Ú@iW_–”®h›;ŒVRb°ÚP%!­ìb]SBšƒ’õUl	åâ³érˆÜ\rÀ-\0 À\"Q=ÀIhÒÍ€´	 F‘ùþLèÎFxR‚Ñ@œ\0*Æj5Œük\0Ï0'	@El€O˜ÚÆH CxÜ@\"G41Ä`Ï¼P(G91«Ž\0„ð\"f:QÊ¸@¨`'>7ÑÈŽädÀ¨ˆíÇR41ç>ÌrIHõGt\n€RH	ÀÄbÒ€¶71»ìfãh)Dª„8 B`À†°(V<Q§8c? 2€´€EŽ4j\0œ9¼\r‚Íÿ@‹\0'FúDš¢,Å!ÓÿH=Ò* ˆEí(×ÆÆ?Ñª&xd_H÷Ç¢E²6Ä~£uÈßG\0RXýÀZ~P'U=Çß @žèÏÈl+A­\n„h£IiÆ”ü±ŸPG€Z`\$ÈP‡þ‘À¤Ù.Þ;ÀEÀ\0‚}€ §¸Q±¤“äÓ%èÑÉjA’W’Ø¥\$»!ýÉ3r1‘ {Ó‰%i=IfK”!Œe\$àžé8Ê0!üh#\\¹HF|Œi8tl\$ƒðÊlÀìläi*(ïG¸ñçL	 ß\$€—xØ.èq\"Wzs{8d`&ðWô©\0&E´¯Íì15jWäb¬öÄ‡ÊÞV©R„³™¿-#{\0ŠXi¤²Äg*÷š7ÒVF3‹`å¦©p@õÅ#7°	å†0€æ[Ò®–¬¸[øÃ©hË–\\áo{ÈáÞT­ÊÒ]²ï—Œ¼Å¦á‘€8l`f@—reh·¥\nÊÞW2Å*@\0€`K(©L•Ì·\0vTƒË\0åc'L¯ŠÀ:„” 0˜¼@L1×T0b¢àhþWÌ|\\É-èïÏDN‡óž€\ns3ÀÚ\"°€¥°`Ç¢ùè‚’2ªå€&¾ˆ\rœU+™^ÌèR‰eS‹n›i0ÙuËšb	J˜’€¹2s¹Ípƒs^n<¸¥òâ™±Fl°aØ\0¸š´\0’mA2›`|ØŸ6	‡¦nrÁ›¨\0DÙ¼Íì7Ë&mÜß§-)¸ÊÚ\\©ÆäÝŒ\n=â¤–à;* ‚Þb„è“ˆÄT“‚y7cú|o /–Ôßß:‹ît¡P<ÙÀY: žK¸&C´ì'G/Å@ÎàQ *›8çv’/‡À&¼üòWí6p.\0ªu3«žŒñBq:(eOPáp	”é§²üÙã\rœ‹á0ž(ac>ºNö|£º	“t¹Ó\n6vÀ_„îeÝ;yÕÎè6fügQ;yúÎ²[Sø	äëgöÇ°èO’ud¡dH€Hð= Z\ræ'ÚÊùqC*€) žœîgÂÇEêO’€ \" ð¨!kÐ('€`Ÿ\nkhTùÄ*ösˆÄ5R¤Eöa\n#Ö!1¡œ¿‰×\0¡;ÆÇSÂiÈ¼@(àl¦Á¸I× Ìv\rœnj~ØçŠ63¿ÎˆôI:h°ÔÂƒ\n.‰«2plÄ9Btâ0\$bº†p+”Ç€*‹tJ¢ðÌ¾s†JQ8;4P(ý†Ò§Ñ¶!’€.Ppk@©)6¶5ý”!µ(ø“\n+¦Ø{`=£¸H,É\\Ñ´€4ƒ\"[²Cø»º1“´Œ-èÌluoµä¸4•[™±â…EÊ%‡\"‹ôw] Ù(ã ÊTe¢)êK´A“E={ \n·`;?Ýôœ-ÀGŠ5I¡í­Ò.%Á¥²þéq%EŸ—ýs¢é©gFˆ¹s	‰¦¸žŠKºGÑøn4i/,­i0·uèx)73ŒSzgŒâÁV[¢¯hãDp'ÑL<TM¤äjP*oœâ‰´‘\nHÎÚÅ\n 4¨M-W÷NÊA/î†@¤8mH¢‚Rp€tžp„V”=h*0ºÁ	¥1;\0uG‘ÊT6’@s™\0)ô6À–Æ£T\\…(\"ŽèÅU,ò•C:‹¥5iÉKšl«ì‚Û§¡E*Œ\"êrà¦ÔÎ.@jRâJ–QîŒÕ/¨½L@ÓSZ”‘¥Põ)(jjžJ¨««ŽªÝL*ª¯Ä\0§ªÛ\r¢-ˆñQ*„QÚœgª9é~P@…ÕÔH³‘¬\n-e»\0êQw%^ ETø< 2Hþ@Þ´îe¥\0ð e#;öÖI‚T’l“¤Ý+A+C*’YŒ¢ªh/øD\\ð£!é¬š8“Â»3AÐ™ÄÐEðÍE¦/}0tµJ|™ÀÝ1Qm«Øn%(¬p´ë!\nÈÑÂ±UË)\rsEXú‚’5u%B- ´Àw]¡*•»E¢)<+¾¦qyV¸@°mFH òÔšBN#ý]ÃYQ1¸Ö:¯ìV#ù\$“æ þô<&ˆX„€¡úÿ…x« tš@]GðíÔ¶¥j)-@—qÐˆL\nc÷I°Y?qC´\ràv(@ØËX\0Ov£<¬Rå3X©µ¬Q¾Jä–Éü9Ö9ÈlxCuÄ«d±± vT²Zkl\rÓJíÀ\\o›&?”o6EÐq °³ªÉÐ\r–÷«'3úËÉª˜J´6ë'Y@È6ÉFZ50‡VÍT²yŠ¬˜C`\0äÝVS!ýš‹&Û6”6ÉÑ³rD§f`ê›¨Jvqz„¬àF¿ ÂÂò´@è¸Ýµ…šÒ…Z.\$kXkJÚ\\ª\"Ë\"àÖi°ê«:ÓEÿµÎ\roXÁ\0>P–¥Pðmi]\0ªöö“µaV¨¸=¿ªÈI6¨´°ÎÓjK3ÚòÔZµQ¦m‰EÄèðbÓ0:Ÿ32ºV4N6³´à‘!÷lë^Ú¦Ù@hµhUÐ>:ú	˜ÐE›>jäèÐú0g´\\|¡Shâ7yÂÞ„\$•†,5aÄ—7&¡ë°:[WX4ÊØqÖ ‹ìJ¹Æä×‚Þc8!°H¸àØVD§ÄŽ­+íDŠ:‘¡¥°9,DUa!±X\$‘ÕÐ¯ÀÚ‹GÁÜŒŠBŠt9-+oÛt”L÷£}Ä­õqK‹‘x6&¯¯%x”ÏtR¿–éð\"ÕÏ€èR‚IWA`c÷°È}l6€Â~Ä*¸0vkýp«Ü6Àë›8z+¡qúXöäw*·EƒªIN›¶ªå¶ê*qPKFO\0Ý,ž(Ð€|œ•‘”°k *YF5”åå;“<6´@ØQU—\"×ð\rbØOAXÃŽvè÷v¯)H®ôo`STÈpbj1+Å‹¢e²Á™ Ê€Qx8@¡‡ÐÈç5\\Q¦,Œ‡¸Ä‰NëÝÞ˜b#Y½H¥¯p1›ÖÊøkB¨8NüoûX3,#UÚ©å'Ä\"†é”€ÂeeH#z›­q^rG[¸—:¿\r¸m‹ngòÜÌ·5½¥V]«ñ-(ÝWð¿0âëÑ~kh\\˜„ZŠå`ïél°êÄÜk ‚oÊjõWÐ!€.¯hFŠÔå[tÖA‡wê¿e¥Mà««¡3!¬µÍæ°nK_SF˜j©¿þ-S‚[rœÌ€wä´ø0^Áh„fü-´­ý°?‚›ýXø5—/±©Š€ëëIY ÅV7²a€d ‡8°bq·µbƒn\n1YRÇvT±õ•,ƒ+!Øýü¶NÀT£î2IÃß·ÄÄ÷„ÇòØ‡õ©K`K\"ð½ô£÷O)\nY­Ú4!}K¢^²êÂàD@á…÷naˆ\$@¦ ƒÆ\$AŠ”jÉËÇø\\‹D[=Ë	bHpùSOAG—ho!F@l„UËÝ`Xn\$\\˜Íˆ_†¢Ë˜`¶âHBÅÕ]ª2ü«¢\"z0i1‹\\”ÞÇÂÔwù.…fyÞ»K)£îíÂ‡¸ pÀ0ä¸XÂS>1	*,]’à\r\"ÿ¹<cQ±ñ\$t‹„qœ.‹ü	<ð¬ñ™Ž+t,©]Lò!È{€gŽüãX¤¶\$¤6v…˜ùÇ ¡Žš£%GÜHõ–ÄØœÈEŽ ÒXÃÈ*Á‚0ÛŠ)q¡nCØ)I›ûà\"µåÚÅÞíˆ³¬`„KFçÁ’@ïd»5Œê»AÈÉp€{“\\äÓÀpÉ¾Nòrì'£S(+5®ÐŠ+ \"´Ä€£U0ÆiËÜ›úæ!nMˆùbrKÀðä6Ãº¡r–ì¥â¬|aüÊÀˆ@Æx|®²kaÍ9WR4\"?5Ê¬pýÛ“•ñk„rÄ˜«¸¨ýß’ðæ¼7Â—Hp†‹5YpW®¼ØG#ÏrÊ¶AWD+`¬ä=Ê\"ø}Ï@HÑ\\Žp°“Ð€©ß‹Ì)C3Í!ŽsO:)Ùè_F/\r4éÀç<A¦…\nn /Tæ3f7P1«6ÓÄÙýOYÐ»Ï²‡¢óqì×;ìØÀæaýXtS<ã¼9Ânws²x@1ÎžxsÑ?¬ï3Åž@¹…×54„®oÜÈƒ0»ÞÐïpR\0Øà¦„†Îù·óâyqßÕL&S^:ÙÒQð>\\4OInƒZ“nçòvà3¸3ô+P¨…L(÷Ä”ð…Àà.x \$àÂ«Cå‡éCnªAžkçc:LÙ6¨ÍÂr³w›ÓÌh°½ÙÈnr³Zêã=è»=jÑ’˜³‡6}MŸGýu~3ùšÄbg4Åùôs6sóQé±#:¡3g~v3¼ó€¿<¡+Ï<ô³Òa}Ï§=Îe8£'n)ÓžcCÇzÑ‰4L=hýŒ{i´±Jç^~çƒÓwg‹Dà»jLÓéÏ^šœÒÁ=6Î§NÓ”êÅÁ¢\\éÛDóÆÑN”†êEý?hÃ:SÂ*>„ô+¡uúhhÒ…´W›E1j†x²Ÿôí´ŠtÖ'Îtà[ îwS²¸ê·9š¯Tö®[«,ÕjÒv“òÕîžt£¬A#T™¸Ôæž‚9ìèj‹K-õÒÞ ³¿¨Yèi‹Qe?®£4ÓžÓÁë_WzßÎéó‹@JkWYêhÎÖpu®­çj|z4×˜õ	èi˜ðm¢	àO5à\0>ç|ß9É×–«µè½ öëgVyÒÔu´»¨=}gs_ºãÔV¹sÕ®{çk¤@r×^—õÚ(ÝwÏ…øH'°Ýaì=i»ÖNÅ4µ¨‹ë_{Ï6ÇtÏ¨ÜöÏ—e [Ðh-¢“Ul?Jîƒ0O\0^ÛHlõ\0.±„Z‚’œ¼âÚxu€æð\"<	 /7ÁŠ¨Ú û‹ïi:Ò\nÇ ¡´à;íÇ!À3ÚÈÀ_0`ž\0H`ž€Â2\0€ŒHò#h€[¶P<í¦†‘×¢g¶Ü§m@~ï(þÕ\0ßµkâY»vÚæâ#>¥ù„\nz\n˜@ÌQñ\n(àGÝ\nöüàŽ'kóš¦èº5“n”5Û¨Ø@_`Ð‡_l€1Üþèwp¿Pî›w›ªÞ\0…ŽcµÐoEl{ÅÝ¾é7“»¼¶o0ÐÛÂôIbÏên‹zÛÊÞÎï·›¼ ‹ç{Ç8øwŽ=ëîŸ| /yê3aíß¼#xqŸÛØò¿»@ï÷kaà!ÿ\08dîmˆäR[wvÇ‹RGp8øŸ vñ\$Zü½¸mÈûtÜÞÝÀ¥·½íôºÜû·Ç½Ôîûu€oÝp÷`2ðãm|;#x»mñnç~;ËáVëE£ÂíØðÄü3OŸ\r¸,~o¿w[òáNêø}ºþ ›clyá¾ñ¸OÄÍÞñ;…œ?á~ì€^j\"ñWz¼:ß'xWÂÞ.ñ	Áu’(¸ÅÃäq—‹<gâçv¿hWq¿‰\\;ßŸ8¡Ã)M\\³š5vÚ·x=h¦iºb-ÀÞ|bÎðàpyŽDÐ•Hh\rceà˜y7·p®îxþÜG€@D=ð Öù§1Œÿ!4Ra\r¥9”!\0'ÊYŒŸ¥@>iS>æ€Ö¦Ÿo°óoòÎfsO 9 .íþéâ\"ÐF‚…ló20åðE!Qšá¦çËD9dÑBW4ƒ›\0û‚y`RoF>FÄa„‰0‘ùÊƒó0	À2ç<‚IÏP'\\ñçÈIÌ\0\$Ÿœ\n R aUÐ.‚sÐ„«æ\"ùŽš1Ð†…eºYç ¢„Zêqœñ1 |Ç÷#¯G!±P’P\0|‰HÇFnp>Wü:¢ž`YP%”ÄâŸ\nÈa8‰ÃP>‘ÁÁè–™`]‘‹4œ`<Ðr\0ùÃŽ›ç¨û¡–z–4Ù‡¥Ë8€ùÎÐ4ó`mãh:¢Îª¬HDªãÀjÏ+p>*ä‹ÃÄê8äŸÕ 08—A¸È:€À»Ñ´]wêÃºùz>9\n+¯ççÍÀñØ:Ž—°ii“PoG0°Öö1þ¬)ìŠZ°Ú–èn¤È’ì×eRÖ–Üí‡g£M¢à”ÀŒgs‰LC½rç8Ð€!°†À‚Œ3R)Îú0³0Œôs¨IéJˆVPpK\n|9e[á•ÖÇË‘²’D0¡Õ àz4Ï‘ªo¥Ôéáèà´,N8nåØsµ#{è“·z3ð>¸BSý\";Àe5VD0±¬š[\$7z0¬ºøÃËã=8þ	T 3÷»¨Q÷'R’±—’ØnÈ¼LÐyÅ‹ìö'£\0oäÛ,»‰\0:[}(’¢ƒ|×ú‡X†>xvqWá“?tBÒE1wG;ó!®Ý‹5Î€|Ç0¯»JI@¯¨#¢ˆÞuÅ†Iážø\\p8Û!'‚]ß®šl-€låSßBØð,Ó—·»ò]èñ¬1‡Ô•HöÿNÂ8%%¤	Å/;FGSôòôhé\\Ù„ÓcÔt²¡á2|ùWÚ\$tøÎ<ËhÝOŠ¬+#¦BêaN1ùç{ØÐyÊwòš°2\\Z&)½d°b'ž,XxmÃ~‚Hƒç@:d	>=-Ÿ¦lK¯ŒÜþJí€\0ŸÌÌó@€rÏ¥²@\"Œ(AÁñïªýZ¼7Åh>¥÷­½\\Íæú¨#>¬õø\0­ƒXrã—YøïYxÅæq=:žšÔ¹ó\rlŠoæm‡gbööÀ¿À˜ï„D_àTx·C³ß0.Šôy€†R]Ú_ÝëÇZñÇ»WöIàëGÔï	MÉª(®É|@\0SO¬ÈsÞ {î£”ˆø@k}äFXSÛb8àå=¾È_ŠÔ”¹l²\0å=ÈgÁÊ{ HÿÉyGüÕáÛ sœ_þJ\$hkúF¼q„àŸ÷¢Éd4Ï‰ø»æÖ'ø½>vÏ¬ !_7ùVq­Ó@1zë¤uSe…õjKdyuëÛÂS©.‚2Œ\"¯{úÌKþØË?˜s·ä¬Ë¦h’ßRíd‚é`:y—ÙåûGÚ¾\nQéý·Ùßow’„'öïhS—î>ñ©¶‰LÖX}ðˆe·§¸G¾â­@9ýãíŸˆüWÝ|íøÏ¹û@•_ˆ÷uZ=©‡,¸åÌ!}¥ÞÂ\0äI@ˆä#·¶\"±'ãY`¿Ò\\?Ìßpó·ê,Gú¯µý×œ_®±'åGúÿ²Ð	ŸT†‚#ûoŸÍH\rþ‡\"Êëúoã}§ò?¬þOé¼”7ç|'ÎÁ´=8³M±ñQ”yôaÈH€?±…ß®‡ ž³ÿ\0ÿ±öbUdè67þÁ¾I Oöäïû\"-¤2_ÿ0\rõ?øÿ«–ÿ hO×¿¶t\0\0002°~þÂ° 4²¢ÌK,“Öoh¼Î	Pc£ƒ·z`@ÚÀ\"îœâŒàÇH; ,=Ì 'S‚.bËÇS„¾øàCc—ƒêìšŒ¡R,~ƒñXŠ@ '…œ8Z0„&í(np<pÈ£ð32(ü«.@R3ºÐ@^\r¸+Ð@ , öò\$	ÏŸ¸„E’ƒèt«B,²¯¤âª€Ê°h\r£><6]#ø¥ƒ;‚íC÷.ÒŽ€¢ËÐ8»Pð3þ°;@æªL,+>½‰p(#Ð-†f1Äz°Áª,8»ß ÆÆPà:9ÀŒï·RðÛ³¯ƒ¹†)e\0Ú¢R²°!µ\nr{Æîe™ÒøÎGA@*ÛÊnDöŠ6ÁŽ»ðòóíN¸\rŽR™Ôø8QK²0»àé¢½®À>PN°Ü©IQ=r<á;&À°fÁNGJ;ðUAžõÜ¦×A–P€&žþõØã`©ÁüÀ€);‰ø!Ðs\0î£Áp†p\r‹¶à‹¾n(ø•@…%&	S²dY«ÞìïuCÚ,¥º8O˜#ÏÁ„óòoªšêRè¬v,€¯#è¯|7Ù\"Cp‰ƒ¡Bô`ìj¦X3«~ïŠ„RÐ@¤ÂvÂø¨£À9B#˜¹ @\nð0—>Tíõá‘À-€5„ˆ/¡=è€ ¾‚ÝE¯ž—Ç\nç“Âˆd\"!‚;ÞÄp*n¬¼Z²\08/ŒjX°\r¨>F	PÏe>À•OŸ¢LÄ¯¡¬O0³\0Ù)kÀÂºã¦ƒ[	ÀÈÏ³Âêœ'L€Ù	Ãåñƒ‚é›1 1\0ø¡Cë 1Tº`©„¾ìRÊz¼Äš£îÒp®¢°ÁÜ¶ìÀ< .£>î¨5ŽÝ\0ä»¹>Ÿ BnËŠ<\"he•>ÐººÃ®£çsõ!ºHý{Ü‘!\rÐ\rÀ\"¬ä| ‰>Rš1dàö÷\"U@ÈD6ÐåÁ¢3£çðŸ>o\r³çá¿vžL:K„2å+Æ0ì¾€>°È\0äí ®‚·Bé{!r*Hî¹§’y;®`8\0ÈËØ¯ô½dþ³ûé\rÃ0ÿÍÀ2AþÀ£î¼?°õ+û\0ÛÃ…\0AŽ¯ŽƒwSû‡lÁ²¿°\r[Ô¡ª6ôcoƒ=¶ü¼ˆ0§z/J+ê†ŒøW[·¬~C0‹ùeü30HQP÷DPY“}‡4#YDö…ºp)	º|û@Ž¥&ã-À†/F˜	á‰T˜	­«„¦aH5‘#ƒëH.ƒA>Ðð0;.¬­þY“Ä¡	Ã*ûD2 =3·	pBnuDw\n€!ÄzûCQ \0ØÌHQ4DË*Žñ7\0‡JÄñ%Ä±pŽuD (ôO=!°>®u,7»ù1†ãTMŽ+—3ù1:\"P¸Ä÷”RQ?¿“üP°Š¼+ù11= ŒM\$ZÄ×lT7Å,Nq%E!ÌS±2Å&öŒU*>GDS&¼ªéó›ozh8881\\:ÑØZ0hŠÁÈT •C+#Ê±A%¤¤D!\0ØïòñÁXDAÀ3\0•!\\í#h¼ªí9bÏ‚T€!dª—ˆÏÄY‘j2ôSëÈÅÊ\nA+Í½¤šHÈwD`íŠ(AB*÷ª+%ÕEï¬X.Ë Bé#ºƒÈ¿Œ¸&ÙÄXe„EoŸ\"×è|©r¼ª8ÄW€2‘@8Daï|ƒ‚ø÷‘Š”Núhô¥ÊJ8[¬Û³öÂö®WzØ{Z\"L\0¶\0ž€È†8ØxŒÛ¶X@”À E£Íïë‘h;¿af˜¼1Âþ;nÃÎhZ3¨E™Â«†0|¼ ì˜‘­öAà’£tB,~ôŠW£8^»Ç ×ƒ‚õ<2/	º8¢+´¨Û”‚O+ %P#Î®\n?»ß‰?½þeË”ÁO\\]Ò7(#û©DÛ¾(!c) NöˆºÑMF”E£#DXîgï)¾0Aª\0€:ÜrBÆ×``  ÚèQ’³H>!\rB‡¨\0€‰V%ce¡HFH×ñ¤m2€B¨2IêµÄÙë`#ú˜ØD>¬ø³n\n:LŒýÉ9CñÊ˜0ãë\0“x(Þ©(\nþ€¦ºLÀ\"GŠ\n@éø`[Ãó€Š˜\ni'\0œð)ˆù€‚¼y)&¤Ÿ(p\0€Nˆ	À\"€®N:8±é.\r!'4|×œ~¬ç§ÜÙÊ€ê´·\"…cúÇDlt‘Ó¨Ÿ0c«Å5kQQ×¨+‹ZŽGkê!F€„cÍ4ˆÓRx@ƒ&>z=Ž¹\$(?óŸïÂ(\nì€¨>à	ëÒµ‚ÔéCqÛŒ¼Œt-}ÇG,tòGW ’xqÛHf«b\0ž\0zÕìƒÁT9zwÐ…¢Dmn'îccb H\0z…‰ñ3¹!¼€ÑÔÅ HóÚHz×€Iy\",ƒ- \0Û\"<†2ˆî Ð'’#H`†d-µ#clŽjÄž`³­i(º_¤ÈdgÈŽíÇ‚*Ój\rª\0ò>Â 6¶ºà6É2ókjã·<ÚCq‘Ð9àÄ†ÉI\r\$C’AI\$x\r’H¶È7Ê8 Ü€Z²pZrR£òà‚_²U\0äl\r‚®IRXi\0<²äÄÌr…~xÃS¬é%™Ò^“%j@^ÆôT3…3É€GH±z€ñ&\$˜(…Éq\0Œšf&8+Å\rÉ—%ì–2hCüx™¥ÕI½šlbÉ€’(hòSƒY&àBªÀŒ•’`”f•òxÉv n.L+þ›/\"=I 0«d¼\$4¨7rŒæ¼A£„õ(4 2gJ(D˜á=F„¡â´Èå(«‚û-'Ä òXGô29Z=˜’Ê,ÊÀr`);x\"Éä8;²–>û&…¡„ó',—@¢¤2Ãpl²—ä:0ÃlI¡¨\rrœJDˆÀúÊ»°±’hAÈz22pÎ`O2hˆ±8H‚´Ä„wt˜BF²Œg`7ÉÂä¥2{‘,Kl£ð›Œß°%C%úomû€¾àÀ’´ƒ‘+X£íûÊ41ò¹¸Ž\nÈ2pŠÒ	ZB!ò=VÆÜ¨èÈ€Ø+H6²ÃÊ*èª\0ækÕà—%<² øK',3ØrÄI ;¥ 8\0Z°+EÜ­Ò`Ðˆ²½Êã+l¯ÈÏËW+¨YÒµ-t­fËb¡Qò·Ë_-Ó€Þ…§+„· 95ŠLjJ.GÊ©,\\·òÔ….\$¯2ØJè\\„- À1ÿ-c¨²‚Ë‡.l·fŒxBqK°,d·èË€â8äA¹Ko-ô¸²îÃæ²°3KÆ¯r¾¸/|¬ÊËå/\\¸r¾Ëñ,¡HÏ¤¸!ðYÀ1¹0¤@­.Â„&|˜ÿËâ+ÀéJ\0ç0P3JÍ-ZQ³	»\r&„‘Ãá\nÒLÑ*ÀËÞj‘Ä‰|—ÒåËæ#Ô¾ª\"Ëº“AÊï/ä¹òû8)1#ï7\$\"È6\n>\nô¢Ã7L1à‹òh9Î\0B€Z»d˜#©b:\0+A¹¾©22ÁÓ'Ì•\nt ’ÄÌœÉOÄç2lÊ³.L¢”HC\0™é2 ó+L¢\\¼™r´Kk+¼¹³Ë³.êŒ’êº;(DÆ€¢Êù1s€ÕÌòdÏs9Ìú•¼ P4ÊìŒœÏó@‹.ìÄáAäÅnhJß1²3óKõ0„Ñ3J\$\0ìÒ2íLk3ãˆáQÍ;3”Ñn\0\0Ä,ÔsIÍ@Œûu/VAÅ1œµ³UMâ<ÆLe4DÖ2þÍV¢% ¨Ap\nÈ¬2ÉÍ35ØòÐA-´“TÍu5š3òÛ¹1+fL~ä\nô°ƒ	„õ->£° ÖÒ¡M—4XLóS†õdÙ²ÖÍŸ*\\Ú@Í¨€˜YÓk¤Š¤ÛSDM»5 Xf° ¬ªD³s¤äÀUs%	«Ì±p+Ké6ÄÞ/ÍÔüÝ’ñ8XäÞ‚=K»6pHà†’ñ%è3ƒÍ«7lØI£K0ú¤ÉLíÎD»³uƒêõ`±½P\rüÙSOÍ™&(;³L@Œ£ÏˆN>Sü¸2€Ë8(ü³Ò`J®E°€r­F	2üåSE‰”M’†MÈá\$qÎE¶Ÿ\$ÔÃ£/I\$\\“ãáIDå\" †\nä±º½w.tÏS	€æ„Ñ’Pðò#\nWÆõ-\0CÒµÎ:jœRíÍ^Süí„Å8;dì`”£ò5ÔªaÊ–ÇôE¹+(XröMë;Œì3±;´•ó¼B,Œ˜*1&î“ÃÎË2XåS¼ˆõ)<Í ­L9;òRSN¼Þ£ÁgIs+ÜëÓ°Kƒ<¬ñsµLY-Z’:A<áÓÂOO*œõ2vÏW7¹¹+|ô €Ë»<TÖóÕ9 h’“²Ïy\$<ôÎ#Ï;ÔöÓá›v±\$öOé\0­ ¬,Hkòü-äõàÏš\rÜú²ŸÏ£;„”¹O•>ìù“·Ë7>´§3@O{.4öpO½?TübÃÏË.ë.~O…4ôÏSïÏì>1SS€Ï*4¶PÈ£ó>ü·ÁÏï3í\0ÒWÏ>´ô2å><ëóßP?4€Û@Œôt\nNÀÇùAŒxpÜû%=P@ÅÒCÏ@…RÇËŸ?x°ó\n˜´Œ0NòwÐO?ÕTJC@õÎ#„	.dþ“·MêÌt¯&=¹\\ä4èÄAÈå:L“¥€í\$ÜéÒNƒ­:Œ’\rÎÉI'Å²–AÕráŒ;\r /€ñCôÈåBåÓ®Œi>LèŠ7:9¡¡€ö|©C\$ÊË)Ñù¡­¹z@´tlÇ:>€úCê\n²Bi0GÚ,\0±FD%p)o\0Š°©ƒ\n>ˆú`)QZIéKGÚ%M\0#\0DÐ ¦Q.Hà'\$ÍE\n «\$Ü%4IÑD°3o¢:LÀ\$£Îm ±ƒ0¨	ÔB£\\(Ž«¨8üÃé€š…hÌ«D½ÔCÑsDX4TK€¦Œ{ö£xì`\n€,…¼\nE£ê:Òp\nÀ'€–> ê¡o\0¬“ýtIÆ` -\0‹D½À/€®KPú`/¤êøH×\$\n=‰€†>´U÷FP0£ëÈUG}4B\$?EýÛÑž%”T€WD} *©H0ûT„\0tõ´†‚ÂØ\"!o\0Eâ7±ïR.“€útfRFu!ÔDð\nï\0‡F-4V€QHÅ%4„Ñ0uN\0ŸDõQRuEà	)ÍI\n &Q“m€)Çš’m ‰#\\˜“ÒD½À(\$Ì“x4€€WFM&ÔœR5Hå%qåÒ[F…+ÈùÑIF \nT«R3DºLÁo°Œ¼y4TQ/E´[Ñž<­t^ÒËFü )Qˆå+4°Q—IÕ#´½‰IF'TiÑªXÿÀ!Ñ±FÐ*ÔnRÊ>ª5ÔpÑÇKm+ÔsÇÜ û£ïÒáIåôŸREý+Ô©¤ÙM\0ûÀ(R°?+HÒ€¥Jí\"TÃDˆª\$˜Œà	4wQà}Tz\0‹Gµ8|ÒxçÍ©R¢õ6ÀRæ	4XR6\nµ4yÑmNôãQ÷NMà&RÓH&É2Q/ª7#èÒ›Ü{©'ÒÒ,|”’ÇÎ\n°	.·\0˜>Ô{Áo#1D…;ÀÂÐ?Uô‘Ò•Jò9€*€š¸j”ý€¯F’N¨ÒÑ‰Jõ #Ñ~%-?CôÇßL¨3Õ@EP´{`>QÆÈ”µÔ%Oí)4ïR%IŠ@Ôô%,\"ÕÓùIÕ<‘ëÓÏå\$Ô‰TP>Ð\nµ\0QP5DÿÓkOFÕTYµ<ÁoýQ…=T‰\0¬“x	5©D¥,Â0?ÍiÎ?xþ  ºmE}>Î|¤ÀŒÀ[Èç\0žŽ€•&RL€ú”H«S9•G›I›§1ä€–Ž…M4V­HþoT-S)QãGÇF [ÃùTQRjN±ã#x]N(ÌU8\nuU\n?5,TmÔž?Ðÿ’Ü?€þ@ÂU\nµu-€‹Rê9ãðU/S \nU3­IEStQYJu.µQÒõF´o\$&ŒÀûi	ÜKPCó6Â>å5µG\0uR€ÿu)U'R¨0”Ð€¡DuIU…J@	Ô÷:åV8*ÕRf%&µ\\¿RÈõMU9RøüfUAU[T°UQSe[¤µ\0KeZUa‚­UhúµmS<»®À,Rès¨`&Tj@ˆçGÇ!\\xô^£0>¨þ\0&ÀpÿÎ‚Q¿Q)T˜UåPs®@%\0ŸW€	`\$Ôò(1éQ?Õ\$CïQp\nµOÔJ¹ñX#ƒýV7Xu;Ö!YBî°ÓSåcþÑ+V£ÎÃñ#MUÕW•HÍUýR²Ç…U-+ôðVmY}\\õ€ÈOK¥Mƒì\$ÉSíeToV„ŒÍHTùÑ!!<{´RÓÍZA5œRÁ!=3U™¤(’{@*Ratz\0)QƒP5HØÒ“ÎÕ°­N5+•–ÏP[Ôí9óV%\"µ²ÖØ\n°ýñäG•SL•µÔò9”ùÇÌë•lÀ£ˆ‘\rVˆØ¤Í[•ouºUIY…R_T©Y­p5OÖ§\\q`«U×[ÕBu'Uw\\mRUÇÔ­\\Es5ÓK\\úƒïVÉ\\ÅS•{×AZ%Oõ¼\$Ü¥FµÔ¬>ý5E×WVm`õ€Wd]& \$ÑÎŒÅ•ÛÓ!R¥Z}Ô…]}v5À€§ZUgôÔQ^y` Ñ!^=F•áRÁ^¥vëUÅKex@+¤Þr5À#×@?=”uÎ“s •¤×¥YšNµsS!^c5ð\$.“u`µÜ\0«XE~1ï9Ò…JóUZ¢@²#1_[­4JÒ2à\nà\$VI²4n»\0˜?ò4aªRç!U~)&ÓòB>t’RßIÕ0ÀÔ_EkTUSØœ|µýUk_Â8€&€›E°ü(â€˜?â@õ××JÒ5Ò½JU†BQT}HVÖ‘j€¤Qx\neÖVsU=ƒÔýV‘N¢4Õ²Ø—\\xèÒÖïR34ÝG¿D\":	KQþ>˜[Õ\rÕY_å#!ª#][j<6Ø®X	¨ìÍc‰•Ø#KL}>`'\0Ž¨5”XÑcU[\0õ(ÔÙÑWt|tô€R]pÀ/£]H2I€QO‹­1âS©Qj•Z€¨¸´Hº´m¨ÌÙ)dµ^SXCY\rtu@Jëpüµ%ÓÿM¸ø€¨óµ“Ö?ÙUQ°\nö=Råar:Ô¿Eí‘À¥-G€\0\$ÑÇd½“ö]Òmeh*ÃìQ‰Wt„öc€¡`•˜AªY=S\r®¯«	m-´‚¤=MwÖH£]Jå\"ä´Ä õþ­fõ\"´{#9Teœ‰ÙÍMÔc¹ñNêI£òÙßD¥œõÙÜçUœ6ÙñgÑ2Ù×Ý¶eƒa­L´€Q&&uTåX51Y >£óûSýÖŠQ#êIµ¥Õj\0ûœ£ÅW PÑþ?ub5FUóLn¶)V5R¢@ãë\$!%o¶ÔPúÉ'€‰EµUÁÔP-†¶š¤Bp\nµF\$ŸS4…t±UF|{–qÖÈ“0û•ÎUmjsÎÃü€²øý\$´Ú›j…cëÚå¦Ö«€¿aZI5X€ƒj26®¤&>vŽÑ\n\r)2Õ_kîG¶®TJÚÁeQ-cîZñVM­Ö½£z>õ]•a¹c£Ëcìß`t„”HÚÑjÝ6¹£+kŠM–\0Œ>Œ„€##3l=à'´¥^6Í\0¨Ã¨v¦Z9Se£€\"×ÊêbÎ¡ÔB>)•/TÁ=ö9\0ù`Pà\$\0¿]í/0Úª•«äµ½k-š6ÝÛ{küÖá[F\r|´SÑ¿J¥õMQ¿D=õ/ÈWX¢öœV—a¬'¶¹éa¨to€©lå†¶ÐXj}C@\"ÀKPÛÎÖÚom’3\0#HV”µ…v÷Ñ~“{žµÖ?gx	n|[Ø?U¶äµ[rê½h¶ÞG¸`õ3#Gk%L£ê\0¿I`CùDÞê¸	 \"\0ˆŒÅ§¶°#cN«6ßÚ¹fÂÔzÛŽêº;Ñ¤ÃeeF–7Ù/N\r:ôâQñGÕ9	\$ÔóIøÕ¼ºß]£®TÝØWGs«ÔdWõMÚIãèÑÙf’BcêÛ¤êõÂ÷!#cnu&(ÞSã_Õw£ùSfë&TšZ:…0CóSÙLN`Ü³Yj=·¶>Å²ÃñZ!=€rV]gû	Ó£rµ ËXlŒÉ-.¹UÄ'uJuJ\0ƒs­J¶'W%·¶­\\>?òBöëV­j4µÏJ}I/-ÒrRLºSè3\0,RgqÓ­ôÇTf>Ý1Õï\0¥_•”Ç\\V8õ¡ZÛt…Ácè€†ú<^\\ùll´j\0¾˜þT¥]CÝÔw×Î“zI¶ÙZwN…¶¶pVW…jv»Y¶>2Ó	o\$|U‡WÃL%{toX3_õ¶òR‰J5~6\"×ãZl}´`Ôkc­ÑîÛeR=^UÔŽ•¥1òÑ½w7eØdµÝvŽÙb=á\0ùf €,³må)ÕéGpûÕ-Ó¼½)9Lý“š>|Ôë \"Ì@èû¤5§`†:›ô\0é,€ñt@ºÄxº“òlÃJÈŽ»b¨6 à…½‰ÝaŽÞA\0Ø»ARì[A»Ã0\$qo—AàÊSÒü@Ìø¬<@ÓyÄÐ\"as.âÎä÷V^„•è®¥^õ›…—œ\0ÜÈHÁ·[H@’bK—©Þ)zÀ\r·¨¤¤=éÁ^¿zˆB\0º¿’¤äNéo<Ì‡t<xî£\0Ú¬0*R ºI{¥í®´^æEµî·¸:{KÕ§1Eˆ0²ÓYº•›à/ÕÑcêÀ\"\0„ê¸4øÉF7'€†˜\nÕ0ÝÉ`U£Tù¤?MPÔÀÓlµÈ4ŒÓr(	´ÁZ¿|„€&†©t\"Iµ¿ÖÛL w+Òm}…§÷€Wi\r>ÖU__uÅ÷63ßy[¢8µT-÷ÙVÏ}¤xãô_~è%ø7Ùß{jMáo_šEù÷ØÓë~]ôP\$ßJõCaXGŠ9„\0007Åƒ5óA#á\0.‹Àä\rË´Žž_Ö¢áÀßÚ%þáÀÀ\n€\r#<MÅxØJËù±|¸Ø2ð\0¨–;oŒ^a+F€í¸Îç¬€LkúÁ;À_ÛÝê#€¾M\\“¬€¤pr@ä“ÃµÆÔøÂþOR€¿ñ–~zÇûAÁNE°YÁO	(1N×‰ˆRø¨8Ø€C¼Ž¦ë¨Én?O)ƒ¶1AçDo\0ä\r»Ç¢?àkJâî‘“„\"â,ŽOFÈÌa…›ùª-bà6]PSø)Æ™ 5xCâ=@j°€ÇL”ÁèÈLî˜:\"èƒ»ÎŠ¤l#¢ÀéBèk£“ˆ›ž€ÖË@ •Nº:ê>ï|BéžŽ9î	«Èî”:Nýñ\$èéS¥ CB:j6î—Þé•àÎ‰Jk”†uKð_W›Í¢Ã˜I =@TvãÒ\n0^o…\\¿Ó ?/Á‡&uê.ÞØ_˜æ\r®î¥Cæì+Úøc†~±J¸b†6ÓüØe\0ÍyóÑ¡\0wxêhÁ8j%S›À–VH@N'\\Û¯‡ÆN¥`n\r‹ÒuÞn‰KèqUÃBé+í˜f>G‡°\r¸»ˆ=@G¤Åädç‚†\nã)¬ÐFOÅ hÊ·›†ÃˆfC‡É…X|˜‡I…]æð3auyàUi^â9yÖ\no^rt\r8ÀÍ‡#óîØâN	VÈâY†;Êc*â%Và<›‰#Øh9r \rxcâv(\raŸá¨æ(xja¡`g¸0çVÌ¼°Œ¿Q†©x(ÇëƒÀglÕ°{—Ægh`sW<Kj°'¿;)°Gnq\$¨pæ+ÎÉŒ_ŠÉdø¶^& ¯Š˜DÂxà!bèvÞ!EjPV¤' ââÁ(”=ÏbÂ\rˆ\"–b¦ÝL¼\0€¿Ìbtá‚\n>J¬Ôã1;üù¼ÖîÛˆ¿4^s¨QÁp`Öfr`7‚ˆ«xª»E<lÑÏã	8sþ¯'PT°øÖºæËƒ¸°z_ÊT[>Ð€:Ïó`³1.î¾°;7ó@[ÑÞ>ºž6!¡*\$`²•\0À„æ`,€“øÇàÝÁ@°àáå?Ìm˜>ƒ>\0êLCÇ¸ñˆR¸În™°/+½`;CŠ£Õø\0ê½*€<F“„ö+ëƒâ„q MŒÁþ;1ºK\nÀ:b3j1™Ôl–:c>áYøhôìžÞŽ¾#Ô;ã´Ü3Öº”8à5Ç:ï\\Þï¨\0XH·Â…¶«aþŽ®¸™M1ä\\æL[YC…£vN’·\0+\0Ôät#ø\$¬ÆØØà!@*©l¦„	F»dhdÝýùF›‘à&˜˜Æ˜fó¹)=˜¦0¡ 4…x\0004ED6KÍòä¢£±…”\0ònN¨];qº4sj-Ê=-8½ê†\0æsÇ¨ûˆ¹D§f5p4Œàé©Jè^Öí’'Ó”[úùH^·NR F˜Kw¼z¢Ò ÜÐE”º“ágF|!Èc©ôäo•dbÁêùxß\0ì-åà6ß,Eí„_†íê3uåp ÇÂ/åwz¨( ØexžRaºH¼YùceŠš5ê9d\0ó–0@2@ÒÖYùfey–ŽYÙcM×•ºhÙÃ•Ö[¹ez\rv\\0Áeƒ•ö\\¹cÊƒ†î[Ùue“—NY`•åÛ–Î]9hå§—~^Yqe±–¦]™qe_|6!ŽÞóuï`ŽfÕî™Jæ{è7¸ºM{¶YÙ‡©øj‚eÆÌC»¢S6\0DuasFL}º\$È‡à(å”Mb…ÈàÆ¤,0BuÎ¯…ì¥Ñ‚2ögxFÑ™{a¸n:i\rPjýeÏñ˜rÈrØÏGýBY ˆM+qïçiY”dË™é`0ŽÀ,>6®foš0ù©†o™ó æXf¢äù\0ÀVÝL!“«f…†láœ6 Å/ëæ£1eƒ•\0‰>kbfé\r˜!ïufò<%ä(rË›ùa&	ý™¨àY€Þ!¡Òñ–mBg=@ƒÐ\rç; \rÞ5phI 9bm›\$BYË‹ÿšÄgxç#‰@QEOÇæm9–®Ë0\"€ºç!t¨˜ê†Ë‰¸®Ð‡çO* Ååÿ\0ÂÝ>%Ö\$éoîrN&s9¿f£ž4çù™gŠä~jMùf›wyèg›yí\\`X1y5xÿŒùž^zï_,& kÑæ¢é|¡€À¦1xçÏA‘6ð \nîoè”»Œ&xÙïgg™{r…?ç·›ü-°½…®|tä3±šˆÈÍ}gHgK¢9¿¿¨õJÀ<C C° 1„î9þ7‡g÷š‚ïh6!0Hâí›cdy´fÿ¡DA;ƒ‚9…Tæ¢ÿ®0¬Ä\0ÆpØàù†!‡ 6^ã.øSÂ²?ÆØ¦E(P­Îˆ .æÂ 5€ÄhŠéˆEPJv‰ .‹•¢+—\$ç5Œ>P+µ?~‰¡gŒ6\r³öh¢¼p«z(è†WÙÄ`Â•¨±\"y¯ñÏ:ÐFadÅ¬6:ù¡f˜Þi\0ì˜ÝØàA;áe¢°àì¬ç^ÊÖwf„ >yÍŽŠËõ`-\rŠÚ…á\0­hr\rÎr£8i\"_Ú	££¼9¡CI¹fXËˆ2¦‰š\"ÍÅ¢‰… øh¢L~Š\"ö…š%V•:!%Šžxyèizyg„vxÚ]‚žÆ}qgžÄÃZiŒä|Œ`Ç+ _úgèòú†™Ù£¾úªÂÀÂè­ž6PA€Ê€\$¶=9¢ŒùàÍh‹¢|p’ ÿ¢ˆé˜íè!¢Ž.ø!”þ¶žüiç§^œøÚiË¢Ž8zVCÌùöŒZ\"€æäØ(Ä¥›¹°9èU)û¥!DgU\0Ãjÿã¿?`Çð4ãLTo@•B¤§úN†aš{Ãrç:\nÌŸ“E„»8Ã¦&=êE¨*Z:\n?˜¨g¢èÌŠ£‹h¢õ.•˜’ Nþ5(ˆSƒhÑôi2Ö*c„fý@•“ÑÞ7¦œz\"áƒ|ÖúrP†.Ç€ÊL8T'¿¸k¢ˆß:(¹q2&œÆED±2~žÿ¿Ø±þœŒ¬Ã9ûÒÂv£©¼8ÿƒ©– @úé^X=X`ªqZºÐQ«Ö®`9jø5^ˆ¹å@ç«¸În¼qvž±á¨3±ÚÇèŠ(I6ðªjšdT±ÚÂ\\Š ‚Ÿ3¢,™Ïhék¢3ú(ë3¬‘‘PÒu•VÏ|\0ï§†Uâk;¢ÌJQ¶ã é. Ú	:J\rŽŠ1ŸênìBI\r\0É¬h@˜¼?ÒN±\nsh—®å\"ë’ò;¦r~7O§\$ ú(ã5¤RÅèÆ	èÊ½jÂîšØFYF šÜ”£«~‰xÞ¾©f º\"ã†vÛ“ošëË¨ººÂº#ŒÜaÒèŠõ¶®P“„Ë<ãáh£-3éº/Gx®õ²nÇi@\"’G…?ó¤,ïZpÖxX`v¦4XÆõóàû„[ƒI¶œ7žÃ¥Xc	îÅ!¡bç¢}ÚjŒ_¾¥9á5qti¦6f»ž’°¸ÝÙž5ÿûç FÆ¹ãiÑ±©pX'ø2¡Žrƒ„®0ÆÆºé§D,#GëU2€ÌØâIè\rl(£— €ì±£¦¨=ÐA¸a€ì©³-8›dbSþˆûõ4~‚ô—H;°Â­0à6Çbé{ª„ÞºRæèÃs3zë¯ÃÀüNðÞ„Ž`ÆË†+ò¦­ 4<ø^aƒy°¬”	}r°Âây´õãáû¸kŒ&4@ˆÁ?~ÔäÅcE´ÂÈ­@ˆLS@€Œéz^qqN¦°</H‚j^sCâ`èæsbgGy¹¤Ö^\nÈNó\n:G¶N}¼c\nîÚÕí¤ +£†ï=†pÙ1º’NµTB[dÀÿ¶–š¶Ð‹¢¾Ü¹ñ`³nÚoj;žjÄ›whØõž€c9ƒ‚pÌ¡[y4«¨¶05œÍ‹NßÁ+Î¿·Ð`Xdaáæ/zn*öPÀ‡êÁ¸#tíèµ¸~à9Wî	šVâò~=¸#Ùùn)¨î´î	2ÜÉ;…j:õ°Ják„C¸!>xîù5š£==¦2»—‚. ã|¿'¨îä[€Ì'—;üÚv½ù«–“¸„®÷ÎëÎ;:SA	º&Ð[£me†êãn±ëúûªî™«Ëµ¦Ä•<Ÿº6ma‘=Y.ç¥žÀÅ:g¶ÔþÉè…€ù°žÐ;«Iß»xÅ[”éI¡J\0÷~ÂzaY®íºîüwT\\`–íV\nÆ~P)ézJ¾©æ½üñðQ@Ýà[¶{rÊ‰µDîB„v—ï|i-¹EæøKŒ;^n»{êó½å:Nh;–—Ú2Á¨Æ€pçÑ´6“úƒ»ç½˜9§9¡¥öÖXÂhQœ~—ÛÛiAŸ@D šj‡¥î}ÑozLV÷ïçÑ³~ù•ž	8B?â#F}F¾Td­ë»áÐe±ÃzcîçŸFÅÀŠg‚7Î—Ûêà€ 6ý#.EÂ£¼áÀÖÂ£¥ðS£.J3¥ö5»¯KÉ¥óJ™§¸;¤—„n5¾¾:ySï‘ÀCÛvoÕ½.˜{ñð	d\\0ë?W\0!)ð'šû¼èEgá;à+»\0üY NtŽbp+À†cŒø“þ£\0©B=\"ùc†Tñ:Bœ±Áž¤úcðïˆþîÆï¸P‘IÜÈD¸ÂV0ÊÇ!ROl‰O˜N~aFþ|%Éßº³¸¬…ò)Où¿	Wìo´û‡Qðw¨È:ÙŸlé0h@:ƒ«ÀÖ…8îQ£&™[Ànç¹FïÛp,Ã¦å@‡ºJTöw°9½„(þ†œ<é{ÃÆO\rñ	¥àùÚ‚\$m…/HnP\$o^®U¡Ì\"»¿ã{Ä–…<.îç¡‹n¥q8\rÕ\0;³n£ÄÞÔÛðç¡Ÿˆ+ÎÞ³3¢¼n{ÃD\$7¬,Ez7\0…“l!{˜é8÷á¶xÒ‚°.s8‡PA¹FxÛrðÄÓôQÛ®€¹†1Ì…¸p+@ØdÔÞ9OP5¼lKÂ/¾‘·¾˜\\mæú¸Äs‡q» îvºQí/§ÿÜ	„!»¶åz¼7¾oœ¿EÇ†Ò:qàV 5˜?G¡HO®âO†\$ül¾š+â,òœ\r;ãç°¾¤’~ÎAÄéŒ³é{È`7|‡ÿÄ‚Äàër'‰°Ji\rc+¢|—#+<&Ò›¹<W,Ã>¢»^òPð&nÂJhÐe‡%d¶æìèÏÜCƒi¶zXÃAÿ'DÍ>ÉÎˆ¡Ek£Ê¬@©Bòw(€.–¾\n99Aê¯hNæcîkN¾d`£ÐÂp`Âò°%2ö¦½3H†Ëb2&¨< 9¤R(òÀ‡táTH¬	àz‘Ö'œ× oòÀ‹>4?Ô\rZÌwÊÓ‚ä×4ƒ`ºÈÐ‡é†µ³N‡ñŸéÓ€îž'-IõÈì†÷0(S¨rØw,ü¹ÐåËKÊrÍÌ'-2Hlo-ÁUòáËâ_’'W#'/üÉHÖŸ¤®j6“Ì‰¡¡ÉàÈ«¶\0é„<‘„ÚúŒŽj1¤E’QŒTÜT­ÆrÁBcmí16ãÍˆgÙ«:w6Í¯›h@1ÅI:¤ÃÁ’Éþ2ópò’L/ÎÁŸÂžwÿ:òÅ‘ÓÎøK<ðÌE<‚þJ­76Ó€s×.Ì²sZóß/\$÷AsEyÏœàrÚr:w?Õ‰”!Ï?³áêÇ™ÐZ“MÍ9»Õ\0ÏÁ1?ARÍ¦%Ð7>ÖMÇARr}sé€ñr)\\t-8=³öÍËÐŽUýË,WOCsÕ†„Ð#w½5®á¯ERlM*¯D³ç1ûÑ>]ÏÀgK¤²V¹\nÜ\\èÜÓsˆÜ‡8Í¹seÍ§9­soÎ~„ ìów4xàŒ†’ñf@×ÐÜD­ö9€‡ÎÊ6¬\0	@.©î²@´9\0ŠC;Kôy+ÓJð“ÜÙ¥ƒÏu<\\û`òc{Ó‹¤E£>ÿyŽÁJ=lŒüïá/…-—7˜þ”ÐZ46¨uC5™‘PçÎ©´RVÐòæ¡ÜáÐýÊ³lVøÒaNxû`Õ´?UÛ7(HP“}jVØJëzNQJ÷S–¸±s-gQ!a¥VØ_SwRýOõ3am‡ZXwZÍo‰'Ýwa­‰ÖOØoZµ“õ!Ù[\n<ôZ€µO¥Ò¶'ÇÅOmo÷[×Óa=Qºä>‚:õTÐ\nµŽ¨ç\0Š=€ým×jú–ATÃRÅbu(ÈI×´è:å×\$v¾Wõ×µÃðuÅS¿\\V8Øçvç\\õ•×g!MÐ¶¦uÅÖ_µ&Öis¿\\CÿRVM¢]tXT7\\UoT×Øo_Ô¯Ý›S?aÔlÈSØ-LutZGeÇÕái`	}XZ‹i}Q•yW[i­…TŠöYo¦ (ZE\\¨}nÙi—f–‘Ú‹ÙÏW×dÑ%Týpu3uÍTýf5)vˆÛ]ÕUR3VEY]¥X¸\n·^½§VqS½Sý}XéiGf•Úv>­Sý‚v»JMQšvÚ•Š…ÔÙ\\•g]´QYE“ÎÝµ#1Vÿl5UØEK]ÕÉ\0³ØÝSýU?\\ºBwS•UŠ7–´ÕmZ½V5\\õ¹WfýÂÕ§[¥eUrõ{G\\µýUµÚ,„Éö‘W…[]xö›V×j5mTïV×jÝ~u7Ø\0ûV¦UµØ'tý°w?msÝÕÔÉÛ5VÝÃvÝq}ÙöáÝu-UqÕ]Ý—c]ÚWÝØõ]Tt:ífŠM”k¶“e]î¹[-p}^ÔI[©XDãéºåY¿V—dõÀýO]	seNõ£ÜßZ¯WYÚ[Õt…ÈV?ò3ÞÇµßM“öñÝ™`Ðût^w£d²:qTL•@@>]Áj\rFÝqvµÝ-Lv´GKwiôLwIPMo”ùÇ¹Mgv½ÿø[§Uss¦Ž~	èõ…w:BâA‘ŸÑNEù{ä!-ÔÃdýŸo\0´’}&Þ­hXÕÎA–5µ%Ù£fzLÖHÙ5d­” Y…_%…v´Ó™!mšÒ]Öë•ØÒÌ%üñßò€þå=B©>E [#^}öhYFÛa·ßÆ>{¡gS…¶ðp[ìF÷¦ÏDaë6næ´À¶x9«¥8LêIãˆ«N–a=ˆSÊ@úbPk¦.™áNòøHù”l\0ú†:àðè–îŠº2#çÎ˜;¼í®vøO}€9ik]	&®{õ‰ ø«ÕœÙ2|a—·&óãÔÇåÿÞQ½¥ª±ÌîÎç¨)ÉñµoÙ“Ç¸:é&.\0¶5q\0JÐL½é‚64hy€3®Þ¢«¹˜a®Þƒù‚Iz†ÁO‚—–ñ„æï®ˆ\"á¶yB»Ê³{ª3Æ%˜5r(mØÈàÂáÇx.7rÒb%Á‡ü^ e†M€»¢2®\0x—½!‰b}.®âY6\$qS”Ï\"^|xE…äÈøaãþ‘¼À€ëXÇ¡5‚9†ž'T‚R	Ãc9ÄãèW¢1ßáÑAÎ”Pí¦ŸØh6'Þoò-àÖËpµ¾T(\nn\rËÅ“å1ÔŽ„RïRUgÛéƒÈþ™“çx¨•Pe#îé*¤âkT<Ÿ<>b;‹“\0™Á˜gL½.Ž<k©ZváÌ„ø¯óz³¶Æ8~¬ðy7€Y¸ïÈêÜ7w¨áOdnÒ>¤<€ú›Eé3ˆ¦wS”Û†œ@¾¡ë® oôWÅ1…ñúñ¾Òº¿zã‰eíÞ½è±å1Ýˆz÷\0f=ØùcãŠ¤g¹Ÿ{éÞ>nŒp\0±ÍèÎ‘:Hé†BnŒ6FèÆB¯rçW=öãC>M.1~@3ºGí9‡8÷q<Sô|ûY•8QPâû`L[žžÖqzç˜Û«PÇíèNà<{_-Ù®¥dO¸ùd-îNB7ä4ÝîBùNÁí.Vº·ç9Æ¨Qø3ºž{IcP\$§»ºhû¾<R yy…ì?ÞòGÒþ:n™ã€µôgÍÁœÿ;Ah!åÔþÁ&å»+>ðË€Û;MÁËŒÞ	ÍþþÃïÿ6SâîŠ·N¸ÚŒ=#ñëëñ³±`üTü#+ìnû;•·r,‚Ç½ð¦ÏX|#ïÄ\rü# ïÃ?\nüD>¨|VüSñ¿ÂÚeÏ—~Jãm99…á¾\nsÆ{S|r],~ÿË¹ñøé¿ µqÏI?\"|wñ¦øÿ%|Œj‘\0rEò,kSnü¡íç¿øqÆ•Èd8B.ûñ‡1«Ñü³\"™ß/|Æ´€Øƒ]òüˆ¸­€·EüÏœèN²lüÌÕÆxÖËI°÷Ï Icó¿Å¸.|\$8D¹ŸF¨ÝÌ“…˜PÕKÆò€3ƒô\\j¾¥xUÏC/äã³Ò—¿A{¹ŽÀÐûþeüÚƒ€ÿÓæ×¶éÜ¾ÿŠÕôà\rpýU\nçÕŸWloÂ­Yâ{ÿô˜ã`]'Öþýsž†Õ/|¼oïÿ×à3çŽÀržü}‹ö;Úÿ[ÊnÎ¹ûÿºž—¿OíM7¯ÛÉß£Ø¼q¾µq(ÏÐ_lâqsN÷“yòûñÄçÕ;ŒiÀg¿t—‡ÅÎ:ÿýåÈëÕ™§qk‡¿íôá{÷Ÿß?zý¿÷ÏÞûêñMÈ—ßoýì'àj˜úïá†ãcøyñß„ýãøgß‡gkŒwÉâf8¼VcÔ7fAÌY‘³å+Kxñ…=žgKAkþT,95rdã+ùGåÀºíÙ¯„…ñþ[Òà%…AÅwæŸžµú…½å7ùßåà¬…£%· {½míú8%_”þmú—qˆàVËË¨_ þ“%«!þEƒú¼iø~‘ù²h ú~»ŸCªß­~§ù¨%Ž†„­µ—ç_¨þÙúåÿ·rLkD«yÌúŒð~Ô?p1O!?¿®vÌ\\ïä±Pm©\"¸Ì<ûŒ¯ïŸÅúE©6… äEŸVð³åÎñšzkîÇú¦9³zÉªßÐ~Ê/ìäÕº¬é!Q‹>ÿ O£åNmèð3rˆç Fú˜l‘Òúe;¤Mãß·…ŸºÏ½ž_a ´!~C»¼f€úå¼b}3œ K¼føÜí. 	Ùä}.©þ»ƒDX	i5¿|úŒ?ðÀ=\0õ±?ï?»ø?£Þ@ˆÿÃ•£½fu~a^’Ønûáªy±Q;ï q¹ÌàŒþ)€s’S½,\"G†\nu%ÊÇU­YïAKl\nÓëBØIÊ86VCcO\0Ö`}.x©ƒî„,-Ná‡@~ºèœTÿG›çü–'üÄdÛJƒ÷‚ŸÆy1ƒzl‡á½Ã¦f÷gõ·ùAB aõ!þŒM\\<ƒgÊƒýz4Æ¿ìÜ@/³ÞCÜÃ‚ì@õ	¯Qq÷)¤ûxäÁ/Ã.7inD±#=Àœ *79cÂF²ËÑd2(¶ .ÀV€À3µ¿ùÚ\$g`ˆAá§‹rl|øm˜²¶b§‚/¯qE²›ÕÃ´!bU@œ¿9iâ;ppÊdííÛ×¤=ð1ùy–x°x	™=€v=ø®(v±ï¬s_œ³BoòÉ‚ãÖ#àK\r nŽñîÈ\\—# Ûf˜PXÐu-3&«	½›J&,FÊ(9¶v´0Á&@khZòy¶gîCÔ‹€z Á”Ãã¦hi=¡s9TñÂ eT>gŒÂ3ëdÞtFûö2b&:¾ð\0ÐP¡÷€B–š-¹QËº8~ÔLSÆMàˆ™Ú·cgÐÎðTh'òf(Ñ³Ð\$¨.EŒ«§VLÀ°·œAýI¼ãÃßŒñ†¹¼râ¦ãêgÛ\rÜÙã0§¶œ‚ëTëÎ1P`1’dÔâôÕÄ\r¦4âÁÚ=6@FüÁ¼È F±Ìñœ=¿É‚6ÏA¾Â>åN¥AVß	èÙÚ(\$ÎA/¦·ØÚõ¦;¦­çÚ?¾gŒf^	¬\nè&ðKO³Æn„{]õÐgË›Î8åc¬ÒÑž„–²Ï·Þý³ÿ‚\nÈ7LÐŒ¶‚t:ÒÑ ³hF°VO\r³èJú)bƒ(\"OBÌm°	oØß\$]T„SHÎZ^½õKŒÿ©äwð\\[A9('ÒÙ„cÛ‘â­Üàb0‚ØÙÄ K’à£åà²srB™x\nè*BaÆz6oƒ\ry&tX1p'›Ž^ƒM·¹<âCg¹`Ì4Ã8GHõ“zd?gX›†.@,‹7wÃïÛž:+ƒTiUX16à“L¸Üs’:ž\ršLè6‡Á±ƒf—r\r`ãtà67~g°xˆgH9ãJÀ¿O=-\$ð4?rÙª4½ƒ¨¡O›ûè:Žz¦§{ÈþD`ó¨‹Ð21FŒÜµ£Ð(DòMÓÊ;¥º½ñ&–¡ÍÌ©ÔÚ­¾ƒU>ÎI˜6‹™cÝÄò›ß¸@\r/œ/¸¶Ô•ýó_HÀƒ\n7zë ¶ü€“œ‰7òaî É»[9D¢'ü„¿ì}Bÿ€O›R‡ôÝŸ¸B#s“¼]z!(DÀ“Å@L^„ý	û³x£Ý@oá¿u„OäïÁ¥D¸ÏÜ!Že`\na³k>´0`á„€Ì-*™ ˆ8E‡Z6=fÌé%¡™Ý×cã›°”K=£ò¤F‡\rÊ…ÂShèyNò[v*vá\rÁää@Ž#ß¸í‰ªAh*ãL\$°À±AÀA\\”¢‚úÓ%Á*	ÄçpŠ\r*==8ì\$Wî\rƒ [±“Jx0yñÛZÃ+&YÙHA~A\n,\\(Öìp¤!F¶êÚ<6SØ&IP`6Xzü+í£dfÞ\r¾ÏJÂ£€ÞÌië•sã+Ò&5¼å/rE…À£M^\$R(R‘QÌÒEw3‰ôlH*m\0Bq¬aŒ¯rèêLB“Žª¥Q¹z6~lËùBŽ‰\rIÂ®GøæXÙ¸XVbs¡mB·Hª×ó™ócî_Kç\$pæ-:8„•Nj:ÂÑ…Œ¡-#¢Få	\0’aiBÆs\\)Î<.!ÆÝ\\ß‰N‹ÒbIw8§Í¹t…øPjWä¨`¶‚y\0ìÝ&0˜i?¡ˆÃÒ”:«Ia)=’C†,a&ºM˜apÆƒ\$ÝI€IFcæ­ç\0!„ƒ˜YÄxa)~¯C1†PÒZL3T¸jÝC\0yˆÒ¤`\\ÆWÂü\\t\$¤2µ\næ+a¤\0aKbèíÎ\n„˜]àC@‚º?I\rÐHãƒ®Ks%ÏN©ð—áË^°ÏÔ9CL/šž=%Û¨õhÉÆ:?&PþìEYÒ>5¢Žín[GÙ’×%Vàá»*ôw<¥ù­ÕgJ¸]º*éwd®]ÞBŸ5^óÖ¢’OQ>%­s{½Ô…ç•«;ìWö³‰ÖzÂGi®ýÀ*»ùRnìÑG9ÐE°Š¢Þ,(u*°±Õ’Ã—€ŠXÕs«àRŒ¦¦:µ5ë;”æ)°R¶¦ÍNúŠÈvKØ(œR³ÝM¢œÇbðîÔé©_‡{ÕF<<3ª:%ºÙHVëYS\ná%L+{”o.>Z(´Qk¢ÖÂN«!Ãì,‰:rH}nRÒNkI		ª‡[ò´Ìë’Ó§gÎÎÖ¤;mYÒ³g™%ñ9V~-J_³ñg²­•©Ë\\–É®£Q\n®–!õt«\\UY-tZn¨¡d:Bµ°Ê½Ü*í]')t“²¥wÁù–É«[BUm*Úr4†Ø–Õ*yv¢¶ÁvZÀÕ¹+GHÎåZn°PÂÜ…|\nT¥ %#\\·AX\0}5b+wr«XwÜ²1uù×%Cg=I­òv`cržeË0`..<·êðh‰+ŒHÌ^\\j­yFòÝ%Ê]¹BÊ\0ŽÉrÅ+€> %Zx¹š æ%C.ªÃìÄ`Vn­1KS¾¥Îk\rƒõçX|´õ[Ì;õ6H	U@©D:Þ»Mj	Î•ÛÊ?ýª]Ú¤Øˆb“A+ÔÅG£\0thxbþÆL`”ÅÀ64MÞ›ÄôŠY#ºhfD=e€Øw=´c˜+H…ñ¡¡:„.%ü^\$òDZrAzjÿfLl›7’o¬Œý°Û\0¨-äÜ³EdäÞ‰yz'V ­“Óž¯W´	Zö§K˜+°d(AÌfyÞP?‡xRš^hõ…¸'•æàA\0ˆž¯:p\r„d(V±ŒÜ½šdöt	SîFcHÈŸ¹]r¢rÊCHY	X_º/fƒŒÝÍ½ 4 7eÚ6D³{,ÑèþêØ<<Z^´Ýj\"	éµ\n+Æ€M…Y9…’A‚(<Pl¤lp	“,>Ð€¤{E9Ü&àGhšh{(ý±Agg8 (@ÞjTûnËg€Zã†ÙÅ°ÁJˆÁŠ³x¦˜Œü¼@ic¶àÕ‹ô(pƒ'oJ0MnÄ€í&Ê§³\r'\0Õ‘ø„\rqÑFè4½°Š)ý½cL˜§þ_ÀoJÚ}5ïÚc–o¨àà|6„m¾}Qª£á4QëÇb„·µ[úx«m( Ý&µ@ä;Â+ò˜¥®ÚÅf|IÎàõ”RÐ48… {	`øè®çk`u»r`èWã¸±`\"´Ž)fI\n©Ô;ò8ZjÍ‡–gð~¡šAÎˆè!j¼Ä%ÄæT ÂE\\¯\r3E“j‚jê¢FXZ	âÏAyækH ØXdðgCQ“–±´áÎ€þ0ðd”ü²¨°ïû¡†út¨	œÇzkÀ`@\0001\0n”ŒøçH¸À\0€4\0g&.€\0Àú\0O(³ÈP@\r¢èEÄ\0l\0à°X» \râæEä‹Ç8Àx»¥›@ÅÔ‹Ö\0À¤^˜»±z@Eð‹æ\0Þ.¤^¨¸Qq\"éÅà‹æYäÂD_p&âÿ€3\0mZ.Ppà\r€EÏ‹÷sˆñv\"éÅá‹ç0´`ø¿wâñÆ,óü¼_¼`\rcÅâŒö/Ô]x¸q‚€€3\0qÎ.p˜ÂqŠâð\0002Œ_ì³i„ˆÄÑŠ¢âEÆ\0aÞ1äbÀÑwJ \0l\0Î1,`ˆº1y\0€9#?0T^ØÇq‘£\$F6Œž/\$d¨¸‘‚€FDŒyJ0b˜»\0	ªÆWŒ¾\0æ.œc¸Â‘{c EØ\0s†3l]@\rbùFŒ\"\0Â2ô`˜Á‘’\"ñ€7‹µÎ/à\0±š¢èÅÓa	^04e¨ºQ{c<ÅÑŒÉj/_˜ÁÑc\0001Œµ*28BAàã\0000ŒxÆ”iØ¾1˜£F5ž0ljH¸‘™\"éFŒ30\\_ˆ¾q™\0ÆfŒ¡T³l_0Ñ‚£BEÄŒ#3ì]øÒñs€Æ½‹Ó†64_XÀ1–\0Æ½‹ñà™d`ø×`\r£SÆ_JMV/f€±­€1\0005I6tf€°ã4Fª‹Á¶34fà‘ ãF-‹ß’6Œd‘±\"÷€4k½„\$h¨Â± #EÅÌŒú\0Ö6¤_01—c@F‹áª/d]X×Q£#G\n‹÷†5¬g¹q‘ãEF\nŒm\\ÂDn˜Åq½£YFv1/4`øàq½ã€4=â8b×q|À\0004‹‰Ž3ÄmXÁ1‹£e‘ö\0Åî.¬\\èàQ—cIÆ	·.7ü\\xÖ`\"íÆ\0i^3ð(ç±’ÀÆ\"ŽEv4l_ÈÈq®Œ\$Fñ‹±àœoÈ¾ \r#UEä©^9ütˆÁ‘¹¢ïÆ.Ž\0Þ3|rÈÄ1¿\0Æöù69l^x¹Ñ¼PF-Ž]\n0ÔvˆâQy\"íG‹³2,sxÁQq#™F+Œ\0Ù/DiÈëq}£ÀÇ8Ž[6,jø»\0cmÇo×N5¼ehàQv£«GL€H<T_ÐQ®£?FÉ‹É..\$føÛÑyãšE÷ŒC2Ül¨Û1s#ØEéŒD³lohÙÑ²£j ‹²Â8Ôe¸Å±ÔbðF!õÆ9Ü`xÓq¨£§–CÆ7ÄhxÕÙ£ÆÅŽ»ú7œ^xÍñðK<Çhƒø	,uØé±‘ãG)Ú;luàÀ#îEßŽ¹þ<ükÛÑíbþÆÜ\0sR.¬w¸Ö±ž#zÆ~Žw’2|x(Ú÷âð\0001'†:Üv‰\0001‘ã¢GæŒ¿¦?|`øò‘£‡ÆóŽÛ .2¨XÜÀ#“G¨8KÆ@<z¾1–£Æ¹Ž\"9|jˆÒÑÐã	G¤Ž/æ6ÜqˆÞÑö€GÁsÖ7ù/\0001‹büÇßí¶:|ƒ8ÚQÚ#~F»W‚4ég˜ÌÒ#<F\rµ š2üƒXÁQÌ#ÿFvkî7´xÒ1Ú#ÎÅÆŽ›¦@¬rhÜÑÀãêF”íZ;¬fÈårc¿y‹‘!\r	ä_xë1¿\"üH1Ï¶0TwèÙ²c\rF1 \n8dX»rãÐÆÔŒ§Þ2Dbèý±{d4HˆŒrA<~ÈÙ1±dBHI[J?¼¸ÅÒ£qÇ~kº0ÔtØØÒ#„F\r#ž0\\h¨î\r¤GÈŽí’EttØè‘íc7ÈUŒ¿!Ö=D_ˆèòcNÇ\0‘yÖ6aÙñë¤ Fgç!v1ÌqØÈ1ØãKÇ‡»â@äeè÷Ñ³cGoó\n/¬ŒøÆ²ãˆEã‹Á\"ž3t`©ñö#cHŽµ‚<ÜcøÓqâüFî%†?Tbè¹±°d)Ç‹© r0‚øÌñqc¿EøŽã>3\$tyQÒ£…ÉŽE’Cl`9)¤VFHMJ7”føöÄ\$HHQ ;üri’7#F³-F¤HÆQ÷#\0G·!‚1ä^Èþ&4¤vG&‘û7Ôgèà±ƒ\$\0GŽ\rr/ÄdÙR¤(Æã‘s6@¤“Ù'RAãÇ¬›È”Œù&‘¢¤–Çg\0k z=´|HÙ±Éã‡ÅàŒÉ^J´]ÀÑsd¤Ç,\$’1”¨à<cqÇ¦’ŸêJœ_øÏÁbçGˆŽQvJ´¸Ø±ÞãH5Œ¢FôpÜÀIc¬È[‹‹Î@ÔrÈÏ¤vHå%ã¶3D”¨Çòc<I\$ŽM.d—Ùr1c=FžŽ÷.4„cˆÕ2béG.Œ!¦L|{X×Ñ³£{I«NFôdx÷qscÞÆÝ¿#þE¼a)‘Ñ#¹G”ƒŽJ¬m¹.‘û\$=Gh’AN=¬s‰ÑÅ¤EÍ‘GþG\\a1ò0¤ÛH¡‘ÁF.tg8ê‘Ã¤[Èòÿ¦Idn¸þò8ãF€‹ÙÖ.T’¨ûñ·€F3‘Eº6riq¸ãsF¼ŽÖ6ÄxºrãÚÆL=nFTžÒod Ç>-ª3ô|©2\$ý0„‘= â:‘xc’HËI\"NP\$b¸ÛQñ\$Fñ ®DÄ‚˜æÑïä}FêŒ%ª?äŸ(î£êÉG”3\$‚O\$^xÂ2T¢éÆñÕŽ0Œ¡ðR’‹Ì#ÈDŒ:„òE¤|i/2Œ£XGˆ’”’8¬•¹-ù\$HÉv¥Ö=dš‰ è¤Ç`’ù’:laxäÑú¢ðI¦¢:ì—XâRJ¤Òñ”ÒRÌmxê’J#\nGG“9!N¨ä{cIõ’Ó&æI¬ éR=£€I\rŒù&j:ä‘8ÃÒg#¸H‹á'3„_x¸²b¤H}”£>7ƒèèñŠcÌÇÙ\"&K<xØÊ2¡ãçH†‹¥\"6@dbèë±­e;É)Œ!–.Ä]ù/ò‘d—ÊŽm*f6,v©—ÉªÊ‹£ªLäÉ(qµ£AI8”7d„9TtcôÊ’‚UL•XÈò%H¡”I*z:Ì|IXqsá¨ó-ÂBÐÅäq^(•R¼»aq(~eÑñ¯§ 9JèU‡+-eq*nTà­Ð>¡\$ÕÑ«er’•Î±¡p\nÅÕ¼Ë\$es+îV£IšºÇb«øeq:ß#]•cc®7r\nÙf,gYø³TC²%Œñ	Ô}Ë\0–²©\\*ìEWPæaè:ÏE¥,&WòÆp)Å¦Ëxl²MáÂÄ3\0t\0¦/IipñD'\0	k\$T¤¬F‡¤]fºÍdMòÈ€K\$”¼ýH(@îÉ”‹»(–zµnWÒ¤Ù_ŠMÝ”*º\0¦eÙlF™^H	W*B––ZPe½ÅÖ˜‡ÓR/dRÂ—RÊ…\0Ku£,yH)¶\"SÊXI'®¹Zƒ=çLøRå3ŽåÄÒ\nÀ'š[kð­Í6@;}R”íýI²ò³ô¬_é) wê‚[óÀ û\nß´n–ª¼ŒÊ“bBr¸l,\$vÖíÍÝÔ°‡ˆÀÕH©à‡…\\¢‹Ùs*È ºå–.Qt’B…ºdˆb‘½—@ï?3¼S`a@¤Kª\\.«´à~Çfªž)¬«¨ï,?|&Ó¶KÀ£…Z9.ÝX³+S‘â|ÀœØ\0PÊ¼¢ŒE“òçe‚/Ê\0VëÖ^KÄ\0\n-	:ËÉSØ²)×ªû0j‘9TX•åžBðƒ½K\"åÅ¯±•Â²,2Æ'‡2ËåÖ˜P,¡xŠôàpÀÐáKê—ª´š›õ\"ÊD¢#TV²œD¿õ1ñAo;Ø•×/9TH%V`WJ<9˜¯aeÊ° K/V^/¨Q†¤Ø\nBñZ\"9íËÆXÒ¯M~\$°5„ŠßÚ\$0dè½I€U“Í³2¼^X\n¼*ãE7I\nV3«–…+ÎaŒÃIiÒÒNËKK˜g0’aŒ°„z*“V©º#bJyMÒ¦eõâZ– …V ¢`’ÐòÐU1ËC˜Ÿ.\rF²ª-jÎ&LU˜p§9s‚é¹Š+Q&1¨âRm¥ÕÓ±gZª²–	,.XryZì²°0¨ÏÜ3¬2˜A1©Ö‚’e‰Nû©¸˜ú²(?Al ÞÌ,Nèue²Ï\$|rùá_%²ñE05E}³\$¡Ü…X2«%ÚZªe €\n\";<9a¾hã¶¥àa]úÊì™8±à*éu¯åÁªL¥¦¶±dR¿ð0«¸Áª+ÞQm.ü,Gù–«¦M®ï_±2åedBêÍÝ¸,°S…2Á²>UÕêëÔ°»4vlë~e2©ò2¤eÄµËYg2nf’=Àþ\$%óÌÙ–žFfaìµ)‹ê§å”ÌfTÆ¶áG¤Í×g2ºW,[™šíÊX>)tÊA]œº™R*º&Z·Å6j2|‘¥\0 °(©p	ê9× ÌùuÒªô?ôÐ`nåœ-lZnë!H9²çæzLðš¢9VLÏ¹yÒÐÝ¢ZØJhR›‰g“EfL©UŠ²~`4ÍYˆçæx)\$B±QR#Ã•Sê”¥ËËõ,6i#ÀY¦“,;C±šr¬âiÙ&ÇXªû]èÍ\nw54­K‰x\n*&ž©Tš£îWüÓùŠ“¦©+SÐ»qNc·yóIWä¯Û\0W5cÔÒÉ«‹ð&+š¶ðVrå)¬êÎ£Kgšª¾Ô?‰ µŠ“¥|«gR¦¯†hR´%Kë¹œ)Z#‹5äŽ,Öµ–k…æ¼»`šìl:à•LsC”[M‰UB©6ldÑÑ“J¦°ªŸ•ï1nl:ºù•j¦ËLß–¢\0®hã¶ *)¥p/®šÞ§5\\”<9´óV¦…/‹šÞ«®hTÇdjµårMbx\nˆ]R¹çWªR‰ MaUµ3=×µ`0³oÈË,Z™¬³lÀÅ}Èó¦m¨ì›”í²lôÎ´ÕmLåS6ê\\’tÎ™¹òºèL—îÉ\\Ï%‘J¶”ƒKå™ñ7oÑ©Ÿ¤ef€Mš£’oC»Y¡“væ…­NVÃ4=RÑ¢sJÝÉÍö¬¶*hÔÕéhnäæ-m›é4‰ß4ày¤óHñMû›|îÊis¬U=ƒÝÚÍA\$Ú­òi¹Ï™¾“…öÍ>–êîÊpâ¼pûóQfø«îšÀ§ªq,ÔÕ5sŠULùš£8}Ý¬ÅÙª“Œ÷#ÃXH±ÙÝìßI««î§¼9Uµ8íc:³I»îíf´ªÐ±7Òklä5}Ð÷f¹LY•ð¬áN2Þ°ó}&½	išê®ñc,åI¹3‹ÚÄRœ©6räØ‰Ì3b¦ûÍœÇ6>lXY¿ûfýLœ)+ÙS,Ù‰Ì*ùelÍô™U\"edæº\"ZçªÚ–6’ZDßE9°á%ÈÎ‚›Y9rmtãEÐó'.M²[4¬‚^„åÉ·ë;M»wÙ5…×Í9¸Òóa¬¦v+70lÍÉÓÓd%£Ì<œù3Š_<é•lN²¦Š(€v+7YRlÎ…Óª]‡.•Õ4©I³®)¼³=ÖƒN®Tš]Û¹'U^Ó?çS«¼½7¾XC®Å©Ó¨Õ1Íu¹9©E´ß™²kçL;œ¤NhÌìÀSÝqNXk;1[„ÒõÓLgpVœBî1_¤á¥ÎÅgs¬ š;­RlîÕEˆ×ßNðTÇ8öw,îéÅs¯•1ÍPxrëŠq”ê‰ß3¦¬(ª;ñZÚý	yÓ¾'{O	_´¾êrï™ÈªMg|ÎIó92eLçÊó”f¼O\rYŠnkÜåuŠ™”SNÉv9Vkâ“	Ë3Ç§.Ì›v9zydæ)á“¦ÈNÐYì&s\$ìùÍjd'6Í”œQ<ÍVÜç)èeç+Ï›§:ÑØ¬êYjt¥¡Ãp‡u<±ÝÊ–Éß3¢]qM°žY:9XãµS³¾gI«Ã*¿mäÆÄCëùýžv GßìÜR@ÀÖ¯¬jT—=¨:e ÛÀ(\0_Vn©,?p	3Þ'Î ™¸¨‘Ø™ïÒ\r¬†•¼ö|\"ÞiðºgT’nþPçš¤°\nÓ”åq,ÛSf¸.YÐµQ A¼A‡,ZÊÚeSå›˜sEÀì\rú‘v„T‹¬QŸZ©\"pó²IósëUAÏ›\0¾ëvZ¸}®rÙ¥KŸtféPäf9ç–®¸{¼¶^J€çßÏ‚Ÿ”¿šø©•\n0%«€NGÚ«*~lüD.»¦ÎKeŸ¹6¢[,Ô%ÀˆðOÕ˜É-†~ìµ•–óú¥j®ŸRO;úŒ@	Ë¨en›b_¾%sK¿Åœë‚ÃïYÿæºÎYÑ0ü¥ÃLËWª¦jrßÕóèÏ† ë©!BšÙñ”æ„Pv´£fwÚ«Éø€çãMÃR2´2€zŒ4rúh;Ò#M@…}…\0‰|ëã¨MÃ\0…=Ú=å¡àf-!Ÿ6pÊ g[P4‚´†ÌìóCÚ[5:–‚\rµCt¨ÍÃ u@ýÛº<éŸäif„ÐNu¼n[ñ!u8j{&9Ku FQlR“iÀ(ËC ÇAä®™s4ˆë\0Y Í;fƒB<Ô{”å˜¼R_Iš~š…6ô×|MWTAí]4÷e@J­eÉP|[ú¨–r5*Áÿ—OÎ íBt½)¤ê¯%Ð-\0Pªjm	usá§}Ð˜Ÿ“Bi^©Ú*¦zÐ0YK.ù`[¯Yû2íÖÐ«—|°XBÑÅÁÓÁ(?Ð—±.\$“l¼’³,æÎX¶DçÍ\nêëjæ¡OD ->_<¼¥ÕÖ‡Ù\0š£ÙÕ¬¥Ásøh\\…¡•ea\\Ó\0Êöeä‘™Yµ`¼¥´7UØ\"e¡ÇCYTìñÙzt:V9P™_š³…a‚Ð•FÔ;Ý€\0MŸ¢´†…2“eúëHCéÐóZ‘?îVò¼åœ'×¬å‡ä³}c¾Yüaõè„¬åý?Qh8	ð´0•Q‡CM`ºŸ«ó6æø,‹Ÿ¢J‘eZ¾Z\"G—Wª¡u†–u\rÕ>49èKý—ðI%L–¹ÍÝV9Ïü˜ÝÖ‰´øZë{VEOÄX;©áÑÏÐoàagPÂ\$\n²RX@}!-Si€òRª¾¢qzÖ	öêITH.¡Ôí\nk\nïš \ndÏ®˜Tº‰²>Ð\nîÂ– ­?£E…`²Ì5D+f’?#z³…IZü7T[¨€Qs#ùDˆŠ\$«ÕÏPù¢ìI†	û3¾×*¼:Ý9YI²ãH‹³ÔH®¬X«0åDŠ!u7J¸–m® YB}Eª°Š³¿—ç®€¢òr”8Q•ù\n}'PõSâ²	Q±Ðõáú¨Ž‘°\$§Å`RÇ)^áõ(O€P\0®aK½µõômè3¬Š\$H.„ùX„ëñÔç)ÐV®™`”­Ú9 ¨.®Y™‘18âÚeUÁ’`Xç9Ž‚´	Œðäç\\Lcˆj°IE Né«ª¦6€W¡D¦XBØ	Z‹:”|Ï¤:	E-P-Ú&ÎÁè¿)ú†ð§ˆ*ÓúÔlÀ)PÂuŒy|R°³Lhÿ.p¤§é_* QA †@ ·?,Æ§êYêÖ)t‚Ñ‡œ<íÁP*êåÜj’VuQþ:2\0L¸?JëçèÑ,TPHL²ÁúE%–¬\0ª¢yP(YJZ¥î©úTHÅX\r	•Q4ŽhOÒ;\\vVõ#åÀTWw‡ï\\`ŽõOÒ¡Å«?ÒJR2³ò’=õFóâ]»ÐŸI5TMjIë9é,(Æ¤Dv|tÉ)ŠWy-¦]z¨Úe‚Œ‰a,pQ6\$ëI-g=%‘SÔW#íTP§Ü¤É)«T&]ÞÑõX15j†”B8„„æVÏÓ¥\nìem y“”Žh›*è¤ü»Ž„°dç4Ï‚·bd!0¤gR”J\\Í ÖMtƒÀ1R\n\nïâxè¡èÜÁª.ö_¾üuò+Æ¼Ç;ý‹*4ˆÎ¸)]À\\¡lÜ(m\"ñžƒQ†nTˆ(*\0¬`ð1Hì@2	6hàêYÀcžžH_ÌÚÈfð?°Ða«–7=KKdeÂt÷HàÀ2\0/\0…62@b~Ë`·\0.”€\0¼vÙ) !~º€JPÄT—Á½ô½’–…µ¥óÂ—ÚOƒ{t¾¾\0005¦¾˜/à¯€\r©ƒÁJ^ð½0Úa!¶)€8¦%KÞ˜PP4Åé~ÓH’˜á÷ÐÅô¼Üí\r+¦Lb˜¥/24)“Ó¦GKê™e0ŠeËé€S1¦B¨	-0jfÔÄéšS¦wLÎ™Äiêd …é Ó¦Lºš\r1ºhôÈ©œS ¦—MJJÊht¾)¨Ó+?L¶še5n”Óé|FHŒÉMN—õ5êjÔÉ©™SH“ÕL–—å4É=TØé´ÓD“ÕMnš½6Zm@I@S`¦)'ª™Õ7fòz©ŸSz¦x~OU1k”¿¤õSF¦ýMOU4ªpôÙ£2\0000¦ì¾7…6ŠkÑ#xSl§'Kâ7…7\nl”ÍãxSu§LR7…7šstßãxS}§GM7…8*qtÓ#xS†§OM\"7…8ªuôë)ÆÓ\0¿’š•9úr™)ËSr¦‰2šý; ôð)ÞÓ7§Nj›m/Šxç©ÕÓ¿¦sNÚž:jy4¿©àSª§gO:1ý=\ncTö©§SÍ§•’œ•;ê{ñ¥©îSÈ§/ORH\r=ÊtTôéŠIÝ§¥Ož˜¤\\zx4÷©Sò§‹MþŸ•>j|TýiºS¶‘³O†™¼š~ôÐ\$lÓú¨Oöžš}tüÈÙ§ßOî˜¤šzÔû*%§]PPüšvU\"úÓÝ§¯Kâ í@\noõjÓH¨;P¡>š1£éÿFd¨P.5BØ¸•ª\rÔ¨3œuB¹<µL#Ô<¨QPECÊu*\nÅÛ¨yPN¡´lª‚õ\r‹6Óó¨?Kú¢mBZi•jÓH¨›O2¢}1J‰µé›ÔM¨_Mþ¢mDŠˆ€ê&ÔK¨ÇQ6¡­Fzv´ð‹6Ó¹§éQjå;jµj)Ô*¨Þ¾£mEÊŒª9Fd¨ÅQv5eGØÉµd¤Ô„¨EM\0+åDêƒ\"j)SD©QÒ¤pZfµéÆ‚§mR&¢ýHŠ’U’Û%§{Rv0m0z”¥ä§ŸLÆ¥@ú”'ÖÔ©ER¶?eJ÷>é¸Ô¨ÝM’¥µIú•²ªYT¦ŽÛRõ/¥BÊ•.êUT»©YRÎ¡L:™jNÔ…©•Rš¡ÝLú˜5ji&,Ž‰Oê¦mJDß5,ã9ÔÀ©­Q¦©Íè•1êhTf©›NÈ˜ÒÑÞ¥Q€'©Î7¾§Lih¸²\rcjÔŒ‘Sz§ušŸ\0nãÔº©g¶§Ø9Õ@cÕŒ\rT§%LÅÕAªfT­ŽMT9uQ\nŸÕ)¢çU©µSº¨uD:“±—jˆU	©­Æ¨…PÚ–q‰*‚EÚªKSb¥l\\Ú¤µFª”ÔÅªGTz§gJ¤µHªSFª	\"©½Q:˜1‘ê›Õ©;†©½Rê¦µL*~EßªoTÒ¦\\z ‘„ª¥Õ:©­âª]Sê•±Ÿª¥ÕBª“U¨^J©uR*kEõª	ªýTêœQtê¯ÕR©g2ªýUj«µV\$ÅÕ_ª¹Sˆ³mPHÆU\\ª±TüŒ[UÊ«5JhÙµ\\ªµUpªÙ¢«•Vð7a_*€Ó«¬=R‡>\0I*¼¥ô”V«íX:hU8jÉTæKZ’¬\\:ƒÕ)jÇT·«8˜±	åWZ³Ub’òJ8«R­=Y³UVžU–«R¬¤\\:™Õ-jËÔÑ«iV.¦¥[z´±ÒªÂÇ-«{T²­ÅZªuoj×U»«3 ¡Í[ª±Õ>ªØÈ«E ­%\\º±µh#bÕ…‹©WZ®-\\º¸õCêæÕ«»W>¨­]Úºg4#¶ÕÀ«KTr®íZÊ¤wjãÕ\$«›z¬-Rj½õtjÐU*«ßWš¬tp\n¾4õ€ð'–N•Mº´²ªxUþ™X32[xò•+®“Ë\$B°US*½õqê›UÍªqXZ®}SÊÂÕxêÁÕ@¬-W\n5ÝXZ¨Õ…ªãÕJ«›U2±=\\úª‰ëF+«ñV‚0]XXÁUŒªìÖ0«Ž¬-VJ¹²+Ö/«É‚±ÍZÊ®5sj¹ÖD«ŸUÞ²%bØÉµªÁÇ÷«V²%Yš^u@d¤Õ¢’“WÐæ„”šÅ²Rk&œŒñYR¬\\¤Å’RkÖY©cVÆO-\\š—	kdòÓáKoX²¥KÊÍ/ë9Ö]“ËVªO-U‰<µ™@ÝÉå¬¥VÎ³[Ÿõ›«6U¹­—Â=eŠÏµo«4TÝ­Yâ0eHÆÕ¤ª\rÊÍ9«¢•¬6à(ó®•+ž7ÎybÓrI §|Ä\0—:FzðÉè\n…§|ªœs<°R½%JÓËÔ]¦õFèµ3õ­Œ‰j¢Î£¹Y®µZ“¾^<5žX·IJòÅM`×nO\\£B&¶r“õsÅçQˆuz¨¢x¼å¹è	¬Tˆ®¤VwÍJ5¸g	Ï?v¨qF4ï•9³Ó·»­Õ6ªzjùèÕ‡OV•¿\rÎuÊ=Â@Ê’fTÍšœðïöy´³	€Ö«pKaXU9šm²³…­\nekMo›Ã5\nhTÞ†ê¦¦…V ®¬v€‚ý:®Ñs®ž\\p>ÁÒLÓ:¦‹)ñ­O=nk}j¥Sõ«&·Ö®žª~µŠ¤y©àe”¬ÜšßZÖµñ)jØ®”t×VR¢Vµ½sµrÊ:+aÍo­‹,!TýlŠUÏ•Þ*n­›5¾¶\\ðU÷dv+’M\\®)]B¶|ñJë´¦l;4˜¯5öpLÖùÓµØ¦7Liý[~bmtÉæSe€\"»°›Bº½v©´d“ç@Í§SÁ4)Ø’—Zï¼»\$)®ñ5ic!™µ´¢½ÎŒ–êî\\Rù*ßSD¦’Îw\$›9ætSÁ\ná”GfòPÔ›ÆîÊ¸´ßÚã*¦	KÍô­D·Vyû¹5ÍuÈ¦J×‘š\\šµC¹•\$“ÙW,¯M\\º»ôåÊæ5¬ëÓ–®k^•VÕsŠè5®k¡Ö»¯M^êµý{Àu°§Ï¤wFQàßJéHûgWN¡k8þºÍŠôÊ‰+¸»§˜¥1brÄíùË•ØëÓVÜX]dLçjí´YT™Îv®ç6–twyË•Þkò×ë­à«vx=…5àh»²ï½ô8—]ÊÁ‘ñË·x\"c|ÐufUÿƒþØ\0˜Ò§5ÞjÈ©}”PknÌšRl¾‰fÙªà+ò“ÑÛ£‚¢>c4Æ×W+TýDo®Òï ’Ç÷qî¯É€SX’¨Ýb}}Åhnµ&<Ï?™/3º”-Ã¡h†°©qn‰ý§	õpƒ%)SÉyP\r…ÛÍµÿm-Ïf5°Šº[€\\–=ÌTà}øy )ýç Ydç«Ø¤46#Y>¥3ÔŒ× šm©ú\n09h;²4˜°Â0‚Ã+ßae\nÈƒÄ°Èž!ÊÅüÑ)‘@ôx¢x}‡\$¦ÖßýAFŒúÃ‘²0Nö Rã	º°þÓ„èiÜ¥ü¬U¬?½¡—b5í!+×­\0G˜ýØw{¶îÓ¤—ïlI £)’w-4;p8ÂÎØ¤;@\r\n\r­…ÚN5Æ…F\\Ó¹hgPE il0¦ëX¦%’)\nˆØLkÈ^‚Æ2¢Ý<5FØìd‰Iƒ<ñFÆj³bM¬d'á	¶Æ²D£âîŽBma²ÐÒö…ýOYñXgg¼8¥çZVØ%mf¬Ô%å€F¡-¥,É\nƒ‘ýaù¤FÇwfƒôs¹ç¬Ê0Gä¹‘ØZ²\n	1†;Jí–1Á\"iPñBÈy´C¬–Ìû²t—zÓ‰ãÑÖ;l‚4âÈÒ¡‚ƒJ‡”mLX²+lá˜ªõ{Â8¬\"â\nÌVÁÀšÄÛ(Ú\$Y\0íd\\Ý†6›D9B´H±d%¦Óî–1ÛÁ˜6f Ñ\"ÊTJÖÚ`/²‡>ÊC=Äc“ì¨±¼²?e!ýk*±3l~ƒÃÓiÿ«,×A‚z/dà¨¦MoìÅí´Ú²nÑ\"É½„ÍÂëÆzTr}eÙŒ{MÀaCÔ7‘fiTºõ—Ë/6W¢©P²ìÖÌ8†Fa`Ýì¾5³ó©¹M…f2V]œ['}cn4]h·íÖe«¦‹Z€Å§\r™‹2ÉÈ½XllGa`(­™—Û(‚ŠÄò\0èÄýšÐ_ölO˜ùf&fÄ1c8ìD{¼QæÜ	S6öp\0äYÂ˜æ¹˜™î\0\röq…3m&*fÎ;Ìpò6r^cŒÏ³¨—`Éµ&z€n^Ú±ù;DÈèSã¤oj^ã=¿L'g”5œ“Ä&ƒìä‡Ef&ñÞÏ|\nK 6?bX*¬.fÏˆEƒû–~&9Ù!˜çdŒk@‰v\"F¬Gšx\\é=ýEŠ7ïXP2[:Á¶\0ƒ×Žà¡ X~¦½7·ÍâX6†4²œÉ(Ã\";Bì\nÞýX×Ñhy¹Ì&›DÖˆÛZ¼l\nKC–‰íšŸ†pØ’Ä`mS®	2ÐU¢;Gà•‘8¶´{’Ñ-”±WBmì¸\$F€ø\ràl&B‡Y2\r´¨mAÅ‘°wÄZØ6ØRÐ’¿Ð%d´ŒÝÂÚ_²œTô5¦``BaÐÙG´ÕcáXKö\r¶˜\0­ØgN¼ù\\‘´¾;Nà¨àÄÚs^\nŒÌu§ä¿Ÿ­Ñ²VwzÄU F\"\0T-±,^’Î\0‹Îö—è2 /æ™ óÂÏàEWž/\0Â¼ò–ÒÄ¾Ë4;\"ìK-NZš½ÐMcÎ»RVNeœZ¦wj–ÂŠ6ë¯a¶÷yÌˆÙç»‹KV®lN?±Ãjt2­–¶T/[íN¤û±j|0t% #°”€âÑ\0ôÓ`£ø5F<–´ƒ X@\nÓ¢Áí•ËZF\\-m›¼³cd2Äp5Gºv'Bß'¢7{kŠ*'LÜAªZ|I±k´\n-.C¢6¼«¹Çk•-¯×Ž©SÚú°÷kÑ]¯Ë_\$…Ú+Gò× [^‡­­z]kÑÑ8›\\ö¿F|§¢?BˆØÁ^ÏB¨‰ÌŽ|ñ™ë@Š­Â÷B¯¥zPéžW/R?[!bB–á¹kÀ‰Ñ '	(ãe:xfàr‚7\r_íâq¶Maê\0#±ä7|éQ&\0É@)µô†À1òë®†LA[PtÀ\0œ™ý`‡6Õ\\e‘Ÿ¶zxÒÚSÝ€vÕˆÏ€U:žÚ±¿T¼Á‡ˆÏ—>fÛ\nq‹l€Å+K(|¶\\Ž´Ñ G›UØ‹³Æ@(ð*ÉiS%F¨\rR\$©•C¶¶LÐÝÄö;ÉdµìÄ¼gë-\$m?ölhÊŠ3?PªY\0");
    } else {
        header("Content-Type: image/gif");
        switch ($_GET["file"]) {
            case"plus.gif":
                echo "GIF89a\0\0\0001îîî\0\0€™™™\0\0\0!ù\0\0\0,\0\0\0\0\0\0!„©ËíMñÌ*)¾oú¯) q•¡eˆµî#ÄòLË\0;";
                break;
            case"cross.gif":
                echo "GIF89a\0\0\0001îîî\0\0€™™™\0\0\0!ù\0\0\0,\0\0\0\0\0\0#„©Ëí#\naÖFo~yÃ._wa”á1ç±JîGÂL×6]\0\0;";
                break;
            case"up.gif":
                echo "GIF89a\0\0\0001îîî\0\0€™™™\0\0\0!ù\0\0\0,\0\0\0\0\0\0 „©ËíMQN\nï}ôža8ŠyšaÅ¶®\0Çò\0;";
                break;
            case"down.gif":
                echo "GIF89a\0\0\0001îîî\0\0€™™™\0\0\0!ù\0\0\0,\0\0\0\0\0\0 „©ËíMñÌ*)¾[Wþ\\¢ÇL&ÙœÆ¶•\0Çò\0;";
                break;
            case"arrow.gif":
                echo "GIF89a\0\n\0€\0\0€€€ÿÿÿ!ù\0\0\0,\0\0\0\0\0\n\0\0‚i–±‹ž”ªÓ²Þ»\0\0;";
                break;
        }
    }
    exit;
}
if ($_GET["script"] == "version") {
    $ld = file_open_lock(get_temp_dir() . "/adminer.version");
    if ($ld) file_write_unlock($ld, serialize(array("signature" => $_POST["signature"], "version" => $_POST["version"])));
    exit;
}
global $b, $g, $m, $ic, $qc, $_c, $n, $nd, $td, $ba, $Td, $y, $ca, $me, $pf, $bg, $Gh, $yd, $ni, $ti, $U, $Hi, $ia;
if (!$_SERVER["REQUEST_URI"]) $_SERVER["REQUEST_URI"] = $_SERVER["ORIG_PATH_INFO"];
if (!strpos($_SERVER["REQUEST_URI"], '?') && $_SERVER["QUERY_STRING"] != "") $_SERVER["REQUEST_URI"] .= "?$_SERVER[QUERY_STRING]";
if ($_SERVER["HTTP_X_FORWARDED_PREFIX"]) $_SERVER["REQUEST_URI"] = $_SERVER["HTTP_X_FORWARDED_PREFIX"] . $_SERVER["REQUEST_URI"];
$ba = ($_SERVER["HTTPS"] && strcasecmp($_SERVER["HTTPS"], "off")) || ini_bool("session.cookie_secure");
@ini_set("session.use_trans_sid", false);
if (!defined("SID")) {
    session_cache_limiter("");
    session_name("adminer_sid");
    $Of = array(0, preg_replace('~\?.*~', '', $_SERVER["REQUEST_URI"]), "", $ba);
    if (version_compare(PHP_VERSION, '5.2.0') >= 0) $Of[] = true;
    call_user_func_array('session_set_cookie_params', $Of);
    session_start();
}
remove_slashes(array(&$_GET, &$_POST, &$_COOKIE), $Yc);
if (function_exists("get_magic_quotes_runtime") && get_magic_quotes_runtime()) set_magic_quotes_runtime(false);
@set_time_limit(0);
@ini_set("zend.ze1_compatibility_mode", false);
@ini_set("precision", 15);
function
get_lang()
{
    return 'en';
}

function
lang($si, $ef = null)
{
    if (is_array($si)) {
        $eg = ($ef == 1 ? 0 : 1);
        $si = $si[$eg];
    }
    $si = str_replace("%d", "%s", $si);
    $ef = format_number($ef);
    return
        sprintf($si, $ef);
}

if (extension_loaded('pdo')) {
    class
    Min_PDO
    {
        var $_result, $server_info, $affected_rows, $errno, $error, $pdo;

        function
        __construct()
        {
            global $b;
            $eg = array_search("SQL", $b->operators);
            if ($eg !== false) unset($b->operators[$eg]);
        }

        function
        dsn($nc, $V, $F, $xf = array())
        {
            $xf[PDO::ATTR_ERRMODE] = PDO::ERRMODE_SILENT;
            $xf[PDO::ATTR_STATEMENT_CLASS] = array('Min_PDOStatement');
            try {
                $this->pdo = new
                PDO($nc, $V, $F, $xf);
            } catch (Exception$Fc) {
                auth_error(h($Fc->getMessage()));
            }
            $this->server_info = @$this->pdo->getAttribute(PDO::ATTR_SERVER_VERSION);
        }

        function
        quote($P)
        {
            return $this->pdo->quote($P);
        }

        function
        query($G, $Bi = false)
        {
            $H = $this->pdo->query($G);
            $this->error = "";
            if (!$H) {
                list(, $this->errno, $this->error) = $this->pdo->errorInfo();
                if (!$this->error) $this->error = 'Unknown error.';
                return
                    false;
            }
            $this->store_result($H);
            return $H;
        }

        function
        multi_query($G)
        {
            return $this->_result = $this->query($G);
        }

        function
        store_result($H = null)
        {
            if (!$H) {
                $H = $this->_result;
                if (!$H) return
                    false;
            }
            if ($H->columnCount()) {
                $H->num_rows = $H->rowCount();
                return $H;
            }
            $this->affected_rows = $H->rowCount();
            return
                true;
        }

        function
        next_result()
        {
            if (!$this->_result) return
                false;
            $this->_result->_offset = 0;
            return @$this->_result->nextRowset();
        }

        function
        result($G, $o = 0)
        {
            $H = $this->query($G);
            if (!$H) return
                false;
            $J = $H->fetch();
            return $J[$o];
        }
    }

    class
    Min_PDOStatement
        extends
        PDOStatement
    {
        var $_offset = 0, $num_rows;

        function
        fetch_assoc()
        {
            return $this->fetch(PDO::FETCH_ASSOC);
        }

        function
        fetch_row()
        {
            return $this->fetch(PDO::FETCH_NUM);
        }

        function
        fetch_field()
        {
            $J = (object)$this->getColumnMeta($this->_offset++);
            $J->orgtable = $J->table;
            $J->orgname = $J->name;
            $J->charsetnr = (in_array("blob", (array)$J->flags) ? 63 : 0);
            return $J;
        }
    }
}
$ic = array();
function
add_driver($u, $D)
{
    global $ic;
    $ic[$u] = $D;
}

class
Min_SQL
{
    var $_conn;

    function
    __construct($g)
    {
        $this->_conn = $g;
    }

    function
    select($Q, $L, $Z, $qd, $zf = array(), $_ = 1, $E = 0, $mg = false)
    {
        global $b, $y;
        $ae = (count($qd) < count($L));
        $G = $b->selectQueryBuild($L, $Z, $qd, $zf, $_, $E);
        if (!$G) $G = "SELECT" . limit(($_GET["page"] != "last" && $_ != "" && $qd && $ae && $y == "sql" ? "SQL_CALC_FOUND_ROWS " : "") . implode(", ", $L) . "\nFROM " . table($Q), ($Z ? "\nWHERE " . implode(" AND ", $Z) : "") . ($qd && $ae ? "\nGROUP BY " . implode(", ", $qd) : "") . ($zf ? "\nORDER BY " . implode(", ", $zf) : ""), ($_ != "" ? +$_ : null), ($E ? $_ * $E : 0), "\n");
        $Ch = microtime(true);
        $I = $this->_conn->query($G);
        if ($mg) echo $b->selectQuery($G, $Ch, !$I);
        return $I;
    }

    function
    delete($Q, $wg, $_ = 0)
    {
        $G = "FROM " . table($Q);
        return
            queries("DELETE" . ($_ ? limit1($Q, $G, $wg) : " $G$wg"));
    }

    function
    update($Q, $N, $wg, $_ = 0, $hh = "\n")
    {
        $Ti = array();
        foreach ($N
                 as $z => $X) $Ti[] = "$z = $X";
        $G = table($Q) . " SET$hh" . implode(",$hh", $Ti);
        return
            queries("UPDATE" . ($_ ? limit1($Q, $G, $wg, $hh) : " $G$wg"));
    }

    function
    insert($Q, $N)
    {
        return
            queries("INSERT INTO " . table($Q) . ($N ? " (" . implode(", ", array_keys($N)) . ")\nVALUES (" . implode(", ", $N) . ")" : " DEFAULT VALUES"));
    }

    function
    insertUpdate($Q, $K, $kg)
    {
        return
            false;
    }

    function
    begin()
    {
        return
            queries("BEGIN");
    }

    function
    commit()
    {
        return
            queries("COMMIT");
    }

    function
    rollback()
    {
        return
            queries("ROLLBACK");
    }

    function
    slowQuery($G, $ei)
    {
    }

    function
    convertSearch($v, $X, $o)
    {
        return $v;
    }

    function
    value($X, $o)
    {
        return (method_exists($this->_conn, 'value') ? $this->_conn->value($X, $o) : (is_resource($X) ? stream_get_contents($X) : $X));
    }

    function
    quoteBinary($Xg)
    {
        return
            q($Xg);
    }

    function
    warnings()
    {
        return '';
    }

    function
    tableHelp($D)
    {
    }
}

$ic["sqlite"] = "SQLite 3";
$ic["sqlite2"] = "SQLite 2";
if (isset($_GET["sqlite"]) || isset($_GET["sqlite2"])) {
    define("DRIVER", (isset($_GET["sqlite"]) ? "sqlite" : "sqlite2"));
    if (class_exists(isset($_GET["sqlite"]) ? "SQLite3" : "SQLiteDatabase")) {
        if (isset($_GET["sqlite"])) {
            class
            Min_SQLite
            {
                var $extension = "SQLite3", $server_info, $affected_rows, $errno, $error, $_link;

                function
                __construct($q)
                {
                    $this->_link = new
                    SQLite3($q);
                    $Wi = $this->_link->version();
                    $this->server_info = $Wi["versionString"];
                }

                function
                query($G)
                {
                    $H = @$this->_link->query($G);
                    $this->error = "";
                    if (!$H) {
                        $this->errno = $this->_link->lastErrorCode();
                        $this->error = $this->_link->lastErrorMsg();
                        return
                            false;
                    } elseif ($H->numColumns()) return
                        new
                        Min_Result($H);
                    $this->affected_rows = $this->_link->changes();
                    return
                        true;
                }

                function
                quote($P)
                {
                    return (is_utf8($P) ? "'" . $this->_link->escapeString($P) . "'" : "x'" . reset(unpack('H*', $P)) . "'");
                }

                function
                store_result()
                {
                    return $this->_result;
                }

                function
                result($G, $o = 0)
                {
                    $H = $this->query($G);
                    if (!is_object($H)) return
                        false;
                    $J = $H->_result->fetchArray();
                    return $J[$o];
                }
            }

            class
            Min_Result
            {
                var $_result, $_offset = 0, $num_rows;

                function
                __construct($H)
                {
                    $this->_result = $H;
                }

                function
                fetch_assoc()
                {
                    return $this->_result->fetchArray(SQLITE3_ASSOC);
                }

                function
                fetch_row()
                {
                    return $this->_result->fetchArray(SQLITE3_NUM);
                }

                function
                fetch_field()
                {
                    $e = $this->_offset++;
                    $T = $this->_result->columnType($e);
                    return (object)array("name" => $this->_result->columnName($e), "type" => $T, "charsetnr" => ($T == SQLITE3_BLOB ? 63 : 0),);
                }

                function
                __desctruct()
                {
                    return $this->_result->finalize();
                }
            }
        } else {
            class
            Min_SQLite
            {
                var $extension = "SQLite", $server_info, $affected_rows, $error, $_link;

                function
                __construct($q)
                {
                    $this->server_info = sqlite_libversion();
                    $this->_link = new
                    SQLiteDatabase($q);
                }

                function
                query($G, $Bi = false)
                {
                    $Pe = ($Bi ? "unbufferedQuery" : "query");
                    $H = @$this->_link->$Pe($G, SQLITE_BOTH, $n);
                    $this->error = "";
                    if (!$H) {
                        $this->error = $n;
                        return
                            false;
                    } elseif ($H === true) {
                        $this->affected_rows = $this->changes();
                        return
                            true;
                    }
                    return
                        new
                        Min_Result($H);
                }

                function
                quote($P)
                {
                    return "'" . sqlite_escape_string($P) . "'";
                }

                function
                store_result()
                {
                    return $this->_result;
                }

                function
                result($G, $o = 0)
                {
                    $H = $this->query($G);
                    if (!is_object($H)) return
                        false;
                    $J = $H->_result->fetch();
                    return $J[$o];
                }
            }

            class
            Min_Result
            {
                var $_result, $_offset = 0, $num_rows;

                function
                __construct($H)
                {
                    $this->_result = $H;
                    if (method_exists($H, 'numRows')) $this->num_rows = $H->numRows();
                }

                function
                fetch_assoc()
                {
                    $J = $this->_result->fetch(SQLITE_ASSOC);
                    if (!$J) return
                        false;
                    $I = array();
                    foreach ($J
                             as $z => $X) $I[idf_unescape($z)] = $X;
                    return $I;
                }

                function
                fetch_row()
                {
                    return $this->_result->fetch(SQLITE_NUM);
                }

                function
                fetch_field()
                {
                    $D = $this->_result->fieldName($this->_offset++);
                    $Zf = '(\[.*]|"(?:[^"]|"")*"|(.+))';
                    if (preg_match("~^($Zf\\.)?$Zf\$~", $D, $C)) {
                        $Q = ($C[3] != "" ? $C[3] : idf_unescape($C[2]));
                        $D = ($C[5] != "" ? $C[5] : idf_unescape($C[4]));
                    }
                    return (object)array("name" => $D, "orgname" => $D, "orgtable" => $Q,);
                }
            }
        }
    } elseif (extension_loaded("pdo_sqlite")) {
        class
        Min_SQLite
            extends
            Min_PDO
        {
            var $extension = "PDO_SQLite";

            function
            __construct($q)
            {
                $this->dsn(DRIVER . ":$q", "", "");
            }
        }
    }
    if (class_exists("Min_SQLite")) {
        class
        Min_DB
            extends
            Min_SQLite
        {
            function
            __construct()
            {
                parent::__construct(":memory:");
                $this->query("PRAGMA foreign_keys = 1");
            }

            function
            select_db($q)
            {
                if (is_readable($q) && $this->query("ATTACH " . $this->quote(preg_match("~(^[/\\\\]|:)~", $q) ? $q : dirname($_SERVER["SCRIPT_FILENAME"]) . "/$q") . " AS a")) {
                    parent::__construct($q);
                    $this->query("PRAGMA foreign_keys = 1");
                    $this->query("PRAGMA busy_timeout = 500");
                    return
                        true;
                }
                return
                    false;
            }

            function
            multi_query($G)
            {
                return $this->_result = $this->query($G);
            }

            function
            next_result()
            {
                return
                    false;
            }
        }
    }

    class
    Min_Driver
        extends
        Min_SQL
    {
        function
        insertUpdate($Q, $K, $kg)
        {
            $Ti = array();
            foreach ($K
                     as $N) $Ti[] = "(" . implode(", ", $N) . ")";
            return
                queries("REPLACE INTO " . table($Q) . " (" . implode(", ", array_keys(reset($K))) . ") VALUES\n" . implode(",\n", $Ti));
        }

        function
        tableHelp($D)
        {
            if ($D == "sqlite_sequence") return "fileformat2.html#seqtab";
            if ($D == "sqlite_master") return "fileformat2.html#$D";
        }
    }

    function
    idf_escape($v)
    {
        return '"' . str_replace('"', '""', $v) . '"';
    }

    function
    table($v)
    {
        return
            idf_escape($v);
    }

    function
    connect()
    {
        global $b;
        list(, , $F) = $b->credentials();
        if ($F != "") return 'Database does not support password.';
        return
            new
            Min_DB;
    }

    function
    get_databases()
    {
        return
            array();
    }

    function
    limit($G, $Z, $_, $hf = 0, $hh = " ")
    {
        return " $G$Z" . ($_ !== null ? $hh . "LIMIT $_" . ($hf ? " OFFSET $hf" : "") : "");
    }

    function
    limit1($Q, $G, $Z, $hh = "\n")
    {
        global $g;
        return (preg_match('~^INTO~', $G) || $g->result("SELECT sqlite_compileoption_used('ENABLE_UPDATE_DELETE_LIMIT')") ? limit($G, $Z, 1, 0, $hh) : " $G WHERE rowid = (SELECT rowid FROM " . table($Q) . $Z . $hh . "LIMIT 1)");
    }

    function
    db_collation($l, $lb)
    {
        global $g;
        return $g->result("PRAGMA encoding");
    }

    function
    engines()
    {
        return
            array();
    }

    function
    logged_user()
    {
        return
            get_current_user();
    }

    function
    tables_list()
    {
        return
            get_key_vals("SELECT name, type FROM sqlite_master WHERE type IN ('table', 'view') ORDER BY (name = 'sqlite_sequence'), name");
    }

    function
    count_tables($k)
    {
        return
            array();
    }

    function
    table_status($D = "")
    {
        global $g;
        $I = array();
        foreach (get_rows("SELECT name AS Name, type AS Engine, 'rowid' AS Oid, '' AS Auto_increment FROM sqlite_master WHERE type IN ('table', 'view') " . ($D != "" ? "AND name = " . q($D) : "ORDER BY name")) as $J) {
            $J["Rows"] = $g->result("SELECT COUNT(*) FROM " . idf_escape($J["Name"]));
            $I[$J["Name"]] = $J;
        }
        foreach (get_rows("SELECT * FROM sqlite_sequence", null, "") as $J) $I[$J["name"]]["Auto_increment"] = $J["seq"];
        return ($D != "" ? $I[$D] : $I);
    }

    function
    is_view($R)
    {
        return $R["Engine"] == "view";
    }

    function
    fk_support($R)
    {
        global $g;
        return !$g->result("SELECT sqlite_compileoption_used('OMIT_FOREIGN_KEY')");
    }

    function
    fields($Q)
    {
        global $g;
        $I = array();
        $kg = "";
        foreach (get_rows("PRAGMA table_info(" . table($Q) . ")") as $J) {
            $D = $J["name"];
            $T = strtolower($J["type"]);
            $Wb = $J["dflt_value"];
            $I[$D] = array("field" => $D, "type" => (preg_match('~int~i', $T) ? "integer" : (preg_match('~char|clob|text~i', $T) ? "text" : (preg_match('~blob~i', $T) ? "blob" : (preg_match('~real|floa|doub~i', $T) ? "real" : "numeric")))), "full_type" => $T, "default" => (preg_match("~'(.*)'~", $Wb, $C) ? str_replace("''", "'", $C[1]) : ($Wb == "NULL" ? null : $Wb)), "null" => !$J["notnull"], "privileges" => array("select" => 1, "insert" => 1, "update" => 1), "primary" => $J["pk"],);
            if ($J["pk"]) {
                if ($kg != "") $I[$kg]["auto_increment"] = false; elseif (preg_match('~^integer$~i', $T)) $I[$D]["auto_increment"] = true;
                $kg = $D;
            }
        }
        $yh = $g->result("SELECT sql FROM sqlite_master WHERE type = 'table' AND name = " . q($Q));
        preg_match_all('~(("[^"]*+")+|[a-z0-9_]+)\s+text\s+COLLATE\s+(\'[^\']+\'|\S+)~i', $yh, $Ce, PREG_SET_ORDER);
        foreach ($Ce
                 as $C) {
            $D = str_replace('""', '"', preg_replace('~^"|"$~', '', $C[1]));
            if ($I[$D]) $I[$D]["collation"] = trim($C[3], "'");
        }
        return $I;
    }

    function
    indexes($Q, $h = null)
    {
        global $g;
        if (!is_object($h)) $h = $g;
        $I = array();
        $yh = $h->result("SELECT sql FROM sqlite_master WHERE type = 'table' AND name = " . q($Q));
        if (preg_match('~\bPRIMARY\s+KEY\s*\((([^)"]+|"[^"]*"|`[^`]*`)++)~i', $yh, $C)) {
            $I[""] = array("type" => "PRIMARY", "columns" => array(), "lengths" => array(), "descs" => array());
            preg_match_all('~((("[^"]*+")+|(?:`[^`]*+`)+)|(\S+))(\s+(ASC|DESC))?(,\s*|$)~i', $C[1], $Ce, PREG_SET_ORDER);
            foreach ($Ce
                     as $C) {
                $I[""]["columns"][] = idf_unescape($C[2]) . $C[4];
                $I[""]["descs"][] = (preg_match('~DESC~i', $C[5]) ? '1' : null);
            }
        }
        if (!$I) {
            foreach (fields($Q) as $D => $o) {
                if ($o["primary"]) $I[""] = array("type" => "PRIMARY", "columns" => array($D), "lengths" => array(), "descs" => array(null));
            }
        }
        $Ah = get_key_vals("SELECT name, sql FROM sqlite_master WHERE type = 'index' AND tbl_name = " . q($Q), $h);
        foreach (get_rows("PRAGMA index_list(" . table($Q) . ")", $h) as $J) {
            $D = $J["name"];
            $w = array("type" => ($J["unique"] ? "UNIQUE" : "INDEX"));
            $w["lengths"] = array();
            $w["descs"] = array();
            foreach (get_rows("PRAGMA index_info(" . idf_escape($D) . ")", $h) as $Wg) {
                $w["columns"][] = $Wg["name"];
                $w["descs"][] = null;
            }
            if (preg_match('~^CREATE( UNIQUE)? INDEX ' . preg_quote(idf_escape($D) . ' ON ' . idf_escape($Q), '~') . ' \((.*)\)$~i', $Ah[$D], $Gg)) {
                preg_match_all('/("[^"]*+")+( DESC)?/', $Gg[2], $Ce);
                foreach ($Ce[2] as $z => $X) {
                    if ($X) $w["descs"][$z] = '1';
                }
            }
            if (!$I[""] || $w["type"] != "UNIQUE" || $w["columns"] != $I[""]["columns"] || $w["descs"] != $I[""]["descs"] || !preg_match("~^sqlite_~", $D)) $I[$D] = $w;
        }
        return $I;
    }

    function
    foreign_keys($Q)
    {
        $I = array();
        foreach (get_rows("PRAGMA foreign_key_list(" . table($Q) . ")") as $J) {
            $r =& $I[$J["id"]];
            if (!$r) $r = $J;
            $r["source"][] = $J["from"];
            $r["target"][] = $J["to"];
        }
        return $I;
    }

    function
    view($D)
    {
        global $g;
        return
            array("select" => preg_replace('~^(?:[^`"[]+|`[^`]*`|"[^"]*")* AS\s+~iU', '', $g->result("SELECT sql FROM sqlite_master WHERE name = " . q($D))));
    }

    function
    collations()
    {
        return (isset($_GET["create"]) ? get_vals("PRAGMA collation_list", 1) : array());
    }

    function
    information_schema($l)
    {
        return
            false;
    }

    function
    error()
    {
        global $g;
        return
            h($g->error);
    }

    function
    check_sqlite_name($D)
    {
        global $g;
        $Oc = "db|sdb|sqlite";
        if (!preg_match("~^[^\\0]*\\.($Oc)\$~", $D)) {
            $g->error = sprintf('Please use one of the extensions %s.', str_replace("|", ", ", $Oc));
            return
                false;
        }
        return
            true;
    }

    function
    create_database($l, $d)
    {
        global $g;
        if (file_exists($l)) {
            $g->error = 'File exists.';
            return
                false;
        }
        if (!check_sqlite_name($l)) return
            false;
        try {
            $A = new
            Min_SQLite($l);
        } catch (Exception$Fc) {
            $g->error = $Fc->getMessage();
            return
                false;
        }
        $A->query('PRAGMA encoding = "UTF-8"');
        $A->query('CREATE TABLE adminer (i)');
        $A->query('DROP TABLE adminer');
        return
            true;
    }

    function
    drop_databases($k)
    {
        global $g;
        $g->__construct(":memory:");
        foreach ($k
                 as $l) {
            if (!@unlink($l)) {
                $g->error = 'File exists.';
                return
                    false;
            }
        }
        return
            true;
    }

    function
    rename_database($D, $d)
    {
        global $g;
        if (!check_sqlite_name($D)) return
            false;
        $g->__construct(":memory:");
        $g->error = 'File exists.';
        return @rename(DB, $D);
    }

    function
    auto_increment()
    {
        return " PRIMARY KEY" . (DRIVER == "sqlite" ? " AUTOINCREMENT" : "");
    }

    function
    alter_table($Q, $D, $p, $fd, $rb, $yc, $d, $Ka, $Tf)
    {
        global $g;
        $Mi = ($Q == "" || $fd);
        foreach ($p
                 as $o) {
            if ($o[0] != "" || !$o[1] || $o[2]) {
                $Mi = true;
                break;
            }
        }
        $c = array();
        $Hf = array();
        foreach ($p
                 as $o) {
            if ($o[1]) {
                $c[] = ($Mi ? $o[1] : "ADD " . implode($o[1]));
                if ($o[0] != "") $Hf[$o[0]] = $o[1][0];
            }
        }
        if (!$Mi) {
            foreach ($c
                     as $X) {
                if (!queries("ALTER TABLE " . table($Q) . " $X")) return
                    false;
            }
            if ($Q != $D && !queries("ALTER TABLE " . table($Q) . " RENAME TO " . table($D))) return
                false;
        } elseif (!recreate_table($Q, $D, $c, $Hf, $fd, $Ka)) return
            false;
        if ($Ka) {
            queries("BEGIN");
            queries("UPDATE sqlite_sequence SET seq = $Ka WHERE name = " . q($D));
            if (!$g->affected_rows) queries("INSERT INTO sqlite_sequence (name, seq) VALUES (" . q($D) . ", $Ka)");
            queries("COMMIT");
        }
        return
            true;
    }

    function
    recreate_table($Q, $D, $p, $Hf, $fd, $Ka, $x = array())
    {
        global $g;
        if ($Q != "") {
            if (!$p) {
                foreach (fields($Q) as $z => $o) {
                    if ($x) $o["auto_increment"] = 0;
                    $p[] = process_field($o, $o);
                    $Hf[$z] = idf_escape($z);
                }
            }
            $lg = false;
            foreach ($p
                     as $o) {
                if ($o[6]) $lg = true;
            }
            $lc = array();
            foreach ($x
                     as $z => $X) {
                if ($X[2] == "DROP") {
                    $lc[$X[1]] = true;
                    unset($x[$z]);
                }
            }
            foreach (indexes($Q) as $ge => $w) {
                $f = array();
                foreach ($w["columns"] as $z => $e) {
                    if (!$Hf[$e]) continue
                    2;
                    $f[] = $Hf[$e] . ($w["descs"][$z] ? " DESC" : "");
                }
                if (!$lc[$ge]) {
                    if ($w["type"] != "PRIMARY" || !$lg) $x[] = array($w["type"], $ge, $f);
                }
            }
            foreach ($x
                     as $z => $X) {
                if ($X[0] == "PRIMARY") {
                    unset($x[$z]);
                    $fd[] = "  PRIMARY KEY (" . implode(", ", $X[2]) . ")";
                }
            }
            foreach (foreign_keys($Q) as $ge => $r) {
                foreach ($r["source"] as $z => $e) {
                    if (!$Hf[$e]) continue
                    2;
                    $r["source"][$z] = idf_unescape($Hf[$e]);
                }
                if (!isset($fd[" $ge"])) $fd[] = " " . format_foreign_key($r);
            }
            queries("BEGIN");
        }
        foreach ($p
                 as $z => $o) $p[$z] = "  " . implode($o);
        $p = array_merge($p, array_filter($fd));
        $Yh = ($Q == $D ? "adminer_$D" : $D);
        if (!queries("CREATE TABLE " . table($Yh) . " (\n" . implode(",\n", $p) . "\n)")) return
            false;
        if ($Q != "") {
            if ($Hf && !queries("INSERT INTO " . table($Yh) . " (" . implode(", ", $Hf) . ") SELECT " . implode(", ", array_map('idf_escape', array_keys($Hf))) . " FROM " . table($Q))) return
                false;
            $zi = array();
            foreach (triggers($Q) as $xi => $fi) {
                $wi = trigger($xi);
                $zi[] = "CREATE TRIGGER " . idf_escape($xi) . " " . implode(" ", $fi) . " ON " . table($D) . "\n$wi[Statement]";
            }
            $Ka = $Ka ? 0 : $g->result("SELECT seq FROM sqlite_sequence WHERE name = " . q($Q));
            if (!queries("DROP TABLE " . table($Q)) || ($Q == $D && !queries("ALTER TABLE " . table($Yh) . " RENAME TO " . table($D))) || !alter_indexes($D, $x)) return
                false;
            if ($Ka) queries("UPDATE sqlite_sequence SET seq = $Ka WHERE name = " . q($D));
            foreach ($zi
                     as $wi) {
                if (!queries($wi)) return
                    false;
            }
            queries("COMMIT");
        }
        return
            true;
    }

    function
    index_sql($Q, $T, $D, $f)
    {
        return "CREATE $T " . ($T != "INDEX" ? "INDEX " : "") . idf_escape($D != "" ? $D : uniqid($Q . "_")) . " ON " . table($Q) . " $f";
    }

    function
    alter_indexes($Q, $c)
    {
        foreach ($c
                 as $kg) {
            if ($kg[0] == "PRIMARY") return
                recreate_table($Q, $Q, array(), array(), array(), 0, $c);
        }
        foreach (array_reverse($c) as $X) {
            if (!queries($X[2] == "DROP" ? "DROP INDEX " . idf_escape($X[1]) : index_sql($Q, $X[0], $X[1], "(" . implode(", ", $X[2]) . ")"))) return
                false;
        }
        return
            true;
    }

    function
    truncate_tables($S)
    {
        return
            apply_queries("DELETE FROM", $S);
    }

    function
    drop_views($Yi)
    {
        return
            apply_queries("DROP VIEW", $Yi);
    }

    function
    drop_tables($S)
    {
        return
            apply_queries("DROP TABLE", $S);
    }

    function
    move_tables($S, $Yi, $Wh)
    {
        return
            false;
    }

    function
    trigger($D)
    {
        global $g;
        if ($D == "") return
            array("Statement" => "BEGIN\n\t;\nEND");
        $v = '(?:[^`"\s]+|`[^`]*`|"[^"]*")+';
        $yi = trigger_options();
        preg_match("~^CREATE\\s+TRIGGER\\s*$v\\s*(" . implode("|", $yi["Timing"]) . ")\\s+([a-z]+)(?:\\s+OF\\s+($v))?\\s+ON\\s*$v\\s*(?:FOR\\s+EACH\\s+ROW\\s)?(.*)~is", $g->result("SELECT sql FROM sqlite_master WHERE type = 'trigger' AND name = " . q($D)), $C);
        $gf = $C[3];
        return
            array("Timing" => strtoupper($C[1]), "Event" => strtoupper($C[2]) . ($gf ? " OF" : ""), "Of" => idf_unescape($gf), "Trigger" => $D, "Statement" => $C[4],);
    }

    function
    triggers($Q)
    {
        $I = array();
        $yi = trigger_options();
        foreach (get_rows("SELECT * FROM sqlite_master WHERE type = 'trigger' AND tbl_name = " . q($Q)) as $J) {
            preg_match('~^CREATE\s+TRIGGER\s*(?:[^`"\s]+|`[^`]*`|"[^"]*")+\s*(' . implode("|", $yi["Timing"]) . ')\s*(.*?)\s+ON\b~i', $J["sql"], $C);
            $I[$J["name"]] = array($C[1], $C[2]);
        }
        return $I;
    }

    function
    trigger_options()
    {
        return
            array("Timing" => array("BEFORE", "AFTER", "INSTEAD OF"), "Event" => array("INSERT", "UPDATE", "UPDATE OF", "DELETE"), "Type" => array("FOR EACH ROW"),);
    }

    function
    begin()
    {
        return
            queries("BEGIN");
    }

    function
    last_id()
    {
        global $g;
        return $g->result("SELECT LAST_INSERT_ROWID()");
    }

    function
    explain($g, $G)
    {
        return $g->query("EXPLAIN QUERY PLAN $G");
    }

    function
    found_rows($R, $Z)
    {
    }

    function
    types()
    {
        return
            array();
    }

    function
    schemas()
    {
        return
            array();
    }

    function
    get_schema()
    {
        return "";
    }

    function
    set_schema($ah)
    {
        return
            true;
    }

    function
    create_sql($Q, $Ka, $Hh)
    {
        global $g;
        $I = $g->result("SELECT sql FROM sqlite_master WHERE type IN ('table', 'view') AND name = " . q($Q));
        foreach (indexes($Q) as $D => $w) {
            if ($D == '') continue;
            $I .= ";\n\n" . index_sql($Q, $w['type'], $D, "(" . implode(", ", array_map('idf_escape', $w['columns'])) . ")");
        }
        return $I;
    }

    function
    truncate_sql($Q)
    {
        return "DELETE FROM " . table($Q);
    }

    function
    use_sql($j)
    {
    }

    function
    trigger_sql($Q)
    {
        return
            implode(get_vals("SELECT sql || ';;\n' FROM sqlite_master WHERE type = 'trigger' AND tbl_name = " . q($Q)));
    }

    function
    show_variables()
    {
        global $g;
        $I = array();
        foreach (array("auto_vacuum", "cache_size", "count_changes", "default_cache_size", "empty_result_callbacks", "encoding", "foreign_keys", "full_column_names", "fullfsync", "journal_mode", "journal_size_limit", "legacy_file_format", "locking_mode", "page_size", "max_page_count", "read_uncommitted", "recursive_triggers", "reverse_unordered_selects", "secure_delete", "short_column_names", "synchronous", "temp_store", "temp_store_directory", "schema_version", "integrity_check", "quick_check") as $z) $I[$z] = $g->result("PRAGMA $z");
        return $I;
    }

    function
    show_status()
    {
        $I = array();
        foreach (get_vals("PRAGMA compile_options") as $wf) {
            list($z, $X) = explode("=", $wf, 2);
            $I[$z] = $X;
        }
        return $I;
    }

    function
    convert_field($o)
    {
    }

    function
    unconvert_field($o, $I)
    {
        return $I;
    }

    function
    support($Tc)
    {
        return
            preg_match('~^(columns|database|drop_col|dump|indexes|descidx|move_col|sql|status|table|trigger|variables|view|view_trigger)$~', $Tc);
    }

    function
    driver_config()
    {
        $U = array("integer" => 0, "real" => 0, "numeric" => 0, "text" => 0, "blob" => 0);
        return
            array('possible_drivers' => array((isset($_GET["sqlite"]) ? "SQLite3" : "SQLite"), "PDO_SQLite"), 'jush' => "sqlite", 'types' => $U, 'structured_types' => array_keys($U), 'unsigned' => array(), 'operators' => array("=", "<", ">", "<=", ">=", "!=", "LIKE", "LIKE %%", "IN", "IS NULL", "NOT LIKE", "NOT IN", "IS NOT NULL", "SQL"), 'functions' => array("hex", "length", "lower", "round", "unixepoch", "upper"), 'grouping' => array("avg", "count", "count distinct", "group_concat", "max", "min", "sum"), 'edit_functions' => array(array(), array("integer|real|numeric" => "+/-", "text" => "||",)),);
    }
}
$ic["pgsql"] = "PostgreSQL";
if (isset($_GET["pgsql"])) {
    define("DRIVER", "pgsql");
    if (extension_loaded("pgsql")) {
        class
        Min_DB
        {
            var $extension = "PgSQL", $_link, $_result, $_string, $_database = true, $server_info, $affected_rows, $error, $timeout;

            function
            _error($Ac, $n)
            {
                if (ini_bool("html_errors")) $n = html_entity_decode(strip_tags($n));
                $n = preg_replace('~^[^:]*: ~', '', $n);
                $this->error = $n;
            }

            function
            connect($M, $V, $F)
            {
                global $b;
                $l = $b->database();
                set_error_handler(array($this, '_error'));
                $this->_string = "host='" . str_replace(":", "' port='", addcslashes($M, "'\\")) . "' user='" . addcslashes($V, "'\\") . "' password='" . addcslashes($F, "'\\") . "'";
                $this->_link = @pg_connect("$this->_string dbname='" . ($l != "" ? addcslashes($l, "'\\") : "postgres") . "'", PGSQL_CONNECT_FORCE_NEW);
                if (!$this->_link && $l != "") {
                    $this->_database = false;
                    $this->_link = @pg_connect("$this->_string dbname='postgres'", PGSQL_CONNECT_FORCE_NEW);
                }
                restore_error_handler();
                if ($this->_link) {
                    $Wi = pg_version($this->_link);
                    $this->server_info = $Wi["server"];
                    pg_set_client_encoding($this->_link, "UTF8");
                }
                return (bool)$this->_link;
            }

            function
            quote($P)
            {
                return "'" . pg_escape_string($this->_link, $P) . "'";
            }

            function
            value($X, $o)
            {
                return ($o["type"] == "bytea" && $X !== null ? pg_unescape_bytea($X) : $X);
            }

            function
            quoteBinary($P)
            {
                return "'" . pg_escape_bytea($this->_link, $P) . "'";
            }

            function
            select_db($j)
            {
                global $b;
                if ($j == $b->database()) return $this->_database;
                $I = @pg_connect("$this->_string dbname='" . addcslashes($j, "'\\") . "'", PGSQL_CONNECT_FORCE_NEW);
                if ($I) $this->_link = $I;
                return $I;
            }

            function
            close()
            {
                $this->_link = @pg_connect("$this->_string dbname='postgres'");
            }

            function
            query($G, $Bi = false)
            {
                $H = @pg_query($this->_link, $G);
                $this->error = "";
                if (!$H) {
                    $this->error = pg_last_error($this->_link);
                    $I = false;
                } elseif (!pg_num_fields($H)) {
                    $this->affected_rows = pg_affected_rows($H);
                    $I = true;
                } else$I = new
                Min_Result($H);
                if ($this->timeout) {
                    $this->timeout = 0;
                    $this->query("RESET statement_timeout");
                }
                return $I;
            }

            function
            multi_query($G)
            {
                return $this->_result = $this->query($G);
            }

            function
            store_result()
            {
                return $this->_result;
            }

            function
            next_result()
            {
                return
                    false;
            }

            function
            result($G, $o = 0)
            {
                $H = $this->query($G);
                if (!$H || !$H->num_rows) return
                    false;
                return
                    pg_fetch_result($H->_result, 0, $o);
            }

            function
            warnings()
            {
                return
                    h(pg_last_notice($this->_link));
            }
        }

        class
        Min_Result
        {
            var $_result, $_offset = 0, $num_rows;

            function
            __construct($H)
            {
                $this->_result = $H;
                $this->num_rows = pg_num_rows($H);
            }

            function
            fetch_assoc()
            {
                return
                    pg_fetch_assoc($this->_result);
            }

            function
            fetch_row()
            {
                return
                    pg_fetch_row($this->_result);
            }

            function
            fetch_field()
            {
                $e = $this->_offset++;
                $I = new
                stdClass;
                if (function_exists('pg_field_table')) $I->orgtable = pg_field_table($this->_result, $e);
                $I->name = pg_field_name($this->_result, $e);
                $I->orgname = $I->name;
                $I->type = pg_field_type($this->_result, $e);
                $I->charsetnr = ($I->type == "bytea" ? 63 : 0);
                return $I;
            }

            function
            __destruct()
            {
                pg_free_result($this->_result);
            }
        }
    } elseif (extension_loaded("pdo_pgsql")) {
        class
        Min_DB
            extends
            Min_PDO
        {
            var $extension = "PDO_PgSQL", $timeout;

            function
            connect($M, $V, $F)
            {
                global $b;
                $l = $b->database();
                $this->dsn("pgsql:host='" . str_replace(":", "' port='", addcslashes($M, "'\\")) . "' client_encoding=utf8 dbname='" . ($l != "" ? addcslashes($l, "'\\") : "postgres") . "'", $V, $F);
                return
                    true;
            }

            function
            select_db($j)
            {
                global $b;
                return ($b->database() == $j);
            }

            function
            quoteBinary($Xg)
            {
                return
                    q($Xg);
            }

            function
            query($G, $Bi = false)
            {
                $I = parent::query($G, $Bi);
                if ($this->timeout) {
                    $this->timeout = 0;
                    parent::query("RESET statement_timeout");
                }
                return $I;
            }

            function
            warnings()
            {
                return '';
            }

            function
            close()
            {
            }
        }
    }

    class
    Min_Driver
        extends
        Min_SQL
    {
        function
        insertUpdate($Q, $K, $kg)
        {
            global $g;
            foreach ($K
                     as $N) {
                $Ii = array();
                $Z = array();
                foreach ($N
                         as $z => $X) {
                    $Ii[] = "$z = $X";
                    if (isset($kg[idf_unescape($z)])) $Z[] = "$z = $X";
                }
                if (!(($Z && queries("UPDATE " . table($Q) . " SET " . implode(", ", $Ii) . " WHERE " . implode(" AND ", $Z)) && $g->affected_rows) || queries("INSERT INTO " . table($Q) . " (" . implode(", ", array_keys($N)) . ") VALUES (" . implode(", ", $N) . ")"))) return
                    false;
            }
            return
                true;
        }

        function
        slowQuery($G, $ei)
        {
            $this->_conn->query("SET statement_timeout = " . (1000 * $ei));
            $this->_conn->timeout = 1000 * $ei;
            return $G;
        }

        function
        convertSearch($v, $X, $o)
        {
            return (preg_match('~char|text' . (!preg_match('~LIKE~', $X["op"]) ? '|date|time(stamp)?|boolean|uuid|' . number_type() : '') . '~', $o["type"]) ? $v : "CAST($v AS text)");
        }

        function
        quoteBinary($Xg)
        {
            return $this->_conn->quoteBinary($Xg);
        }

        function
        warnings()
        {
            return $this->_conn->warnings();
        }

        function
        tableHelp($D)
        {
            $we = array("information_schema" => "infoschema", "pg_catalog" => "catalog",);
            $A = $we[$_GET["ns"]];
            if ($A) return "$A-" . str_replace("_", "-", $D) . ".html";
        }
    }

    function
    idf_escape($v)
    {
        return '"' . str_replace('"', '""', $v) . '"';
    }

    function
    table($v)
    {
        return
            idf_escape($v);
    }

    function
    connect()
    {
        global $b, $U, $Gh;
        $g = new
        Min_DB;
        $Kb = $b->credentials();
        if ($g->connect($Kb[0], $Kb[1], $Kb[2])) {
            if (min_version(9, 0, $g)) {
                $g->query("SET application_name = 'Adminer'");
                if (min_version(9.2, 0, $g)) {
                    $Gh['Strings'][] = "json";
                    $U["json"] = 4294967295;
                    if (min_version(9.4, 0, $g)) {
                        $Gh['Strings'][] = "jsonb";
                        $U["jsonb"] = 4294967295;
                    }
                }
            }
            return $g;
        }
        return $g->error;
    }

    function
    get_databases()
    {
        return
            get_vals("SELECT datname FROM pg_database WHERE has_database_privilege(datname, 'CONNECT') ORDER BY datname");
    }

    function
    limit($G, $Z, $_, $hf = 0, $hh = " ")
    {
        return " $G$Z" . ($_ !== null ? $hh . "LIMIT $_" . ($hf ? " OFFSET $hf" : "") : "");
    }

    function
    limit1($Q, $G, $Z, $hh = "\n")
    {
        return (preg_match('~^INTO~', $G) ? limit($G, $Z, 1, 0, $hh) : " $G" . (is_view(table_status1($Q)) ? $Z : " WHERE ctid = (SELECT ctid FROM " . table($Q) . $Z . $hh . "LIMIT 1)"));
    }

    function
    db_collation($l, $lb)
    {
        global $g;
        return $g->result("SELECT datcollate FROM pg_database WHERE datname = " . q($l));
    }

    function
    engines()
    {
        return
            array();
    }

    function
    logged_user()
    {
        global $g;
        return $g->result("SELECT user");
    }

    function
    tables_list()
    {
        $G = "SELECT table_name, table_type FROM information_schema.tables WHERE table_schema = current_schema()";
        if (support('materializedview')) $G .= "
UNION ALL
SELECT matviewname, 'MATERIALIZED VIEW'
FROM pg_matviews
WHERE schemaname = current_schema()";
        $G .= "
ORDER BY 1";
        return
            get_key_vals($G);
    }

    function
    count_tables($k)
    {
        return
            array();
    }

    function
    table_status($D = "")
    {
        $I = array();
        foreach (get_rows("SELECT c.relname AS \"Name\", CASE c.relkind WHEN 'r' THEN 'table' WHEN 'm' THEN 'materialized view' ELSE 'view' END AS \"Engine\", pg_relation_size(c.oid) AS \"Data_length\", pg_total_relation_size(c.oid) - pg_relation_size(c.oid) AS \"Index_length\", obj_description(c.oid, 'pg_class') AS \"Comment\", " . (min_version(12) ? "''" : "CASE WHEN c.relhasoids THEN 'oid' ELSE '' END") . " AS \"Oid\", c.reltuples as \"Rows\", n.nspname
FROM pg_class c
JOIN pg_namespace n ON(n.nspname = current_schema() AND n.oid = c.relnamespace)
WHERE relkind IN ('r', 'm', 'v', 'f', 'p')
" . ($D != "" ? "AND relname = " . q($D) : "ORDER BY relname")) as $J) $I[$J["Name"]] = $J;
        return ($D != "" ? $I[$D] : $I);
    }

    function
    is_view($R)
    {
        return
            in_array($R["Engine"], array("view", "materialized view"));
    }

    function
    fk_support($R)
    {
        return
            true;
    }

    function
    fields($Q)
    {
        $I = array();
        $Ba = array('timestamp without time zone' => 'timestamp', 'timestamp with time zone' => 'timestamptz',);
        foreach (get_rows("SELECT a.attname AS field, format_type(a.atttypid, a.atttypmod) AS full_type, pg_get_expr(d.adbin, d.adrelid) AS default, a.attnotnull::int, col_description(c.oid, a.attnum) AS comment" . (min_version(10) ? ", a.attidentity" : "") . "
FROM pg_class c
JOIN pg_namespace n ON c.relnamespace = n.oid
JOIN pg_attribute a ON c.oid = a.attrelid
LEFT JOIN pg_attrdef d ON c.oid = d.adrelid AND a.attnum = d.adnum
WHERE c.relname = " . q($Q) . "
AND n.nspname = current_schema()
AND NOT a.attisdropped
AND a.attnum > 0
ORDER BY a.attnum") as $J) {
            preg_match('~([^([]+)(\((.*)\))?([a-z ]+)?((\[[0-9]*])*)$~', $J["full_type"], $C);
            list(, $T, $te, $J["length"], $wa, $Ea) = $C;
            $J["length"] .= $Ea;
            $bb = $T . $wa;
            if (isset($Ba[$bb])) {
                $J["type"] = $Ba[$bb];
                $J["full_type"] = $J["type"] . $te . $Ea;
            } else {
                $J["type"] = $T;
                $J["full_type"] = $J["type"] . $te . $wa . $Ea;
            }
            if (in_array($J['attidentity'], array('a', 'd'))) $J['default'] = 'GENERATED ' . ($J['attidentity'] == 'd' ? 'BY DEFAULT' : 'ALWAYS') . ' AS IDENTITY';
            $J["null"] = !$J["attnotnull"];
            $J["auto_increment"] = $J['attidentity'] || preg_match('~^nextval\(~i', $J["default"]);
            $J["privileges"] = array("insert" => 1, "select" => 1, "update" => 1);
            if (preg_match('~(.+)::[^,)]+(.*)~', $J["default"], $C)) $J["default"] = ($C[1] == "NULL" ? null : idf_unescape($C[1]) . $C[2]);
            $I[$J["field"]] = $J;
        }
        return $I;
    }

    function
    indexes($Q, $h = null)
    {
        global $g;
        if (!is_object($h)) $h = $g;
        $I = array();
        $Ph = $h->result("SELECT oid FROM pg_class WHERE relnamespace = (SELECT oid FROM pg_namespace WHERE nspname = current_schema()) AND relname = " . q($Q));
        $f = get_key_vals("SELECT attnum, attname FROM pg_attribute WHERE attrelid = $Ph AND attnum > 0", $h);
        foreach (get_rows("SELECT relname, indisunique::int, indisprimary::int, indkey, indoption, (indpred IS NOT NULL)::int as indispartial FROM pg_index i, pg_class ci WHERE i.indrelid = $Ph AND ci.oid = i.indexrelid", $h) as $J) {
            $Hg = $J["relname"];
            $I[$Hg]["type"] = ($J["indispartial"] ? "INDEX" : ($J["indisprimary"] ? "PRIMARY" : ($J["indisunique"] ? "UNIQUE" : "INDEX")));
            $I[$Hg]["columns"] = array();
            foreach (explode(" ", $J["indkey"]) as $Pd) $I[$Hg]["columns"][] = $f[$Pd];
            $I[$Hg]["descs"] = array();
            foreach (explode(" ", $J["indoption"]) as $Qd) $I[$Hg]["descs"][] = ($Qd & 1 ? '1' : null);
            $I[$Hg]["lengths"] = array();
        }
        return $I;
    }

    function
    foreign_keys($Q)
    {
        global $pf;
        $I = array();
        foreach (get_rows("SELECT conname, condeferrable::int AS deferrable, pg_get_constraintdef(oid) AS definition
FROM pg_constraint
WHERE conrelid = (SELECT pc.oid FROM pg_class AS pc INNER JOIN pg_namespace AS pn ON (pn.oid = pc.relnamespace) WHERE pc.relname = " . q($Q) . " AND pn.nspname = current_schema())
AND contype = 'f'::char
ORDER BY conkey, conname") as $J) {
            if (preg_match('~FOREIGN KEY\s*\((.+)\)\s*REFERENCES (.+)\((.+)\)(.*)$~iA', $J['definition'], $C)) {
                $J['source'] = array_map('idf_unescape', array_map('trim', explode(',', $C[1])));
                if (preg_match('~^(("([^"]|"")+"|[^"]+)\.)?"?("([^"]|"")+"|[^"]+)$~', $C[2], $Be)) {
                    $J['ns'] = idf_unescape($Be[2]);
                    $J['table'] = idf_unescape($Be[4]);
                }
                $J['target'] = array_map('idf_unescape', array_map('trim', explode(',', $C[3])));
                $J['on_delete'] = (preg_match("~ON DELETE ($pf)~", $C[4], $Be) ? $Be[1] : 'NO ACTION');
                $J['on_update'] = (preg_match("~ON UPDATE ($pf)~", $C[4], $Be) ? $Be[1] : 'NO ACTION');
                $I[$J['conname']] = $J;
            }
        }
        return $I;
    }

    function
    constraints($Q)
    {
        global $pf;
        $I = array();
        foreach (get_rows("SELECT conname, consrc
FROM pg_catalog.pg_constraint
INNER JOIN pg_catalog.pg_namespace ON pg_constraint.connamespace = pg_namespace.oid
INNER JOIN pg_catalog.pg_class ON pg_constraint.conrelid = pg_class.oid AND pg_constraint.connamespace = pg_class.relnamespace
WHERE pg_constraint.contype = 'c'
AND conrelid != 0 -- handle only CONSTRAINTs here, not TYPES
AND nspname = current_schema()
AND relname = " . q($Q) . "
ORDER BY connamespace, conname") as $J) $I[$J['conname']] = $J['consrc'];
        return $I;
    }

    function
    view($D)
    {
        global $g;
        return
            array("select" => trim($g->result("SELECT pg_get_viewdef(" . $g->result("SELECT oid FROM pg_class WHERE relnamespace = (SELECT oid FROM pg_namespace WHERE nspname = current_schema()) AND relname = " . q($D)) . ")")));
    }

    function
    collations()
    {
        return
            array();
    }

    function
    information_schema($l)
    {
        return ($l == "information_schema");
    }

    function
    error()
    {
        global $g;
        $I = h($g->error);
        if (preg_match('~^(.*\n)?([^\n]*)\n( *)\^(\n.*)?$~s', $I, $C)) $I = $C[1] . preg_replace('~((?:[^&]|&[^;]*;){' . strlen($C[3]) . '})(.*)~', '\1<b>\2</b>', $C[2]) . $C[4];
        return
            nl_br($I);
    }

    function
    create_database($l, $d)
    {
        return
            queries("CREATE DATABASE " . idf_escape($l) . ($d ? " ENCODING " . idf_escape($d) : ""));
    }

    function
    drop_databases($k)
    {
        global $g;
        $g->close();
        return
            apply_queries("DROP DATABASE", $k, 'idf_escape');
    }

    function
    rename_database($D, $d)
    {
        return
            queries("ALTER DATABASE " . idf_escape(DB) . " RENAME TO " . idf_escape($D));
    }

    function
    auto_increment()
    {
        return "";
    }

    function
    alter_table($Q, $D, $p, $fd, $rb, $yc, $d, $Ka, $Tf)
    {
        $c = array();
        $vg = array();
        if ($Q != "" && $Q != $D) $vg[] = "ALTER TABLE " . table($Q) . " RENAME TO " . table($D);
        foreach ($p
                 as $o) {
            $e = idf_escape($o[0]);
            $X = $o[1];
            if (!$X) $c[] = "DROP $e"; else {
                $Si = $X[5];
                unset($X[5]);
                if ($o[0] == "") {
                    if (isset($X[6])) $X[1] = ($X[1] == " bigint" ? " big" : ($X[1] == " smallint" ? " small" : " ")) . "serial";
                    $c[] = ($Q != "" ? "ADD " : "  ") . implode($X);
                    if (isset($X[6])) $c[] = ($Q != "" ? "ADD" : " ") . " PRIMARY KEY ($X[0])";
                } else {
                    if ($e != $X[0]) $vg[] = "ALTER TABLE " . table($D) . " RENAME $e TO $X[0]";
                    $c[] = "ALTER $e TYPE$X[1]";
                    if (!$X[6]) {
                        $c[] = "ALTER $e " . ($X[3] ? "SET$X[3]" : "DROP DEFAULT");
                        $c[] = "ALTER $e " . ($X[2] == " NULL" ? "DROP NOT" : "SET") . $X[2];
                    }
                }
                if ($o[0] != "" || $Si != "") $vg[] = "COMMENT ON COLUMN " . table($D) . ".$X[0] IS " . ($Si != "" ? substr($Si, 9) : "''");
            }
        }
        $c = array_merge($c, $fd);
        if ($Q == "") array_unshift($vg, "CREATE TABLE " . table($D) . " (\n" . implode(",\n", $c) . "\n)"); elseif ($c) array_unshift($vg, "ALTER TABLE " . table($Q) . "\n" . implode(",\n", $c));
        if ($Q != "" || $rb != "") $vg[] = "COMMENT ON TABLE " . table($D) . " IS " . q($rb);
        if ($Ka != "") {
        }
        foreach ($vg
                 as $G) {
            if (!queries($G)) return
                false;
        }
        return
            true;
    }

    function
    alter_indexes($Q, $c)
    {
        $i = array();
        $jc = array();
        $vg = array();
        foreach ($c
                 as $X) {
            if ($X[0] != "INDEX") $i[] = ($X[2] == "DROP" ? "\nDROP CONSTRAINT " . idf_escape($X[1]) : "\nADD" . ($X[1] != "" ? " CONSTRAINT " . idf_escape($X[1]) : "") . " $X[0] " . ($X[0] == "PRIMARY" ? "KEY " : "") . "(" . implode(", ", $X[2]) . ")"); elseif ($X[2] == "DROP") $jc[] = idf_escape($X[1]);
            else$vg[] = "CREATE INDEX " . idf_escape($X[1] != "" ? $X[1] : uniqid($Q . "_")) . " ON " . table($Q) . " (" . implode(", ", $X[2]) . ")";
        }
        if ($i) array_unshift($vg, "ALTER TABLE " . table($Q) . implode(",", $i));
        if ($jc) array_unshift($vg, "DROP INDEX " . implode(", ", $jc));
        foreach ($vg
                 as $G) {
            if (!queries($G)) return
                false;
        }
        return
            true;
    }

    function
    truncate_tables($S)
    {
        return
            queries("TRUNCATE " . implode(", ", array_map('table', $S)));
        return
            true;
    }

    function
    drop_views($Yi)
    {
        return
            drop_tables($Yi);
    }

    function
    drop_tables($S)
    {
        foreach ($S
                 as $Q) {
            $O = table_status($Q);
            if (!queries("DROP " . strtoupper($O["Engine"]) . " " . table($Q))) return
                false;
        }
        return
            true;
    }

    function
    move_tables($S, $Yi, $Wh)
    {
        foreach (array_merge($S, $Yi) as $Q) {
            $O = table_status($Q);
            if (!queries("ALTER " . strtoupper($O["Engine"]) . " " . table($Q) . " SET SCHEMA " . idf_escape($Wh))) return
                false;
        }
        return
            true;
    }

    function
    trigger($D, $Q)
    {
        if ($D == "") return
            array("Statement" => "EXECUTE PROCEDURE ()");
        $f = array();
        $Z = "WHERE trigger_schema = current_schema() AND event_object_table = " . q($Q) . " AND trigger_name = " . q($D);
        foreach (get_rows("SELECT * FROM information_schema.triggered_update_columns $Z") as $J) $f[] = $J["event_object_column"];
        $I = array();
        foreach (get_rows('SELECT trigger_name AS "Trigger", action_timing AS "Timing", event_manipulation AS "Event", \'FOR EACH \' || action_orientation AS "Type", action_statement AS "Statement" FROM information_schema.triggers ' . "$Z ORDER BY event_manipulation DESC") as $J) {
            if ($f && $J["Event"] == "UPDATE") $J["Event"] .= " OF";
            $J["Of"] = implode(", ", $f);
            if ($I) $J["Event"] .= " OR $I[Event]";
            $I = $J;
        }
        return $I;
    }

    function
    triggers($Q)
    {
        $I = array();
        foreach (get_rows("SELECT * FROM information_schema.triggers WHERE trigger_schema = current_schema() AND event_object_table = " . q($Q)) as $J) {
            $wi = trigger($J["trigger_name"], $Q);
            $I[$wi["Trigger"]] = array($wi["Timing"], $wi["Event"]);
        }
        return $I;
    }

    function
    trigger_options()
    {
        return
            array("Timing" => array("BEFORE", "AFTER"), "Event" => array("INSERT", "UPDATE", "UPDATE OF", "DELETE", "INSERT OR UPDATE", "INSERT OR UPDATE OF", "DELETE OR INSERT", "DELETE OR UPDATE", "DELETE OR UPDATE OF", "DELETE OR INSERT OR UPDATE", "DELETE OR INSERT OR UPDATE OF"), "Type" => array("FOR EACH ROW", "FOR EACH STATEMENT"),);
    }

    function
    routine($D, $T)
    {
        $K = get_rows('SELECT routine_definition AS definition, LOWER(external_language) AS language, *
FROM information_schema.routines
WHERE routine_schema = current_schema() AND specific_name = ' . q($D));
        $I = $K[0];
        $I["returns"] = array("type" => $I["type_udt_name"]);
        $I["fields"] = get_rows('SELECT parameter_name AS field, data_type AS type, character_maximum_length AS length, parameter_mode AS inout
FROM information_schema.parameters
WHERE specific_schema = current_schema() AND specific_name = ' . q($D) . '
ORDER BY ordinal_position');
        return $I;
    }

    function
    routines()
    {
        return
            get_rows('SELECT specific_name AS "SPECIFIC_NAME", routine_type AS "ROUTINE_TYPE", routine_name AS "ROUTINE_NAME", type_udt_name AS "DTD_IDENTIFIER"
FROM information_schema.routines
WHERE routine_schema = current_schema()
ORDER BY SPECIFIC_NAME');
    }

    function
    routine_languages()
    {
        return
            get_vals("SELECT LOWER(lanname) FROM pg_catalog.pg_language");
    }

    function
    routine_id($D, $J)
    {
        $I = array();
        foreach ($J["fields"] as $o) $I[] = $o["type"];
        return
            idf_escape($D) . "(" . implode(", ", $I) . ")";
    }

    function
    last_id()
    {
        return
            0;
    }

    function
    explain($g, $G)
    {
        return $g->query("EXPLAIN $G");
    }

    function
    found_rows($R, $Z)
    {
        global $g;
        if (preg_match("~ rows=([0-9]+)~", $g->result("EXPLAIN SELECT * FROM " . idf_escape($R["Name"]) . ($Z ? " WHERE " . implode(" AND ", $Z) : "")), $Gg)) return $Gg[1];
        return
            false;
    }

    function
    types()
    {
        return
            get_vals("SELECT typname
FROM pg_type
WHERE typnamespace = (SELECT oid FROM pg_namespace WHERE nspname = current_schema())
AND typtype IN ('b','d','e')
AND typelem = 0");
    }

    function
    schemas()
    {
        return
            get_vals("SELECT nspname FROM pg_namespace ORDER BY nspname");
    }

    function
    get_schema()
    {
        global $g;
        return $g->result("SELECT current_schema()");
    }

    function
    set_schema($Zg, $h = null)
    {
        global $g, $U, $Gh;
        if (!$h) $h = $g;
        $I = $h->query("SET search_path TO " . idf_escape($Zg));
        foreach (types() as $T) {
            if (!isset($U[$T])) {
                $U[$T] = 0;
                $Gh['User types'][] = $T;
            }
        }
        return $I;
    }

    function
    foreign_keys_sql($Q)
    {
        $I = "";
        $O = table_status($Q);
        $cd = foreign_keys($Q);
        ksort($cd);
        foreach ($cd
                 as $bd => $ad) $I .= "ALTER TABLE ONLY " . idf_escape($O['nspname']) . "." . idf_escape($O['Name']) . " ADD CONSTRAINT " . idf_escape($bd) . " $ad[definition] " . ($ad['deferrable'] ? 'DEFERRABLE' : 'NOT DEFERRABLE') . ";\n";
        return ($I ? "$I\n" : $I);
    }

    function
    create_sql($Q, $Ka, $Hh)
    {
        global $g;
        $I = '';
        $Pg = array();
        $jh = array();
        $O = table_status($Q);
        if (is_view($O)) {
            $Xi = view($Q);
            return
                rtrim("CREATE VIEW " . idf_escape($Q) . " AS $Xi[select]", ";");
        }
        $p = fields($Q);
        $x = indexes($Q);
        ksort($x);
        $Ab = constraints($Q);
        if (!$O || empty($p)) return
            false;
        $I = "CREATE TABLE " . idf_escape($O['nspname']) . "." . idf_escape($O['Name']) . " (\n    ";
        foreach ($p
                 as $Vc => $o) {
            $Qf = idf_escape($o['field']) . ' ' . $o['full_type'] . default_value($o) . ($o['attnotnull'] ? " NOT NULL" : "");
            $Pg[] = $Qf;
            if (preg_match('~nextval\(\'([^\']+)\'\)~', $o['default'], $Ce)) {
                $ih = $Ce[1];
                $xh = reset(get_rows(min_version(10) ? "SELECT *, cache_size AS cache_value FROM pg_sequences WHERE schemaname = current_schema() AND sequencename = " . q($ih) : "SELECT * FROM $ih"));
                $jh[] = ($Hh == "DROP+CREATE" ? "DROP SEQUENCE IF EXISTS $ih;\n" : "") . "CREATE SEQUENCE $ih INCREMENT $xh[increment_by] MINVALUE $xh[min_value] MAXVALUE $xh[max_value]" . ($Ka && $xh['last_value'] ? " START $xh[last_value]" : "") . " CACHE $xh[cache_value];";
            }
        }
        if (!empty($jh)) $I = implode("\n\n", $jh) . "\n\n$I";
        foreach ($x
                 as $Kd => $w) {
            switch ($w['type']) {
                case'UNIQUE':
                    $Pg[] = "CONSTRAINT " . idf_escape($Kd) . " UNIQUE (" . implode(', ', array_map('idf_escape', $w['columns'])) . ")";
                    break;
                case'PRIMARY':
                    $Pg[] = "CONSTRAINT " . idf_escape($Kd) . " PRIMARY KEY (" . implode(', ', array_map('idf_escape', $w['columns'])) . ")";
                    break;
            }
        }
        foreach ($Ab
                 as $xb => $zb) $Pg[] = "CONSTRAINT " . idf_escape($xb) . " CHECK $zb";
        $I .= implode(",\n    ", $Pg) . "\n) WITH (oids = " . ($O['Oid'] ? 'true' : 'false') . ");";
        foreach ($x
                 as $Kd => $w) {
            if ($w['type'] == 'INDEX') {
                $f = array();
                foreach ($w['columns'] as $z => $X) $f[] = idf_escape($X) . ($w['descs'][$z] ? " DESC" : "");
                $I .= "\n\nCREATE INDEX " . idf_escape($Kd) . " ON " . idf_escape($O['nspname']) . "." . idf_escape($O['Name']) . " USING btree (" . implode(', ', $f) . ");";
            }
        }
        if ($O['Comment']) $I .= "\n\nCOMMENT ON TABLE " . idf_escape($O['nspname']) . "." . idf_escape($O['Name']) . " IS " . q($O['Comment']) . ";";
        foreach ($p
                 as $Vc => $o) {
            if ($o['comment']) $I .= "\n\nCOMMENT ON COLUMN " . idf_escape($O['nspname']) . "." . idf_escape($O['Name']) . "." . idf_escape($Vc) . " IS " . q($o['comment']) . ";";
        }
        return
            rtrim($I, ';');
    }

    function
    truncate_sql($Q)
    {
        return "TRUNCATE " . table($Q);
    }

    function
    trigger_sql($Q)
    {
        $O = table_status($Q);
        $I = "";
        foreach (triggers($Q) as $vi => $ui) {
            $wi = trigger($vi, $O['Name']);
            $I .= "\nCREATE TRIGGER " . idf_escape($wi['Trigger']) . " $wi[Timing] $wi[Event] ON " . idf_escape($O["nspname"]) . "." . idf_escape($O['Name']) . " $wi[Type] $wi[Statement];;\n";
        }
        return $I;
    }

    function
    use_sql($j)
    {
        return "\connect " . idf_escape($j);
    }

    function
    show_variables()
    {
        return
            get_key_vals("SHOW ALL");
    }

    function
    process_list()
    {
        return
            get_rows("SELECT * FROM pg_stat_activity ORDER BY " . (min_version(9.2) ? "pid" : "procpid"));
    }

    function
    show_status()
    {
    }

    function
    convert_field($o)
    {
    }

    function
    unconvert_field($o, $I)
    {
        return $I;
    }

    function
    support($Tc)
    {
        return
            preg_match('~^(database|table|columns|sql|indexes|descidx|comment|view|' . (min_version(9.3) ? 'materializedview|' : '') . 'scheme|routine|processlist|sequence|trigger|type|variables|drop_col|kill|dump)$~', $Tc);
    }

    function
    kill_process($X)
    {
        return
            queries("SELECT pg_terminate_backend(" . number($X) . ")");
    }

    function
    connection_id()
    {
        return "SELECT pg_backend_pid()";
    }

    function
    max_connections()
    {
        global $g;
        return $g->result("SHOW max_connections");
    }

    function
    driver_config()
    {
        $U = array();
        $Gh = array();
        foreach (array('Numbers' => array("smallint" => 5, "integer" => 10, "bigint" => 19, "boolean" => 1, "numeric" => 0, "real" => 7, "double precision" => 16, "money" => 20), 'Date and time' => array("date" => 13, "time" => 17, "timestamp" => 20, "timestamptz" => 21, "interval" => 0), 'Strings' => array("character" => 0, "character varying" => 0, "text" => 0, "tsquery" => 0, "tsvector" => 0, "uuid" => 0, "xml" => 0), 'Binary' => array("bit" => 0, "bit varying" => 0, "bytea" => 0), 'Network' => array("cidr" => 43, "inet" => 43, "macaddr" => 17, "txid_snapshot" => 0), 'Geometry' => array("box" => 0, "circle" => 0, "line" => 0, "lseg" => 0, "path" => 0, "point" => 0, "polygon" => 0),) as $z => $X) {
            $U += $X;
            $Gh[$z] = array_keys($X);
        }
        return
            array('possible_drivers' => array("PgSQL", "PDO_PgSQL"), 'jush' => "pgsql", 'types' => $U, 'structured_types' => $Gh, 'unsigned' => array(), 'operators' => array("=", "<", ">", "<=", ">=", "!=", "~", "!~", "LIKE", "LIKE %%", "ILIKE", "ILIKE %%", "IN", "IS NULL", "NOT LIKE", "NOT IN", "IS NOT NULL"), 'functions' => array("char_length", "lower", "round", "to_hex", "to_timestamp", "upper"), 'grouping' => array("avg", "count", "count distinct", "max", "min", "sum"), 'edit_functions' => array(array("char" => "md5", "date|time" => "now",), array(number_type() => "+/-", "date|time" => "+ interval/- interval", "char|text" => "||",)),);
    }
}
$ic["oracle"] = "Oracle (beta)";
if (isset($_GET["oracle"])) {
    define("DRIVER", "oracle");
    if (extension_loaded("oci8")) {
        class
        Min_DB
        {
            var $extension = "oci8", $_link, $_result, $server_info, $affected_rows, $errno, $error;
            var $_current_db;

            function
            _error($Ac, $n)
            {
                if (ini_bool("html_errors")) $n = html_entity_decode(strip_tags($n));
                $n = preg_replace('~^[^:]*: ~', '', $n);
                $this->error = $n;
            }

            function
            connect($M, $V, $F)
            {
                $this->_link = @oci_new_connect($V, $F, $M, "AL32UTF8");
                if ($this->_link) {
                    $this->server_info = oci_server_version($this->_link);
                    return
                        true;
                }
                $n = oci_error();
                $this->error = $n["message"];
                return
                    false;
            }

            function
            quote($P)
            {
                return "'" . str_replace("'", "''", $P) . "'";
            }

            function
            select_db($j)
            {
                $this->_current_db = $j;
                return
                    true;
            }

            function
            query($G, $Bi = false)
            {
                $H = oci_parse($this->_link, $G);
                $this->error = "";
                if (!$H) {
                    $n = oci_error($this->_link);
                    $this->errno = $n["code"];
                    $this->error = $n["message"];
                    return
                        false;
                }
                set_error_handler(array($this, '_error'));
                $I = @oci_execute($H);
                restore_error_handler();
                if ($I) {
                    if (oci_num_fields($H)) return
                        new
                        Min_Result($H);
                    $this->affected_rows = oci_num_rows($H);
                    oci_free_statement($H);
                }
                return $I;
            }

            function
            multi_query($G)
            {
                return $this->_result = $this->query($G);
            }

            function
            store_result()
            {
                return $this->_result;
            }

            function
            next_result()
            {
                return
                    false;
            }

            function
            result($G, $o = 1)
            {
                $H = $this->query($G);
                if (!is_object($H) || !oci_fetch($H->_result)) return
                    false;
                return
                    oci_result($H->_result, $o);
            }
        }

        class
        Min_Result
        {
            var $_result, $_offset = 1, $num_rows;

            function
            __construct($H)
            {
                $this->_result = $H;
            }

            function
            _convert($J)
            {
                foreach ((array)$J
                         as $z => $X) {
                    if (is_a($X, 'OCI-Lob')) $J[$z] = $X->load();
                }
                return $J;
            }

            function
            fetch_assoc()
            {
                return $this->_convert(oci_fetch_assoc($this->_result));
            }

            function
            fetch_row()
            {
                return $this->_convert(oci_fetch_row($this->_result));
            }

            function
            fetch_field()
            {
                $e = $this->_offset++;
                $I = new
                stdClass;
                $I->name = oci_field_name($this->_result, $e);
                $I->orgname = $I->name;
                $I->type = oci_field_type($this->_result, $e);
                $I->charsetnr = (preg_match("~raw|blob|bfile~", $I->type) ? 63 : 0);
                return $I;
            }

            function
            __destruct()
            {
                oci_free_statement($this->_result);
            }
        }
    } elseif (extension_loaded("pdo_oci")) {
        class
        Min_DB
            extends
            Min_PDO
        {
            var $extension = "PDO_OCI";
            var $_current_db;

            function
            connect($M, $V, $F)
            {
                $this->dsn("oci:dbname=//$M;charset=AL32UTF8", $V, $F);
                return
                    true;
            }

            function
            select_db($j)
            {
                $this->_current_db = $j;
                return
                    true;
            }
        }
    }

    class
    Min_Driver
        extends
        Min_SQL
    {
        function
        begin()
        {
            return
                true;
        }

        function
        insertUpdate($Q, $K, $kg)
        {
            global $g;
            foreach ($K
                     as $N) {
                $Ii = array();
                $Z = array();
                foreach ($N
                         as $z => $X) {
                    $Ii[] = "$z = $X";
                    if (isset($kg[idf_unescape($z)])) $Z[] = "$z = $X";
                }
                if (!(($Z && queries("UPDATE " . table($Q) . " SET " . implode(", ", $Ii) . " WHERE " . implode(" AND ", $Z)) && $g->affected_rows) || queries("INSERT INTO " . table($Q) . " (" . implode(", ", array_keys($N)) . ") VALUES (" . implode(", ", $N) . ")"))) return
                    false;
            }
            return
                true;
        }
    }

    function
    idf_escape($v)
    {
        return '"' . str_replace('"', '""', $v) . '"';
    }

    function
    table($v)
    {
        return
            idf_escape($v);
    }

    function
    connect()
    {
        global $b;
        $g = new
        Min_DB;
        $Kb = $b->credentials();
        if ($g->connect($Kb[0], $Kb[1], $Kb[2])) return $g;
        return $g->error;
    }

    function
    get_databases()
    {
        return
            get_vals("SELECT tablespace_name FROM user_tablespaces ORDER BY 1");
    }

    function
    limit($G, $Z, $_, $hf = 0, $hh = " ")
    {
        return ($hf ? " * FROM (SELECT t.*, rownum AS rnum FROM (SELECT $G$Z) t WHERE rownum <= " . ($_ + $hf) . ") WHERE rnum > $hf" : ($_ !== null ? " * FROM (SELECT $G$Z) WHERE rownum <= " . ($_ + $hf) : " $G$Z"));
    }

    function
    limit1($Q, $G, $Z, $hh = "\n")
    {
        return " $G$Z";
    }

    function
    db_collation($l, $lb)
    {
        global $g;
        return $g->result("SELECT value FROM nls_database_parameters WHERE parameter = 'NLS_CHARACTERSET'");
    }

    function
    engines()
    {
        return
            array();
    }

    function
    logged_user()
    {
        global $g;
        return $g->result("SELECT USER FROM DUAL");
    }

    function
    get_current_db()
    {
        global $g;
        $l = $g->_current_db ? $g->_current_db : DB;
        unset($g->_current_db);
        return $l;
    }

    function
    where_owner($ig, $Kf = "owner")
    {
        if (!$_GET["ns"]) return '';
        return "$ig$Kf = sys_context('USERENV', 'CURRENT_SCHEMA')";
    }

    function
    views_table($f)
    {
        $Kf = where_owner('');
        return "(SELECT $f FROM all_views WHERE " . ($Kf ? $Kf : "rownum < 0") . ")";
    }

    function
    tables_list()
    {
        $Xi = views_table("view_name");
        $Kf = where_owner(" AND ");
        return
            get_key_vals("SELECT table_name, 'table' FROM all_tables WHERE tablespace_name = " . q(DB) . "$Kf
UNION SELECT view_name, 'view' FROM $Xi
ORDER BY 1");
    }

    function
    count_tables($k)
    {
        global $g;
        $I = array();
        foreach ($k
                 as $l) $I[$l] = $g->result("SELECT COUNT(*) FROM all_tables WHERE tablespace_name = " . q($l));
        return $I;
    }

    function
    table_status($D = "")
    {
        $I = array();
        $bh = q($D);
        $l = get_current_db();
        $Xi = views_table("view_name");
        $Kf = where_owner(" AND ");
        foreach (get_rows('SELECT table_name "Name", \'table\' "Engine", avg_row_len * num_rows "Data_length", num_rows "Rows" FROM all_tables WHERE tablespace_name = ' . q($l) . $Kf . ($D != "" ? " AND table_name = $bh" : "") . "
UNION SELECT view_name, 'view', 0, 0 FROM $Xi" . ($D != "" ? " WHERE view_name = $bh" : "") . "
ORDER BY 1") as $J) {
            if ($D != "") return $J;
            $I[$J["Name"]] = $J;
        }
        return $I;
    }

    function
    is_view($R)
    {
        return $R["Engine"] == "view";
    }

    function
    fk_support($R)
    {
        return
            true;
    }

    function
    fields($Q)
    {
        $I = array();
        $Kf = where_owner(" AND ");
        foreach (get_rows("SELECT * FROM all_tab_columns WHERE table_name = " . q($Q) . "$Kf ORDER BY column_id") as $J) {
            $T = $J["DATA_TYPE"];
            $te = "$J[DATA_PRECISION],$J[DATA_SCALE]";
            if ($te == ",") $te = $J["CHAR_COL_DECL_LENGTH"];
            $I[$J["COLUMN_NAME"]] = array("field" => $J["COLUMN_NAME"], "full_type" => $T . ($te ? "($te)" : ""), "type" => strtolower($T), "length" => $te, "default" => $J["DATA_DEFAULT"], "null" => ($J["NULLABLE"] == "Y"), "privileges" => array("insert" => 1, "select" => 1, "update" => 1),);
        }
        return $I;
    }

    function
    indexes($Q, $h = null)
    {
        $I = array();
        $Kf = where_owner(" AND ", "aic.table_owner");
        foreach (get_rows("SELECT aic.*, ac.constraint_type, atc.data_default
FROM all_ind_columns aic
LEFT JOIN all_constraints ac ON aic.index_name = ac.constraint_name AND aic.table_name = ac.table_name AND aic.index_owner = ac.owner
LEFT JOIN all_tab_cols atc ON aic.column_name = atc.column_name AND aic.table_name = atc.table_name AND aic.index_owner = atc.owner
WHERE aic.table_name = " . q($Q) . "$Kf
ORDER BY ac.constraint_type, aic.column_position", $h) as $J) {
            $Kd = $J["INDEX_NAME"];
            $ob = $J["DATA_DEFAULT"];
            $ob = ($ob ? trim($ob, '"') : $J["COLUMN_NAME"]);
            $I[$Kd]["type"] = ($J["CONSTRAINT_TYPE"] == "P" ? "PRIMARY" : ($J["CONSTRAINT_TYPE"] == "U" ? "UNIQUE" : "INDEX"));
            $I[$Kd]["columns"][] = $ob;
            $I[$Kd]["lengths"][] = ($J["CHAR_LENGTH"] && $J["CHAR_LENGTH"] != $J["COLUMN_LENGTH"] ? $J["CHAR_LENGTH"] : null);
            $I[$Kd]["descs"][] = ($J["DESCEND"] && $J["DESCEND"] == "DESC" ? '1' : null);
        }
        return $I;
    }

    function
    view($D)
    {
        $Xi = views_table("view_name, text");
        $K = get_rows('SELECT text "select" FROM ' . $Xi . ' WHERE view_name = ' . q($D));
        return
            reset($K);
    }

    function
    collations()
    {
        return
            array();
    }

    function
    information_schema($l)
    {
        return
            false;
    }

    function
    error()
    {
        global $g;
        return
            h($g->error);
    }

    function
    explain($g, $G)
    {
        $g->query("EXPLAIN PLAN FOR $G");
        return $g->query("SELECT * FROM plan_table");
    }

    function
    found_rows($R, $Z)
    {
    }

    function
    auto_increment()
    {
        return "";
    }

    function
    alter_table($Q, $D, $p, $fd, $rb, $yc, $d, $Ka, $Tf)
    {
        $c = $jc = array();
        $Ef = ($Q ? fields($Q) : array());
        foreach ($p
                 as $o) {
            $X = $o[1];
            if ($X && $o[0] != "" && idf_escape($o[0]) != $X[0]) queries("ALTER TABLE " . table($Q) . " RENAME COLUMN " . idf_escape($o[0]) . " TO $X[0]");
            $Df = $Ef[$o[0]];
            if ($X && $Df) {
                $jf = process_field($Df, $Df);
                if ($X[2] == $jf[2]) $X[2] = "";
            }
            if ($X) $c[] = ($Q != "" ? ($o[0] != "" ? "MODIFY (" : "ADD (") : "  ") . implode($X) . ($Q != "" ? ")" : ""); else$jc[] = idf_escape($o[0]);
        }
        if ($Q == "") return
            queries("CREATE TABLE " . table($D) . " (\n" . implode(",\n", $c) . "\n)");
        return (!$c || queries("ALTER TABLE " . table($Q) . "\n" . implode("\n", $c))) && (!$jc || queries("ALTER TABLE " . table($Q) . " DROP (" . implode(", ", $jc) . ")")) && ($Q == $D || queries("ALTER TABLE " . table($Q) . " RENAME TO " . table($D)));
    }

    function
    alter_indexes($Q, $c)
    {
        $jc = array();
        $vg = array();
        foreach ($c
                 as $X) {
            if ($X[0] != "INDEX") {
                $X[2] = preg_replace('~ DESC$~', '', $X[2]);
                $i = ($X[2] == "DROP" ? "\nDROP CONSTRAINT " . idf_escape($X[1]) : "\nADD" . ($X[1] != "" ? " CONSTRAINT " . idf_escape($X[1]) : "") . " $X[0] " . ($X[0] == "PRIMARY" ? "KEY " : "") . "(" . implode(", ", $X[2]) . ")");
                array_unshift($vg, "ALTER TABLE " . table($Q) . $i);
            } elseif ($X[2] == "DROP") $jc[] = idf_escape($X[1]);
            else$vg[] = "CREATE INDEX " . idf_escape($X[1] != "" ? $X[1] : uniqid($Q . "_")) . " ON " . table($Q) . " (" . implode(", ", $X[2]) . ")";
        }
        if ($jc) array_unshift($vg, "DROP INDEX " . implode(", ", $jc));
        foreach ($vg
                 as $G) {
            if (!queries($G)) return
                false;
        }
        return
            true;
    }

    function
    foreign_keys($Q)
    {
        $I = array();
        $G = "SELECT c_list.CONSTRAINT_NAME as NAME,
c_src.COLUMN_NAME as SRC_COLUMN,
c_dest.OWNER as DEST_DB,
c_dest.TABLE_NAME as DEST_TABLE,
c_dest.COLUMN_NAME as DEST_COLUMN,
c_list.DELETE_RULE as ON_DELETE
FROM ALL_CONSTRAINTS c_list, ALL_CONS_COLUMNS c_src, ALL_CONS_COLUMNS c_dest
WHERE c_list.CONSTRAINT_NAME = c_src.CONSTRAINT_NAME
AND c_list.R_CONSTRAINT_NAME = c_dest.CONSTRAINT_NAME
AND c_list.CONSTRAINT_TYPE = 'R'
AND c_src.TABLE_NAME = " . q($Q);
        foreach (get_rows($G) as $J) $I[$J['NAME']] = array("db" => $J['DEST_DB'], "table" => $J['DEST_TABLE'], "source" => array($J['SRC_COLUMN']), "target" => array($J['DEST_COLUMN']), "on_delete" => $J['ON_DELETE'], "on_update" => null,);
        return $I;
    }

    function
    truncate_tables($S)
    {
        return
            apply_queries("TRUNCATE TABLE", $S);
    }

    function
    drop_views($Yi)
    {
        return
            apply_queries("DROP VIEW", $Yi);
    }

    function
    drop_tables($S)
    {
        return
            apply_queries("DROP TABLE", $S);
    }

    function
    last_id()
    {
        return
            0;
    }

    function
    schemas()
    {
        $I = get_vals("SELECT DISTINCT owner FROM dba_segments WHERE owner IN (SELECT username FROM dba_users WHERE default_tablespace NOT IN ('SYSTEM','SYSAUX')) ORDER BY 1");
        return ($I ? $I : get_vals("SELECT DISTINCT owner FROM all_tables WHERE tablespace_name = " . q(DB) . " ORDER BY 1"));
    }

    function
    get_schema()
    {
        global $g;
        return $g->result("SELECT sys_context('USERENV', 'SESSION_USER') FROM dual");
    }

    function
    set_schema($ah, $h = null)
    {
        global $g;
        if (!$h) $h = $g;
        return $h->query("ALTER SESSION SET CURRENT_SCHEMA = " . idf_escape($ah));
    }

    function
    show_variables()
    {
        return
            get_key_vals('SELECT name, display_value FROM v$parameter');
    }

    function
    process_list()
    {
        return
            get_rows('SELECT sess.process AS "process", sess.username AS "user", sess.schemaname AS "schema", sess.status AS "status", sess.wait_class AS "wait_class", sess.seconds_in_wait AS "seconds_in_wait", sql.sql_text AS "sql_text", sess.machine AS "machine", sess.port AS "port"
FROM v$session sess LEFT OUTER JOIN v$sql sql
ON sql.sql_id = sess.sql_id
WHERE sess.type = \'USER\'
ORDER BY PROCESS
');
    }

    function
    show_status()
    {
        $K = get_rows('SELECT * FROM v$instance');
        return
            reset($K);
    }

    function
    convert_field($o)
    {
    }

    function
    unconvert_field($o, $I)
    {
        return $I;
    }

    function
    support($Tc)
    {
        return
            preg_match('~^(columns|database|drop_col|indexes|descidx|processlist|scheme|sql|status|table|variables|view)$~', $Tc);
    }

    function
    driver_config()
    {
        $U = array();
        $Gh = array();
        foreach (array('Numbers' => array("number" => 38, "binary_float" => 12, "binary_double" => 21), 'Date and time' => array("date" => 10, "timestamp" => 29, "interval year" => 12, "interval day" => 28), 'Strings' => array("char" => 2000, "varchar2" => 4000, "nchar" => 2000, "nvarchar2" => 4000, "clob" => 4294967295, "nclob" => 4294967295), 'Binary' => array("raw" => 2000, "long raw" => 2147483648, "blob" => 4294967295, "bfile" => 4294967296),) as $z => $X) {
            $U += $X;
            $Gh[$z] = array_keys($X);
        }
        return
            array('possible_drivers' => array("OCI8", "PDO_OCI"), 'jush' => "oracle", 'types' => $U, 'structured_types' => $Gh, 'unsigned' => array(), 'operators' => array("=", "<", ">", "<=", ">=", "!=", "LIKE", "LIKE %%", "IN", "IS NULL", "NOT LIKE", "NOT REGEXP", "NOT IN", "IS NOT NULL", "SQL"), 'functions' => array("length", "lower", "round", "upper"), 'grouping' => array("avg", "count", "count distinct", "max", "min", "sum"), 'edit_functions' => array(array("date" => "current_date", "timestamp" => "current_timestamp",), array("number|float|double" => "+/-", "date|timestamp" => "+ interval/- interval", "char|clob" => "||",)),);
    }
}
$ic["mssql"] = "MS SQL (beta)";
if (isset($_GET["mssql"])) {
    define("DRIVER", "mssql");
    if (extension_loaded("sqlsrv")) {
        class
        Min_DB
        {
            var $extension = "sqlsrv", $_link, $_result, $server_info, $affected_rows, $errno, $error;

            function
            _get_error()
            {
                $this->error = "";
                foreach (sqlsrv_errors() as $n) {
                    $this->errno = $n["code"];
                    $this->error .= "$n[message]\n";
                }
                $this->error = rtrim($this->error);
            }

            function
            connect($M, $V, $F)
            {
                global $b;
                $l = $b->database();
                $yb = array("UID" => $V, "PWD" => $F, "CharacterSet" => "UTF-8");
                if ($l != "") $yb["Database"] = $l;
                $this->_link = @sqlsrv_connect(preg_replace('~:~', ',', $M), $yb);
                if ($this->_link) {
                    $Rd = sqlsrv_server_info($this->_link);
                    $this->server_info = $Rd['SQLServerVersion'];
                } else$this->_get_error();
                return (bool)$this->_link;
            }

            function
            quote($P)
            {
                return "'" . str_replace("'", "''", $P) . "'";
            }

            function
            select_db($j)
            {
                return $this->query("USE " . idf_escape($j));
            }

            function
            query($G, $Bi = false)
            {
                $H = sqlsrv_query($this->_link, $G);
                $this->error = "";
                if (!$H) {
                    $this->_get_error();
                    return
                        false;
                }
                return $this->store_result($H);
            }

            function
            multi_query($G)
            {
                $this->_result = sqlsrv_query($this->_link, $G);
                $this->error = "";
                if (!$this->_result) {
                    $this->_get_error();
                    return
                        false;
                }
                return
                    true;
            }

            function
            store_result($H = null)
            {
                if (!$H) $H = $this->_result;
                if (!$H) return
                    false;
                if (sqlsrv_field_metadata($H)) return
                    new
                    Min_Result($H);
                $this->affected_rows = sqlsrv_rows_affected($H);
                return
                    true;
            }

            function
            next_result()
            {
                return $this->_result ? sqlsrv_next_result($this->_result) : null;
            }

            function
            result($G, $o = 0)
            {
                $H = $this->query($G);
                if (!is_object($H)) return
                    false;
                $J = $H->fetch_row();
                return $J[$o];
            }
        }

        class
        Min_Result
        {
            var $_result, $_offset = 0, $_fields, $num_rows;

            function
            __construct($H)
            {
                $this->_result = $H;
            }

            function
            _convert($J)
            {
                foreach ((array)$J
                         as $z => $X) {
                    if (is_a($X, 'DateTime')) $J[$z] = $X->format("Y-m-d H:i:s");
                }
                return $J;
            }

            function
            fetch_assoc()
            {
                return $this->_convert(sqlsrv_fetch_array($this->_result, SQLSRV_FETCH_ASSOC));
            }

            function
            fetch_row()
            {
                return $this->_convert(sqlsrv_fetch_array($this->_result, SQLSRV_FETCH_NUMERIC));
            }

            function
            fetch_field()
            {
                if (!$this->_fields) $this->_fields = sqlsrv_field_metadata($this->_result);
                $o = $this->_fields[$this->_offset++];
                $I = new
                stdClass;
                $I->name = $o["Name"];
                $I->orgname = $o["Name"];
                $I->type = ($o["Type"] == 1 ? 254 : 0);
                return $I;
            }

            function
            seek($hf)
            {
                for ($t = 0; $t < $hf; $t++) sqlsrv_fetch($this->_result);
            }

            function
            __destruct()
            {
                sqlsrv_free_stmt($this->_result);
            }
        }
    } elseif (extension_loaded("mssql")) {
        class
        Min_DB
        {
            var $extension = "MSSQL", $_link, $_result, $server_info, $affected_rows, $error;

            function
            connect($M, $V, $F)
            {
                $this->_link = @mssql_connect($M, $V, $F);
                if ($this->_link) {
                    $H = $this->query("SELECT SERVERPROPERTY('ProductLevel'), SERVERPROPERTY('Edition')");
                    if ($H) {
                        $J = $H->fetch_row();
                        $this->server_info = $this->result("sp_server_info 2", 2) . " [$J[0]] $J[1]";
                    }
                } else$this->error = mssql_get_last_message();
                return (bool)$this->_link;
            }

            function
            quote($P)
            {
                return "'" . str_replace("'", "''", $P) . "'";
            }

            function
            select_db($j)
            {
                return
                    mssql_select_db($j);
            }

            function
            query($G, $Bi = false)
            {
                $H = @mssql_query($G, $this->_link);
                $this->error = "";
                if (!$H) {
                    $this->error = mssql_get_last_message();
                    return
                        false;
                }
                if ($H === true) {
                    $this->affected_rows = mssql_rows_affected($this->_link);
                    return
                        true;
                }
                return
                    new
                    Min_Result($H);
            }

            function
            multi_query($G)
            {
                return $this->_result = $this->query($G);
            }

            function
            store_result()
            {
                return $this->_result;
            }

            function
            next_result()
            {
                return
                    mssql_next_result($this->_result->_result);
            }

            function
            result($G, $o = 0)
            {
                $H = $this->query($G);
                if (!is_object($H)) return
                    false;
                return
                    mssql_result($H->_result, 0, $o);
            }
        }

        class
        Min_Result
        {
            var $_result, $_offset = 0, $_fields, $num_rows;

            function
            __construct($H)
            {
                $this->_result = $H;
                $this->num_rows = mssql_num_rows($H);
            }

            function
            fetch_assoc()
            {
                return
                    mssql_fetch_assoc($this->_result);
            }

            function
            fetch_row()
            {
                return
                    mssql_fetch_row($this->_result);
            }

            function
            num_rows()
            {
                return
                    mssql_num_rows($this->_result);
            }

            function
            fetch_field()
            {
                $I = mssql_fetch_field($this->_result);
                $I->orgtable = $I->table;
                $I->orgname = $I->name;
                return $I;
            }

            function
            seek($hf)
            {
                mssql_data_seek($this->_result, $hf);
            }

            function
            __destruct()
            {
                mssql_free_result($this->_result);
            }
        }
    } elseif (extension_loaded("pdo_dblib")) {
        class
        Min_DB
            extends
            Min_PDO
        {
            var $extension = "PDO_DBLIB";

            function
            connect($M, $V, $F)
            {
                $this->dsn("dblib:charset=utf8;host=" . str_replace(":", ";unix_socket=", preg_replace('~:(\d)~', ';port=\1', $M)), $V, $F);
                return
                    true;
            }

            function
            select_db($j)
            {
                return $this->query("USE " . idf_escape($j));
            }
        }
    }

    class
    Min_Driver
        extends
        Min_SQL
    {
        function
        insertUpdate($Q, $K, $kg)
        {
            foreach ($K
                     as $N) {
                $Ii = array();
                $Z = array();
                foreach ($N
                         as $z => $X) {
                    $Ii[] = "$z = $X";
                    if (isset($kg[idf_unescape($z)])) $Z[] = "$z = $X";
                }
                if (!queries("MERGE " . table($Q) . " USING (VALUES(" . implode(", ", $N) . ")) AS source (c" . implode(", c", range(1, count($N))) . ") ON " . implode(" AND ", $Z) . " WHEN MATCHED THEN UPDATE SET " . implode(", ", $Ii) . " WHEN NOT MATCHED THEN INSERT (" . implode(", ", array_keys($N)) . ") VALUES (" . implode(", ", $N) . ");")) return
                    false;
            }
            return
                true;
        }

        function
        begin()
        {
            return
                queries("BEGIN TRANSACTION");
        }
    }

    function
    idf_escape($v)
    {
        return "[" . str_replace("]", "]]", $v) . "]";
    }

    function
    table($v)
    {
        return ($_GET["ns"] != "" ? idf_escape($_GET["ns"]) . "." : "") . idf_escape($v);
    }

    function
    connect()
    {
        global $b;
        $g = new
        Min_DB;
        $Kb = $b->credentials();
        if ($g->connect($Kb[0], $Kb[1], $Kb[2])) return $g;
        return $g->error;
    }

    function
    get_databases()
    {
        return
            get_vals("SELECT name FROM sys.databases WHERE name NOT IN ('master', 'tempdb', 'model', 'msdb')");
    }

    function
    limit($G, $Z, $_, $hf = 0, $hh = " ")
    {
        return ($_ !== null ? " TOP (" . ($_ + $hf) . ")" : "") . " $G$Z";
    }

    function
    limit1($Q, $G, $Z, $hh = "\n")
    {
        return
            limit($G, $Z, 1, 0, $hh);
    }

    function
    db_collation($l, $lb)
    {
        global $g;
        return $g->result("SELECT collation_name FROM sys.databases WHERE name = " . q($l));
    }

    function
    engines()
    {
        return
            array();
    }

    function
    logged_user()
    {
        global $g;
        return $g->result("SELECT SUSER_NAME()");
    }

    function
    tables_list()
    {
        return
            get_key_vals("SELECT name, type_desc FROM sys.all_objects WHERE schema_id = SCHEMA_ID(" . q(get_schema()) . ") AND type IN ('S', 'U', 'V') ORDER BY name");
    }

    function
    count_tables($k)
    {
        global $g;
        $I = array();
        foreach ($k
                 as $l) {
            $g->select_db($l);
            $I[$l] = $g->result("SELECT COUNT(*) FROM INFORMATION_SCHEMA.TABLES");
        }
        return $I;
    }

    function
    table_status($D = "")
    {
        $I = array();
        foreach (get_rows("SELECT ao.name AS Name, ao.type_desc AS Engine, (SELECT value FROM fn_listextendedproperty(default, 'SCHEMA', schema_name(schema_id), 'TABLE', ao.name, null, null)) AS Comment FROM sys.all_objects AS ao WHERE schema_id = SCHEMA_ID(" . q(get_schema()) . ") AND type IN ('S', 'U', 'V') " . ($D != "" ? "AND name = " . q($D) : "ORDER BY name")) as $J) {
            if ($D != "") return $J;
            $I[$J["Name"]] = $J;
        }
        return $I;
    }

    function
    is_view($R)
    {
        return $R["Engine"] == "VIEW";
    }

    function
    fk_support($R)
    {
        return
            true;
    }

    function
    fields($Q)
    {
        $tb = get_key_vals("SELECT objname, cast(value as varchar(max)) FROM fn_listextendedproperty('MS_DESCRIPTION', 'schema', " . q(get_schema()) . ", 'table', " . q($Q) . ", 'column', NULL)");
        $I = array();
        foreach (get_rows("SELECT c.max_length, c.precision, c.scale, c.name, c.is_nullable, c.is_identity, c.collation_name, t.name type, CAST(d.definition as text) [default]
FROM sys.all_columns c
JOIN sys.all_objects o ON c.object_id = o.object_id
JOIN sys.types t ON c.user_type_id = t.user_type_id
LEFT JOIN sys.default_constraints d ON c.default_object_id = d.parent_column_id
WHERE o.schema_id = SCHEMA_ID(" . q(get_schema()) . ") AND o.type IN ('S', 'U', 'V') AND o.name = " . q($Q)) as $J) {
            $T = $J["type"];
            $te = (preg_match("~char|binary~", $T) ? $J["max_length"] : ($T == "decimal" ? "$J[precision],$J[scale]" : ""));
            $I[$J["name"]] = array("field" => $J["name"], "full_type" => $T . ($te ? "($te)" : ""), "type" => $T, "length" => $te, "default" => $J["default"], "null" => $J["is_nullable"], "auto_increment" => $J["is_identity"], "collation" => $J["collation_name"], "privileges" => array("insert" => 1, "select" => 1, "update" => 1), "primary" => $J["is_identity"], "comment" => $tb[$J["name"]],);
        }
        return $I;
    }

    function
    indexes($Q, $h = null)
    {
        $I = array();
        foreach (get_rows("SELECT i.name, key_ordinal, is_unique, is_primary_key, c.name AS column_name, is_descending_key
FROM sys.indexes i
INNER JOIN sys.index_columns ic ON i.object_id = ic.object_id AND i.index_id = ic.index_id
INNER JOIN sys.columns c ON ic.object_id = c.object_id AND ic.column_id = c.column_id
WHERE OBJECT_NAME(i.object_id) = " . q($Q), $h) as $J) {
            $D = $J["name"];
            $I[$D]["type"] = ($J["is_primary_key"] ? "PRIMARY" : ($J["is_unique"] ? "UNIQUE" : "INDEX"));
            $I[$D]["lengths"] = array();
            $I[$D]["columns"][$J["key_ordinal"]] = $J["column_name"];
            $I[$D]["descs"][$J["key_ordinal"]] = ($J["is_descending_key"] ? '1' : null);
        }
        return $I;
    }

    function
    view($D)
    {
        global $g;
        return
            array("select" => preg_replace('~^(?:[^[]|\[[^]]*])*\s+AS\s+~isU', '', $g->result("SELECT VIEW_DEFINITION FROM INFORMATION_SCHEMA.VIEWS WHERE TABLE_SCHEMA = SCHEMA_NAME() AND TABLE_NAME = " . q($D))));
    }

    function
    collations()
    {
        $I = array();
        foreach (get_vals("SELECT name FROM fn_helpcollations()") as $d) $I[preg_replace('~_.*~', '', $d)][] = $d;
        return $I;
    }

    function
    information_schema($l)
    {
        return
            false;
    }

    function
    error()
    {
        global $g;
        return
            nl_br(h(preg_replace('~^(\[[^]]*])+~m', '', $g->error)));
    }

    function
    create_database($l, $d)
    {
        return
            queries("CREATE DATABASE " . idf_escape($l) . (preg_match('~^[a-z0-9_]+$~i', $d) ? " COLLATE $d" : ""));
    }

    function
    drop_databases($k)
    {
        return
            queries("DROP DATABASE " . implode(", ", array_map('idf_escape', $k)));
    }

    function
    rename_database($D, $d)
    {
        if (preg_match('~^[a-z0-9_]+$~i', $d)) queries("ALTER DATABASE " . idf_escape(DB) . " COLLATE $d");
        queries("ALTER DATABASE " . idf_escape(DB) . " MODIFY NAME = " . idf_escape($D));
        return
            true;
    }

    function
    auto_increment()
    {
        return " IDENTITY" . ($_POST["Auto_increment"] != "" ? "(" . number($_POST["Auto_increment"]) . ",1)" : "") . " PRIMARY KEY";
    }

    function
    alter_table($Q, $D, $p, $fd, $rb, $yc, $d, $Ka, $Tf)
    {
        $c = array();
        $tb = array();
        foreach ($p
                 as $o) {
            $e = idf_escape($o[0]);
            $X = $o[1];
            if (!$X) $c["DROP"][] = " COLUMN $e"; else {
                $X[1] = preg_replace("~( COLLATE )'(\\w+)'~", '\1\2', $X[1]);
                $tb[$o[0]] = $X[5];
                unset($X[5]);
                if ($o[0] == "") $c["ADD"][] = "\n  " . implode("", $X) . ($Q == "" ? substr($fd[$X[0]], 16 + strlen($X[0])) : ""); else {
                    unset($X[6]);
                    if ($e != $X[0]) queries("EXEC sp_rename " . q(table($Q) . ".$e") . ", " . q(idf_unescape($X[0])) . ", 'COLUMN'");
                    $c["ALTER COLUMN " . implode("", $X)][] = "";
                }
            }
        }
        if ($Q == "") return
            queries("CREATE TABLE " . table($D) . " (" . implode(",", (array)$c["ADD"]) . "\n)");
        if ($Q != $D) queries("EXEC sp_rename " . q(table($Q)) . ", " . q($D));
        if ($fd) $c[""] = $fd;
        foreach ($c
                 as $z => $X) {
            if (!queries("ALTER TABLE " . idf_escape($D) . " $z" . implode(",", $X))) return
                false;
        }
        foreach ($tb
                 as $z => $X) {
            $rb = substr($X, 9);
            queries("EXEC sp_dropextendedproperty @name = N'MS_Description', @level0type = N'Schema', @level0name = " . q(get_schema()) . ", @level1type = N'Table', @level1name = " . q($D) . ", @level2type = N'Column', @level2name = " . q($z));
            queries("EXEC sp_addextendedproperty @name = N'MS_Description', @value = " . $rb . ", @level0type = N'Schema', @level0name = " . q(get_schema()) . ", @level1type = N'Table', @level1name = " . q($D) . ", @level2type = N'Column', @level2name = " . q($z));
        }
        return
            true;
    }

    function
    alter_indexes($Q, $c)
    {
        $w = array();
        $jc = array();
        foreach ($c
                 as $X) {
            if ($X[2] == "DROP") {
                if ($X[0] == "PRIMARY") $jc[] = idf_escape($X[1]); else$w[] = idf_escape($X[1]) . " ON " . table($Q);
            } elseif (!queries(($X[0] != "PRIMARY" ? "CREATE $X[0] " . ($X[0] != "INDEX" ? "INDEX " : "") . idf_escape($X[1] != "" ? $X[1] : uniqid($Q . "_")) . " ON " . table($Q) : "ALTER TABLE " . table($Q) . " ADD PRIMARY KEY") . " (" . implode(", ", $X[2]) . ")")) return
                false;
        }
        return (!$w || queries("DROP INDEX " . implode(", ", $w))) && (!$jc || queries("ALTER TABLE " . table($Q) . " DROP " . implode(", ", $jc)));
    }

    function
    last_id()
    {
        global $g;
        return $g->result("SELECT SCOPE_IDENTITY()");
    }

    function
    explain($g, $G)
    {
        $g->query("SET SHOWPLAN_ALL ON");
        $I = $g->query($G);
        $g->query("SET SHOWPLAN_ALL OFF");
        return $I;
    }

    function
    found_rows($R, $Z)
    {
    }

    function
    foreign_keys($Q)
    {
        $I = array();
        foreach (get_rows("EXEC sp_fkeys @fktable_name = " . q($Q)) as $J) {
            $r =& $I[$J["FK_NAME"]];
            $r["db"] = $J["PKTABLE_QUALIFIER"];
            $r["table"] = $J["PKTABLE_NAME"];
            $r["source"][] = $J["FKCOLUMN_NAME"];
            $r["target"][] = $J["PKCOLUMN_NAME"];
        }
        return $I;
    }

    function
    truncate_tables($S)
    {
        return
            apply_queries("TRUNCATE TABLE", $S);
    }

    function
    drop_views($Yi)
    {
        return
            queries("DROP VIEW " . implode(", ", array_map('table', $Yi)));
    }

    function
    drop_tables($S)
    {
        return
            queries("DROP TABLE " . implode(", ", array_map('table', $S)));
    }

    function
    move_tables($S, $Yi, $Wh)
    {
        return
            apply_queries("ALTER SCHEMA " . idf_escape($Wh) . " TRANSFER", array_merge($S, $Yi));
    }

    function
    trigger($D)
    {
        if ($D == "") return
            array();
        $K = get_rows("SELECT s.name [Trigger],
CASE WHEN OBJECTPROPERTY(s.id, 'ExecIsInsertTrigger') = 1 THEN 'INSERT' WHEN OBJECTPROPERTY(s.id, 'ExecIsUpdateTrigger') = 1 THEN 'UPDATE' WHEN OBJECTPROPERTY(s.id, 'ExecIsDeleteTrigger') = 1 THEN 'DELETE' END [Event],
CASE WHEN OBJECTPROPERTY(s.id, 'ExecIsInsteadOfTrigger') = 1 THEN 'INSTEAD OF' ELSE 'AFTER' END [Timing],
c.text
FROM sysobjects s
JOIN syscomments c ON s.id = c.id
WHERE s.xtype = 'TR' AND s.name = " . q($D));
        $I = reset($K);
        if ($I) $I["Statement"] = preg_replace('~^.+\s+AS\s+~isU', '', $I["text"]);
        return $I;
    }

    function
    triggers($Q)
    {
        $I = array();
        foreach (get_rows("SELECT sys1.name,
CASE WHEN OBJECTPROPERTY(sys1.id, 'ExecIsInsertTrigger') = 1 THEN 'INSERT' WHEN OBJECTPROPERTY(sys1.id, 'ExecIsUpdateTrigger') = 1 THEN 'UPDATE' WHEN OBJECTPROPERTY(sys1.id, 'ExecIsDeleteTrigger') = 1 THEN 'DELETE' END [Event],
CASE WHEN OBJECTPROPERTY(sys1.id, 'ExecIsInsteadOfTrigger') = 1 THEN 'INSTEAD OF' ELSE 'AFTER' END [Timing]
FROM sysobjects sys1
JOIN sysobjects sys2 ON sys1.parent_obj = sys2.id
WHERE sys1.xtype = 'TR' AND sys2.name = " . q($Q)) as $J) $I[$J["name"]] = array($J["Timing"], $J["Event"]);
        return $I;
    }

    function
    trigger_options()
    {
        return
            array("Timing" => array("AFTER", "INSTEAD OF"), "Event" => array("INSERT", "UPDATE", "DELETE"), "Type" => array("AS"),);
    }

    function
    schemas()
    {
        return
            get_vals("SELECT name FROM sys.schemas");
    }

    function
    get_schema()
    {
        global $g;
        if ($_GET["ns"] != "") return $_GET["ns"];
        return $g->result("SELECT SCHEMA_NAME()");
    }

    function
    set_schema($Zg)
    {
        return
            true;
    }

    function
    use_sql($j)
    {
        return "USE " . idf_escape($j);
    }

    function
    show_variables()
    {
        return
            array();
    }

    function
    show_status()
    {
        return
            array();
    }

    function
    convert_field($o)
    {
    }

    function
    unconvert_field($o, $I)
    {
        return $I;
    }

    function
    support($Tc)
    {
        return
            preg_match('~^(comment|columns|database|drop_col|indexes|descidx|scheme|sql|table|trigger|view|view_trigger)$~', $Tc);
    }

    function
    driver_config()
    {
        $U = array();
        $Gh = array();
        foreach (array('Numbers' => array("tinyint" => 3, "smallint" => 5, "int" => 10, "bigint" => 20, "bit" => 1, "decimal" => 0, "real" => 12, "float" => 53, "smallmoney" => 10, "money" => 20), 'Date and time' => array("date" => 10, "smalldatetime" => 19, "datetime" => 19, "datetime2" => 19, "time" => 8, "datetimeoffset" => 10), 'Strings' => array("char" => 8000, "varchar" => 8000, "text" => 2147483647, "nchar" => 4000, "nvarchar" => 4000, "ntext" => 1073741823), 'Binary' => array("binary" => 8000, "varbinary" => 8000, "image" => 2147483647),) as $z => $X) {
            $U += $X;
            $Gh[$z] = array_keys($X);
        }
        return
            array('possible_drivers' => array("SQLSRV", "MSSQL", "PDO_DBLIB"), 'jush' => "mssql", 'types' => $U, 'structured_types' => $Gh, 'unsigned' => array(), 'operators' => array("=", "<", ">", "<=", ">=", "!=", "LIKE", "LIKE %%", "IN", "IS NULL", "NOT LIKE", "NOT IN", "IS NOT NULL"), 'functions' => array("len", "lower", "round", "upper"), 'grouping' => array("avg", "count", "count distinct", "max", "min", "sum"), 'edit_functions' => array(array("date|time" => "getdate",), array("int|decimal|real|float|money|datetime" => "+/-", "char|text" => "+",)),);
    }
}
$ic["mongo"] = "MongoDB (alpha)";
if (isset($_GET["mongo"])) {
    define("DRIVER", "mongo");
    if (class_exists('MongoDB')) {
        class
        Min_DB
        {
            var $extension = "Mongo", $server_info = MongoClient::VERSION, $error, $last_id, $_link, $_db;

            function
            connect($Ji, $xf)
            {
                try {
                    $this->_link = new
                    MongoClient($Ji, $xf);
                    if ($xf["password"] != "") {
                        $xf["password"] = "";
                        try {
                            new
                            MongoClient($Ji, $xf);
                            $this->error = 'Database does not support password.';
                        } catch (Exception$pc) {
                        }
                    }
                } catch (Exception$pc) {
                    $this->error = $pc->getMessage();
                }
            }

            function
            query($G)
            {
                return
                    false;
            }

            function
            select_db($j)
            {
                try {
                    $this->_db = $this->_link->selectDB($j);
                    return
                        true;
                } catch (Exception$Fc) {
                    $this->error = $Fc->getMessage();
                    return
                        false;
                }
            }

            function
            quote($P)
            {
                return $P;
            }
        }

        class
        Min_Result
        {
            var $num_rows, $_rows = array(), $_offset = 0, $_charset = array();

            function
            __construct($H)
            {
                foreach ($H
                         as $de) {
                    $J = array();
                    foreach ($de
                             as $z => $X) {
                        if (is_a($X, 'MongoBinData')) $this->_charset[$z] = 63;
                        $J[$z] = (is_a($X, 'MongoId') ? "ObjectId(\"$X\")" : (is_a($X, 'MongoDate') ? gmdate("Y-m-d H:i:s", $X->sec) . " GMT" : (is_a($X, 'MongoBinData') ? $X->bin : (is_a($X, 'MongoRegex') ? "$X" : (is_object($X) ? get_class($X) : $X)))));
                    }
                    $this->_rows[] = $J;
                    foreach ($J
                             as $z => $X) {
                        if (!isset($this->_rows[0][$z])) $this->_rows[0][$z] = null;
                    }
                }
                $this->num_rows = count($this->_rows);
            }

            function
            fetch_assoc()
            {
                $J = current($this->_rows);
                if (!$J) return $J;
                $I = array();
                foreach ($this->_rows[0] as $z => $X) $I[$z] = $J[$z];
                next($this->_rows);
                return $I;
            }

            function
            fetch_row()
            {
                $I = $this->fetch_assoc();
                if (!$I) return $I;
                return
                    array_values($I);
            }

            function
            fetch_field()
            {
                $he = array_keys($this->_rows[0]);
                $D = $he[$this->_offset++];
                return (object)array('name' => $D, 'charsetnr' => $this->_charset[$D],);
            }
        }

        class
        Min_Driver
            extends
            Min_SQL
        {
            public $kg = "_id";

            function
            select($Q, $L, $Z, $qd, $zf = array(), $_ = 1, $E = 0, $mg = false)
            {
                $L = ($L == array("*") ? array() : array_fill_keys($L, true));
                $uh = array();
                foreach ($zf
                         as $X) {
                    $X = preg_replace('~ DESC$~', '', $X, 1, $Gb);
                    $uh[$X] = ($Gb ? -1 : 1);
                }
                return
                    new
                    Min_Result($this->_conn->_db->selectCollection($Q)->find(array(), $L)->sort($uh)->limit($_ != "" ? +$_ : 0)->skip($E * $_));
            }

            function
            insert($Q, $N)
            {
                try {
                    $I = $this->_conn->_db->selectCollection($Q)->insert($N);
                    $this->_conn->errno = $I['code'];
                    $this->_conn->error = $I['err'];
                    $this->_conn->last_id = $N['_id'];
                    return !$I['err'];
                } catch (Exception$Fc) {
                    $this->_conn->error = $Fc->getMessage();
                    return
                        false;
                }
            }
        }

        function
        get_databases($dd)
        {
            global $g;
            $I = array();
            $Ub = $g->_link->listDBs();
            foreach ($Ub['databases'] as $l) $I[] = $l['name'];
            return $I;
        }

        function
        count_tables($k)
        {
            global $g;
            $I = array();
            foreach ($k
                     as $l) $I[$l] = count($g->_link->selectDB($l)->getCollectionNames(true));
            return $I;
        }

        function
        tables_list()
        {
            global $g;
            return
                array_fill_keys($g->_db->getCollectionNames(true), 'table');
        }

        function
        drop_databases($k)
        {
            global $g;
            foreach ($k
                     as $l) {
                $Lg = $g->_link->selectDB($l)->drop();
                if (!$Lg['ok']) return
                    false;
            }
            return
                true;
        }

        function
        indexes($Q, $h = null)
        {
            global $g;
            $I = array();
            foreach ($g->_db->selectCollection($Q)->getIndexInfo() as $w) {
                $cc = array();
                foreach ($w["key"] as $e => $T) $cc[] = ($T == -1 ? '1' : null);
                $I[$w["name"]] = array("type" => ($w["name"] == "_id_" ? "PRIMARY" : ($w["unique"] ? "UNIQUE" : "INDEX")), "columns" => array_keys($w["key"]), "lengths" => array(), "descs" => $cc,);
            }
            return $I;
        }

        function
        fields($Q)
        {
            return
                fields_from_edit();
        }

        function
        found_rows($R, $Z)
        {
            global $g;
            return $g->_db->selectCollection($_GET["select"])->count($Z);
        }

        $uf = array("=");
    } elseif (class_exists('MongoDB\Driver\Manager')) {
        class
        Min_DB
        {
            var $extension = "MongoDB", $server_info = MONGODB_VERSION, $affected_rows, $error, $last_id;
            var $_link;
            var $_db, $_db_name;

            function
            connect($Ji, $xf)
            {
                $gb = 'MongoDB\Driver\Manager';
                $this->_link = new$gb($Ji, $xf);
                $this->executeCommand('admin', array('ping' => 1));
            }

            function
            executeCommand($l, $pb)
            {
                $gb = 'MongoDB\Driver\Command';
                try {
                    return $this->_link->executeCommand($l, new$gb($pb));
                } catch (Exception$pc) {
                    $this->error = $pc->getMessage();
                    return
                        array();
                }
            }

            function
            executeBulkWrite($We, $Wa, $Hb)
            {
                try {
                    $Og = $this->_link->executeBulkWrite($We, $Wa);
                    $this->affected_rows = $Og->$Hb();
                    return
                        true;
                } catch (Exception$pc) {
                    $this->error = $pc->getMessage();
                    return
                        false;
                }
            }

            function
            query($G)
            {
                return
                    false;
            }

            function
            select_db($j)
            {
                $this->_db_name = $j;
                return
                    true;
            }

            function
            quote($P)
            {
                return $P;
            }
        }

        class
        Min_Result
        {
            var $num_rows, $_rows = array(), $_offset = 0, $_charset = array();

            function
            __construct($H)
            {
                foreach ($H
                         as $de) {
                    $J = array();
                    foreach ($de
                             as $z => $X) {
                        if (is_a($X, 'MongoDB\BSON\Binary')) $this->_charset[$z] = 63;
                        $J[$z] = (is_a($X, 'MongoDB\BSON\ObjectID') ? 'MongoDB\BSON\ObjectID("' . "$X\")" : (is_a($X, 'MongoDB\BSON\UTCDatetime') ? $X->toDateTime()->format('Y-m-d H:i:s') : (is_a($X, 'MongoDB\BSON\Binary') ? $X->getData() : (is_a($X, 'MongoDB\BSON\Regex') ? "$X" : (is_object($X) || is_array($X) ? json_encode($X, 256) : $X)))));
                    }
                    $this->_rows[] = $J;
                    foreach ($J
                             as $z => $X) {
                        if (!isset($this->_rows[0][$z])) $this->_rows[0][$z] = null;
                    }
                }
                $this->num_rows = count($this->_rows);
            }

            function
            fetch_assoc()
            {
                $J = current($this->_rows);
                if (!$J) return $J;
                $I = array();
                foreach ($this->_rows[0] as $z => $X) $I[$z] = $J[$z];
                next($this->_rows);
                return $I;
            }

            function
            fetch_row()
            {
                $I = $this->fetch_assoc();
                if (!$I) return $I;
                return
                    array_values($I);
            }

            function
            fetch_field()
            {
                $he = array_keys($this->_rows[0]);
                $D = $he[$this->_offset++];
                return (object)array('name' => $D, 'charsetnr' => $this->_charset[$D],);
            }
        }

        class
        Min_Driver
            extends
            Min_SQL
        {
            public $kg = "_id";

            function
            select($Q, $L, $Z, $qd, $zf = array(), $_ = 1, $E = 0, $mg = false)
            {
                global $g;
                $L = ($L == array("*") ? array() : array_fill_keys($L, 1));
                if (count($L) && !isset($L['_id'])) $L['_id'] = 0;
                $Z = where_to_query($Z);
                $uh = array();
                foreach ($zf
                         as $X) {
                    $X = preg_replace('~ DESC$~', '', $X, 1, $Gb);
                    $uh[$X] = ($Gb ? -1 : 1);
                }
                if (isset($_GET['limit']) && is_numeric($_GET['limit']) && $_GET['limit'] > 0) $_ = $_GET['limit'];
                $_ = min(200, max(1, (int)$_));
                $rh = $E * $_;
                $gb = 'MongoDB\Driver\Query';
                try {
                    return
                        new
                        Min_Result($g->_link->executeQuery("$g->_db_name.$Q", new$gb($Z, array('projection' => $L, 'limit' => $_, 'skip' => $rh, 'sort' => $uh))));
                } catch (Exception$pc) {
                    $g->error = $pc->getMessage();
                    return
                        false;
                }
            }

            function
            update($Q, $N, $wg, $_ = 0, $hh = "\n")
            {
                global $g;
                $l = $g->_db_name;
                $Z = sql_query_where_parser($wg);
                $gb = 'MongoDB\Driver\BulkWrite';
                $Wa = new$gb(array());
                if (isset($N['_id'])) unset($N['_id']);
                $Ig = array();
                foreach ($N
                         as $z => $Y) {
                    if ($Y == 'NULL') {
                        $Ig[$z] = 1;
                        unset($N[$z]);
                    }
                }
                $Ii = array('$set' => $N);
                if (count($Ig)) $Ii['$unset'] = $Ig;
                $Wa->update($Z, $Ii, array('upsert' => false));
                return $g->executeBulkWrite("$l.$Q", $Wa, 'getModifiedCount');
            }

            function
            delete($Q, $wg, $_ = 0)
            {
                global $g;
                $l = $g->_db_name;
                $Z = sql_query_where_parser($wg);
                $gb = 'MongoDB\Driver\BulkWrite';
                $Wa = new$gb(array());
                $Wa->delete($Z, array('limit' => $_));
                return $g->executeBulkWrite("$l.$Q", $Wa, 'getDeletedCount');
            }

            function
            insert($Q, $N)
            {
                global $g;
                $l = $g->_db_name;
                $gb = 'MongoDB\Driver\BulkWrite';
                $Wa = new$gb(array());
                if ($N['_id'] == '') unset($N['_id']);
                $Wa->insert($N);
                return $g->executeBulkWrite("$l.$Q", $Wa, 'getInsertedCount');
            }
        }

        function
        get_databases($dd)
        {
            global $g;
            $I = array();
            foreach ($g->executeCommand('admin', array('listDatabases' => 1)) as $Ub) {
                foreach ($Ub->databases
                         as $l) $I[] = $l->name;
            }
            return $I;
        }

        function
        count_tables($k)
        {
            $I = array();
            return $I;
        }

        function
        tables_list()
        {
            global $g;
            $mb = array();
            foreach ($g->executeCommand($g->_db_name, array('listCollections' => 1)) as $H) $mb[$H->name] = 'table';
            return $mb;
        }

        function
        drop_databases($k)
        {
            return
                false;
        }

        function
        indexes($Q, $h = null)
        {
            global $g;
            $I = array();
            foreach ($g->executeCommand($g->_db_name, array('listIndexes' => $Q)) as $w) {
                $cc = array();
                $f = array();
                foreach (get_object_vars($w->key) as $e => $T) {
                    $cc[] = ($T == -1 ? '1' : null);
                    $f[] = $e;
                }
                $I[$w->name] = array("type" => ($w->name == "_id_" ? "PRIMARY" : (isset($w->unique) ? "UNIQUE" : "INDEX")), "columns" => $f, "lengths" => array(), "descs" => $cc,);
            }
            return $I;
        }

        function
        fields($Q)
        {
            global $m;
            $p = fields_from_edit();
            if (!$p) {
                $H = $m->select($Q, array("*"), null, null, array(), 10);
                if ($H) {
                    while ($J = $H->fetch_assoc()) {
                        foreach ($J
                                 as $z => $X) {
                            $J[$z] = null;
                            $p[$z] = array("field" => $z, "type" => "string", "null" => ($z != $m->primary), "auto_increment" => ($z == $m->primary), "privileges" => array("insert" => 1, "select" => 1, "update" => 1,),);
                        }
                    }
                }
            }
            return $p;
        }

        function
        found_rows($R, $Z)
        {
            global $g;
            $Z = where_to_query($Z);
            $mi = $g->executeCommand($g->_db_name, array('count' => $R['Name'], 'query' => $Z))->toArray();
            return $mi[0]->n;
        }

        function
        sql_query_where_parser($wg)
        {
            $wg = preg_replace('~^\sWHERE \(?\(?(.+?)\)?\)?$~', '\1', $wg);
            $ij = explode(' AND ', $wg);
            $jj = explode(') OR (', $wg);
            $Z = array();
            foreach ($ij
                     as $gj) $Z[] = trim($gj);
            if (count($jj) == 1) $jj = array(); elseif (count($jj) > 1) $Z = array();
            return
                where_to_query($Z, $jj);
        }

        function
        where_to_query($ej = array(), $fj = array())
        {
            global $b;
            $Pb = array();
            foreach (array('and' => $ej, 'or' => $fj) as $T => $Z) {
                if (is_array($Z)) {
                    foreach ($Z
                             as $Lc) {
                        list($jb, $sf, $X) = explode(" ", $Lc, 3);
                        if ($jb == "_id" && preg_match('~^(MongoDB\\\\BSON\\\\ObjectID)\("(.+)"\)$~', $X, $C)) {
                            list(, $gb, $X) = $C;
                            $X = new$gb($X);
                        }
                        if (!in_array($sf, $b->operators)) continue;
                        if (preg_match('~^\(f\)(.+)~', $sf, $C)) {
                            $X = (float)$X;
                            $sf = $C[1];
                        } elseif (preg_match('~^\(date\)(.+)~', $sf, $C)) {
                            $Rb = new
                            DateTime($X);
                            $gb = 'MongoDB\BSON\UTCDatetime';
                            $X = new$gb($Rb->getTimestamp() * 1000);
                            $sf = $C[1];
                        }
                        switch ($sf) {
                            case'=':
                                $sf = '$eq';
                                break;
                            case'!=':
                                $sf = '$ne';
                                break;
                            case'>':
                                $sf = '$gt';
                                break;
                            case'<':
                                $sf = '$lt';
                                break;
                            case'>=':
                                $sf = '$gte';
                                break;
                            case'<=':
                                $sf = '$lte';
                                break;
                            case'regex':
                                $sf = '$regex';
                                break;
                            default:
                                continue
                                2;
                        }
                        if ($T == 'and') $Pb['$and'][] = array($jb => array($sf => $X)); elseif ($T == 'or') $Pb['$or'][] = array($jb => array($sf => $X));
                    }
                }
            }
            return $Pb;
        }

        $uf = array("=", "!=", ">", "<", ">=", "<=", "regex", "(f)=", "(f)!=", "(f)>", "(f)<", "(f)>=", "(f)<=", "(date)=", "(date)!=", "(date)>", "(date)<", "(date)>=", "(date)<=",);
    }
    function
    table($v)
    {
        return $v;
    }

    function
    idf_escape($v)
    {
        return $v;
    }

    function
    table_status($D = "", $Sc = false)
    {
        $I = array();
        foreach (tables_list() as $Q => $T) {
            $I[$Q] = array("Name" => $Q);
            if ($D == $Q) return $I[$Q];
        }
        return $I;
    }

    function
    create_database($l, $d)
    {
        return
            true;
    }

    function
    last_id()
    {
        global $g;
        return $g->last_id;
    }

    function
    error()
    {
        global $g;
        return
            h($g->error);
    }

    function
    collations()
    {
        return
            array();
    }

    function
    logged_user()
    {
        global $b;
        $Kb = $b->credentials();
        return $Kb[1];
    }

    function
    connect()
    {
        global $b;
        $g = new
        Min_DB;
        list($M, $V, $F) = $b->credentials();
        $xf = array();
        if ($V . $F != "") {
            $xf["username"] = $V;
            $xf["password"] = $F;
        }
        $l = $b->database();
        if ($l != "") $xf["db"] = $l;
        if (($Ja = getenv("MONGO_AUTH_SOURCE"))) $xf["authSource"] = $Ja;
        $g->connect("mongodb://$M", $xf);
        if ($g->error) return $g->error;
        return $g;
    }

    function
    alter_indexes($Q, $c)
    {
        global $g;
        foreach ($c
                 as $X) {
            list($T, $D, $N) = $X;
            if ($N == "DROP") $I = $g->_db->command(array("deleteIndexes" => $Q, "index" => $D)); else {
                $f = array();
                foreach ($N
                         as $e) {
                    $e = preg_replace('~ DESC$~', '', $e, 1, $Gb);
                    $f[$e] = ($Gb ? -1 : 1);
                }
                $I = $g->_db->selectCollection($Q)->ensureIndex($f, array("unique" => ($T == "UNIQUE"), "name" => $D,));
            }
            if ($I['errmsg']) {
                $g->error = $I['errmsg'];
                return
                    false;
            }
        }
        return
            true;
    }

    function
    support($Tc)
    {
        return
            preg_match("~database|indexes|descidx~", $Tc);
    }

    function
    db_collation($l, $lb)
    {
    }

    function
    information_schema()
    {
    }

    function
    is_view($R)
    {
    }

    function
    convert_field($o)
    {
    }

    function
    unconvert_field($o, $I)
    {
        return $I;
    }

    function
    foreign_keys($Q)
    {
        return
            array();
    }

    function
    fk_support($R)
    {
    }

    function
    engines()
    {
        return
            array();
    }

    function
    alter_table($Q, $D, $p, $fd, $rb, $yc, $d, $Ka, $Tf)
    {
        global $g;
        if ($Q == "") {
            $g->_db->createCollection($D);
            return
                true;
        }
    }

    function
    drop_tables($S)
    {
        global $g;
        foreach ($S
                 as $Q) {
            $Lg = $g->_db->selectCollection($Q)->drop();
            if (!$Lg['ok']) return
                false;
        }
        return
            true;
    }

    function
    truncate_tables($S)
    {
        global $g;
        foreach ($S
                 as $Q) {
            $Lg = $g->_db->selectCollection($Q)->remove();
            if (!$Lg['ok']) return
                false;
        }
        return
            true;
    }

    function
    driver_config()
    {
        global $uf;
        return
            array('possible_drivers' => array("mongo", "mongodb"), 'jush' => "mongo", 'operators' => $uf, 'functions' => array(), 'grouping' => array(), 'edit_functions' => array(array("json")),);
    }
}
$ic["elastic"] = "Elasticsearch (beta)";
if (isset($_GET["elastic"])) {
    define("DRIVER", "elastic");
    if (function_exists('json_decode') && ini_bool('allow_url_fopen')) {
        class
        Min_DB
        {
            var $extension = "JSON", $server_info, $errno, $error, $_url, $_db;

            function
            rootQuery($Xf, $Bb = array(), $Pe = 'GET')
            {
                @ini_set('track_errors', 1);
                $Xc = @file_get_contents("$this->_url/" . ltrim($Xf, '/'), false, stream_context_create(array('http' => array('method' => $Pe, 'content' => $Bb === null ? $Bb : json_encode($Bb), 'header' => 'Content-Type: application/json', 'ignore_errors' => 1,))));
                if (!$Xc) {
                    $this->error = $php_errormsg;
                    return $Xc;
                }
                if (!preg_match('~^HTTP/[0-9.]+ 2~i', $http_response_header[0])) {
                    $this->error = 'Invalid credentials.' . " $http_response_header[0]";
                    return
                        false;
                }
                $I = json_decode($Xc, true);
                if ($I === null) {
                    $this->errno = json_last_error();
                    if (function_exists('json_last_error_msg')) $this->error = json_last_error_msg(); else {
                        $_b = get_defined_constants(true);
                        foreach ($_b['json'] as $D => $Y) {
                            if ($Y == $this->errno && preg_match('~^JSON_ERROR_~', $D)) {
                                $this->error = $D;
                                break;
                            }
                        }
                    }
                }
                return $I;
            }

            function
            query($Xf, $Bb = array(), $Pe = 'GET')
            {
                return $this->rootQuery(($this->_db != "" ? "$this->_db/" : "/") . ltrim($Xf, '/'), $Bb, $Pe);
            }

            function
            connect($M, $V, $F)
            {
                preg_match('~^(https?://)?(.*)~', $M, $C);
                $this->_url = ($C[1] ? $C[1] : "http://") . "$V:$F@$C[2]";
                $I = $this->query('');
                if ($I) $this->server_info = $I['version']['number'];
                return (bool)$I;
            }

            function
            select_db($j)
            {
                $this->_db = $j;
                return
                    true;
            }

            function
            quote($P)
            {
                return $P;
            }
        }

        class
        Min_Result
        {
            var $num_rows, $_rows;

            function
            __construct($K)
            {
                $this->num_rows = count($K);
                $this->_rows = $K;
                reset($this->_rows);
            }

            function
            fetch_assoc()
            {
                $I = current($this->_rows);
                next($this->_rows);
                return $I;
            }

            function
            fetch_row()
            {
                return
                    array_values($this->fetch_assoc());
            }
        }
    }

    class
    Min_Driver
        extends
        Min_SQL
    {
        function
        select($Q, $L, $Z, $qd, $zf = array(), $_ = 1, $E = 0, $mg = false)
        {
            global $b;
            $Pb = array();
            $G = "$Q/_search";
            if ($L != array("*")) $Pb["fields"] = $L;
            if ($zf) {
                $uh = array();
                foreach ($zf
                         as $jb) {
                    $jb = preg_replace('~ DESC$~', '', $jb, 1, $Gb);
                    $uh[] = ($Gb ? array($jb => "desc") : $jb);
                }
                $Pb["sort"] = $uh;
            }
            if ($_) {
                $Pb["size"] = +$_;
                if ($E) $Pb["from"] = ($E * $_);
            }
            foreach ($Z
                     as $X) {
                list($jb, $sf, $X) = explode(" ", $X, 3);
                if ($jb == "_id") $Pb["query"]["ids"]["values"][] = $X; elseif ($jb . $X != "") {
                    $Zh = array("term" => array(($jb != "" ? $jb : "_all") => $X));
                    if ($sf == "=") $Pb["query"]["filtered"]["filter"]["and"][] = $Zh; else$Pb["query"]["filtered"]["query"]["bool"]["must"][] = $Zh;
                }
            }
            if ($Pb["query"] && !$Pb["query"]["filtered"]["query"] && !$Pb["query"]["ids"]) $Pb["query"]["filtered"]["query"] = array("match_all" => array());
            $Ch = microtime(true);
            $bh = $this->_conn->query($G, $Pb);
            if ($mg) echo $b->selectQuery("$G: " . json_encode($Pb), $Ch, !$bh);
            if (!$bh) return
                false;
            $I = array();
            foreach ($bh['hits']['hits'] as $Cd) {
                $J = array();
                if ($L == array("*")) $J["_id"] = $Cd["_id"];
                $p = $Cd['_source'];
                if ($L != array("*")) {
                    $p = array();
                    foreach ($L
                             as $z) $p[$z] = $Cd['fields'][$z];
                }
                foreach ($p
                         as $z => $X) {
                    if ($Pb["fields"]) $X = $X[0];
                    $J[$z] = (is_array($X) ? json_encode($X) : $X);
                }
                $I[] = $J;
            }
            return
                new
                Min_Result($I);
        }

        function
        update($T, $_g, $wg, $_ = 0, $hh = "\n")
        {
            $Vf = preg_split('~ *= *~', $wg);
            if (count($Vf) == 2) {
                $u = trim($Vf[1]);
                $G = "$T/$u";
                return $this->_conn->query($G, $_g, 'POST');
            }
            return
                false;
        }

        function
        insert($T, $_g)
        {
            $u = "";
            $G = "$T/$u";
            $Lg = $this->_conn->query($G, $_g, 'POST');
            $this->_conn->last_id = $Lg['_id'];
            return $Lg['created'];
        }

        function
        delete($T, $wg, $_ = 0)
        {
            $Gd = array();
            if (is_array($_GET["where"]) && $_GET["where"]["_id"]) $Gd[] = $_GET["where"]["_id"];
            if (is_array($_POST['check'])) {
                foreach ($_POST['check'] as $ab) {
                    $Vf = preg_split('~ *= *~', $ab);
                    if (count($Vf) == 2) $Gd[] = trim($Vf[1]);
                }
            }
            $this->_conn->affected_rows = 0;
            foreach ($Gd
                     as $u) {
                $G = "{$T}/{$u}";
                $Lg = $this->_conn->query($G, '{}', 'DELETE');
                if (is_array($Lg) && $Lg['found'] == true) $this->_conn->affected_rows++;
            }
            return $this->_conn->affected_rows;
        }
    }

    function
    connect()
    {
        global $b;
        $g = new
        Min_DB;
        list($M, $V, $F) = $b->credentials();
        if ($F != "" && $g->connect($M, $V, "")) return 'Database does not support password.';
        if ($g->connect($M, $V, $F)) return $g;
        return $g->error;
    }

    function
    support($Tc)
    {
        return
            preg_match("~database|table|columns~", $Tc);
    }

    function
    logged_user()
    {
        global $b;
        $Kb = $b->credentials();
        return $Kb[1];
    }

    function
    get_databases()
    {
        global $g;
        $I = $g->rootQuery('_aliases');
        if ($I) {
            $I = array_keys($I);
            sort($I, SORT_STRING);
        }
        return $I;
    }

    function
    collations()
    {
        return
            array();
    }

    function
    db_collation($l, $lb)
    {
    }

    function
    engines()
    {
        return
            array();
    }

    function
    count_tables($k)
    {
        global $g;
        $I = array();
        $H = $g->query('_stats');
        if ($H && $H['indices']) {
            $Od = $H['indices'];
            foreach ($Od
                     as $Nd => $Dh) {
                $Md = $Dh['total']['indexing'];
                $I[$Nd] = $Md['index_total'];
            }
        }
        return $I;
    }

    function
    tables_list()
    {
        global $g;
        if (min_version(6)) return
            array('_doc' => 'table');
        $I = $g->query('_mapping');
        if ($I) $I = array_fill_keys(array_keys($I[$g->_db]["mappings"]), 'table');
        return $I;
    }

    function
    table_status($D = "", $Sc = false)
    {
        global $g;
        $bh = $g->query("_search", array("size" => 0, "aggregations" => array("count_by_type" => array("terms" => array("field" => "_type")))), "POST");
        $I = array();
        if ($bh) {
            $S = $bh["aggregations"]["count_by_type"]["buckets"];
            foreach ($S
                     as $Q) {
                $I[$Q["key"]] = array("Name" => $Q["key"], "Engine" => "table", "Rows" => $Q["doc_count"],);
                if ($D != "" && $D == $Q["key"]) return $I[$D];
            }
        }
        return $I;
    }

    function
    error()
    {
        global $g;
        return
            h($g->error);
    }

    function
    information_schema()
    {
    }

    function
    is_view($R)
    {
    }

    function
    indexes($Q, $h = null)
    {
        return
            array(array("type" => "PRIMARY", "columns" => array("_id")),);
    }

    function
    fields($Q)
    {
        global $g;
        $ze = array();
        if (min_version(6)) {
            $H = $g->query("_mapping");
            if ($H) $ze = $H[$g->_db]['mappings']['properties'];
        } else {
            $H = $g->query("$Q/_mapping");
            if ($H) {
                $ze = $H[$Q]['properties'];
                if (!$ze) $ze = $H[$g->_db]['mappings'][$Q]['properties'];
            }
        }
        $I = array();
        if ($ze) {
            foreach ($ze
                     as $D => $o) {
                $I[$D] = array("field" => $D, "full_type" => $o["type"], "type" => $o["type"], "privileges" => array("insert" => 1, "select" => 1, "update" => 1),);
                if ($o["properties"]) {
                    unset($I[$D]["privileges"]["insert"]);
                    unset($I[$D]["privileges"]["update"]);
                }
            }
        }
        return $I;
    }

    function
    foreign_keys($Q)
    {
        return
            array();
    }

    function
    table($v)
    {
        return $v;
    }

    function
    idf_escape($v)
    {
        return $v;
    }

    function
    convert_field($o)
    {
    }

    function
    unconvert_field($o, $I)
    {
        return $I;
    }

    function
    fk_support($R)
    {
    }

    function
    found_rows($R, $Z)
    {
        return
            null;
    }

    function
    create_database($l)
    {
        global $g;
        return $g->rootQuery(urlencode($l), null, 'PUT');
    }

    function
    drop_databases($k)
    {
        global $g;
        return $g->rootQuery(urlencode(implode(',', $k)), array(), 'DELETE');
    }

    function
    alter_table($Q, $D, $p, $fd, $rb, $yc, $d, $Ka, $Tf)
    {
        global $g;
        $sg = array();
        foreach ($p
                 as $Qc) {
            $Vc = trim($Qc[1][0]);
            $Wc = trim($Qc[1][1] ? $Qc[1][1] : "text");
            $sg[$Vc] = array('type' => $Wc);
        }
        if (!empty($sg)) $sg = array('properties' => $sg);
        return $g->query("_mapping/{$D}", $sg, 'PUT');
    }

    function
    drop_tables($S)
    {
        global $g;
        $I = true;
        foreach ($S
                 as $Q) $I = $I && $g->query(urlencode($Q), array(), 'DELETE');
        return $I;
    }

    function
    last_id()
    {
        global $g;
        return $g->last_id;
    }

    function
    driver_config()
    {
        $U = array();
        $Gh = array();
        foreach (array('Numbers' => array("long" => 3, "integer" => 5, "short" => 8, "byte" => 10, "double" => 20, "float" => 66, "half_float" => 12, "scaled_float" => 21), 'Date and time' => array("date" => 10), 'Strings' => array("string" => 65535, "text" => 65535), 'Binary' => array("binary" => 255),) as $z => $X) {
            $U += $X;
            $Gh[$z] = array_keys($X);
        }
        return
            array('possible_drivers' => array("json + allow_url_fopen"), 'jush' => "elastic", 'operators' => array("=", "query"), 'functions' => array(), 'grouping' => array(), 'edit_functions' => array(array("json")), 'types' => $U, 'structured_types' => $Gh,);
    }
}

class
Adminer
{
    var $operators;

    function
    name()
    {
        return "<a href='https://www.adminer.org/'" . target_blank() . " id='h1'>Adminer</a>";
    }

    function
    credentials()
    {
        return
            array(SERVER, $_GET["username"], get_password());
    }

    function
    connectSsl()
    {
    }

    function
    permanentLogin($i = false)
    {
        return
            password_file($i);
    }

    function
    bruteForceKey()
    {
        return $_SERVER["REMOTE_ADDR"];
    }

    function
    serverName($M)
    {
        return
            h($M);
    }

    function
    database()
    {
        return
            DB;
    }

    function
    databases($dd = true)
    {
        return
            get_databases($dd);
    }

    function
    schemas()
    {
        return
            schemas();
    }

    function
    queryTimeout()
    {
        return
            2;
    }

    function
    headers()
    {
    }

    function
    csp()
    {
        return
            csp();
    }

    function
    head()
    {
        return
            true;
    }

    function
    css()
    {
        $I = array();
        $q = "adminer.css";
        if (file_exists($q)) $I[] = "$q?v=" . crc32(file_get_contents($q));
        return $I;
    }

    function
    loginForm()
    {
        global $ic;
        echo "<table cellspacing='0' class='layout'>\n", $this->loginFormField('driver', '<tr><th>' . 'System' . '<td>', html_select("auth[driver]", $ic, DRIVER, "loginDriver(this);") . "\n"), $this->loginFormField('server', '<tr><th>' . 'Server' . '<td>', '<input name="auth[server]" value="' . h(SERVER) . '" title="hostname[:port]" placeholder="localhost" autocapitalize="off">' . "\n"), $this->loginFormField('username', '<tr><th>' . 'Username' . '<td>', '<input name="auth[username]" id="username" value="' . h($_GET["username"]) . '" autocomplete="username" autocapitalize="off">' . script("focus(qs('#username')); qs('#username').form['auth[driver]'].onchange();")), $this->loginFormField('password', '<tr><th>' . 'Password' . '<td>', '<input type="password" name="auth[password]" autocomplete="current-password">' . "\n"), $this->loginFormField('db', '<tr><th>' . 'Database' . '<td>', '<input name="auth[db]" value="' . h($_GET["db"]) . '" autocapitalize="off">' . "\n"), "</table>\n", "<p><input type='submit' value='" . 'Login' . "'>\n", checkbox("auth[permanent]", 1, $_COOKIE["adminer_permanent"], 'Permanent login') . "\n";
    }

    function
    loginFormField($D, $_d, $Y)
    {
        return $_d . $Y;
    }

    function
    login($xe, $F)
    {
        if ($F == "") return
            sprintf('Adminer does not support accessing a database without a password, <a href="https://www.adminer.org/en/password/"%s>more information</a>.', target_blank());
        return
            true;
    }

    function
    tableName($Nh)
    {
        return
            h($Nh["Name"]);
    }

    function
    fieldName($o, $zf = 0)
    {
        return '<span title="' . h($o["full_type"]) . '">' . h($o["field"]) . '</span>';
    }

    function
    selectLinks($Nh, $N = "")
    {
        global $y, $m;
        echo '<p class="links">';
        $we = array("select" => 'Select data');
        if (support("table") || support("indexes")) $we["table"] = 'Show structure';
        if (support("table")) {
            if (is_view($Nh)) $we["view"] = 'Alter view'; else$we["create"] = 'Alter table';
        }
        if ($N !== null) $we["edit"] = 'New item';
        $D = $Nh["Name"];
        foreach ($we
                 as $z => $X) echo " <a href='" . h(ME) . "$z=" . urlencode($D) . ($z == "edit" ? $N : "") . "'" . bold(isset($_GET[$z])) . ">$X</a>";
        echo
        doc_link(array($y => $m->tableHelp($D)), "?"), "\n";
    }

    function
    foreignKeys($Q)
    {
        return
            foreign_keys($Q);
    }

    function
    backwardKeys($Q, $Mh)
    {
        return
            array();
    }

    function
    backwardKeysPrint($Na, $J)
    {
    }

    function
    selectQuery($G, $Ch, $Rc = false)
    {
        global $y, $m;
        $I = "</p>\n";
        if (!$Rc && ($bj = $m->warnings())) {
            $u = "warnings";
            $I = ", <a href='#$u'>" . 'Warnings' . "</a>" . script("qsl('a').onclick = partial(toggle, '$u');", "") . "$I<div id='$u' class='hidden'>\n$bj</div>\n";
        }
        return "<p><code class='jush-$y'>" . h(str_replace("\n", " ", $G)) . "</code> <span class='time'>(" . format_time($Ch) . ")</span>" . (support("sql") ? " <a href='" . h(ME) . "sql=" . urlencode($G) . "'>" . 'Edit' . "</a>" : "") . $I;
    }

    function
    sqlCommandQuery($G)
    {
        return
            shorten_utf8(trim($G), 1000);
    }

    function
    rowDescription($Q)
    {
        return "";
    }

    function
    rowDescriptions($K, $gd)
    {
        return $K;
    }

    function
    selectLink($X, $o)
    {
    }

    function
    selectVal($X, $A, $o, $Gf)
    {
        $I = ($X === null ? "<i>NULL</i>" : (preg_match("~char|binary|boolean~", $o["type"]) && !preg_match("~var~", $o["type"]) ? "<code>$X</code>" : $X));
        if (preg_match('~blob|bytea|raw|file~', $o["type"]) && !is_utf8($X)) $I = "<i>" . lang(array('%d byte', '%d bytes'), strlen($Gf)) . "</i>";
        if (preg_match('~json~', $o["type"])) $I = "<code class='jush-js'>$I</code>";
        return ($A ? "<a href='" . h($A) . "'" . (is_url($A) ? target_blank() : "") . ">$I</a>" : $I);
    }

    function
    editVal($X, $o)
    {
        return $X;
    }

    function
    tableStructurePrint($p)
    {
        echo "<div class='scrollable'>\n", "<table cellspacing='0' class='nowrap'>\n", "<thead><tr><th>" . 'Column' . "<td>" . 'Type' . (support("comment") ? "<td>" . 'Comment' : "") . "</thead>\n";
        foreach ($p
                 as $o) {
            echo "<tr" . odd() . "><th>" . h($o["field"]), "<td><span title='" . h($o["collation"]) . "'>" . h($o["full_type"]) . "</span>", ($o["null"] ? " <i>NULL</i>" : ""), ($o["auto_increment"] ? " <i>" . 'Auto Increment' . "</i>" : ""), (isset($o["default"]) ? " <span title='" . 'Default value' . "'>[<b>" . h($o["default"]) . "</b>]</span>" : ""), (support("comment") ? "<td>" . h($o["comment"]) : ""), "\n";
        }
        echo "</table>\n", "</div>\n";
    }

    function
    tableIndexesPrint($x)
    {
        echo "<table cellspacing='0'>\n";
        foreach ($x
                 as $D => $w) {
            ksort($w["columns"]);
            $mg = array();
            foreach ($w["columns"] as $z => $X) $mg[] = "<i>" . h($X) . "</i>" . ($w["lengths"][$z] ? "(" . $w["lengths"][$z] . ")" : "") . ($w["descs"][$z] ? " DESC" : "");
            echo "<tr title='" . h($D) . "'><th>$w[type]<td>" . implode(", ", $mg) . "\n";
        }
        echo "</table>\n";
    }

    function
    selectColumnsPrint($L, $f)
    {
        global $nd, $td;
        print_fieldset("select", 'Select', $L);
        $t = 0;
        $L[""] = array();
        foreach ($L
                 as $z => $X) {
            $X = $_GET["columns"][$z];
            $e = select_input(" name='columns[$t][col]'", $f, $X["col"], ($z !== "" ? "selectFieldChange" : "selectAddRow"));
            echo "<div>" . ($nd || $td ? "<select name='columns[$t][fun]'>" . optionlist(array(-1 => "") + array_filter(array('Functions' => $nd, 'Aggregation' => $td)), $X["fun"]) . "</select>" . on_help("getTarget(event).value && getTarget(event).value.replace(/ |\$/, '(') + ')'", 1) . script("qsl('select').onchange = function () { helpClose();" . ($z !== "" ? "" : " qsl('select, input', this.parentNode).onchange();") . " };", "") . "($e)" : $e) . "</div>\n";
            $t++;
        }
        echo "</div></fieldset>\n";
    }

    function
    selectSearchPrint($Z, $f, $x)
    {
        print_fieldset("search", 'Search', $Z);
        foreach ($x
                 as $t => $w) {
            if ($w["type"] == "FULLTEXT") {
                echo "<div>(<i>" . implode("</i>, <i>", array_map('h', $w["columns"])) . "</i>) AGAINST", " <input type='search' name='fulltext[$t]' value='" . h($_GET["fulltext"][$t]) . "'>", script("qsl('input').oninput = selectFieldChange;", ""), checkbox("boolean[$t]", 1, isset($_GET["boolean"][$t]), "BOOL"), "</div>\n";
            }
        }
        $Ya = "this.parentNode.firstChild.onchange();";
        foreach (array_merge((array)$_GET["where"], array(array())) as $t => $X) {
            if (!$X || ("$X[col]$X[val]" != "" && in_array($X["op"], $this->operators))) {
                echo "<div>" . select_input(" name='where[$t][col]'", $f, $X["col"], ($X ? "selectFieldChange" : "selectAddRow"), "(" . 'anywhere' . ")"), html_select("where[$t][op]", $this->operators, $X["op"], $Ya), "<input type='search' name='where[$t][val]' value='" . h($X["val"]) . "'>", script("mixin(qsl('input'), {oninput: function () { $Ya }, onkeydown: selectSearchKeydown, onsearch: selectSearchSearch});", ""), "</div>\n";
            }
        }
        echo "</div></fieldset>\n";
    }

    function
    selectOrderPrint($zf, $f, $x)
    {
        print_fieldset("sort", 'Sort', $zf);
        $t = 0;
        foreach ((array)$_GET["order"] as $z => $X) {
            if ($X != "") {
                echo "<div>" . select_input(" name='order[$t]'", $f, $X, "selectFieldChange"), checkbox("desc[$t]", 1, isset($_GET["desc"][$z]), 'descending') . "</div>\n";
                $t++;
            }
        }
        echo "<div>" . select_input(" name='order[$t]'", $f, "", "selectAddRow"), checkbox("desc[$t]", 1, false, 'descending') . "</div>\n", "</div></fieldset>\n";
    }

    function
    selectLimitPrint($_)
    {
        echo "<fieldset><legend>" . 'Limit' . "</legend><div>";
        echo "<input type='number' name='limit' class='size' value='" . h($_) . "'>", script("qsl('input').oninput = selectFieldChange;", ""), "</div></fieldset>\n";
    }

    function
    selectLengthPrint($ci)
    {
        if ($ci !== null) {
            echo "<fieldset><legend>" . 'Text length' . "</legend><div>", "<input type='number' name='text_length' class='size' value='" . h($ci) . "'>", "</div></fieldset>\n";
        }
    }

    function
    selectActionPrint($x)
    {
        echo "<fieldset><legend>" . 'Action' . "</legend><div>", "<input type='submit' value='" . 'Select' . "'>", " <span id='noindex' title='" . 'Full table scan' . "'></span>", "<script" . nonce() . ">\n", "var indexColumns = ";
        $f = array();
        foreach ($x
                 as $w) {
            $Ob = reset($w["columns"]);
            if ($w["type"] != "FULLTEXT" && $Ob) $f[$Ob] = 1;
        }
        $f[""] = 1;
        foreach ($f
                 as $z => $X) json_row($z);
        echo ";\n", "selectFieldChange.call(qs('#form')['select']);\n", "</script>\n", "</div></fieldset>\n";
    }

    function
    selectCommandPrint()
    {
        return !information_schema(DB);
    }

    function
    selectImportPrint()
    {
        return !information_schema(DB);
    }

    function
    selectEmailPrint($vc, $f)
    {
    }

    function
    selectColumnsProcess($f, $x)
    {
        global $nd, $td;
        $L = array();
        $qd = array();
        foreach ((array)$_GET["columns"] as $z => $X) {
            if ($X["fun"] == "count" || ($X["col"] != "" && (!$X["fun"] || in_array($X["fun"], $nd) || in_array($X["fun"], $td)))) {
                $L[$z] = apply_sql_function($X["fun"], ($X["col"] != "" ? idf_escape($X["col"]) : "*"));
                if (!in_array($X["fun"], $td)) $qd[] = $L[$z];
            }
        }
        return
            array($L, $qd);
    }

    function
    selectSearchProcess($p, $x)
    {
        global $g, $m;
        $I = array();
        foreach ($x
                 as $t => $w) {
            if ($w["type"] == "FULLTEXT" && $_GET["fulltext"][$t] != "") $I[] = "MATCH (" . implode(", ", array_map('idf_escape', $w["columns"])) . ") AGAINST (" . q($_GET["fulltext"][$t]) . (isset($_GET["boolean"][$t]) ? " IN BOOLEAN MODE" : "") . ")";
        }
        foreach ((array)$_GET["where"] as $z => $X) {
            if ("$X[col]$X[val]" != "" && in_array($X["op"], $this->operators)) {
                $ig = "";
                $ub = " $X[op]";
                if (preg_match('~IN$~', $X["op"])) {
                    $Jd = process_length($X["val"]);
                    $ub .= " " . ($Jd != "" ? $Jd : "(NULL)");
                } elseif ($X["op"] == "SQL") $ub = " $X[val]";
                elseif ($X["op"] == "LIKE %%") $ub = " LIKE " . $this->processInput($p[$X["col"]], "%$X[val]%");
                elseif ($X["op"] == "ILIKE %%") $ub = " ILIKE " . $this->processInput($p[$X["col"]], "%$X[val]%");
                elseif ($X["op"] == "FIND_IN_SET") {
                    $ig = "$X[op](" . q($X["val"]) . ", ";
                    $ub = ")";
                } elseif (!preg_match('~NULL$~', $X["op"])) $ub .= " " . $this->processInput($p[$X["col"]], $X["val"]);
                if ($X["col"] != "") $I[] = $ig . $m->convertSearch(idf_escape($X["col"]), $X, $p[$X["col"]]) . $ub; else {
                    $nb = array();
                    foreach ($p
                             as $D => $o) {
                        if ((preg_match('~^[-\d.' . (preg_match('~IN$~', $X["op"]) ? ',' : '') . ']+$~', $X["val"]) || !preg_match('~' . number_type() . '|bit~', $o["type"])) && (!preg_match("~[\x80-\xFF]~", $X["val"]) || preg_match('~char|text|enum|set~', $o["type"])) && (!preg_match('~date|timestamp~', $o["type"]) || preg_match('~^\d+-\d+-\d+~', $X["val"]))) $nb[] = $ig . $m->convertSearch(idf_escape($D), $X, $o) . $ub;
                    }
                    $I[] = ($nb ? "(" . implode(" OR ", $nb) . ")" : "1 = 0");
                }
            }
        }
        return $I;
    }

    function
    selectOrderProcess($p, $x)
    {
        $I = array();
        foreach ((array)$_GET["order"] as $z => $X) {
            if ($X != "") $I[] = (preg_match('~^((COUNT\(DISTINCT |[A-Z0-9_]+\()(`(?:[^`]|``)+`|"(?:[^"]|"")+")\)|COUNT\(\*\))$~', $X) ? $X : idf_escape($X)) . (isset($_GET["desc"][$z]) ? " DESC" : "");
        }
        return $I;
    }

    function
    selectLimitProcess()
    {
        return (isset($_GET["limit"]) ? $_GET["limit"] : "50");
    }

    function
    selectLengthProcess()
    {
        return (isset($_GET["text_length"]) ? $_GET["text_length"] : "100");
    }

    function
    selectEmailProcess($Z, $gd)
    {
        return
            false;
    }

    function
    selectQueryBuild($L, $Z, $qd, $zf, $_, $E)
    {
        return "";
    }

    function
    messageQuery($G, $di, $Rc = false)
    {
        global $y, $m;
        restart_session();
        $Ad =& get_session("queries");
        if (!$Ad[$_GET["db"]]) $Ad[$_GET["db"]] = array();
        if (strlen($G) > 1e6) $G = preg_replace('~[\x80-\xFF]+$~', '', substr($G, 0, 1e6)) . "\nâ€¦";
        $Ad[$_GET["db"]][] = array($G, time(), $di);
        $_h = "sql-" . count($Ad[$_GET["db"]]);
        $I = "<a href='#$_h' class='toggle'>" . 'SQL command' . "</a>\n";
        if (!$Rc && ($bj = $m->warnings())) {
            $u = "warnings-" . count($Ad[$_GET["db"]]);
            $I = "<a href='#$u' class='toggle'>" . 'Warnings' . "</a>, $I<div id='$u' class='hidden'>\n$bj</div>\n";
        }
        return " <span class='time'>" . @date("H:i:s") . "</span>" . " $I<div id='$_h' class='hidden'><pre><code class='jush-$y'>" . shorten_utf8($G, 1000) . "</code></pre>" . ($di ? " <span class='time'>($di)</span>" : '') . (support("sql") ? '<p><a href="' . h(str_replace("db=" . urlencode(DB), "db=" . urlencode($_GET["db"]), ME) . 'sql=&history=' . (count($Ad[$_GET["db"]]) - 1)) . '">' . 'Edit' . '</a>' : '') . '</div>';
    }

    function
    editRowPrint($Q, $p, $J, $Ii)
    {
    }

    function
    editFunctions($o)
    {
        global $qc;
        $I = ($o["null"] ? "NULL/" : "");
        $Ii = isset($_GET["select"]) || where($_GET);
        foreach ($qc
                 as $z => $nd) {
            if (!$z || (!isset($_GET["call"]) && $Ii)) {
                foreach ($nd
                         as $Zf => $X) {
                    if (!$Zf || preg_match("~$Zf~", $o["type"])) $I .= "/$X";
                }
            }
            if ($z && !preg_match('~set|blob|bytea|raw|file|bool~', $o["type"])) $I .= "/SQL";
        }
        if ($o["auto_increment"] && !$Ii) $I = 'Auto Increment';
        return
            explode("/", $I);
    }

    function
    editInput($Q, $o, $Ha, $Y)
    {
        if ($o["type"] == "enum") return (isset($_GET["select"]) ? "<label><input type='radio'$Ha value='-1' checked><i>" . 'original' . "</i></label> " : "") . ($o["null"] ? "<label><input type='radio'$Ha value=''" . ($Y !== null || isset($_GET["select"]) ? "" : " checked") . "><i>NULL</i></label> " : "") . enum_input("radio", $Ha, $o, $Y, 0);
        return "";
    }

    function
    editHint($Q, $o, $Y)
    {
        return "";
    }

    function
    processInput($o, $Y, $s = "")
    {
        if ($s == "SQL") return $Y;
        $D = $o["field"];
        $I = q($Y);
        if (preg_match('~^(now|getdate|uuid)$~', $s)) $I = "$s()"; elseif (preg_match('~^current_(date|timestamp)$~', $s)) $I = $s;
        elseif (preg_match('~^([+-]|\|\|)$~', $s)) $I = idf_escape($D) . " $s $I";
        elseif (preg_match('~^[+-] interval$~', $s)) $I = idf_escape($D) . " $s " . (preg_match("~^(\\d+|'[0-9.: -]') [A-Z_]+\$~i", $Y) ? $Y : $I);
        elseif (preg_match('~^(addtime|subtime|concat)$~', $s)) $I = "$s(" . idf_escape($D) . ", $I)";
        elseif (preg_match('~^(md5|sha1|password|encrypt)$~', $s)) $I = "$s($I)";
        return
            unconvert_field($o, $I);
    }

    function
    dumpOutput()
    {
        $I = array('text' => 'open', 'file' => 'save');
        if (function_exists('gzencode')) $I['gz'] = 'gzip';
        return $I;
    }

    function
    dumpFormat()
    {
        return
            array('sql' => 'SQL', 'csv' => 'CSV,', 'csv;' => 'CSV;', 'tsv' => 'TSV');
    }

    function
    dumpDatabase($l)
    {
    }

    function
    dumpTable($Q, $Hh, $ce = 0)
    {
        if ($_POST["format"] != "sql") {
            echo "\xef\xbb\xbf";
            if ($Hh) dump_csv(array_keys(fields($Q)));
        } else {
            if ($ce == 2) {
                $p = array();
                foreach (fields($Q) as $D => $o) $p[] = idf_escape($D) . " $o[full_type]";
                $i = "CREATE TABLE " . table($Q) . " (" . implode(", ", $p) . ")";
            } else$i = create_sql($Q, $_POST["auto_increment"], $Hh);
            set_utf8mb4($i);
            if ($Hh && $i) {
                if ($Hh == "DROP+CREATE" || $ce == 1) echo "DROP " . ($ce == 2 ? "VIEW" : "TABLE") . " IF EXISTS " . table($Q) . ";\n";
                if ($ce == 1) $i = remove_definer($i);
                echo "$i;\n\n";
            }
        }
    }

    function
    dumpData($Q, $Hh, $G)
    {
        global $g, $y;
        $Ee = ($y == "sqlite" ? 0 : 1048576);
        if ($Hh) {
            if ($_POST["format"] == "sql") {
                if ($Hh == "TRUNCATE+INSERT") echo
                    truncate_sql($Q) . ";\n";
                $p = fields($Q);
            }
            $H = $g->query($G, 1);
            if ($H) {
                $Vd = "";
                $Va = "";
                $he = array();
                $Jh = "";
                $Uc = ($Q != '' ? 'fetch_assoc' : 'fetch_row');
                while ($J = $H->$Uc()) {
                    if (!$he) {
                        $Ti = array();
                        foreach ($J
                                 as $X) {
                            $o = $H->fetch_field();
                            $he[] = $o->name;
                            $z = idf_escape($o->name);
                            $Ti[] = "$z = VALUES($z)";
                        }
                        $Jh = ($Hh == "INSERT+UPDATE" ? "\nON DUPLICATE KEY UPDATE " . implode(", ", $Ti) : "") . ";\n";
                    }
                    if ($_POST["format"] != "sql") {
                        if ($Hh == "table") {
                            dump_csv($he);
                            $Hh = "INSERT";
                        }
                        dump_csv($J);
                    } else {
                        if (!$Vd) $Vd = "INSERT INTO " . table($Q) . " (" . implode(", ", array_map('idf_escape', $he)) . ") VALUES";
                        foreach ($J
                                 as $z => $X) {
                            $o = $p[$z];
                            $J[$z] = ($X !== null ? unconvert_field($o, preg_match(number_type(), $o["type"]) && !preg_match('~\[~', $o["full_type"]) && is_numeric($X) ? $X : q(($X === false ? 0 : $X))) : "NULL");
                        }
                        $Xg = ($Ee ? "\n" : " ") . "(" . implode(",\t", $J) . ")";
                        if (!$Va) $Va = $Vd . $Xg; elseif (strlen($Va) + 4 + strlen($Xg) + strlen($Jh) < $Ee) $Va .= ",$Xg";
                        else {
                            echo $Va . $Jh;
                            $Va = $Vd . $Xg;
                        }
                    }
                }
                if ($Va) echo $Va . $Jh;
            } elseif ($_POST["format"] == "sql") echo "-- " . str_replace("\n", " ", $g->error) . "\n";
        }
    }

    function
    dumpFilename($Fd)
    {
        return
            friendly_url($Fd != "" ? $Fd : (SERVER != "" ? SERVER : "localhost"));
    }

    function
    dumpHeaders($Fd, $Se = false)
    {
        $Jf = $_POST["output"];
        $Mc = (preg_match('~sql~', $_POST["format"]) ? "sql" : ($Se ? "tar" : "csv"));
        header("Content-Type: " . ($Jf == "gz" ? "application/x-gzip" : ($Mc == "tar" ? "application/x-tar" : ($Mc == "sql" || $Jf != "file" ? "text/plain" : "text/csv") . "; charset=utf-8")));
        if ($Jf == "gz") ob_start('ob_gzencode', 1e6);
        return $Mc;
    }

    function
    importServerPath()
    {
        return "adminer.sql";
    }

    function
    homepage()
    {
        echo '<p class="links">' . ($_GET["ns"] == "" && support("database") ? '<a href="' . h(ME) . 'database=">' . 'Alter database' . "</a>\n" : ""), (support("scheme") ? "<a href='" . h(ME) . "scheme='>" . ($_GET["ns"] != "" ? 'Alter schema' : 'Create schema') . "</a>\n" : ""), ($_GET["ns"] !== "" ? '<a href="' . h(ME) . 'schema=">' . 'Database schema' . "</a>\n" : ""), (support("privileges") ? "<a href='" . h(ME) . "privileges='>" . 'Privileges' . "</a>\n" : "");
        return
            true;
    }

    function
    navigation($Re)
    {
        global $ia, $y, $ic, $g;
        echo '<h1>
', $this->name(), ' <span class="version">', $ia, '</span>
<a href="https://www.adminer.org/#download"', target_blank(), ' id="version">', (version_compare($ia, $_COOKIE["adminer_version"]) < 0 ? h($_COOKIE["adminer_version"]) : ""), '</a>
</h1>
';
        if ($Re == "auth") {
            $Jf = "";
            foreach ((array)$_SESSION["pwds"] as $Vi => $lh) {
                foreach ($lh
                         as $M => $Qi) {
                    foreach ($Qi
                             as $V => $F) {
                        if ($F !== null) {
                            $Ub = $_SESSION["db"][$Vi][$M][$V];
                            foreach (($Ub ? array_keys($Ub) : array("")) as $l) $Jf .= "<li><a href='" . h(auth_url($Vi, $M, $V, $l)) . "'>($ic[$Vi]) " . h($V . ($M != "" ? "@" . $this->serverName($M) : "") . ($l != "" ? " - $l" : "")) . "</a>\n";
                        }
                    }
                }
            }
            if ($Jf) echo "<ul id='logins'>\n$Jf</ul>\n" . script("mixin(qs('#logins'), {onmouseover: menuOver, onmouseout: menuOut});");
        } else {
            $S = array();
            if ($_GET["ns"] !== "" && !$Re && DB != "") {
                $g->select_db(DB);
                $S = table_status('', true);
            }
            echo
            script_src(preg_replace("~\\?.*~", "", ME) . "?file=jush.js&version=4.8.1");
            if (support("sql")) {
                echo '<script', nonce(), '>
';
                if ($S) {
                    $we = array();
                    foreach ($S
                             as $Q => $T) $we[] = preg_quote($Q, '/');
                    echo "var jushLinks = { $y: [ '" . js_escape(ME) . (support("table") ? "table=" : "select=") . "\$&', /\\b(" . implode("|", $we) . ")\\b/g ] };\n";
                    foreach (array("bac", "bra", "sqlite_quo", "mssql_bra") as $X) echo "jushLinks.$X = jushLinks.$y;\n";
                }
                $kh = $g->server_info;
                echo 'bodyLoad(\'', (is_object($g) ? preg_replace('~^(\d\.?\d).*~s', '\1', $kh) : ""), '\'', (preg_match('~MariaDB~', $kh) ? ", true" : ""), ');
</script>
';
            }
            $this->databasesPrint($Re);
            if (DB == "" || !$Re) {
                echo "<p class='links'>" . (support("sql") ? "<a href='" . h(ME) . "sql='" . bold(isset($_GET["sql"]) && !isset($_GET["import"])) . ">" . 'SQL command' . "</a>\n<a href='" . h(ME) . "import='" . bold(isset($_GET["import"])) . ">" . 'Import' . "</a>\n" : "") . "";
                if (support("dump")) echo "<a href='" . h(ME) . "dump=" . urlencode(isset($_GET["table"]) ? $_GET["table"] : $_GET["select"]) . "' id='dump'" . bold(isset($_GET["dump"])) . ">" . 'Export' . "</a>\n";
            }
            if ($_GET["ns"] !== "" && !$Re && DB != "") {
                echo '<a href="' . h(ME) . 'create="' . bold($_GET["create"] === "") . ">" . 'Create table' . "</a>\n";
                if (!$S) echo "<p class='message'>" . 'No tables.' . "\n"; else$this->tablesPrint($S);
            }
        }
    }

    function
    databasesPrint($Re)
    {
        global $b, $g;
        $k = $this->databases();
        if (DB && $k && !in_array(DB, $k)) array_unshift($k, DB);
        echo '<form action="">
<p id="dbs">
';
        hidden_fields_get();
        $Sb = script("mixin(qsl('select'), {onmousedown: dbMouseDown, onchange: dbChange});");
        echo "<span title='" . 'database' . "'>" . 'DB' . "</span>: " . ($k ? "<select name='db'>" . optionlist(array("" => "") + $k, DB) . "</select>$Sb" : "<input name='db' value='" . h(DB) . "' autocapitalize='off'>\n"), "<input type='submit' value='" . 'Use' . "'" . ($k ? " class='hidden'" : "") . ">\n";
        if (support("scheme")) {
            if ($Re != "db" && DB != "" && $g->select_db(DB)) {
                echo "<br>" . 'Schema' . ": <select name='ns'>" . optionlist(array("" => "") + $b->schemas(), $_GET["ns"]) . "</select>$Sb";
                if ($_GET["ns"] != "") set_schema($_GET["ns"]);
            }
        }
        foreach (array("import", "sql", "schema", "dump", "privileges") as $X) {
            if (isset($_GET[$X])) {
                echo "<input type='hidden' name='$X' value=''>";
                break;
            }
        }
        echo "</p></form>\n";
    }

    function
    tablesPrint($S)
    {
        echo "<ul id='tables'>" . script("mixin(qs('#tables'), {onmouseover: menuOver, onmouseout: menuOut});");
        foreach ($S
                 as $Q => $O) {
            $D = $this->tableName($O);
            if ($D != "") {
                echo '<li><a href="' . h(ME) . 'select=' . urlencode($Q) . '"' . bold($_GET["select"] == $Q || $_GET["edit"] == $Q, "select") . " title='" . 'Select data' . "'>" . 'select' . "</a> ", (support("table") || support("indexes") ? '<a href="' . h(ME) . 'table=' . urlencode($Q) . '"' . bold(in_array($Q, array($_GET["table"], $_GET["create"], $_GET["indexes"], $_GET["foreign"], $_GET["trigger"])), (is_view($O) ? "view" : "structure")) . " title='" . 'Show structure' . "'>$D</a>" : "<span>$D</span>") . "\n";
            }
        }
        echo "</ul>\n";
    }
}

$b = (function_exists('adminer_object') ? adminer_object() : new
Adminer);
$ic = array("server" => "MySQL") + $ic;
if (!defined("DRIVER")) {
    define("DRIVER", "server");
    if (extension_loaded("mysqli")) {
        class
        Min_DB
            extends
            MySQLi
        {
            var $extension = "MySQLi";

            function
            __construct()
            {
                parent::init();
            }

            function
            connect($M = "", $V = "", $F = "", $j = null, $dg = null, $th = null)
            {
                global $b;
                mysqli_report(MYSQLI_REPORT_OFF);
                list($Dd, $dg) = explode(":", $M, 2);
                $Bh = $b->connectSsl();
                if ($Bh) $this->ssl_set($Bh['key'], $Bh['cert'], $Bh['ca'], '', '');
                $I = @$this->real_connect(($M != "" ? $Dd : ini_get("mysqli.default_host")), ($M . $V != "" ? $V : ini_get("mysqli.default_user")), ($M . $V . $F != "" ? $F : ini_get("mysqli.default_pw")), $j, (is_numeric($dg) ? $dg : ini_get("mysqli.default_port")), (!is_numeric($dg) ? $dg : $th), ($Bh ? 64 : 0));
                $this->options(MYSQLI_OPT_LOCAL_INFILE, false);
                return $I;
            }

            function
            set_charset($Za)
            {
                if (parent::set_charset($Za)) return
                    true;
                parent::set_charset('utf8');
                return $this->query("SET NAMES $Za");
            }

            function
            result($G, $o = 0)
            {
                $H = $this->query($G);
                if (!$H) return
                    false;
                $J = $H->fetch_array();
                return $J[$o];
            }

            function
            quote($P)
            {
                return "'" . $this->escape_string($P) . "'";
            }
        }
    } elseif (extension_loaded("mysql") && !((ini_bool("sql.safe_mode") || ini_bool("mysql.allow_local_infile")) && extension_loaded("pdo_mysql"))) {
        class
        Min_DB
        {
            var $extension = "MySQL", $server_info, $affected_rows, $errno, $error, $_link, $_result;

            function
            connect($M, $V, $F)
            {
                if (ini_bool("mysql.allow_local_infile")) {
                    $this->error = sprintf('Disable %s or enable %s or %s extensions.', "'mysql.allow_local_infile'", "MySQLi", "PDO_MySQL");
                    return
                        false;
                }
                $this->_link = @mysql_connect(($M != "" ? $M : ini_get("mysql.default_host")), ("$M$V" != "" ? $V : ini_get("mysql.default_user")), ("$M$V$F" != "" ? $F : ini_get("mysql.default_password")), true, 131072);
                if ($this->_link) $this->server_info = mysql_get_server_info($this->_link); else$this->error = mysql_error();
                return (bool)$this->_link;
            }

            function
            set_charset($Za)
            {
                if (function_exists('mysql_set_charset')) {
                    if (mysql_set_charset($Za, $this->_link)) return
                        true;
                    mysql_set_charset('utf8', $this->_link);
                }
                return $this->query("SET NAMES $Za");
            }

            function
            quote($P)
            {
                return "'" . mysql_real_escape_string($P, $this->_link) . "'";
            }

            function
            select_db($j)
            {
                return
                    mysql_select_db($j, $this->_link);
            }

            function
            query($G, $Bi = false)
            {
                $H = @($Bi ? mysql_unbuffered_query($G, $this->_link) : mysql_query($G, $this->_link));
                $this->error = "";
                if (!$H) {
                    $this->errno = mysql_errno($this->_link);
                    $this->error = mysql_error($this->_link);
                    return
                        false;
                }
                if ($H === true) {
                    $this->affected_rows = mysql_affected_rows($this->_link);
                    $this->info = mysql_info($this->_link);
                    return
                        true;
                }
                return
                    new
                    Min_Result($H);
            }

            function
            multi_query($G)
            {
                return $this->_result = $this->query($G);
            }

            function
            store_result()
            {
                return $this->_result;
            }

            function
            next_result()
            {
                return
                    false;
            }

            function
            result($G, $o = 0)
            {
                $H = $this->query($G);
                if (!$H || !$H->num_rows) return
                    false;
                return
                    mysql_result($H->_result, 0, $o);
            }
        }

        class
        Min_Result
        {
            var $num_rows, $_result, $_offset = 0;

            function
            __construct($H)
            {
                $this->_result = $H;
                $this->num_rows = mysql_num_rows($H);
            }

            function
            fetch_assoc()
            {
                return
                    mysql_fetch_assoc($this->_result);
            }

            function
            fetch_row()
            {
                return
                    mysql_fetch_row($this->_result);
            }

            function
            fetch_field()
            {
                $I = mysql_fetch_field($this->_result, $this->_offset++);
                $I->orgtable = $I->table;
                $I->orgname = $I->name;
                $I->charsetnr = ($I->blob ? 63 : 0);
                return $I;
            }

            function
            __destruct()
            {
                mysql_free_result($this->_result);
            }
        }
    } elseif (extension_loaded("pdo_mysql")) {
        class
        Min_DB
            extends
            Min_PDO
        {
            var $extension = "PDO_MySQL";

            function
            connect($M, $V, $F)
            {
                global $b;
                $xf = array(PDO::MYSQL_ATTR_LOCAL_INFILE => false);
                $Bh = $b->connectSsl();
                if ($Bh) {
                    if (!empty($Bh['key'])) $xf[PDO::MYSQL_ATTR_SSL_KEY] = $Bh['key'];
                    if (!empty($Bh['cert'])) $xf[PDO::MYSQL_ATTR_SSL_CERT] = $Bh['cert'];
                    if (!empty($Bh['ca'])) $xf[PDO::MYSQL_ATTR_SSL_CA] = $Bh['ca'];
                }
                $this->dsn("mysql:charset=utf8;host=" . str_replace(":", ";unix_socket=", preg_replace('~:(\d)~', ';port=\1', $M)), $V, $F, $xf);
                return
                    true;
            }

            function
            set_charset($Za)
            {
                $this->query("SET NAMES $Za");
            }

            function
            select_db($j)
            {
                return $this->query("USE " . idf_escape($j));
            }

            function
            query($G, $Bi = false)
            {
                $this->pdo->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, !$Bi);
                return
                    parent::query($G, $Bi);
            }
        }
    }

    class
    Min_Driver
        extends
        Min_SQL
    {
        function
        insert($Q, $N)
        {
            return ($N ? parent::insert($Q, $N) : queries("INSERT INTO " . table($Q) . " ()\nVALUES ()"));
        }

        function
        insertUpdate($Q, $K, $kg)
        {
            $f = array_keys(reset($K));
            $ig = "INSERT INTO " . table($Q) . " (" . implode(", ", $f) . ") VALUES\n";
            $Ti = array();
            foreach ($f
                     as $z) $Ti[$z] = "$z = VALUES($z)";
            $Jh = "\nON DUPLICATE KEY UPDATE " . implode(", ", $Ti);
            $Ti = array();
            $te = 0;
            foreach ($K
                     as $N) {
                $Y = "(" . implode(", ", $N) . ")";
                if ($Ti && (strlen($ig) + $te + strlen($Y) + strlen($Jh) > 1e6)) {
                    if (!queries($ig . implode(",\n", $Ti) . $Jh)) return
                        false;
                    $Ti = array();
                    $te = 0;
                }
                $Ti[] = $Y;
                $te += strlen($Y) + 2;
            }
            return
                queries($ig . implode(",\n", $Ti) . $Jh);
        }

        function
        slowQuery($G, $ei)
        {
            if (min_version('5.7.8', '10.1.2')) {
                if (preg_match('~MariaDB~', $this->_conn->server_info)) return "SET STATEMENT max_statement_time=$ei FOR $G"; elseif (preg_match('~^(SELECT\b)(.+)~is', $G, $C)) return "$C[1] /*+ MAX_EXECUTION_TIME(" . ($ei * 1000) . ") */ $C[2]";
            }
        }

        function
        convertSearch($v, $X, $o)
        {
            return (preg_match('~char|text|enum|set~', $o["type"]) && !preg_match("~^utf8~", $o["collation"]) && preg_match('~[\x80-\xFF]~', $X['val']) ? "CONVERT($v USING " . charset($this->_conn) . ")" : $v);
        }

        function
        warnings()
        {
            $H = $this->_conn->query("SHOW WARNINGS");
            if ($H && $H->num_rows) {
                ob_start();
                select($H);
                return
                    ob_get_clean();
            }
        }

        function
        tableHelp($D)
        {
            $_e = preg_match('~MariaDB~', $this->_conn->server_info);
            if (information_schema(DB)) return
                strtolower(($_e ? "information-schema-$D-table/" : str_replace("_", "-", $D) . "-table.html"));
            if (DB == "mysql") return ($_e ? "mysql$D-table/" : "system-database.html");
        }
    }

    function
    idf_escape($v)
    {
        return "`" . str_replace("`", "``", $v) . "`";
    }

    function
    table($v)
    {
        return
            idf_escape($v);
    }

    function
    connect()
    {
        global $b, $U, $Gh;
        $g = new
        Min_DB;
        $Kb = $b->credentials();
        if ($g->connect($Kb[0], $Kb[1], $Kb[2])) {
            $g->set_charset(charset($g));
            $g->query("SET sql_quote_show_create = 1, autocommit = 1");
            if (min_version('5.7.8', 10.2, $g)) {
                $Gh['Strings'][] = "json";
                $U["json"] = 4294967295;
            }
            return $g;
        }
        $I = $g->error;
        if (function_exists('iconv') && !is_utf8($I) && strlen($Xg = iconv("windows-1250", "utf-8", $I)) > strlen($I)) $I = $Xg;
        return $I;
    }

    function
    get_databases($dd)
    {
        $I = get_session("dbs");
        if ($I === null) {
            $G = (min_version(5) ? "SELECT SCHEMA_NAME FROM information_schema.SCHEMATA ORDER BY SCHEMA_NAME" : "SHOW DATABASES");
            $I = ($dd ? slow_query($G) : get_vals($G));
            restart_session();
            set_session("dbs", $I);
            stop_session();
        }
        return $I;
    }

    function
    limit($G, $Z, $_, $hf = 0, $hh = " ")
    {
        return " $G$Z" . ($_ !== null ? $hh . "LIMIT $_" . ($hf ? " OFFSET $hf" : "") : "");
    }

    function
    limit1($Q, $G, $Z, $hh = "\n")
    {
        return
            limit($G, $Z, 1, 0, $hh);
    }

    function
    db_collation($l, $lb)
    {
        global $g;
        $I = null;
        $i = $g->result("SHOW CREATE DATABASE " . idf_escape($l), 1);
        if (preg_match('~ COLLATE ([^ ]+)~', $i, $C)) $I = $C[1]; elseif (preg_match('~ CHARACTER SET ([^ ]+)~', $i, $C)) $I = $lb[$C[1]][-1];
        return $I;
    }

    function
    engines()
    {
        $I = array();
        foreach (get_rows("SHOW ENGINES") as $J) {
            if (preg_match("~YES|DEFAULT~", $J["Support"])) $I[] = $J["Engine"];
        }
        return $I;
    }

    function
    logged_user()
    {
        global $g;
        return $g->result("SELECT USER()");
    }

    function
    tables_list()
    {
        return
            get_key_vals(min_version(5) ? "SELECT TABLE_NAME, TABLE_TYPE FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() ORDER BY TABLE_NAME" : "SHOW TABLES");
    }

    function
    count_tables($k)
    {
        $I = array();
        foreach ($k
                 as $l) $I[$l] = count(get_vals("SHOW TABLES IN " . idf_escape($l)));
        return $I;
    }

    function
    table_status($D = "", $Sc = false)
    {
        $I = array();
        foreach (get_rows($Sc && min_version(5) ? "SELECT TABLE_NAME AS Name, ENGINE AS Engine, TABLE_COMMENT AS Comment FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() " . ($D != "" ? "AND TABLE_NAME = " . q($D) : "ORDER BY Name") : "SHOW TABLE STATUS" . ($D != "" ? " LIKE " . q(addcslashes($D, "%_\\")) : "")) as $J) {
            if ($J["Engine"] == "InnoDB") $J["Comment"] = preg_replace('~(?:(.+); )?InnoDB free: .*~', '\1', $J["Comment"]);
            if (!isset($J["Engine"])) $J["Comment"] = "";
            if ($D != "") return $J;
            $I[$J["Name"]] = $J;
        }
        return $I;
    }

    function
    is_view($R)
    {
        return $R["Engine"] === null;
    }

    function
    fk_support($R)
    {
        return
            preg_match('~InnoDB|IBMDB2I~i', $R["Engine"]) || (preg_match('~NDB~i', $R["Engine"]) && min_version(5.6));
    }

    function
    fields($Q)
    {
        $I = array();
        foreach (get_rows("SHOW FULL COLUMNS FROM " . table($Q)) as $J) {
            preg_match('~^([^( ]+)(?:\((.+)\))?( unsigned)?( zerofill)?$~', $J["Type"], $C);
            $I[$J["Field"]] = array("field" => $J["Field"], "full_type" => $J["Type"], "type" => $C[1], "length" => $C[2], "unsigned" => ltrim($C[3] . $C[4]), "default" => ($J["Default"] != "" || preg_match("~char|set~", $C[1]) ? (preg_match('~text~', $C[1]) ? stripslashes(preg_replace("~^'(.*)'\$~", '\1', $J["Default"])) : $J["Default"]) : null), "null" => ($J["Null"] == "YES"), "auto_increment" => ($J["Extra"] == "auto_increment"), "on_update" => (preg_match('~^on update (.+)~i', $J["Extra"], $C) ? $C[1] : ""), "collation" => $J["Collation"], "privileges" => array_flip(preg_split('~, *~', $J["Privileges"])), "comment" => $J["Comment"], "primary" => ($J["Key"] == "PRI"), "generated" => preg_match('~^(VIRTUAL|PERSISTENT|STORED)~', $J["Extra"]),);
        }
        return $I;
    }

    function
    indexes($Q, $h = null)
    {
        $I = array();
        foreach (get_rows("SHOW INDEX FROM " . table($Q), $h) as $J) {
            $D = $J["Key_name"];
            $I[$D]["type"] = ($D == "PRIMARY" ? "PRIMARY" : ($J["Index_type"] == "FULLTEXT" ? "FULLTEXT" : ($J["Non_unique"] ? ($J["Index_type"] == "SPATIAL" ? "SPATIAL" : "INDEX") : "UNIQUE")));
            $I[$D]["columns"][] = $J["Column_name"];
            $I[$D]["lengths"][] = ($J["Index_type"] == "SPATIAL" ? null : $J["Sub_part"]);
            $I[$D]["descs"][] = null;
        }
        return $I;
    }

    function
    foreign_keys($Q)
    {
        global $g, $pf;
        static $Zf = '(?:`(?:[^`]|``)+`|"(?:[^"]|"")+")';
        $I = array();
        $Ib = $g->result("SHOW CREATE TABLE " . table($Q), 1);
        if ($Ib) {
            preg_match_all("~CONSTRAINT ($Zf) FOREIGN KEY ?\\(((?:$Zf,? ?)+)\\) REFERENCES ($Zf)(?:\\.($Zf))? \\(((?:$Zf,? ?)+)\\)(?: ON DELETE ($pf))?(?: ON UPDATE ($pf))?~", $Ib, $Ce, PREG_SET_ORDER);
            foreach ($Ce
                     as $C) {
                preg_match_all("~$Zf~", $C[2], $vh);
                preg_match_all("~$Zf~", $C[5], $Wh);
                $I[idf_unescape($C[1])] = array("db" => idf_unescape($C[4] != "" ? $C[3] : $C[4]), "table" => idf_unescape($C[4] != "" ? $C[4] : $C[3]), "source" => array_map('idf_unescape', $vh[0]), "target" => array_map('idf_unescape', $Wh[0]), "on_delete" => ($C[6] ? $C[6] : "RESTRICT"), "on_update" => ($C[7] ? $C[7] : "RESTRICT"),);
            }
        }
        return $I;
    }

    function
    view($D)
    {
        global $g;
        return
            array("select" => preg_replace('~^(?:[^`]|`[^`]*`)*\s+AS\s+~isU', '', $g->result("SHOW CREATE VIEW " . table($D), 1)));
    }

    function
    collations()
    {
        $I = array();
        foreach (get_rows("SHOW COLLATION") as $J) {
            if ($J["Default"]) $I[$J["Charset"]][-1] = $J["Collation"]; else$I[$J["Charset"]][] = $J["Collation"];
        }
        ksort($I);
        foreach ($I
                 as $z => $X) asort($I[$z]);
        return $I;
    }

    function
    information_schema($l)
    {
        return (min_version(5) && $l == "information_schema") || (min_version(5.5) && $l == "performance_schema");
    }

    function
    error()
    {
        global $g;
        return
            h(preg_replace('~^You have an error.*syntax to use~U', "Syntax error", $g->error));
    }

    function
    create_database($l, $d)
    {
        return
            queries("CREATE DATABASE " . idf_escape($l) . ($d ? " COLLATE " . q($d) : ""));
    }

    function
    drop_databases($k)
    {
        $I = apply_queries("DROP DATABASE", $k, 'idf_escape');
        restart_session();
        set_session("dbs", null);
        return $I;
    }

    function
    rename_database($D, $d)
    {
        $I = false;
        if (create_database($D, $d)) {
            $S = array();
            $Yi = array();
            foreach (tables_list() as $Q => $T) {
                if ($T == 'VIEW') $Yi[] = $Q; else$S[] = $Q;
            }
            $I = (!$S && !$Yi) || move_tables($S, $Yi, $D);
            drop_databases($I ? array(DB) : array());
        }
        return $I;
    }

    function
    auto_increment()
    {
        $La = " PRIMARY KEY";
        if ($_GET["create"] != "" && $_POST["auto_increment_col"]) {
            foreach (indexes($_GET["create"]) as $w) {
                if (in_array($_POST["fields"][$_POST["auto_increment_col"]]["orig"], $w["columns"], true)) {
                    $La = "";
                    break;
                }
                if ($w["type"] == "PRIMARY") $La = " UNIQUE";
            }
        }
        return " AUTO_INCREMENT$La";
    }

    function
    alter_table($Q, $D, $p, $fd, $rb, $yc, $d, $Ka, $Tf)
    {
        $c = array();
        foreach ($p
                 as $o) $c[] = ($o[1] ? ($Q != "" ? ($o[0] != "" ? "CHANGE " . idf_escape($o[0]) : "ADD") : " ") . " " . implode($o[1]) . ($Q != "" ? $o[2] : "") : "DROP " . idf_escape($o[0]));
        $c = array_merge($c, $fd);
        $O = ($rb !== null ? " COMMENT=" . q($rb) : "") . ($yc ? " ENGINE=" . q($yc) : "") . ($d ? " COLLATE " . q($d) : "") . ($Ka != "" ? " AUTO_INCREMENT=$Ka" : "");
        if ($Q == "") return
            queries("CREATE TABLE " . table($D) . " (\n" . implode(",\n", $c) . "\n)$O$Tf");
        if ($Q != $D) $c[] = "RENAME TO " . table($D);
        if ($O) $c[] = ltrim($O);
        return ($c || $Tf ? queries("ALTER TABLE " . table($Q) . "\n" . implode(",\n", $c) . $Tf) : true);
    }

    function
    alter_indexes($Q, $c)
    {
        foreach ($c
                 as $z => $X) $c[$z] = ($X[2] == "DROP" ? "\nDROP INDEX " . idf_escape($X[1]) : "\nADD $X[0] " . ($X[0] == "PRIMARY" ? "KEY " : "") . ($X[1] != "" ? idf_escape($X[1]) . " " : "") . "(" . implode(", ", $X[2]) . ")");
        return
            queries("ALTER TABLE " . table($Q) . implode(",", $c));
    }

    function
    truncate_tables($S)
    {
        return
            apply_queries("TRUNCATE TABLE", $S);
    }

    function
    drop_views($Yi)
    {
        return
            queries("DROP VIEW " . implode(", ", array_map('table', $Yi)));
    }

    function
    drop_tables($S)
    {
        return
            queries("DROP TABLE " . implode(", ", array_map('table', $S)));
    }

    function
    move_tables($S, $Yi, $Wh)
    {
        global $g;
        $Jg = array();
        foreach ($S
                 as $Q) $Jg[] = table($Q) . " TO " . idf_escape($Wh) . "." . table($Q);
        if (!$Jg || queries("RENAME TABLE " . implode(", ", $Jg))) {
            $Zb = array();
            foreach ($Yi
                     as $Q) $Zb[table($Q)] = view($Q);
            $g->select_db($Wh);
            $l = idf_escape(DB);
            foreach ($Zb
                     as $D => $Xi) {
                if (!queries("CREATE VIEW $D AS " . str_replace(" $l.", " ", $Xi["select"])) || !queries("DROP VIEW $l.$D")) return
                    false;
            }
            return
                true;
        }
        return
            false;
    }

    function
    copy_tables($S, $Yi, $Wh)
    {
        queries("SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO'");
        foreach ($S
                 as $Q) {
            $D = ($Wh == DB ? table("copy_$Q") : idf_escape($Wh) . "." . table($Q));
            if (($_POST["overwrite"] && !queries("\nDROP TABLE IF EXISTS $D")) || !queries("CREATE TABLE $D LIKE " . table($Q)) || !queries("INSERT INTO $D SELECT * FROM " . table($Q))) return
                false;
            foreach (get_rows("SHOW TRIGGERS LIKE " . q(addcslashes($Q, "%_\\"))) as $J) {
                $wi = $J["Trigger"];
                if (!queries("CREATE TRIGGER " . ($Wh == DB ? idf_escape("copy_$wi") : idf_escape($Wh) . "." . idf_escape($wi)) . " $J[Timing] $J[Event] ON $D FOR EACH ROW\n$J[Statement];")) return
                    false;
            }
        }
        foreach ($Yi
                 as $Q) {
            $D = ($Wh == DB ? table("copy_$Q") : idf_escape($Wh) . "." . table($Q));
            $Xi = view($Q);
            if (($_POST["overwrite"] && !queries("DROP VIEW IF EXISTS $D")) || !queries("CREATE VIEW $D AS $Xi[select]")) return
                false;
        }
        return
            true;
    }

    function
    trigger($D)
    {
        if ($D == "") return
            array();
        $K = get_rows("SHOW TRIGGERS WHERE `Trigger` = " . q($D));
        return
            reset($K);
    }

    function
    triggers($Q)
    {
        $I = array();
        foreach (get_rows("SHOW TRIGGERS LIKE " . q(addcslashes($Q, "%_\\"))) as $J) $I[$J["Trigger"]] = array($J["Timing"], $J["Event"]);
        return $I;
    }

    function
    trigger_options()
    {
        return
            array("Timing" => array("BEFORE", "AFTER"), "Event" => array("INSERT", "UPDATE", "DELETE"), "Type" => array("FOR EACH ROW"),);
    }

    function
    routine($D, $T)
    {
        global $g, $_c, $Td, $U;
        $Ba = array("bool", "boolean", "integer", "double precision", "real", "dec", "numeric", "fixed", "national char", "national varchar");
        $wh = "(?:\\s|/\\*[\s\S]*?\\*/|(?:#|-- )[^\n]*\n?|--\r?\n)";
        $Ai = "((" . implode("|", array_merge(array_keys($U), $Ba)) . ")\\b(?:\\s*\\(((?:[^'\")]|$_c)++)\\))?\\s*(zerofill\\s*)?(unsigned(?:\\s+zerofill)?)?)(?:\\s*(?:CHARSET|CHARACTER\\s+SET)\\s*['\"]?([^'\"\\s,]+)['\"]?)?";
        $Zf = "$wh*(" . ($T == "FUNCTION" ? "" : $Td) . ")?\\s*(?:`((?:[^`]|``)*)`\\s*|\\b(\\S+)\\s+)$Ai";
        $i = $g->result("SHOW CREATE $T " . idf_escape($D), 2);
        preg_match("~\\(((?:$Zf\\s*,?)*)\\)\\s*" . ($T == "FUNCTION" ? "RETURNS\\s+$Ai\\s+" : "") . "(.*)~is", $i, $C);
        $p = array();
        preg_match_all("~$Zf\\s*,?~is", $C[1], $Ce, PREG_SET_ORDER);
        foreach ($Ce
                 as $Nf) $p[] = array("field" => str_replace("``", "`", $Nf[2]) . $Nf[3], "type" => strtolower($Nf[5]), "length" => preg_replace_callback("~$_c~s", 'normalize_enum', $Nf[6]), "unsigned" => strtolower(preg_replace('~\s+~', ' ', trim("$Nf[8] $Nf[7]"))), "null" => 1, "full_type" => $Nf[4], "inout" => strtoupper($Nf[1]), "collation" => strtolower($Nf[9]),);
        if ($T != "FUNCTION") return
            array("fields" => $p, "definition" => $C[11]);
        return
            array("fields" => $p, "returns" => array("type" => $C[12], "length" => $C[13], "unsigned" => $C[15], "collation" => $C[16]), "definition" => $C[17], "language" => "SQL",);
    }

    function
    routines()
    {
        return
            get_rows("SELECT ROUTINE_NAME AS SPECIFIC_NAME, ROUTINE_NAME, ROUTINE_TYPE, DTD_IDENTIFIER FROM information_schema.ROUTINES WHERE ROUTINE_SCHEMA = " . q(DB));
    }

    function
    routine_languages()
    {
        return
            array();
    }

    function
    routine_id($D, $J)
    {
        return
            idf_escape($D);
    }

    function
    last_id()
    {
        global $g;
        return $g->result("SELECT LAST_INSERT_ID()");
    }

    function
    explain($g, $G)
    {
        return $g->query("EXPLAIN " . (min_version(5.1) && !min_version(5.7) ? "PARTITIONS " : "") . $G);
    }

    function
    found_rows($R, $Z)
    {
        return ($Z || $R["Engine"] != "InnoDB" ? null : $R["Rows"]);
    }

    function
    types()
    {
        return
            array();
    }

    function
    schemas()
    {
        return
            array();
    }

    function
    get_schema()
    {
        return "";
    }

    function
    set_schema($Zg, $h = null)
    {
        return
            true;
    }

    function
    create_sql($Q, $Ka, $Hh)
    {
        global $g;
        $I = $g->result("SHOW CREATE TABLE " . table($Q), 1);
        if (!$Ka) $I = preg_replace('~ AUTO_INCREMENT=\d+~', '', $I);
        return $I;
    }

    function
    truncate_sql($Q)
    {
        return "TRUNCATE " . table($Q);
    }

    function
    use_sql($j)
    {
        return "USE " . idf_escape($j);
    }

    function
    trigger_sql($Q)
    {
        $I = "";
        foreach (get_rows("SHOW TRIGGERS LIKE " . q(addcslashes($Q, "%_\\")), null, "-- ") as $J) $I .= "\nCREATE TRIGGER " . idf_escape($J["Trigger"]) . " $J[Timing] $J[Event] ON " . table($J["Table"]) . " FOR EACH ROW\n$J[Statement];;\n";
        return $I;
    }

    function
    show_variables()
    {
        return
            get_key_vals("SHOW VARIABLES");
    }

    function
    process_list()
    {
        return
            get_rows("SHOW FULL PROCESSLIST");
    }

    function
    show_status()
    {
        return
            get_key_vals("SHOW STATUS");
    }

    function
    convert_field($o)
    {
        if (preg_match("~binary~", $o["type"])) return "HEX(" . idf_escape($o["field"]) . ")";
        if ($o["type"] == "bit") return "BIN(" . idf_escape($o["field"]) . " + 0)";
        if (preg_match("~geometry|point|linestring|polygon~", $o["type"])) return (min_version(8) ? "ST_" : "") . "AsWKT(" . idf_escape($o["field"]) . ")";
    }

    function
    unconvert_field($o, $I)
    {
        if (preg_match("~binary~", $o["type"])) $I = "UNHEX($I)";
        if ($o["type"] == "bit") $I = "CONV($I, 2, 10) + 0";
        if (preg_match("~geometry|point|linestring|polygon~", $o["type"])) $I = (min_version(8) ? "ST_" : "") . "GeomFromText($I, SRID($o[field]))";
        return $I;
    }

    function
    support($Tc)
    {
        return !preg_match("~scheme|sequence|type|view_trigger|materializedview" . (min_version(8) ? "" : "|descidx" . (min_version(5.1) ? "" : "|event|partitioning" . (min_version(5) ? "" : "|routine|trigger|view"))) . "~", $Tc);
    }

    function
    kill_process($X)
    {
        return
            queries("KILL " . number($X));
    }

    function
    connection_id()
    {
        return "SELECT CONNECTION_ID()";
    }

    function
    max_connections()
    {
        global $g;
        return $g->result("SELECT @@max_connections");
    }

    function
    driver_config()
    {
        $U = array();
        $Gh = array();
        foreach (array('Numbers' => array("tinyint" => 3, "smallint" => 5, "mediumint" => 8, "int" => 10, "bigint" => 20, "decimal" => 66, "float" => 12, "double" => 21), 'Date and time' => array("date" => 10, "datetime" => 19, "timestamp" => 19, "time" => 10, "year" => 4), 'Strings' => array("char" => 255, "varchar" => 65535, "tinytext" => 255, "text" => 65535, "mediumtext" => 16777215, "longtext" => 4294967295), 'Lists' => array("enum" => 65535, "set" => 64), 'Binary' => array("bit" => 20, "binary" => 255, "varbinary" => 65535, "tinyblob" => 255, "blob" => 65535, "mediumblob" => 16777215, "longblob" => 4294967295), 'Geometry' => array("geometry" => 0, "point" => 0, "linestring" => 0, "polygon" => 0, "multipoint" => 0, "multilinestring" => 0, "multipolygon" => 0, "geometrycollection" => 0),) as $z => $X) {
            $U += $X;
            $Gh[$z] = array_keys($X);
        }
        return
            array('possible_drivers' => array("MySQLi", "MySQL", "PDO_MySQL"), 'jush' => "sql", 'types' => $U, 'structured_types' => $Gh, 'unsigned' => array("unsigned", "zerofill", "unsigned zerofill"), 'operators' => array("=", "<", ">", "<=", ">=", "!=", "LIKE", "LIKE %%", "REGEXP", "IN", "FIND_IN_SET", "IS NULL", "NOT LIKE", "NOT REGEXP", "NOT IN", "IS NOT NULL", "SQL"), 'functions' => array("char_length", "date", "from_unixtime", "lower", "round", "floor", "ceil", "sec_to_time", "time_to_sec", "upper"), 'grouping' => array("avg", "count", "count distinct", "group_concat", "max", "min", "sum"), 'edit_functions' => array(array("char" => "md5/sha1/password/encrypt/uuid", "binary" => "md5/sha1", "date|time" => "now",), array(number_type() => "+/-", "date" => "+ interval/- interval", "time" => "addtime/subtime", "char|text" => "concat",)),);
    }
}
$vb = driver_config();
$hg = $vb['possible_drivers'];
$y = $vb['jush'];
$U = $vb['types'];
$Gh = $vb['structured_types'];
$Hi = $vb['unsigned'];
$uf = $vb['operators'];
$nd = $vb['functions'];
$td = $vb['grouping'];
$qc = $vb['edit_functions'];
if ($b->operators === null) $b->operators = $uf;
define("SERVER", $_GET[DRIVER]);
define("DB", $_GET["db"]);
define("ME", preg_replace('~\?.*~', '', relative_uri()) . '?' . (sid() ? SID . '&' : '') . (SERVER !== null ? DRIVER . "=" . urlencode(SERVER) . '&' : '') . (isset($_GET["username"]) ? "username=" . urlencode($_GET["username"]) . '&' : '') . (DB != "" ? 'db=' . urlencode(DB) . '&' . (isset($_GET["ns"]) ? "ns=" . urlencode($_GET["ns"]) . "&" : "") : ''));
$ia = "4.8.1";
function
page_header($gi, $n = "", $Ua = array(), $hi = "")
{
    global $ca, $ia, $b, $ic, $y;
    page_headers();
    if (is_ajax() && $n) {
        page_messages($n);
        exit;
    }
    $ii = $gi . ($hi != "" ? ": $hi" : "");
    $ji = strip_tags($ii . (SERVER != "" && SERVER != "localhost" ? h(" - " . SERVER) : "") . " - " . $b->name());
    echo '<!DOCTYPE html>
<html lang="en" dir="ltr">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="robots" content="noindex">
<title>', $ji, '</title>
<link rel="stylesheet" type="text/css" href="', h(preg_replace("~\\?.*~", "", ME) . "?file=default.css&version=4.8.1"), '">
', script_src(preg_replace("~\\?.*~", "", ME) . "?file=functions.js&version=4.8.1");
    if ($b->head()) {
        echo '<link rel="shortcut icon" type="image/x-icon" href="', h(preg_replace("~\\?.*~", "", ME) . "?file=favicon.ico&version=4.8.1"), '">
<link rel="apple-touch-icon" href="', h(preg_replace("~\\?.*~", "", ME) . "?file=favicon.ico&version=4.8.1"), '">
';
        foreach ($b->css() as $Mb) {
            echo '<link rel="stylesheet" type="text/css" href="', h($Mb), '">
';
        }
    }
    echo '
<body class="ltr nojs">
';
    $q = get_temp_dir() . "/adminer.version";
    if (!$_COOKIE["adminer_version"] && function_exists('openssl_verify') && file_exists($q) && filemtime($q) + 86400 > time()) {
        $Wi = unserialize(file_get_contents($q));
        $tg = "-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAwqWOVuF5uw7/+Z70djoK
RlHIZFZPO0uYRezq90+7Amk+FDNd7KkL5eDve+vHRJBLAszF/7XKXe11xwliIsFs
DFWQlsABVZB3oisKCBEuI71J4kPH8dKGEWR9jDHFw3cWmoH3PmqImX6FISWbG3B8
h7FIx3jEaw5ckVPVTeo5JRm/1DZzJxjyDenXvBQ/6o9DgZKeNDgxwKzH+sw9/YCO
jHnq1cFpOIISzARlrHMa/43YfeNRAm/tsBXjSxembBPo7aQZLAWHmaj5+K19H10B
nCpz9Y++cipkVEiKRGih4ZEvjoFysEOdRLj6WiD/uUNky4xGeA6LaJqh5XpkFkcQ
fQIDAQAB
-----END PUBLIC KEY-----
";
        if (openssl_verify($Wi["version"], base64_decode($Wi["signature"]), $tg) == 1) $_COOKIE["adminer_version"] = $Wi["version"];
    }
    echo '<script', nonce(), '>
mixin(document.body, {onkeydown: bodyKeydown, onclick: bodyClick', (isset($_COOKIE["adminer_version"]) ? "" : ", onload: partial(verifyVersion, '$ia', '" . js_escape(ME) . "', '" . get_token() . "')"); ?>});
    document.body.className = document.body.className.replace(/ nojs/, ' js');
    var offlineMessage = '<?php echo
js_escape('You are offline.'), '\';
var thousandsSeparator = \'', js_escape(','), '\';
</script>

<div id="help" class="jush-', $y, ' jsonly hidden"></div>
', script("mixin(qs('#help'), {onmouseover: function () { helpOpen = 1; }, onmouseout: helpMouseout});"), '
<div id="content">
';
    if ($Ua !== null) {
        $A = substr(preg_replace('~\b(username|db|ns)=[^&]*&~', '', ME), 0, -1);
        echo '<p id="breadcrumb"><a href="' . h($A ? $A : ".") . '">' . $ic[DRIVER] . '</a> &raquo; ';
        $A = substr(preg_replace('~\b(db|ns)=[^&]*&~', '', ME), 0, -1);
        $M = $b->serverName(SERVER);
        $M = ($M != "" ? $M : 'Server');
        if ($Ua === false) echo "$M\n"; else {
            echo "<a href='" . h($A) . "' accesskey='1' title='Alt+Shift+1'>$M</a> &raquo; ";
            if ($_GET["ns"] != "" || (DB != "" && is_array($Ua))) echo '<a href="' . h($A . "&db=" . urlencode(DB) . (support("scheme") ? "&ns=" : "")) . '">' . h(DB) . '</a> &raquo; ';
            if (is_array($Ua)) {
                if ($_GET["ns"] != "") echo '<a href="' . h(substr(ME, 0, -1)) . '">' . h($_GET["ns"]) . '</a> &raquo; ';
                foreach ($Ua
                         as $z => $X) {
                    $bc = (is_array($X) ? $X[1] : h($X));
                    if ($bc != "") echo "<a href='" . h(ME . "$z=") . urlencode(is_array($X) ? $X[0] : $X) . "'>$bc</a> &raquo; ";
                }
            }
            echo "$gi\n";
        }
    }
    echo "<h2>$ii</h2>\n", "<div id='ajaxstatus' class='jsonly hidden'></div>\n";
    restart_session();
    page_messages($n);
    $k =& get_session("dbs");
    if (DB != "" && $k && !in_array(DB, $k, true)) $k = null;
    stop_session();
    define("PAGE_HEADER", 1);
}

function
page_headers()
{
    global $b;
    header("Content-Type: text/html; charset=utf-8");
    header("Cache-Control: no-cache");
    header("X-Frame-Options: deny");
    header("X-XSS-Protection: 0");
    header("X-Content-Type-Options: nosniff");
    header("Referrer-Policy: origin-when-cross-origin");
    foreach ($b->csp() as $Lb) {
        $zd = array();
        foreach ($Lb
                 as $z => $X) $zd[] = "$z $X";
        header("Content-Security-Policy: " . implode("; ", $zd));
    }
    $b->headers();
}

function
csp()
{
    return
        array(array("script-src" => "'self' 'unsafe-inline' 'nonce-" . get_nonce() . "' 'strict-dynamic'", "connect-src" => "'self'", "frame-src" => "https://www.adminer.org", "object-src" => "'none'", "base-uri" => "'none'", "form-action" => "'self'",),);
}

function
get_nonce()
{
    static $bf;
    if (!$bf) $bf = base64_encode(rand_string());
    return $bf;
}

function
page_messages($n)
{
    $Ji = preg_replace('~^[^?]*~', '', $_SERVER["REQUEST_URI"]);
    $Oe = $_SESSION["messages"][$Ji];
    if ($Oe) {
        echo "<div class='message'>" . implode("</div>\n<div class='message'>", $Oe) . "</div>" . script("messagesPrint();");
        unset($_SESSION["messages"][$Ji]);
    }
    if ($n) echo "<div class='error'>$n</div>\n";
}

function
page_footer($Re = "")
{
    global $b, $ni;
    echo '</div>

';
    if ($Re != "auth") {
        echo '<form action="" method="post">
<p class="logout">
<input type="submit" name="logout" value="Logout" id="logout">
<input type="hidden" name="token" value="', $ni, '">
</p>
</form>
';
    }
    echo '<div id="menu">
';
    $b->navigation($Re);
    echo '</div>
', script("setupSubmitHighlight(document);");
}

function
int32($Ue)
{
    while ($Ue >= 2147483648) $Ue -= 4294967296;
    while ($Ue <= -2147483649) $Ue += 4294967296;
    return (int)$Ue;
}

function
long2str($W, $aj)
{
    $Xg = '';
    foreach ($W
             as $X) $Xg .= pack('V', $X);
    if ($aj) return
        substr($Xg, 0, end($W));
    return $Xg;
}

function
str2long($Xg, $aj)
{
    $W = array_values(unpack('V*', str_pad($Xg, 4 * ceil(strlen($Xg) / 4), "\0")));
    if ($aj) $W[] = strlen($Xg);
    return $W;
}

function
xxtea_mx($mj, $lj, $Kh, $fe)
{
    return
        int32((($mj >> 5 & 0x7FFFFFF) ^ $lj << 2) + (($lj >> 3 & 0x1FFFFFFF) ^ $mj << 4)) ^ int32(($Kh ^ $lj) + ($fe ^ $mj));
}

function
encrypt_string($Fh, $z)
{
    if ($Fh == "") return "";
    $z = array_values(unpack("V*", pack("H*", md5($z))));
    $W = str2long($Fh, true);
    $Ue = count($W) - 1;
    $mj = $W[$Ue];
    $lj = $W[0];
    $ug = floor(6 + 52 / ($Ue + 1));
    $Kh = 0;
    while ($ug-- > 0) {
        $Kh = int32($Kh + 0x9E3779B9);
        $pc = $Kh >> 2 & 3;
        for ($Lf = 0; $Lf < $Ue; $Lf++) {
            $lj = $W[$Lf + 1];
            $Te = xxtea_mx($mj, $lj, $Kh, $z[$Lf & 3 ^ $pc]);
            $mj = int32($W[$Lf] + $Te);
            $W[$Lf] = $mj;
        }
        $lj = $W[0];
        $Te = xxtea_mx($mj, $lj, $Kh, $z[$Lf & 3 ^ $pc]);
        $mj = int32($W[$Ue] + $Te);
        $W[$Ue] = $mj;
    }
    return
        long2str($W, false);
}

function
decrypt_string($Fh, $z)
{
    if ($Fh == "") return "";
    if (!$z) return
        false;
    $z = array_values(unpack("V*", pack("H*", md5($z))));
    $W = str2long($Fh, false);
    $Ue = count($W) - 1;
    $mj = $W[$Ue];
    $lj = $W[0];
    $ug = floor(6 + 52 / ($Ue + 1));
    $Kh = int32($ug * 0x9E3779B9);
    while ($Kh) {
        $pc = $Kh >> 2 & 3;
        for ($Lf = $Ue; $Lf > 0; $Lf--) {
            $mj = $W[$Lf - 1];
            $Te = xxtea_mx($mj, $lj, $Kh, $z[$Lf & 3 ^ $pc]);
            $lj = int32($W[$Lf] - $Te);
            $W[$Lf] = $lj;
        }
        $mj = $W[$Ue];
        $Te = xxtea_mx($mj, $lj, $Kh, $z[$Lf & 3 ^ $pc]);
        $lj = int32($W[0] - $Te);
        $W[0] = $lj;
        $Kh = int32($Kh - 0x9E3779B9);
    }
    return
        long2str($W, true);
}

$g = '';
$yd = $_SESSION["token"];
if (!$yd) $_SESSION["token"] = rand(1, 1e6);
$ni = get_token();
$bg = array();
if ($_COOKIE["adminer_permanent"]) {
    foreach (explode(" ", $_COOKIE["adminer_permanent"]) as $X) {
        list($z) = explode(":", $X);
        $bg[$z] = $X;
    }
}
function
add_invalid_login()
{
    global $b;
    $ld = file_open_lock(get_temp_dir() . "/adminer.invalid");
    if (!$ld) return;
    $Yd = unserialize(stream_get_contents($ld));
    $di = time();
    if ($Yd) {
        foreach ($Yd
                 as $Zd => $X) {
            if ($X[0] < $di) unset($Yd[$Zd]);
        }
    }
    $Xd =& $Yd[$b->bruteForceKey()];
    if (!$Xd) $Xd = array($di + 30 * 60, 0);
    $Xd[1]++;
    file_write_unlock($ld, serialize($Yd));
}

function
check_invalid_login()
{
    global $b;
    $Yd = unserialize(@file_get_contents(get_temp_dir() . "/adminer.invalid"));
    $Xd = ($Yd ? $Yd[$b->bruteForceKey()] : array());
    $af = ($Xd[1] > 29 ? $Xd[0] - time() : 0);
    if ($af > 0) auth_error(lang(array('Too many unsuccessful logins, try again in %d minute.', 'Too many unsuccessful logins, try again in %d minutes.'), ceil($af / 60)));
}

$Ia = $_POST["auth"];
if ($Ia) {
    session_regenerate_id();
    $Vi = $Ia["driver"];
    $M = $Ia["server"];
    $V = $Ia["username"];
    $F = (string)$Ia["password"];
    $l = $Ia["db"];
    set_password($Vi, $M, $V, $F);
    $_SESSION["db"][$Vi][$M][$V][$l] = true;
    if ($Ia["permanent"]) {
        $z = base64_encode($Vi) . "-" . base64_encode($M) . "-" . base64_encode($V) . "-" . base64_encode($l);
        $ng = $b->permanentLogin(true);
        $bg[$z] = "$z:" . base64_encode($ng ? encrypt_string($F, $ng) : "");
        cookie("adminer_permanent", implode(" ", $bg));
    }
    if (count($_POST) == 1 || DRIVER != $Vi || SERVER != $M || $_GET["username"] !== $V || DB != $l) redirect(auth_url($Vi, $M, $V, $l));
} elseif ($_POST["logout"] && (!$yd || verify_token())) {
    foreach (array("pwds", "db", "dbs", "queries") as $z) set_session($z, null);
    unset_permanent();
    redirect(substr(preg_replace('~\b(username|db|ns)=[^&]*&~', '', ME), 0, -1), 'Logout successful.' . ' ' . 'Thanks for using Adminer, consider <a href="https://www.adminer.org/en/donation/">donating</a>.');
} elseif ($bg && !$_SESSION["pwds"]) {
    session_regenerate_id();
    $ng = $b->permanentLogin();
    foreach ($bg
             as $z => $X) {
        list(, $fb) = explode(":", $X);
        list($Vi, $M, $V, $l) = array_map('base64_decode', explode("-", $z));
        set_password($Vi, $M, $V, decrypt_string(base64_decode($fb), $ng));
        $_SESSION["db"][$Vi][$M][$V][$l] = true;
    }
}
function
unset_permanent()
{
    global $bg;
    foreach ($bg
             as $z => $X) {
        list($Vi, $M, $V, $l) = array_map('base64_decode', explode("-", $z));
        if ($Vi == DRIVER && $M == SERVER && $V == $_GET["username"] && $l == DB) unset($bg[$z]);
    }
    cookie("adminer_permanent", implode(" ", $bg));
}

function
auth_error($n)
{
    global $b, $yd;
    $mh = session_name();
    if (isset($_GET["username"])) {
        header("HTTP/1.1 403 Forbidden");
        if (($_COOKIE[$mh] || $_GET[$mh]) && !$yd) $n = 'Session expired, please login again.'; else {
            restart_session();
            add_invalid_login();
            $F = get_password();
            if ($F !== null) {
                if ($F === false) $n .= ($n ? '<br>' : '') . sprintf('Master password expired. <a href="https://www.adminer.org/en/extension/"%s>Implement</a> %s method to make it permanent.', target_blank(), '<code>permanentLogin()</code>');
                set_password(DRIVER, SERVER, $_GET["username"], null);
            }
            unset_permanent();
        }
    }
    if (!$_COOKIE[$mh] && $_GET[$mh] && ini_bool("session.use_only_cookies")) $n = 'Session support must be enabled.';
    $Of = session_get_cookie_params();
    cookie("adminer_key", ($_COOKIE["adminer_key"] ? $_COOKIE["adminer_key"] : rand_string()), $Of["lifetime"]);
    page_header('Login', $n, null);
    echo "<form action='' method='post'>\n", "<div>";
    if (hidden_fields($_POST, array("auth"))) echo "<p class='message'>" . 'The action will be performed after successful login with the same credentials.' . "\n";
    echo "</div>\n";
    $b->loginForm();
    echo "</form>\n";
    page_footer("auth");
    exit;
}

if (isset($_GET["username"]) && !class_exists("Min_DB")) {
    unset($_SESSION["pwds"][DRIVER]);
    unset_permanent();
    page_header('No extension', sprintf('None of the supported PHP extensions (%s) are available.', implode(", ", $hg)), false);
    page_footer("auth");
    exit;
}
stop_session(true);
if (isset($_GET["username"]) && is_string(get_password())) {
    list($Dd, $dg) = explode(":", SERVER, 2);
    if (preg_match('~^\s*([-+]?\d+)~', $dg, $C) && ($C[1] < 1024 || $C[1] > 65535)) auth_error('Connecting to privileged ports is not allowed.');
    check_invalid_login();
    $g = connect();
    $m = new
    Min_Driver($g);
}
$xe = null;
if (!is_object($g) || ($xe = $b->login($_GET["username"], get_password())) !== true) {
    $n = (is_string($g) ? h($g) : (is_string($xe) ? $xe : 'Invalid credentials.'));
    auth_error($n . (preg_match('~^ | $~', get_password()) ? '<br>' . 'There is a space in the input password which might be the cause.' : ''));
}
if ($_POST["logout"] && $yd && !verify_token()) {
    page_header('Logout', 'Invalid CSRF token. Send the form again.');
    page_footer("db");
    exit;
}
if ($Ia && $_POST["token"]) $_POST["token"] = $ni;
$n = '';
if ($_POST) {
    if (!verify_token()) {
        $Sd = "max_input_vars";
        $Ie = ini_get($Sd);
        if (extension_loaded("suhosin")) {
            foreach (array("suhosin.request.max_vars", "suhosin.post.max_vars") as $z) {
                $X = ini_get($z);
                if ($X && (!$Ie || $X < $Ie)) {
                    $Sd = $z;
                    $Ie = $X;
                }
            }
        }
        $n = (!$_POST["token"] && $Ie ? sprintf('Maximum number of allowed fields exceeded. Please increase %s.', "'$Sd'") : 'Invalid CSRF token. Send the form again.' . ' ' . 'If you did not send this request from Adminer then close this page.');
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    $n = sprintf('Too big POST data. Reduce the data or increase the %s configuration directive.', "'post_max_size'");
    if (isset($_GET["sql"])) $n .= ' ' . 'You can upload a big SQL file via FTP and import it from server.';
}
function
select($H, $h = null, $Bf = array(), $_ = 0)
{
    global $y;
    $we = array();
    $x = array();
    $f = array();
    $Sa = array();
    $U = array();
    $I = array();
    odd('');
    for ($t = 0; (!$_ || $t < $_) && ($J = $H->fetch_row()); $t++) {
        if (!$t) {
            echo "<div class='scrollable'>\n", "<table cellspacing='0' class='nowrap'>\n", "<thead><tr>";
            for ($ee = 0; $ee < count($J); $ee++) {
                $o = $H->fetch_field();
                $D = $o->name;
                $Af = $o->orgtable;
                $_f = $o->orgname;
                $I[$o->table] = $Af;
                if ($Bf && $y == "sql") $we[$ee] = ($D == "table" ? "table=" : ($D == "possible_keys" ? "indexes=" : null)); elseif ($Af != "") {
                    if (!isset($x[$Af])) {
                        $x[$Af] = array();
                        foreach (indexes($Af, $h) as $w) {
                            if ($w["type"] == "PRIMARY") {
                                $x[$Af] = array_flip($w["columns"]);
                                break;
                            }
                        }
                        $f[$Af] = $x[$Af];
                    }
                    if (isset($f[$Af][$_f])) {
                        unset($f[$Af][$_f]);
                        $x[$Af][$_f] = $ee;
                        $we[$ee] = $Af;
                    }
                }
                if ($o->charsetnr == 63) $Sa[$ee] = true;
                $U[$ee] = $o->type;
                echo "<th" . ($Af != "" || $o->name != $_f ? " title='" . h(($Af != "" ? "$Af." : "") . $_f) . "'" : "") . ">" . h($D) . ($Bf ? doc_link(array('sql' => "explain-output.html#explain_" . strtolower($D), 'mariadb' => "explain/#the-columns-in-explain-select",)) : "");
            }
            echo "</thead>\n";
        }
        echo "<tr" . odd() . ">";
        foreach ($J
                 as $z => $X) {
            $A = "";
            if (isset($we[$z]) && !$f[$we[$z]]) {
                if ($Bf && $y == "sql") {
                    $Q = $J[array_search("table=", $we)];
                    $A = ME . $we[$z] . urlencode($Bf[$Q] != "" ? $Bf[$Q] : $Q);
                } else {
                    $A = ME . "edit=" . urlencode($we[$z]);
                    foreach ($x[$we[$z]] as $jb => $ee) $A .= "&where" . urlencode("[" . bracket_escape($jb) . "]") . "=" . urlencode($J[$ee]);
                }
            } elseif (is_url($X)) $A = $X;
            if ($X === null) $X = "<i>NULL</i>"; elseif ($Sa[$z] && !is_utf8($X)) $X = "<i>" . lang(array('%d byte', '%d bytes'), strlen($X)) . "</i>";
            else {
                $X = h($X);
                if ($U[$z] == 254) $X = "<code>$X</code>";
            }
            if ($A) $X = "<a href='" . h($A) . "'" . (is_url($A) ? target_blank() : '') . ">$X</a>";
            echo "<td>$X";
        }
    }
    echo ($t ? "</table>\n</div>" : "<p class='message'>" . 'No rows.') . "\n";
    return $I;
}

function
referencable_primary($fh)
{
    $I = array();
    foreach (table_status('', true) as $Oh => $Q) {
        if ($Oh != $fh && fk_support($Q)) {
            foreach (fields($Oh) as $o) {
                if ($o["primary"]) {
                    if ($I[$Oh]) {
                        unset($I[$Oh]);
                        break;
                    }
                    $I[$Oh] = $o;
                }
            }
        }
    }
    return $I;
}

function
adminer_settings()
{
    parse_str($_COOKIE["adminer_settings"], $oh);
    return $oh;
}

function
adminer_setting($z)
{
    $oh = adminer_settings();
    return $oh[$z];
}

function
set_adminer_settings($oh)
{
    return
        cookie("adminer_settings", http_build_query($oh + adminer_settings()));
}

function
textarea($D, $Y, $K = 10, $nb = 80)
{
    global $y;
    echo "<textarea name='$D' rows='$K' cols='$nb' class='sqlarea jush-$y' spellcheck='false' wrap='off'>";
    if (is_array($Y)) {
        foreach ($Y
                 as $X) echo
            h($X[0]) . "\n\n\n";
    } else
        echo
        h($Y);
    echo "</textarea>";
}

function
edit_type($z, $o, $lb, $hd = array(), $Pc = array())
{
    global $Gh, $U, $Hi, $pf;
    $T = $o["type"];
    echo '<td><select name="', h($z), '[type]" class="type" aria-labelledby="label-type">';
    if ($T && !isset($U[$T]) && !isset($hd[$T]) && !in_array($T, $Pc)) $Pc[] = $T;
    if ($hd) $Gh['Foreign keys'] = $hd;
    echo
    optionlist(array_merge($Pc, $Gh), $T), '</select><td><input name="', h($z), '[length]" value="', h($o["length"]), '" size="3"', (!$o["length"] && preg_match('~var(char|binary)$~', $T) ? " class='required'" : "");
    echo ' aria-labelledby="label-length"><td class="options">', "<select name='" . h($z) . "[collation]'" . (preg_match('~(char|text|enum|set)$~', $T) ? "" : " class='hidden'") . '><option value="">(' . 'collation' . ')' . optionlist($lb, $o["collation"]) . '</select>', ($Hi ? "<select name='" . h($z) . "[unsigned]'" . (!$T || preg_match(number_type(), $T) ? "" : " class='hidden'") . '><option>' . optionlist($Hi, $o["unsigned"]) . '</select>' : ''), (isset($o['on_update']) ? "<select name='" . h($z) . "[on_update]'" . (preg_match('~timestamp|datetime~', $T) ? "" : " class='hidden'") . '>' . optionlist(array("" => "(" . 'ON UPDATE' . ")", "CURRENT_TIMESTAMP"), (preg_match('~^CURRENT_TIMESTAMP~i', $o["on_update"]) ? "CURRENT_TIMESTAMP" : $o["on_update"])) . '</select>' : ''), ($hd ? "<select name='" . h($z) . "[on_delete]'" . (preg_match("~`~", $T) ? "" : " class='hidden'") . "><option value=''>(" . 'ON DELETE' . ")" . optionlist(explode("|", $pf), $o["on_delete"]) . "</select> " : " ");
}

function
process_length($te)
{
    global $_c;
    return (preg_match("~^\\s*\\(?\\s*$_c(?:\\s*,\\s*$_c)*+\\s*\\)?\\s*\$~", $te) && preg_match_all("~$_c~", $te, $Ce) ? "(" . implode(",", $Ce[0]) . ")" : preg_replace('~^[0-9].*~', '(\0)', preg_replace('~[^-0-9,+()[\]]~', '', $te)));
}

function
process_type($o, $kb = "COLLATE")
{
    global $Hi;
    return " $o[type]" . process_length($o["length"]) . (preg_match(number_type(), $o["type"]) && in_array($o["unsigned"], $Hi) ? " $o[unsigned]" : "") . (preg_match('~char|text|enum|set~', $o["type"]) && $o["collation"] ? " $kb " . q($o["collation"]) : "");
}

function
process_field($o, $_i)
{
    return
        array(idf_escape(trim($o["field"])), process_type($_i), ($o["null"] ? " NULL" : " NOT NULL"), default_value($o), (preg_match('~timestamp|datetime~', $o["type"]) && $o["on_update"] ? " ON UPDATE $o[on_update]" : ""), (support("comment") && $o["comment"] != "" ? " COMMENT " . q($o["comment"]) : ""), ($o["auto_increment"] ? auto_increment() : null),);
}

function
default_value($o)
{
    $Wb = $o["default"];
    return ($Wb === null ? "" : " DEFAULT " . (preg_match('~char|binary|text|enum|set~', $o["type"]) || preg_match('~^(?![a-z])~i', $Wb) ? q($Wb) : $Wb));
}

function
type_class($T)
{
    foreach (array('char' => 'text', 'date' => 'time|year', 'binary' => 'blob', 'enum' => 'set',) as $z => $X) {
        if (preg_match("~$z|$X~", $T)) return " class='$z'";
    }
}

function
edit_fields($p, $lb, $T = "TABLE", $hd = array())
{
    global $Td;
    $p = array_values($p);
    $Xb = (($_POST ? $_POST["defaults"] : adminer_setting("defaults")) ? "" : " class='hidden'");
    $sb = (($_POST ? $_POST["comments"] : adminer_setting("comments")) ? "" : " class='hidden'");
    echo '<thead><tr>
';
    if ($T == "PROCEDURE") {
        echo '<td>';
    }
    echo '<th id="label-name">', ($T == "TABLE" ? 'Column name' : 'Parameter name'), '<td id="label-type">Type<textarea id="enum-edit" rows="4" cols="12" wrap="off" style="display: none;"></textarea>', script("qs('#enum-edit').onblur = editingLengthBlur;"), '<td id="label-length">Length
<td>', 'Options';
    if ($T == "TABLE") {
        echo '<td id="label-null">NULL
<td><input type="radio" name="auto_increment_col" value=""><acronym id="label-ai" title="Auto Increment">AI</acronym>', doc_link(array('sql' => "example-auto-increment.html", 'mariadb' => "auto_increment/", 'sqlite' => "autoinc.html", 'pgsql' => "datatype.html#DATATYPE-SERIAL", 'mssql' => "ms186775.aspx",)), '<td id="label-default"', $Xb, '>Default value
', (support("comment") ? "<td id='label-comment'$sb>" . 'Comment' : "");
    }
    echo '<td>', "<input type='image' class='icon' name='add[" . (support("move_col") ? 0 : count($p)) . "]' src='" . h(preg_replace("~\\?.*~", "", ME) . "?file=plus.gif&version=4.8.1") . "' alt='+' title='" . 'Add next' . "'>" . script("row_count = " . count($p) . ";"), '</thead>
<tbody>
', script("mixin(qsl('tbody'), {onclick: editingClick, onkeydown: editingKeydown, oninput: editingInput});");
    foreach ($p
             as $t => $o) {
        $t++;
        $Cf = $o[($_POST ? "orig" : "field")];
        $fc = (isset($_POST["add"][$t - 1]) || (isset($o["field"]) && !$_POST["drop_col"][$t])) && (support("drop_col") || $Cf == "");
        echo '<tr', ($fc ? "" : " style='display: none;'"), '>
', ($T == "PROCEDURE" ? "<td>" . html_select("fields[$t][inout]", explode("|", $Td), $o["inout"]) : ""), '<th>';
        if ($fc) {
            echo '<input name="fields[', $t, '][field]" value="', h($o["field"]), '" data-maxlength="64" autocapitalize="off" aria-labelledby="label-name">';
        }
        echo '<input type="hidden" name="fields[', $t, '][orig]" value="', h($Cf), '">';
        edit_type("fields[$t]", $o, $lb, $hd);
        if ($T == "TABLE") {
            echo '<td>', checkbox("fields[$t][null]", 1, $o["null"], "", "", "block", "label-null"), '<td><label class="block"><input type="radio" name="auto_increment_col" value="', $t, '"';
            if ($o["auto_increment"]) {
                echo ' checked';
            }
            echo ' aria-labelledby="label-ai"></label><td', $Xb, '>', checkbox("fields[$t][has_default]", 1, $o["has_default"], "", "", "", "label-default"), '<input name="fields[', $t, '][default]" value="', h($o["default"]), '" aria-labelledby="label-default">', (support("comment") ? "<td$sb><input name='fields[$t][comment]' value='" . h($o["comment"]) . "' data-maxlength='" . (min_version(5.5) ? 1024 : 255) . "' aria-labelledby='label-comment'>" : "");
        }
        echo "<td>", (support("move_col") ? "<input type='image' class='icon' name='add[$t]' src='" . h(preg_replace("~\\?.*~", "", ME) . "?file=plus.gif&version=4.8.1") . "' alt='+' title='" . 'Add next' . "'> " . "<input type='image' class='icon' name='up[$t]' src='" . h(preg_replace("~\\?.*~", "", ME) . "?file=up.gif&version=4.8.1") . "' alt='â†‘' title='" . 'Move up' . "'> " . "<input type='image' class='icon' name='down[$t]' src='" . h(preg_replace("~\\?.*~", "", ME) . "?file=down.gif&version=4.8.1") . "' alt='â†“' title='" . 'Move down' . "'> " : ""), ($Cf == "" || support("drop_col") ? "<input type='image' class='icon' name='drop_col[$t]' src='" . h(preg_replace("~\\?.*~", "", ME) . "?file=cross.gif&version=4.8.1") . "' alt='x' title='" . 'Remove' . "'>" : "");
    }
}

function
process_fields(&$p)
{
    $hf = 0;
    if ($_POST["up"]) {
        $ne = 0;
        foreach ($p
                 as $z => $o) {
            if (key($_POST["up"]) == $z) {
                unset($p[$z]);
                array_splice($p, $ne, 0, array($o));
                break;
            }
            if (isset($o["field"])) $ne = $hf;
            $hf++;
        }
    } elseif ($_POST["down"]) {
        $jd = false;
        foreach ($p
                 as $z => $o) {
            if (isset($o["field"]) && $jd) {
                unset($p[key($_POST["down"])]);
                array_splice($p, $hf, 0, array($jd));
                break;
            }
            if (key($_POST["down"]) == $z) $jd = $o;
            $hf++;
        }
    } elseif ($_POST["add"]) {
        $p = array_values($p);
        array_splice($p, key($_POST["add"]), 0, array(array()));
    } elseif (!$_POST["drop_col"]) return
        false;
    return
        true;
}

function
normalize_enum($C)
{
    return "'" . str_replace("'", "''", addcslashes(stripcslashes(str_replace($C[0][0] . $C[0][0], $C[0][0], substr($C[0], 1, -1))), '\\')) . "'";
}

function
grant($od, $pg, $f, $of)
{
    if (!$pg) return
        true;
    if ($pg == array("ALL PRIVILEGES", "GRANT OPTION")) return ($od == "GRANT" ? queries("$od ALL PRIVILEGES$of WITH GRANT OPTION") : queries("$od ALL PRIVILEGES$of") && queries("$od GRANT OPTION$of"));
    return
        queries("$od " . preg_replace('~(GRANT OPTION)\([^)]*\)~', '\1', implode("$f, ", $pg) . $f) . $of);
}

function
drop_create($jc, $i, $kc, $ai, $mc, $B, $Ne, $Le, $Me, $lf, $Ye)
{
    if ($_POST["drop"]) query_redirect($jc, $B, $Ne); elseif ($lf == "") query_redirect($i, $B, $Me);
    elseif ($lf != $Ye) {
        $Jb = queries($i);
        queries_redirect($B, $Le, $Jb && queries($jc));
        if ($Jb) queries($kc);
    } else
        queries_redirect($B, $Le, queries($ai) && queries($mc) && queries($jc) && queries($i));
}

function
create_trigger($of, $J)
{
    global $y;
    $fi = " $J[Timing] $J[Event]" . (preg_match('~ OF~', $J["Event"]) ? " $J[Of]" : "");
    return "CREATE TRIGGER " . idf_escape($J["Trigger"]) . ($y == "mssql" ? $of . $fi : $fi . $of) . rtrim(" $J[Type]\n$J[Statement]", ";") . ";";
}

function
create_routine($Tg, $J)
{
    global $Td, $y;
    $N = array();
    $p = (array)$J["fields"];
    ksort($p);
    foreach ($p
             as $o) {
        if ($o["field"] != "") $N[] = (preg_match("~^($Td)\$~", $o["inout"]) ? "$o[inout] " : "") . idf_escape($o["field"]) . process_type($o, "CHARACTER SET");
    }
    $Yb = rtrim("\n$J[definition]", ";");
    return "CREATE $Tg " . idf_escape(trim($J["name"])) . " (" . implode(", ", $N) . ")" . (isset($_GET["function"]) ? " RETURNS" . process_type($J["returns"], "CHARACTER SET") : "") . ($J["language"] ? " LANGUAGE $J[language]" : "") . ($y == "pgsql" ? " AS " . q($Yb) : "$Yb;");
}

function
remove_definer($G)
{
    return
        preg_replace('~^([A-Z =]+) DEFINER=`' . preg_replace('~@(.*)~', '`@`(%|\1)', logged_user()) . '`~', '\1', $G);
}

function
format_foreign_key($r)
{
    global $pf;
    $l = $r["db"];
    $cf = $r["ns"];
    return " FOREIGN KEY (" . implode(", ", array_map('idf_escape', $r["source"])) . ") REFERENCES " . ($l != "" && $l != $_GET["db"] ? idf_escape($l) . "." : "") . ($cf != "" && $cf != $_GET["ns"] ? idf_escape($cf) . "." : "") . table($r["table"]) . " (" . implode(", ", array_map('idf_escape', $r["target"])) . ")" . (preg_match("~^($pf)\$~", $r["on_delete"]) ? " ON DELETE $r[on_delete]" : "") . (preg_match("~^($pf)\$~", $r["on_update"]) ? " ON UPDATE $r[on_update]" : "");
}

function
tar_file($q, $ki)
{
    $I = pack("a100a8a8a8a12a12", $q, 644, 0, 0, decoct($ki->size), decoct(time()));
    $eb = 8 * 32;
    for ($t = 0; $t < strlen($I); $t++) $eb += ord($I[$t]);
    $I .= sprintf("%06o", $eb) . "\0 ";
    echo $I, str_repeat("\0", 512 - strlen($I));
    $ki->send();
    echo
    str_repeat("\0", 511 - ($ki->size + 511) % 512);
}

function
ini_bytes($Sd)
{
    $X = ini_get($Sd);
    switch (strtolower(substr($X, -1))) {
        case'g':
            $X *= 1024;
        case'm':
            $X *= 1024;
        case'k':
            $X *= 1024;
    }
    return $X;
}

function
doc_link($Yf, $bi = "<sup>?</sup>")
{
    global $y, $g;
    $kh = $g->server_info;
    $Wi = preg_replace('~^(\d\.?\d).*~s', '\1', $kh);
    $Li = array('sql' => "https://dev.mysql.com/doc/refman/$Wi/en/", 'sqlite' => "https://www.sqlite.org/", 'pgsql' => "https://www.postgresql.org/docs/$Wi/", 'mssql' => "https://msdn.microsoft.com/library/", 'oracle' => "https://www.oracle.com/pls/topic/lookup?ctx=db" . preg_replace('~^.* (\d+)\.(\d+)\.\d+\.\d+\.\d+.*~s', '\1\2', $kh) . "&id=",);
    if (preg_match('~MariaDB~', $kh)) {
        $Li['sql'] = "https://mariadb.com/kb/en/library/";
        $Yf['sql'] = (isset($Yf['mariadb']) ? $Yf['mariadb'] : str_replace(".html", "/", $Yf['sql']));
    }
    return ($Yf[$y] ? "<a href='" . h($Li[$y] . $Yf[$y]) . "'" . target_blank() . ">$bi</a>" : "");
}

function
ob_gzencode($P)
{
    return
        gzencode($P);
}

function
db_size($l)
{
    global $g;
    if (!$g->select_db($l)) return "?";
    $I = 0;
    foreach (table_status() as $R) $I += $R["Data_length"] + $R["Index_length"];
    return
        format_number($I);
}

function
set_utf8mb4($i)
{
    global $g;
    static $N = false;
    if (!$N && preg_match('~\butf8mb4~i', $i)) {
        $N = true;
        echo "SET NAMES " . charset($g) . ";\n\n";
    }
}

function
connect_error()
{
    global $b, $g, $ni, $n, $ic;
    if (DB != "") {
        header("HTTP/1.1 404 Not Found");
        page_header('Database' . ": " . h(DB), 'Invalid database.', true);
    } else {
        if ($_POST["db"] && !$n) queries_redirect(substr(ME, 0, -1), 'Databases have been dropped.', drop_databases($_POST["db"]));
        page_header('Select database', $n, false);
        echo "<p class='links'>\n";
        foreach (array('database' => 'Create database', 'privileges' => 'Privileges', 'processlist' => 'Process list', 'variables' => 'Variables', 'status' => 'Status',) as $z => $X) {
            if (support($z)) echo "<a href='" . h(ME) . "$z='>$X</a>\n";
        }
        echo "<p>" . sprintf('%s version: %s through PHP extension %s', $ic[DRIVER], "<b>" . h($g->server_info) . "</b>", "<b>$g->extension</b>") . "\n", "<p>" . sprintf('Logged as: %s', "<b>" . h(logged_user()) . "</b>") . "\n";
        $k = $b->databases();
        if ($k) {
            $ah = support("scheme");
            $lb = collations();
            echo "<form action='' method='post'>\n", "<table cellspacing='0' class='checkable'>\n", script("mixin(qsl('table'), {onclick: tableClick, ondblclick: partialArg(tableClick, true)});"), "<thead><tr>" . (support("database") ? "<td>" : "") . "<th>" . 'Database' . " - <a href='" . h(ME) . "refresh=1'>" . 'Refresh' . "</a>" . "<td>" . 'Collation' . "<td>" . 'Tables' . "<td>" . 'Size' . " - <a href='" . h(ME) . "dbsize=1'>" . 'Compute' . "</a>" . script("qsl('a').onclick = partial(ajaxSetHtml, '" . js_escape(ME) . "script=connect');", "") . "</thead>\n";
            $k = ($_GET["dbsize"] ? count_tables($k) : array_flip($k));
            foreach ($k
                     as $l => $S) {
                $Sg = h(ME) . "db=" . urlencode($l);
                $u = h("Db-" . $l);
                echo "<tr" . odd() . ">" . (support("database") ? "<td>" . checkbox("db[]", $l, in_array($l, (array)$_POST["db"]), "", "", "", $u) : ""), "<th><a href='$Sg' id='$u'>" . h($l) . "</a>";
                $d = h(db_collation($l, $lb));
                echo "<td>" . (support("database") ? "<a href='$Sg" . ($ah ? "&amp;ns=" : "") . "&amp;database=' title='" . 'Alter database' . "'>$d</a>" : $d), "<td align='right'><a href='$Sg&amp;schema=' id='tables-" . h($l) . "' title='" . 'Database schema' . "'>" . ($_GET["dbsize"] ? $S : "?") . "</a>", "<td align='right' id='size-" . h($l) . "'>" . ($_GET["dbsize"] ? db_size($l) : "?"), "\n";
            }
            echo "</table>\n", (support("database") ? "<div class='footer'><div>\n" . "<fieldset><legend>" . 'Selected' . " <span id='selected'></span></legend><div>\n" . "<input type='hidden' name='all' value=''>" . script("qsl('input').onclick = function () { selectCount('selected', formChecked(this, /^db/)); };") . "<input type='submit' name='drop' value='" . 'Drop' . "'>" . confirm() . "\n" . "</div></fieldset>\n" . "</div></div>\n" : ""), "<input type='hidden' name='token' value='$ni'>\n", "</form>\n", script("tableCheck();");
        }
    }
    page_footer("db");
}

if (isset($_GET["status"])) $_GET["variables"] = $_GET["status"];
if (isset($_GET["import"])) $_GET["sql"] = $_GET["import"];
if (!(DB != "" ? $g->select_db(DB) : isset($_GET["sql"]) || isset($_GET["dump"]) || isset($_GET["database"]) || isset($_GET["processlist"]) || isset($_GET["privileges"]) || isset($_GET["user"]) || isset($_GET["variables"]) || $_GET["script"] == "connect" || $_GET["script"] == "kill")) {
    if (DB != "" || $_GET["refresh"]) {
        restart_session();
        set_session("dbs", null);
    }
    connect_error();
    exit;
}
if (support("scheme")) {
    if (DB != "" && $_GET["ns"] !== "") {
        if (!isset($_GET["ns"])) redirect(preg_replace('~ns=[^&]*&~', '', ME) . "ns=" . get_schema());
        if (!set_schema($_GET["ns"])) {
            header("HTTP/1.1 404 Not Found");
            page_header('Schema' . ": " . h($_GET["ns"]), 'Invalid schema.', true);
            page_footer("ns");
            exit;
        }
    }
}
$pf = "RESTRICT|NO ACTION|CASCADE|SET NULL|SET DEFAULT";

class
TmpFile
{
    var $handler;
    var $size;

    function
    __construct()
    {
        $this->handler = tmpfile();
    }

    function
    write($Cb)
    {
        $this->size += strlen($Cb);
        fwrite($this->handler, $Cb);
    }

    function
    send()
    {
        fseek($this->handler, 0);
        fpassthru($this->handler);
        fclose($this->handler);
    }
}

$_c = "'(?:''|[^'\\\\]|\\\\.)*'";
$Td = "IN|OUT|INOUT";
if (isset($_GET["select"]) && ($_POST["edit"] || $_POST["clone"]) && !$_POST["save"]) $_GET["edit"] = $_GET["select"];
if (isset($_GET["callf"])) $_GET["call"] = $_GET["callf"];
if (isset($_GET["function"])) $_GET["procedure"] = $_GET["function"];
if (isset($_GET["download"])) {
    $a = $_GET["download"];
    $p = fields($a);
    header("Content-Type: application/octet-stream");
    header("Content-Disposition: attachment; filename=" . friendly_url("$a-" . implode("_", $_GET["where"])) . "." . friendly_url($_GET["field"]));
    $L = array(idf_escape($_GET["field"]));
    $H = $m->select($a, $L, array(where($_GET, $p)), $L);
    $J = ($H ? $H->fetch_row() : array());
    echo $m->value($J[0], $p[$_GET["field"]]);
    exit;
} elseif (isset($_GET["table"])) {
    $a = $_GET["table"];
    $p = fields($a);
    if (!$p) $n = error();
    $R = table_status1($a, true);
    $D = $b->tableName($R);
    page_header(($p && is_view($R) ? $R['Engine'] == 'materialized view' ? 'Materialized view' : 'View' : 'Table') . ": " . ($D != "" ? $D : h($a)), $n);
    $b->selectLinks($R);
    $rb = $R["Comment"];
    if ($rb != "") echo "<p class='nowrap'>" . 'Comment' . ": " . h($rb) . "\n";
    if ($p) $b->tableStructurePrint($p);
    if (!is_view($R)) {
        if (support("indexes")) {
            echo "<h3 id='indexes'>" . 'Indexes' . "</h3>\n";
            $x = indexes($a);
            if ($x) $b->tableIndexesPrint($x);
            echo '<p class="links"><a href="' . h(ME) . 'indexes=' . urlencode($a) . '">' . 'Alter indexes' . "</a>\n";
        }
        if (fk_support($R)) {
            echo "<h3 id='foreign-keys'>" . 'Foreign keys' . "</h3>\n";
            $hd = foreign_keys($a);
            if ($hd) {
                echo "<table cellspacing='0'>\n", "<thead><tr><th>" . 'Source' . "<td>" . 'Target' . "<td>" . 'ON DELETE' . "<td>" . 'ON UPDATE' . "<td></thead>\n";
                foreach ($hd
                         as $D => $r) {
                    echo "<tr title='" . h($D) . "'>", "<th><i>" . implode("</i>, <i>", array_map('h', $r["source"])) . "</i>", "<td><a href='" . h($r["db"] != "" ? preg_replace('~db=[^&]*~', "db=" . urlencode($r["db"]), ME) : ($r["ns"] != "" ? preg_replace('~ns=[^&]*~', "ns=" . urlencode($r["ns"]), ME) : ME)) . "table=" . urlencode($r["table"]) . "'>" . ($r["db"] != "" ? "<b>" . h($r["db"]) . "</b>." : "") . ($r["ns"] != "" ? "<b>" . h($r["ns"]) . "</b>." : "") . h($r["table"]) . "</a>", "(<i>" . implode("</i>, <i>", array_map('h', $r["target"])) . "</i>)", "<td>" . h($r["on_delete"]) . "\n", "<td>" . h($r["on_update"]) . "\n", '<td><a href="' . h(ME . 'foreign=' . urlencode($a) . '&name=' . urlencode($D)) . '">' . 'Alter' . '</a>';
                }
                echo "</table>\n";
            }
            echo '<p class="links"><a href="' . h(ME) . 'foreign=' . urlencode($a) . '">' . 'Add foreign key' . "</a>\n";
        }
    }
    if (support(is_view($R) ? "view_trigger" : "trigger")) {
        echo "<h3 id='triggers'>" . 'Triggers' . "</h3>\n";
        $zi = triggers($a);
        if ($zi) {
            echo "<table cellspacing='0'>\n";
            foreach ($zi
                     as $z => $X) echo "<tr valign='top'><td>" . h($X[0]) . "<td>" . h($X[1]) . "<th>" . h($z) . "<td><a href='" . h(ME . 'trigger=' . urlencode($a) . '&name=' . urlencode($z)) . "'>" . 'Alter' . "</a>\n";
            echo "</table>\n";
        }
        echo '<p class="links"><a href="' . h(ME) . 'trigger=' . urlencode($a) . '">' . 'Add trigger' . "</a>\n";
    }
} elseif (isset($_GET["schema"])) {
    page_header('Database schema', "", array(), h(DB . ($_GET["ns"] ? ".$_GET[ns]" : "")));
    $Qh = array();
    $Rh = array();
    $ea = ($_GET["schema"] ? $_GET["schema"] : $_COOKIE["adminer_schema-" . str_replace(".", "_", DB)]);
    preg_match_all('~([^:]+):([-0-9.]+)x([-0-9.]+)(_|$)~', $ea, $Ce, PREG_SET_ORDER);
    foreach ($Ce
             as $t => $C) {
        $Qh[$C[1]] = array($C[2], $C[3]);
        $Rh[] = "\n\t'" . js_escape($C[1]) . "': [ $C[2], $C[3] ]";
    }
    $oi = 0;
    $Pa = -1;
    $Zg = array();
    $Eg = array();
    $re = array();
    foreach (table_status('', true) as $Q => $R) {
        if (is_view($R)) continue;
        $eg = 0;
        $Zg[$Q]["fields"] = array();
        foreach (fields($Q) as $D => $o) {
            $eg += 1.25;
            $o["pos"] = $eg;
            $Zg[$Q]["fields"][$D] = $o;
        }
        $Zg[$Q]["pos"] = ($Qh[$Q] ? $Qh[$Q] : array($oi, 0));
        foreach ($b->foreignKeys($Q) as $X) {
            if (!$X["db"]) {
                $pe = $Pa;
                if ($Qh[$Q][1] || $Qh[$X["table"]][1]) $pe = min(floatval($Qh[$Q][1]), floatval($Qh[$X["table"]][1])) - 1; else$Pa -= .1;
                while ($re[(string)$pe]) $pe -= .0001;
                $Zg[$Q]["references"][$X["table"]][(string)$pe] = array($X["source"], $X["target"]);
                $Eg[$X["table"]][$Q][(string)$pe] = $X["target"];
                $re[(string)$pe] = true;
            }
        }
        $oi = max($oi, $Zg[$Q]["pos"][0] + 2.5 + $eg);
    }
    echo '<div id="schema" style="height: ', $oi, 'em;">
<script', nonce(), '>
qs(\'#schema\').onselectstart = function () { return false; };
var tablePos = {', implode(",", $Rh) . "\n", '};
var em = qs(\'#schema\').offsetHeight / ', $oi, ';
document.onmousemove = schemaMousemove;
document.onmouseup = partialArg(schemaMouseup, \'', js_escape(DB), '\');
</script>
';
    foreach ($Zg
             as $D => $Q) {
        echo "<div class='table' style='top: " . $Q["pos"][0] . "em; left: " . $Q["pos"][1] . "em;'>", '<a href="' . h(ME) . 'table=' . urlencode($D) . '"><b>' . h($D) . "</b></a>", script("qsl('div').onmousedown = schemaMousedown;");
        foreach ($Q["fields"] as $o) {
            $X = '<span' . type_class($o["type"]) . ' title="' . h($o["full_type"] . ($o["null"] ? " NULL" : '')) . '">' . h($o["field"]) . '</span>';
            echo "<br>" . ($o["primary"] ? "<i>$X</i>" : $X);
        }
        foreach ((array)$Q["references"] as $Xh => $Fg) {
            foreach ($Fg
                     as $pe => $Bg) {
                $qe = $pe - $Qh[$D][1];
                $t = 0;
                foreach ($Bg[0] as $vh) echo "\n<div class='references' title='" . h($Xh) . "' id='refs$pe-" . ($t++) . "' style='left: $qe" . "em; top: " . $Q["fields"][$vh]["pos"] . "em; padding-top: .5em;'><div style='border-top: 1px solid Gray; width: " . (-$qe) . "em;'></div></div>";
            }
        }
        foreach ((array)$Eg[$D] as $Xh => $Fg) {
            foreach ($Fg
                     as $pe => $f) {
                $qe = $pe - $Qh[$D][1];
                $t = 0;
                foreach ($f
                         as $Wh) echo "\n<div class='references' title='" . h($Xh) . "' id='refd$pe-" . ($t++) . "' style='left: $qe" . "em; top: " . $Q["fields"][$Wh]["pos"] . "em; height: 1.25em; background: url(" . h(preg_replace("~\\?.*~", "", ME) . "?file=arrow.gif) no-repeat right center;&version=4.8.1") . "'><div style='height: .5em; border-bottom: 1px solid Gray; width: " . (-$qe) . "em;'></div></div>";
            }
        }
        echo "\n</div>\n";
    }
    foreach ($Zg
             as $D => $Q) {
        foreach ((array)$Q["references"] as $Xh => $Fg) {
            foreach ($Fg
                     as $pe => $Bg) {
                $Qe = $oi;
                $Ge = -10;
                foreach ($Bg[0] as $z => $vh) {
                    $fg = $Q["pos"][0] + $Q["fields"][$vh]["pos"];
                    $gg = $Zg[$Xh]["pos"][0] + $Zg[$Xh]["fields"][$Bg[1][$z]]["pos"];
                    $Qe = min($Qe, $fg, $gg);
                    $Ge = max($Ge, $fg, $gg);
                }
                echo "<div class='references' id='refl$pe' style='left: $pe" . "em; top: $Qe" . "em; padding: .5em 0;'><div style='border-right: 1px solid Gray; margin-top: 1px; height: " . ($Ge - $Qe) . "em;'></div></div>\n";
            }
        }
    }
    echo '</div>
<p class="links"><a href="', h(ME . "schema=" . urlencode($ea)), '" id="schema-link">Permanent link</a>
';
} elseif (isset($_GET["dump"])) {
    $a = $_GET["dump"];
    if ($_POST && !$n) {
        $Fb = "";
        foreach (array("output", "format", "db_style", "routines", "events", "table_style", "auto_increment", "triggers", "data_style") as $z) $Fb .= "&$z=" . urlencode($_POST[$z]);
        cookie("adminer_export", substr($Fb, 1));
        $S = array_flip((array)$_POST["tables"]) + array_flip((array)$_POST["data"]);
        $Mc = dump_headers((count($S) == 1 ? key($S) : DB), (DB == "" || count($S) > 1));
        $be = preg_match('~sql~', $_POST["format"]);
        if ($be) {
            echo "-- Adminer $ia " . $ic[DRIVER] . " " . str_replace("\n", " ", $g->server_info) . " dump\n\n";
            if ($y == "sql") {
                echo "SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
" . ($_POST["data_style"] ? "SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';
" : "") . "
";
                $g->query("SET time_zone = '+00:00'");
                $g->query("SET sql_mode = ''");
            }
        }
        $Hh = $_POST["db_style"];
        $k = array(DB);
        if (DB == "") {
            $k = $_POST["databases"];
            if (is_string($k)) $k = explode("\n", rtrim(str_replace("\r", "", $k), "\n"));
        }
        foreach ((array)$k
                 as $l) {
            $b->dumpDatabase($l);
            if ($g->select_db($l)) {
                if ($be && preg_match('~CREATE~', $Hh) && ($i = $g->result("SHOW CREATE DATABASE " . idf_escape($l), 1))) {
                    set_utf8mb4($i);
                    if ($Hh == "DROP+CREATE") echo "DROP DATABASE IF EXISTS " . idf_escape($l) . ";\n";
                    echo "$i;\n";
                }
                if ($be) {
                    if ($Hh) echo
                        use_sql($l) . ";\n\n";
                    $If = "";
                    if ($_POST["routines"]) {
                        foreach (array("FUNCTION", "PROCEDURE") as $Tg) {
                            foreach (get_rows("SHOW $Tg STATUS WHERE Db = " . q($l), null, "-- ") as $J) {
                                $i = remove_definer($g->result("SHOW CREATE $Tg " . idf_escape($J["Name"]), 2));
                                set_utf8mb4($i);
                                $If .= ($Hh != 'DROP+CREATE' ? "DROP $Tg IF EXISTS " . idf_escape($J["Name"]) . ";;\n" : "") . "$i;;\n\n";
                            }
                        }
                    }
                    if ($_POST["events"]) {
                        foreach (get_rows("SHOW EVENTS", null, "-- ") as $J) {
                            $i = remove_definer($g->result("SHOW CREATE EVENT " . idf_escape($J["Name"]), 3));
                            set_utf8mb4($i);
                            $If .= ($Hh != 'DROP+CREATE' ? "DROP EVENT IF EXISTS " . idf_escape($J["Name"]) . ";;\n" : "") . "$i;;\n\n";
                        }
                    }
                    if ($If) echo "DELIMITER ;;\n\n$If" . "DELIMITER ;\n\n";
                }
                if ($_POST["table_style"] || $_POST["data_style"]) {
                    $Yi = array();
                    foreach (table_status('', true) as $D => $R) {
                        $Q = (DB == "" || in_array($D, (array)$_POST["tables"]));
                        $Pb = (DB == "" || in_array($D, (array)$_POST["data"]));
                        if ($Q || $Pb) {
                            if ($Mc == "tar") {
                                $ki = new
                                TmpFile;
                                ob_start(array($ki, 'write'), 1e5);
                            }
                            $b->dumpTable($D, ($Q ? $_POST["table_style"] : ""), (is_view($R) ? 2 : 0));
                            if (is_view($R)) $Yi[] = $D; elseif ($Pb) {
                                $p = fields($D);
                                $b->dumpData($D, $_POST["data_style"], "SELECT *" . convert_fields($p, $p) . " FROM " . table($D));
                            }
                            if ($be && $_POST["triggers"] && $Q && ($zi = trigger_sql($D))) echo "\nDELIMITER ;;\n$zi\nDELIMITER ;\n";
                            if ($Mc == "tar") {
                                ob_end_flush();
                                tar_file((DB != "" ? "" : "$l/") . "$D.csv", $ki);
                            } elseif ($be) echo "\n";
                        }
                    }
                    if (function_exists('foreign_keys_sql')) {
                        foreach (table_status('', true) as $D => $R) {
                            $Q = (DB == "" || in_array($D, (array)$_POST["tables"]));
                            if ($Q && !is_view($R)) echo
                            foreign_keys_sql($D);
                        }
                    }
                    foreach ($Yi
                             as $Xi) $b->dumpTable($Xi, $_POST["table_style"], 1);
                    if ($Mc == "tar") echo
                    pack("x512");
                }
            }
        }
        if ($be) echo "-- " . $g->result("SELECT NOW()") . "\n";
        exit;
    }
    page_header('Export', $n, ($_GET["export"] != "" ? array("table" => $_GET["export"]) : array()), h(DB));
    echo '
<form action="" method="post">
<table cellspacing="0" class="layout">
';
    $Tb = array('', 'USE', 'DROP+CREATE', 'CREATE');
    $Sh = array('', 'DROP+CREATE', 'CREATE');
    $Qb = array('', 'TRUNCATE+INSERT', 'INSERT');
    if ($y == "sql") $Qb[] = 'INSERT+UPDATE';
    parse_str($_COOKIE["adminer_export"], $J);
    if (!$J) $J = array("output" => "text", "format" => "sql", "db_style" => (DB != "" ? "" : "CREATE"), "table_style" => "DROP+CREATE", "data_style" => "INSERT");
    if (!isset($J["events"])) {
        $J["routines"] = $J["events"] = ($_GET["dump"] == "");
        $J["triggers"] = $J["table_style"];
    }
    echo "<tr><th>" . 'Output' . "<td>" . html_select("output", $b->dumpOutput(), $J["output"], 0) . "\n";
    echo "<tr><th>" . 'Format' . "<td>" . html_select("format", $b->dumpFormat(), $J["format"], 0) . "\n";
    echo($y == "sqlite" ? "" : "<tr><th>" . 'Database' . "<td>" . html_select('db_style', $Tb, $J["db_style"]) . (support("routine") ? checkbox("routines", 1, $J["routines"], 'Routines') : "") . (support("event") ? checkbox("events", 1, $J["events"], 'Events') : "")), "<tr><th>" . 'Tables' . "<td>" . html_select('table_style', $Sh, $J["table_style"]) . checkbox("auto_increment", 1, $J["auto_increment"], 'Auto Increment') . (support("trigger") ? checkbox("triggers", 1, $J["triggers"], 'Triggers') : ""), "<tr><th>" . 'Data' . "<td>" . html_select('data_style', $Qb, $J["data_style"]), '</table>
<p><input type="submit" value="Export">
<input type="hidden" name="token" value="', $ni, '">

<table cellspacing="0">
', script("qsl('table').onclick = dumpClick;");
    $jg = array();
    if (DB != "") {
        $cb = ($a != "" ? "" : " checked");
        echo "<thead><tr>", "<th style='text-align: left;'><label class='block'><input type='checkbox' id='check-tables'$cb>" . 'Tables' . "</label>" . script("qs('#check-tables').onclick = partial(formCheck, /^tables\\[/);", ""), "<th style='text-align: right;'><label class='block'>" . 'Data' . "<input type='checkbox' id='check-data'$cb></label>" . script("qs('#check-data').onclick = partial(formCheck, /^data\\[/);", ""), "</thead>\n";
        $Yi = "";
        $Th = tables_list();
        foreach ($Th
                 as $D => $T) {
            $ig = preg_replace('~_.*~', '', $D);
            $cb = ($a == "" || $a == (substr($a, -1) == "%" ? "$ig%" : $D));
            $mg = "<tr><td>" . checkbox("tables[]", $D, $cb, $D, "", "block");
            if ($T !== null && !preg_match('~table~i', $T)) $Yi .= "$mg\n"; else
                echo "$mg<td align='right'><label class='block'><span id='Rows-" . h($D) . "'></span>" . checkbox("data[]", $D, $cb) . "</label>\n";
            $jg[$ig]++;
        }
        echo $Yi;
        if ($Th) echo
        script("ajaxSetHtml('" . js_escape(ME) . "script=db');");
    } else {
        echo "<thead><tr><th style='text-align: left;'>", "<label class='block'><input type='checkbox' id='check-databases'" . ($a == "" ? " checked" : "") . ">" . 'Database' . "</label>", script("qs('#check-databases').onclick = partial(formCheck, /^databases\\[/);", ""), "</thead>\n";
        $k = $b->databases();
        if ($k) {
            foreach ($k
                     as $l) {
                if (!information_schema($l)) {
                    $ig = preg_replace('~_.*~', '', $l);
                    echo "<tr><td>" . checkbox("databases[]", $l, $a == "" || $a == "$ig%", $l, "", "block") . "\n";
                    $jg[$ig]++;
                }
            }
        } else
            echo "<tr><td><textarea name='databases' rows='10' cols='20'></textarea>";
    }
    echo '</table>
</form>
';
    $Zc = true;
    foreach ($jg
             as $z => $X) {
        if ($z != "" && $X > 1) {
            echo ($Zc ? "<p>" : " ") . "<a href='" . h(ME) . "dump=" . urlencode("$z%") . "'>" . h($z) . "</a>";
            $Zc = false;
        }
    }
} elseif (isset($_GET["privileges"])) {
    page_header('Privileges');
    echo '<p class="links"><a href="' . h(ME) . 'user=">' . 'Create user' . "</a>";
    $H = $g->query("SELECT User, Host FROM mysql." . (DB == "" ? "user" : "db WHERE " . q(DB) . " LIKE Db") . " ORDER BY Host, User");
    $od = $H;
    if (!$H) $H = $g->query("SELECT SUBSTRING_INDEX(CURRENT_USER, '@', 1) AS User, SUBSTRING_INDEX(CURRENT_USER, '@', -1) AS Host");
    echo "<form action=''><p>\n";
    hidden_fields_get();
    echo "<input type='hidden' name='db' value='" . h(DB) . "'>\n", ($od ? "" : "<input type='hidden' name='grant' value=''>\n"), "<table cellspacing='0'>\n", "<thead><tr><th>" . 'Username' . "<th>" . 'Server' . "<th></thead>\n";
    while ($J = $H->fetch_assoc()) echo '<tr' . odd() . '><td>' . h($J["User"]) . "<td>" . h($J["Host"]) . '<td><a href="' . h(ME . 'user=' . urlencode($J["User"]) . '&host=' . urlencode($J["Host"])) . '">' . 'Edit' . "</a>\n";
    if (!$od || DB != "") echo "<tr" . odd() . "><td><input name='user' autocapitalize='off'><td><input name='host' value='localhost' autocapitalize='off'><td><input type='submit' value='" . 'Edit' . "'>\n";
    echo "</table>\n", "</form>\n";
} elseif (isset($_GET["sql"])) {
    if (!$n && $_POST["export"]) {
        dump_headers("sql");
        $b->dumpTable("", "");
        $b->dumpData("", "table", $_POST["query"]);
        exit;
    }
    restart_session();
    $Bd =& get_session("queries");
    $Ad =& $Bd[DB];
    if (!$n && $_POST["clear"]) {
        $Ad = array();
        redirect(remove_from_uri("history"));
    }
    page_header((isset($_GET["import"]) ? 'Import' : 'SQL command'), $n);
    if (!$n && $_POST) {
        $ld = false;
        if (!isset($_GET["import"])) $G = $_POST["query"]; elseif ($_POST["webfile"]) {
            $zh = $b->importServerPath();
            $ld = @fopen((file_exists($zh) ? $zh : "compress.zlib://$zh.gz"), "rb");
            $G = ($ld ? fread($ld, 1e6) : false);
        } else$G = get_file("sql_file", true);
        if (is_string($G)) {
            if (function_exists('memory_get_usage')) @ini_set("memory_limit", max(ini_bytes("memory_limit"), 2 * strlen($G) + memory_get_usage() + 8e6));
            if ($G != "" && strlen($G) < 1e6) {
                $ug = $G . (preg_match("~;[ \t\r\n]*\$~", $G) ? "" : ";");
                if (!$Ad || reset(end($Ad)) != $ug) {
                    restart_session();
                    $Ad[] = array($ug, time());
                    set_session("queries", $Bd);
                    stop_session();
                }
            }
            $wh = "(?:\\s|/\\*[\s\S]*?\\*/|(?:#|-- )[^\n]*\n?|--\r?\n)";
            $ac = ";";
            $hf = 0;
            $xc = true;
            $h = connect();
            if (is_object($h) && DB != "") {
                $h->select_db(DB);
                if ($_GET["ns"] != "") set_schema($_GET["ns"], $h);
            }
            $qb = 0;
            $Bc = array();
            $Pf = '[\'"' . ($y == "sql" ? '`#' : ($y == "sqlite" ? '`[' : ($y == "mssql" ? '[' : ''))) . ']|/\*|-- |$' . ($y == "pgsql" ? '|\$[^$]*\$' : '');
            $pi = microtime(true);
            parse_str($_COOKIE["adminer_export"], $xa);
            $oc = $b->dumpFormat();
            unset($oc["sql"]);
            while ($G != "") {
                if (!$hf && preg_match("~^$wh*+DELIMITER\\s+(\\S+)~i", $G, $C)) {
                    $ac = $C[1];
                    $G = substr($G, strlen($C[0]));
                } else {
                    preg_match('(' . preg_quote($ac) . "\\s*|$Pf)", $G, $C, PREG_OFFSET_CAPTURE, $hf);
                    list($jd, $eg) = $C[0];
                    if (!$jd && $ld && !feof($ld)) $G .= fread($ld, 1e5); else {
                        if (!$jd && rtrim($G) == "") break;
                        $hf = $eg + strlen($jd);
                        if ($jd && rtrim($jd) != $ac) {
                            while (preg_match('(' . ($jd == '/*' ? '\*/' : ($jd == '[' ? ']' : (preg_match('~^-- |^#~', $jd) ? "\n" : preg_quote($jd) . "|\\\\."))) . '|$)s', $G, $C, PREG_OFFSET_CAPTURE, $hf)) {
                                $Xg = $C[0][0];
                                if (!$Xg && $ld && !feof($ld)) $G .= fread($ld, 1e5); else {
                                    $hf = $C[0][1] + strlen($Xg);
                                    if ($Xg[0] != "\\") break;
                                }
                            }
                        } else {
                            $xc = false;
                            $ug = substr($G, 0, $eg);
                            $qb++;
                            $mg = "<pre id='sql-$qb'><code class='jush-$y'>" . $b->sqlCommandQuery($ug) . "</code></pre>\n";
                            if ($y == "sqlite" && preg_match("~^$wh*+ATTACH\\b~i", $ug, $C)) {
                                echo $mg, "<p class='error'>" . 'ATTACH queries are not supported.' . "\n";
                                $Bc[] = " <a href='#sql-$qb'>$qb</a>";
                                if ($_POST["error_stops"]) break;
                            } else {
                                if (!$_POST["only_errors"]) {
                                    echo $mg;
                                    ob_flush();
                                    flush();
                                }
                                $Ch = microtime(true);
                                if ($g->multi_query($ug) && is_object($h) && preg_match("~^$wh*+USE\\b~i", $ug)) $h->query($ug);
                                do {
                                    $H = $g->store_result();
                                    if ($g->error) {
                                        echo($_POST["only_errors"] ? $mg : ""), "<p class='error'>" . 'Error in query' . ($g->errno ? " ($g->errno)" : "") . ": " . error() . "\n";
                                        $Bc[] = " <a href='#sql-$qb'>$qb</a>";
                                        if ($_POST["error_stops"]) break
                                        2;
                                    } else {
                                        $di = " <span class='time'>(" . format_time($Ch) . ")</span>" . (strlen($ug) < 1000 ? " <a href='" . h(ME) . "sql=" . urlencode(trim($ug)) . "'>" . 'Edit' . "</a>" : "");
                                        $za = $g->affected_rows;
                                        $bj = ($_POST["only_errors"] ? "" : $m->warnings());
                                        $cj = "warnings-$qb";
                                        if ($bj) $di .= ", <a href='#$cj'>" . 'Warnings' . "</a>" . script("qsl('a').onclick = partial(toggle, '$cj');", "");
                                        $Jc = null;
                                        $Kc = "explain-$qb";
                                        if (is_object($H)) {
                                            $_ = $_POST["limit"];
                                            $Bf = select($H, $h, array(), $_);
                                            if (!$_POST["only_errors"]) {
                                                echo "<form action='' method='post'>\n";
                                                $df = $H->num_rows;
                                                echo "<p>" . ($df ? ($_ && $df > $_ ? sprintf('%d / ', $_) : "") . lang(array('%d row', '%d rows'), $df) : ""), $di;
                                                if ($h && preg_match("~^($wh|\\()*+SELECT\\b~i", $ug) && ($Jc = explain($h, $ug))) echo ", <a href='#$Kc'>Explain</a>" . script("qsl('a').onclick = partial(toggle, '$Kc');", "");
                                                $u = "export-$qb";
                                                echo ", <a href='#$u'>" . 'Export' . "</a>" . script("qsl('a').onclick = partial(toggle, '$u');", "") . "<span id='$u' class='hidden'>: " . html_select("output", $b->dumpOutput(), $xa["output"]) . " " . html_select("format", $oc, $xa["format"]) . "<input type='hidden' name='query' value='" . h($ug) . "'>" . " <input type='submit' name='export' value='" . 'Export' . "'><input type='hidden' name='token' value='$ni'></span>\n" . "</form>\n";
                                            }
                                        } else {
                                            if (preg_match("~^$wh*+(CREATE|DROP|ALTER)$wh++(DATABASE|SCHEMA)\\b~i", $ug)) {
                                                restart_session();
                                                set_session("dbs", null);
                                                stop_session();
                                            }
                                            if (!$_POST["only_errors"]) echo "<p class='message' title='" . h($g->info) . "'>" . lang(array('Query executed OK, %d row affected.', 'Query executed OK, %d rows affected.'), $za) . "$di\n";
                                        }
                                        echo($bj ? "<div id='$cj' class='hidden'>\n$bj</div>\n" : "");
                                        if ($Jc) {
                                            echo "<div id='$Kc' class='hidden'>\n";
                                            select($Jc, $h, $Bf);
                                            echo "</div>\n";
                                        }
                                    }
                                    $Ch = microtime(true);
                                } while ($g->next_result());
                            }
                            $G = substr($G, $hf);
                            $hf = 0;
                        }
                    }
                }
            }
            if ($xc) echo "<p class='message'>" . 'No commands to execute.' . "\n"; elseif ($_POST["only_errors"]) {
                echo "<p class='message'>" . lang(array('%d query executed OK.', '%d queries executed OK.'), $qb - count($Bc)), " <span class='time'>(" . format_time($pi) . ")</span>\n";
            } elseif ($Bc && $qb > 1) echo "<p class='error'>" . 'Error in query' . ": " . implode("", $Bc) . "\n";
        } else
            echo "<p class='error'>" . upload_error($G) . "\n";
    }
    echo '
<form action="" method="post" enctype="multipart/form-data" id="form">
';
    $Hc = "<input type='submit' value='" . 'Execute' . "' title='Ctrl+Enter'>";
    if (!isset($_GET["import"])) {
        $ug = $_GET["sql"];
        if ($_POST) $ug = $_POST["query"]; elseif ($_GET["history"] == "all") $ug = $Ad;
        elseif ($_GET["history"] != "") $ug = $Ad[$_GET["history"]][0];
        echo "<p>";
        textarea("query", $ug, 20);
        echo
        script(($_POST ? "" : "qs('textarea').focus();\n") . "qs('#form').onsubmit = partial(sqlSubmit, qs('#form'), '" . js_escape(remove_from_uri("sql|limit|error_stops|only_errors|history")) . "');"), "<p>$Hc\n", 'Limit rows' . ": <input type='number' name='limit' class='size' value='" . h($_POST ? $_POST["limit"] : $_GET["limit"]) . "'>\n";
    } else {
        echo "<fieldset><legend>" . 'File upload' . "</legend><div>";
        $ud = (extension_loaded("zlib") ? "[.gz]" : "");
        echo(ini_bool("file_uploads") ? "SQL$ud (&lt; " . ini_get("upload_max_filesize") . "B): <input type='file' name='sql_file[]' multiple>\n$Hc" : 'File uploads are disabled.'), "</div></fieldset>\n";
        $Id = $b->importServerPath();
        if ($Id) {
            echo "<fieldset><legend>" . 'From server' . "</legend><div>", sprintf('Webserver file %s', "<code>" . h($Id) . "$ud</code>"), ' <input type="submit" name="webfile" value="' . 'Run file' . '">', "</div></fieldset>\n";
        }
        echo "<p>";
    }
    echo
        checkbox("error_stops", 1, ($_POST ? $_POST["error_stops"] : isset($_GET["import"]) || $_GET["error_stops"]), 'Stop on error') . "\n", checkbox("only_errors", 1, ($_POST ? $_POST["only_errors"] : isset($_GET["import"]) || $_GET["only_errors"]), 'Show only errors') . "\n", "<input type='hidden' name='token' value='$ni'>\n";
    if (!isset($_GET["import"]) && $Ad) {
        print_fieldset("history", 'History', $_GET["history"] != "");
        for ($X = end($Ad); $X; $X = prev($Ad)) {
            $z = key($Ad);
            list($ug, $di, $sc) = $X;
            echo '<a href="' . h(ME . "sql=&history=$z") . '">' . 'Edit' . "</a>" . " <span class='time' title='" . @date('Y-m-d', $di) . "'>" . @date("H:i:s", $di) . "</span>" . " <code class='jush-$y'>" . shorten_utf8(ltrim(str_replace("\n", " ", str_replace("\r", "", preg_replace('~^(#|-- ).*~m', '', $ug)))), 80, "</code>") . ($sc ? " <span class='time'>($sc)</span>" : "") . "<br>\n";
        }
        echo "<input type='submit' name='clear' value='" . 'Clear' . "'>\n", "<a href='" . h(ME . "sql=&history=all") . "'>" . 'Edit all' . "</a>\n", "</div></fieldset>\n";
    }
    echo '</form>
';
} elseif (isset($_GET["edit"])) {
    $a = $_GET["edit"];
    $p = fields($a);
    $Z = (isset($_GET["select"]) ? ($_POST["check"] && count($_POST["check"]) == 1 ? where_check($_POST["check"][0], $p) : "") : where($_GET, $p));
    $Ii = (isset($_GET["select"]) ? $_POST["edit"] : $Z);
    foreach ($p
             as $D => $o) {
        if (!isset($o["privileges"][$Ii ? "update" : "insert"]) || $b->fieldName($o) == "" || $o["generated"]) unset($p[$D]);
    }
    if ($_POST && !$n && !isset($_GET["select"])) {
        $B = $_POST["referer"];
        if ($_POST["insert"]) $B = ($Ii ? null : $_SERVER["REQUEST_URI"]); elseif (!preg_match('~^.+&select=.+$~', $B)) $B = ME . "select=" . urlencode($a);
        $x = indexes($a);
        $Di = unique_array($_GET["where"], $x);
        $xg = "\nWHERE $Z";
        if (isset($_POST["delete"])) queries_redirect($B, 'Item has been deleted.', $m->delete($a, $xg, !$Di)); else {
            $N = array();
            foreach ($p
                     as $D => $o) {
                $X = process_input($o);
                if ($X !== false && $X !== null) $N[idf_escape($D)] = $X;
            }
            if ($Ii) {
                if (!$N) redirect($B);
                queries_redirect($B, 'Item has been updated.', $m->update($a, $N, $xg, !$Di));
                if (is_ajax()) {
                    page_headers();
                    page_messages($n);
                    exit;
                }
            } else {
                $H = $m->insert($a, $N);
                $oe = ($H ? last_id() : 0);
                queries_redirect($B, sprintf('Item%s has been inserted.', ($oe ? " $oe" : "")), $H);
            }
        }
    }
    $J = null;
    if ($_POST["save"]) $J = (array)$_POST["fields"]; elseif ($Z) {
        $L = array();
        foreach ($p
                 as $D => $o) {
            if (isset($o["privileges"]["select"])) {
                $Fa = convert_field($o);
                if ($_POST["clone"] && $o["auto_increment"]) $Fa = "''";
                if ($y == "sql" && preg_match("~enum|set~", $o["type"])) $Fa = "1*" . idf_escape($D);
                $L[] = ($Fa ? "$Fa AS " : "") . idf_escape($D);
            }
        }
        $J = array();
        if (!support("table")) $L = array("*");
        if ($L) {
            $H = $m->select($a, $L, array($Z), $L, array(), (isset($_GET["select"]) ? 2 : 1));
            if (!$H) $n = error(); else {
                $J = $H->fetch_assoc();
                if (!$J) $J = false;
            }
            if (isset($_GET["select"]) && (!$J || $H->fetch_assoc())) $J = null;
        }
    }
    if (!support("table") && !$p) {
        if (!$Z) {
            $H = $m->select($a, array("*"), $Z, array("*"));
            $J = ($H ? $H->fetch_assoc() : false);
            if (!$J) $J = array($m->primary => "");
        }
        if ($J) {
            foreach ($J
                     as $z => $X) {
                if (!$Z) $J[$z] = null;
                $p[$z] = array("field" => $z, "null" => ($z != $m->primary), "auto_increment" => ($z == $m->primary));
            }
        }
    }
    edit_form($a, $p, $J, $Ii);
} elseif (isset($_GET["create"])) {
    $a = $_GET["create"];
    $Rf = array();
    foreach (array('HASH', 'LINEAR HASH', 'KEY', 'LINEAR KEY', 'RANGE', 'LIST') as $z) $Rf[$z] = $z;
    $Dg = referencable_primary($a);
    $hd = array();
    foreach ($Dg
             as $Oh => $o) $hd[str_replace("`", "``", $Oh) . "`" . str_replace("`", "``", $o["field"])] = $Oh;
    $Ef = array();
    $R = array();
    if ($a != "") {
        $Ef = fields($a);
        $R = table_status($a);
        if (!$R) $n = 'No tables.';
    }
    $J = $_POST;
    $J["fields"] = (array)$J["fields"];
    if ($J["auto_increment_col"]) $J["fields"][$J["auto_increment_col"]]["auto_increment"] = true;
    if ($_POST) set_adminer_settings(array("comments" => $_POST["comments"], "defaults" => $_POST["defaults"]));
    if ($_POST && !process_fields($J["fields"]) && !$n) {
        if ($_POST["drop"]) queries_redirect(substr(ME, 0, -1), 'Table has been dropped.', drop_tables(array($a))); else {
            $p = array();
            $Ca = array();
            $Mi = false;
            $fd = array();
            $Df = reset($Ef);
            $Aa = " FIRST";
            foreach ($J["fields"] as $z => $o) {
                $r = $hd[$o["type"]];
                $_i = ($r !== null ? $Dg[$r] : $o);
                if ($o["field"] != "") {
                    if (!$o["has_default"]) $o["default"] = null;
                    if ($z == $J["auto_increment_col"]) $o["auto_increment"] = true;
                    $rg = process_field($o, $_i);
                    $Ca[] = array($o["orig"], $rg, $Aa);
                    if (!$Df || $rg != process_field($Df, $Df)) {
                        $p[] = array($o["orig"], $rg, $Aa);
                        if ($o["orig"] != "" || $Aa) $Mi = true;
                    }
                    if ($r !== null) $fd[idf_escape($o["field"])] = ($a != "" && $y != "sqlite" ? "ADD" : " ") . format_foreign_key(array('table' => $hd[$o["type"]], 'source' => array($o["field"]), 'target' => array($_i["field"]), 'on_delete' => $o["on_delete"],));
                    $Aa = " AFTER " . idf_escape($o["field"]);
                } elseif ($o["orig"] != "") {
                    $Mi = true;
                    $p[] = array($o["orig"]);
                }
                if ($o["orig"] != "") {
                    $Df = next($Ef);
                    if (!$Df) $Aa = "";
                }
            }
            $Tf = "";
            if ($Rf[$J["partition_by"]]) {
                $Uf = array();
                if ($J["partition_by"] == 'RANGE' || $J["partition_by"] == 'LIST') {
                    foreach (array_filter($J["partition_names"]) as $z => $X) {
                        $Y = $J["partition_values"][$z];
                        $Uf[] = "\n  PARTITION " . idf_escape($X) . " VALUES " . ($J["partition_by"] == 'RANGE' ? "LESS THAN" : "IN") . ($Y != "" ? " ($Y)" : " MAXVALUE");
                    }
                }
                $Tf .= "\nPARTITION BY $J[partition_by]($J[partition])" . ($Uf ? " (" . implode(",", $Uf) . "\n)" : ($J["partitions"] ? " PARTITIONS " . (+$J["partitions"]) : ""));
            } elseif (support("partitioning") && preg_match("~partitioned~", $R["Create_options"])) $Tf .= "\nREMOVE PARTITIONING";
            $Ke = 'Table has been altered.';
            if ($a == "") {
                cookie("adminer_engine", $J["Engine"]);
                $Ke = 'Table has been created.';
            }
            $D = trim($J["name"]);
            queries_redirect(ME . (support("table") ? "table=" : "select=") . urlencode($D), $Ke, alter_table($a, $D, ($y == "sqlite" && ($Mi || $fd) ? $Ca : $p), $fd, ($J["Comment"] != $R["Comment"] ? $J["Comment"] : null), ($J["Engine"] && $J["Engine"] != $R["Engine"] ? $J["Engine"] : ""), ($J["Collation"] && $J["Collation"] != $R["Collation"] ? $J["Collation"] : ""), ($J["Auto_increment"] != "" ? number($J["Auto_increment"]) : ""), $Tf));
        }
    }
    page_header(($a != "" ? 'Alter table' : 'Create table'), $n, array("table" => $a), h($a));
    if (!$_POST) {
        $J = array("Engine" => $_COOKIE["adminer_engine"], "fields" => array(array("field" => "", "type" => (isset($U["int"]) ? "int" : (isset($U["integer"]) ? "integer" : "")), "on_update" => "")), "partition_names" => array(""),);
        if ($a != "") {
            $J = $R;
            $J["name"] = $a;
            $J["fields"] = array();
            if (!$_GET["auto_increment"]) $J["Auto_increment"] = "";
            foreach ($Ef
                     as $o) {
                $o["has_default"] = isset($o["default"]);
                $J["fields"][] = $o;
            }
            if (support("partitioning")) {
                $md = "FROM information_schema.PARTITIONS WHERE TABLE_SCHEMA = " . q(DB) . " AND TABLE_NAME = " . q($a);
                $H = $g->query("SELECT PARTITION_METHOD, PARTITION_ORDINAL_POSITION, PARTITION_EXPRESSION $md ORDER BY PARTITION_ORDINAL_POSITION DESC LIMIT 1");
                list($J["partition_by"], $J["partitions"], $J["partition"]) = $H->fetch_row();
                $Uf = get_key_vals("SELECT PARTITION_NAME, PARTITION_DESCRIPTION $md AND PARTITION_NAME != '' ORDER BY PARTITION_ORDINAL_POSITION");
                $Uf[""] = "";
                $J["partition_names"] = array_keys($Uf);
                $J["partition_values"] = array_values($Uf);
            }
        }
    }
    $lb = collations();
    $zc = engines();
    foreach ($zc
             as $yc) {
        if (!strcasecmp($yc, $J["Engine"])) {
            $J["Engine"] = $yc;
            break;
        }
    }
    echo '
<form action="" method="post" id="form">
<p>
';
    if (support("columns") || $a == "") {
        echo 'Table name: <input name="name" data-maxlength="64" value="', h($J["name"]), '" autocapitalize="off">
';
        if ($a == "" && !$_POST) echo
        script("focus(qs('#form')['name']);");
        echo($zc ? "<select name='Engine'>" . optionlist(array("" => "(" . 'engine' . ")") + $zc, $J["Engine"]) . "</select>" . on_help("getTarget(event).value", 1) . script("qsl('select').onchange = helpClose;") : ""), ' ', ($lb && !preg_match("~sqlite|mssql~", $y) ? html_select("Collation", array("" => "(" . 'collation' . ")") + $lb, $J["Collation"]) : ""), ' <input type="submit" value="Save">
';
    }
    echo '
';
    if (support("columns")) {
        echo '<div class="scrollable">
<table cellspacing="0" id="edit-fields" class="nowrap">
';
        edit_fields($J["fields"], $lb, "TABLE", $hd);
        echo '</table>
', script("editFields();"), '</div>
<p>
Auto Increment: <input type="number" name="Auto_increment" size="6" value="', h($J["Auto_increment"]), '">
', checkbox("defaults", 1, ($_POST ? $_POST["defaults"] : adminer_setting("defaults")), 'Default values', "columnShow(this.checked, 5)", "jsonly"), (support("comment") ? checkbox("comments", 1, ($_POST ? $_POST["comments"] : adminer_setting("comments")), 'Comment', "editingCommentsClick(this, true);", "jsonly") . ' <input name="Comment" value="' . h($J["Comment"]) . '" data-maxlength="' . (min_version(5.5) ? 2048 : 60) . '">' : ''), '<p>
<input type="submit" value="Save">
';
    }
    echo '
';
    if ($a != "") {
        echo '<input type="submit" name="drop" value="Drop">', confirm(sprintf('Drop %s?', $a));
    }
    if (support("partitioning")) {
        $Sf = preg_match('~RANGE|LIST~', $J["partition_by"]);
        print_fieldset("partition", 'Partition by', $J["partition_by"]);
        echo '<p>
', "<select name='partition_by'>" . optionlist(array("" => "") + $Rf, $J["partition_by"]) . "</select>" . on_help("getTarget(event).value.replace(/./, 'PARTITION BY \$&')", 1) . script("qsl('select').onchange = partitionByChange;"), '(<input name="partition" value="', h($J["partition"]), '">)
Partitions: <input type="number" name="partitions" class="size', ($Sf || !$J["partition_by"] ? " hidden" : ""), '" value="', h($J["partitions"]), '">
<table cellspacing="0" id="partition-table"', ($Sf ? "" : " class='hidden'"), '>
<thead><tr><th>Partition name<th>Values</thead>
';
        foreach ($J["partition_names"] as $z => $X) {
            echo '<tr>', '<td><input name="partition_names[]" value="' . h($X) . '" autocapitalize="off">', ($z == count($J["partition_names"]) - 1 ? script("qsl('input').oninput = partitionNameChange;") : ''), '<td><input name="partition_values[]" value="' . h($J["partition_values"][$z]) . '">';
        }
        echo '</table>
</div></fieldset>
';
    }
    echo '<input type="hidden" name="token" value="', $ni, '">
</form>
';
} elseif (isset($_GET["indexes"])) {
    $a = $_GET["indexes"];
    $Ld = array("PRIMARY", "UNIQUE", "INDEX");
    $R = table_status($a, true);
    if (preg_match('~MyISAM|M?aria' . (min_version(5.6, '10.0.5') ? '|InnoDB' : '') . '~i', $R["Engine"])) $Ld[] = "FULLTEXT";
    if (preg_match('~MyISAM|M?aria' . (min_version(5.7, '10.2.2') ? '|InnoDB' : '') . '~i', $R["Engine"])) $Ld[] = "SPATIAL";
    $x = indexes($a);
    $kg = array();
    if ($y == "mongo") {
        $kg = $x["_id_"];
        unset($Ld[0]);
        unset($x["_id_"]);
    }
    $J = $_POST;
    if ($_POST && !$n && !$_POST["add"] && !$_POST["drop_col"]) {
        $c = array();
        foreach ($J["indexes"] as $w) {
            $D = $w["name"];
            if (in_array($w["type"], $Ld)) {
                $f = array();
                $ue = array();
                $cc = array();
                $N = array();
                ksort($w["columns"]);
                foreach ($w["columns"] as $z => $e) {
                    if ($e != "") {
                        $te = $w["lengths"][$z];
                        $bc = $w["descs"][$z];
                        $N[] = idf_escape($e) . ($te ? "(" . (+$te) . ")" : "") . ($bc ? " DESC" : "");
                        $f[] = $e;
                        $ue[] = ($te ? $te : null);
                        $cc[] = $bc;
                    }
                }
                if ($f) {
                    $Ic = $x[$D];
                    if ($Ic) {
                        ksort($Ic["columns"]);
                        ksort($Ic["lengths"]);
                        ksort($Ic["descs"]);
                        if ($w["type"] == $Ic["type"] && array_values($Ic["columns"]) === $f && (!$Ic["lengths"] || array_values($Ic["lengths"]) === $ue) && array_values($Ic["descs"]) === $cc) {
                            unset($x[$D]);
                            continue;
                        }
                    }
                    $c[] = array($w["type"], $D, $N);
                }
            }
        }
        foreach ($x
                 as $D => $Ic) $c[] = array($Ic["type"], $D, "DROP");
        if (!$c) redirect(ME . "table=" . urlencode($a));
        queries_redirect(ME . "table=" . urlencode($a), 'Indexes have been altered.', alter_indexes($a, $c));
    }
    page_header('Indexes', $n, array("table" => $a), h($a));
    $p = array_keys(fields($a));
    if ($_POST["add"]) {
        foreach ($J["indexes"] as $z => $w) {
            if ($w["columns"][count($w["columns"])] != "") $J["indexes"][$z]["columns"][] = "";
        }
        $w = end($J["indexes"]);
        if ($w["type"] || array_filter($w["columns"], 'strlen')) $J["indexes"][] = array("columns" => array(1 => ""));
    }
    if (!$J) {
        foreach ($x
                 as $z => $w) {
            $x[$z]["name"] = $z;
            $x[$z]["columns"][] = "";
        }
        $x[] = array("columns" => array(1 => ""));
        $J["indexes"] = $x;
    }
    echo '
<form action="" method="post">
<div class="scrollable">
<table cellspacing="0" class="nowrap">
<thead><tr>
<th id="label-type">Index Type
<th><input type="submit" class="wayoff">Column (length)
<th id="label-name">Name
<th><noscript>', "<input type='image' class='icon' name='add[0]' src='" . h(preg_replace("~\\?.*~", "", ME) . "?file=plus.gif&version=4.8.1") . "' alt='+' title='" . 'Add next' . "'>", '</noscript>
</thead>
';
    if ($kg) {
        echo "<tr><td>PRIMARY<td>";
        foreach ($kg["columns"] as $z => $e) {
            echo
            select_input(" disabled", $p, $e), "<label><input disabled type='checkbox'>" . 'descending' . "</label> ";
        }
        echo "<td><td>\n";
    }
    $ee = 1;
    foreach ($J["indexes"] as $w) {
        if (!$_POST["drop_col"] || $ee != key($_POST["drop_col"])) {
            echo "<tr><td>" . html_select("indexes[$ee][type]", array(-1 => "") + $Ld, $w["type"], ($ee == count($J["indexes"]) ? "indexesAddRow.call(this);" : 1), "label-type"), "<td>";
            ksort($w["columns"]);
            $t = 1;
            foreach ($w["columns"] as $z => $e) {
                echo "<span>" . select_input(" name='indexes[$ee][columns][$t]' title='" . 'Column' . "'", ($p ? array_combine($p, $p) : $p), $e, "partial(" . ($t == count($w["columns"]) ? "indexesAddColumn" : "indexesChangeColumn") . ", '" . js_escape($y == "sql" ? "" : $_GET["indexes"] . "_") . "')"), ($y == "sql" || $y == "mssql" ? "<input type='number' name='indexes[$ee][lengths][$t]' class='size' value='" . h($w["lengths"][$z]) . "' title='" . 'Length' . "'>" : ""), (support("descidx") ? checkbox("indexes[$ee][descs][$t]", 1, $w["descs"][$z], 'descending') : ""), " </span>";
                $t++;
            }
            echo "<td><input name='indexes[$ee][name]' value='" . h($w["name"]) . "' autocapitalize='off' aria-labelledby='label-name'>\n", "<td><input type='image' class='icon' name='drop_col[$ee]' src='" . h(preg_replace("~\\?.*~", "", ME) . "?file=cross.gif&version=4.8.1") . "' alt='x' title='" . 'Remove' . "'>" . script("qsl('input').onclick = partial(editingRemoveRow, 'indexes\$1[type]');");
        }
        $ee++;
    }
    echo '</table>
</div>
<p>
<input type="submit" value="Save">
<input type="hidden" name="token" value="', $ni, '">
</form>
';
} elseif (isset($_GET["database"])) {
    $J = $_POST;
    if ($_POST && !$n && !isset($_POST["add_x"])) {
        $D = trim($J["name"]);
        if ($_POST["drop"]) {
            $_GET["db"] = "";
            queries_redirect(remove_from_uri("db|database"), 'Database has been dropped.', drop_databases(array(DB)));
        } elseif (DB !== $D) {
            if (DB != "") {
                $_GET["db"] = $D;
                queries_redirect(preg_replace('~\bdb=[^&]*&~', '', ME) . "db=" . urlencode($D), 'Database has been renamed.', rename_database($D, $J["collation"]));
            } else {
                $k = explode("\n", str_replace("\r", "", $D));
                $Ih = true;
                $ne = "";
                foreach ($k
                         as $l) {
                    if (count($k) == 1 || $l != "") {
                        if (!create_database($l, $J["collation"])) $Ih = false;
                        $ne = $l;
                    }
                }
                restart_session();
                set_session("dbs", null);
                queries_redirect(ME . "db=" . urlencode($ne), 'Database has been created.', $Ih);
            }
        } else {
            if (!$J["collation"]) redirect(substr(ME, 0, -1));
            query_redirect("ALTER DATABASE " . idf_escape($D) . (preg_match('~^[a-z0-9_]+$~i', $J["collation"]) ? " COLLATE $J[collation]" : ""), substr(ME, 0, -1), 'Database has been altered.');
        }
    }
    page_header(DB != "" ? 'Alter database' : 'Create database', $n, array(), h(DB));
    $lb = collations();
    $D = DB;
    if ($_POST) $D = $J["name"]; elseif (DB != "") $J["collation"] = db_collation(DB, $lb);
    elseif ($y == "sql") {
        foreach (get_vals("SHOW GRANTS") as $od) {
            if (preg_match('~ ON (`(([^\\\\`]|``|\\\\.)*)%`\.\*)?~', $od, $C) && $C[1]) {
                $D = stripcslashes(idf_unescape("`$C[2]`"));
                break;
            }
        }
    }
    echo '
<form action="" method="post">
<p>
', ($_POST["add_x"] || strpos($D, "\n") ? '<textarea id="name" name="name" rows="10" cols="40">' . h($D) . '</textarea><br>' : '<input name="name" id="name" value="' . h($D) . '" data-maxlength="64" autocapitalize="off">') . "\n" . ($lb ? html_select("collation", array("" => "(" . 'collation' . ")") + $lb, $J["collation"]) . doc_link(array('sql' => "charset-charsets.html", 'mariadb' => "supported-character-sets-and-collations/", 'mssql' => "ms187963.aspx",)) : ""), script("focus(qs('#name'));"), '<input type="submit" value="Save">
';
    if (DB != "") echo "<input type='submit' name='drop' value='" . 'Drop' . "'>" . confirm(sprintf('Drop %s?', DB)) . "\n"; elseif (!$_POST["add_x"] && $_GET["db"] == "") echo "<input type='image' class='icon' name='add' src='" . h(preg_replace("~\\?.*~", "", ME) . "?file=plus.gif&version=4.8.1") . "' alt='+' title='" . 'Add next' . "'>\n";
    echo '<input type="hidden" name="token" value="', $ni, '">
</form>
';
} elseif (isset($_GET["scheme"])) {
    $J = $_POST;
    if ($_POST && !$n) {
        $A = preg_replace('~ns=[^&]*&~', '', ME) . "ns=";
        if ($_POST["drop"]) query_redirect("DROP SCHEMA " . idf_escape($_GET["ns"]), $A, 'Schema has been dropped.'); else {
            $D = trim($J["name"]);
            $A .= urlencode($D);
            if ($_GET["ns"] == "") query_redirect("CREATE SCHEMA " . idf_escape($D), $A, 'Schema has been created.'); elseif ($_GET["ns"] != $D) query_redirect("ALTER SCHEMA " . idf_escape($_GET["ns"]) . " RENAME TO " . idf_escape($D), $A, 'Schema has been altered.');
            else
                redirect($A);
        }
    }
    page_header($_GET["ns"] != "" ? 'Alter schema' : 'Create schema', $n);
    if (!$J) $J["name"] = $_GET["ns"];
    echo '
<form action="" method="post">
<p><input name="name" id="name" value="', h($J["name"]), '" autocapitalize="off">
', script("focus(qs('#name'));"), '<input type="submit" value="Save">
';
    if ($_GET["ns"] != "") echo "<input type='submit' name='drop' value='" . 'Drop' . "'>" . confirm(sprintf('Drop %s?', $_GET["ns"])) . "\n";
    echo '<input type="hidden" name="token" value="', $ni, '">
</form>
';
} elseif (isset($_GET["call"])) {
    $da = ($_GET["name"] ? $_GET["name"] : $_GET["call"]);
    page_header('Call' . ": " . h($da), $n);
    $Tg = routine($_GET["call"], (isset($_GET["callf"]) ? "FUNCTION" : "PROCEDURE"));
    $Jd = array();
    $If = array();
    foreach ($Tg["fields"] as $t => $o) {
        if (substr($o["inout"], -3) == "OUT") $If[$t] = "@" . idf_escape($o["field"]) . " AS " . idf_escape($o["field"]);
        if (!$o["inout"] || substr($o["inout"], 0, 2) == "IN") $Jd[] = $t;
    }
    if (!$n && $_POST) {
        $Xa = array();
        foreach ($Tg["fields"] as $z => $o) {
            if (in_array($z, $Jd)) {
                $X = process_input($o);
                if ($X === false) $X = "''";
                if (isset($If[$z])) $g->query("SET @" . idf_escape($o["field"]) . " = $X");
            }
            $Xa[] = (isset($If[$z]) ? "@" . idf_escape($o["field"]) : $X);
        }
        $G = (isset($_GET["callf"]) ? "SELECT" : "CALL") . " " . table($da) . "(" . implode(", ", $Xa) . ")";
        $Ch = microtime(true);
        $H = $g->multi_query($G);
        $za = $g->affected_rows;
        echo $b->selectQuery($G, $Ch, !$H);
        if (!$H) echo "<p class='error'>" . error() . "\n"; else {
            $h = connect();
            if (is_object($h)) $h->select_db(DB);
            do {
                $H = $g->store_result();
                if (is_object($H)) select($H, $h); else
                    echo "<p class='message'>" . lang(array('Routine has been called, %d row affected.', 'Routine has been called, %d rows affected.'), $za) . " <span class='time'>" . @date("H:i:s") . "</span>\n";
            } while ($g->next_result());
            if ($If) select($g->query("SELECT " . implode(", ", $If)));
        }
    }
    echo '
<form action="" method="post">
';
    if ($Jd) {
        echo "<table cellspacing='0' class='layout'>\n";
        foreach ($Jd
                 as $z) {
            $o = $Tg["fields"][$z];
            $D = $o["field"];
            echo "<tr><th>" . $b->fieldName($o);
            $Y = $_POST["fields"][$D];
            if ($Y != "") {
                if ($o["type"] == "enum") $Y = +$Y;
                if ($o["type"] == "set") $Y = array_sum($Y);
            }
            input($o, $Y, (string)$_POST["function"][$D]);
            echo "\n";
        }
        echo "</table>\n";
    }
    echo '<p>
<input type="submit" value="Call">
<input type="hidden" name="token" value="', $ni, '">
</form>
';
} elseif (isset($_GET["foreign"])) {
    $a = $_GET["foreign"];
    $D = $_GET["name"];
    $J = $_POST;
    if ($_POST && !$n && !$_POST["add"] && !$_POST["change"] && !$_POST["change-js"]) {
        $Ke = ($_POST["drop"] ? 'Foreign key has been dropped.' : ($D != "" ? 'Foreign key has been altered.' : 'Foreign key has been created.'));
        $B = ME . "table=" . urlencode($a);
        if (!$_POST["drop"]) {
            $J["source"] = array_filter($J["source"], 'strlen');
            ksort($J["source"]);
            $Wh = array();
            foreach ($J["source"] as $z => $X) $Wh[$z] = $J["target"][$z];
            $J["target"] = $Wh;
        }
        if ($y == "sqlite") queries_redirect($B, $Ke, recreate_table($a, $a, array(), array(), array(" $D" => ($_POST["drop"] ? "" : " " . format_foreign_key($J))))); else {
            $c = "ALTER TABLE " . table($a);
            $jc = "\nDROP " . ($y == "sql" ? "FOREIGN KEY " : "CONSTRAINT ") . idf_escape($D);
            if ($_POST["drop"]) query_redirect($c . $jc, $B, $Ke); else {
                query_redirect($c . ($D != "" ? "$jc," : "") . "\nADD" . format_foreign_key($J), $B, $Ke);
                $n = 'Source and target columns must have the same data type, there must be an index on the target columns and referenced data must exist.' . "<br>$n";
            }
        }
    }
    page_header('Foreign key', $n, array("table" => $a), h($a));
    if ($_POST) {
        ksort($J["source"]);
        if ($_POST["add"]) $J["source"][] = ""; elseif ($_POST["change"] || $_POST["change-js"]) $J["target"] = array();
    } elseif ($D != "") {
        $hd = foreign_keys($a);
        $J = $hd[$D];
        $J["source"][] = "";
    } else {
        $J["table"] = $a;
        $J["source"] = array("");
    }
    echo '
<form action="" method="post">
';
    $vh = array_keys(fields($a));
    if ($J["db"] != "") $g->select_db($J["db"]);
    if ($J["ns"] != "") set_schema($J["ns"]);
    $Cg = array_keys(array_filter(table_status('', true), 'fk_support'));
    $Wh = array_keys(fields(in_array($J["table"], $Cg) ? $J["table"] : reset($Cg)));
    $qf = "this.form['change-js'].value = '1'; this.form.submit();";
    echo "<p>" . 'Target table' . ": " . html_select("table", $Cg, $J["table"], $qf) . "\n";
    if ($y == "pgsql") echo 'Schema' . ": " . html_select("ns", $b->schemas(), $J["ns"] != "" ? $J["ns"] : $_GET["ns"], $qf); elseif ($y != "sqlite") {
        $Ub = array();
        foreach ($b->databases() as $l) {
            if (!information_schema($l)) $Ub[] = $l;
        }
        echo 'DB' . ": " . html_select("db", $Ub, $J["db"] != "" ? $J["db"] : $_GET["db"], $qf);
    }
    echo '<input type="hidden" name="change-js" value="">
<noscript><p><input type="submit" name="change" value="Change"></noscript>
<table cellspacing="0">
<thead><tr><th id="label-source">Source<th id="label-target">Target</thead>
';
    $ee = 0;
    foreach ($J["source"] as $z => $X) {
        echo "<tr>", "<td>" . html_select("source[" . (+$z) . "]", array(-1 => "") + $vh, $X, ($ee == count($J["source"]) - 1 ? "foreignAddRow.call(this);" : 1), "label-source"), "<td>" . html_select("target[" . (+$z) . "]", $Wh, $J["target"][$z], 1, "label-target");
        $ee++;
    }
    echo '</table>
<p>
ON DELETE: ', html_select("on_delete", array(-1 => "") + explode("|", $pf), $J["on_delete"]), ' ON UPDATE: ', html_select("on_update", array(-1 => "") + explode("|", $pf), $J["on_update"]), doc_link(array('sql' => "innodb-foreign-key-constraints.html", 'mariadb' => "foreign-keys/", 'pgsql' => "sql-createtable.html#SQL-CREATETABLE-REFERENCES", 'mssql' => "ms174979.aspx", 'oracle' => "https://docs.oracle.com/cd/B19306_01/server.102/b14200/clauses002.htm#sthref2903",)), '<p>
<input type="submit" value="Save">
<noscript><p><input type="submit" name="add" value="Add column"></noscript>
';
    if ($D != "") {
        echo '<input type="submit" name="drop" value="Drop">', confirm(sprintf('Drop %s?', $D));
    }
    echo '<input type="hidden" name="token" value="', $ni, '">
</form>
';
} elseif (isset($_GET["view"])) {
    $a = $_GET["view"];
    $J = $_POST;
    $Ff = "VIEW";
    if ($y == "pgsql" && $a != "") {
        $O = table_status($a);
        $Ff = strtoupper($O["Engine"]);
    }
    if ($_POST && !$n) {
        $D = trim($J["name"]);
        $Fa = " AS\n$J[select]";
        $B = ME . "table=" . urlencode($D);
        $Ke = 'View has been altered.';
        $T = ($_POST["materialized"] ? "MATERIALIZED VIEW" : "VIEW");
        if (!$_POST["drop"] && $a == $D && $y != "sqlite" && $T == "VIEW" && $Ff == "VIEW") query_redirect(($y == "mssql" ? "ALTER" : "CREATE OR REPLACE") . " VIEW " . table($D) . $Fa, $B, $Ke); else {
            $Yh = $D . "_adminer_" . uniqid();
            drop_create("DROP $Ff " . table($a), "CREATE $T " . table($D) . $Fa, "DROP $T " . table($D), "CREATE $T " . table($Yh) . $Fa, "DROP $T " . table($Yh), ($_POST["drop"] ? substr(ME, 0, -1) : $B), 'View has been dropped.', $Ke, 'View has been created.', $a, $D);
        }
    }
    if (!$_POST && $a != "") {
        $J = view($a);
        $J["name"] = $a;
        $J["materialized"] = ($Ff != "VIEW");
        if (!$n) $n = error();
    }
    page_header(($a != "" ? 'Alter view' : 'Create view'), $n, array("table" => $a), h($a));
    echo '
<form action="" method="post">
<p>Name: <input name="name" value="', h($J["name"]), '" data-maxlength="64" autocapitalize="off">
', (support("materializedview") ? " " . checkbox("materialized", 1, $J["materialized"], 'Materialized view') : ""), '<p>';
    textarea("select", $J["select"]);
    echo '<p>
<input type="submit" value="Save">
';
    if ($a != "") {
        echo '<input type="submit" name="drop" value="Drop">', confirm(sprintf('Drop %s?', $a));
    }
    echo '<input type="hidden" name="token" value="', $ni, '">
</form>
';
} elseif (isset($_GET["event"])) {
    $aa = $_GET["event"];
    $Wd = array("YEAR", "QUARTER", "MONTH", "DAY", "HOUR", "MINUTE", "WEEK", "SECOND", "YEAR_MONTH", "DAY_HOUR", "DAY_MINUTE", "DAY_SECOND", "HOUR_MINUTE", "HOUR_SECOND", "MINUTE_SECOND");
    $Eh = array("ENABLED" => "ENABLE", "DISABLED" => "DISABLE", "SLAVESIDE_DISABLED" => "DISABLE ON SLAVE");
    $J = $_POST;
    if ($_POST && !$n) {
        if ($_POST["drop"]) query_redirect("DROP EVENT " . idf_escape($aa), substr(ME, 0, -1), 'Event has been dropped.'); elseif (in_array($J["INTERVAL_FIELD"], $Wd) && isset($Eh[$J["STATUS"]])) {
            $Yg = "\nON SCHEDULE " . ($J["INTERVAL_VALUE"] ? "EVERY " . q($J["INTERVAL_VALUE"]) . " $J[INTERVAL_FIELD]" . ($J["STARTS"] ? " STARTS " . q($J["STARTS"]) : "") . ($J["ENDS"] ? " ENDS " . q($J["ENDS"]) : "") : "AT " . q($J["STARTS"])) . " ON COMPLETION" . ($J["ON_COMPLETION"] ? "" : " NOT") . " PRESERVE";
            queries_redirect(substr(ME, 0, -1), ($aa != "" ? 'Event has been altered.' : 'Event has been created.'), queries(($aa != "" ? "ALTER EVENT " . idf_escape($aa) . $Yg . ($aa != $J["EVENT_NAME"] ? "\nRENAME TO " . idf_escape($J["EVENT_NAME"]) : "") : "CREATE EVENT " . idf_escape($J["EVENT_NAME"]) . $Yg) . "\n" . $Eh[$J["STATUS"]] . " COMMENT " . q($J["EVENT_COMMENT"]) . rtrim(" DO\n$J[EVENT_DEFINITION]", ";") . ";"));
        }
    }
    page_header(($aa != "" ? 'Alter event' . ": " . h($aa) : 'Create event'), $n);
    if (!$J && $aa != "") {
        $K = get_rows("SELECT * FROM information_schema.EVENTS WHERE EVENT_SCHEMA = " . q(DB) . " AND EVENT_NAME = " . q($aa));
        $J = reset($K);
    }
    echo '
<form action="" method="post">
<table cellspacing="0" class="layout">
<tr><th>Name<td><input name="EVENT_NAME" value="', h($J["EVENT_NAME"]), '" data-maxlength="64" autocapitalize="off">
<tr><th title="datetime">Start<td><input name="STARTS" value="', h("$J[EXECUTE_AT]$J[STARTS]"), '">
<tr><th title="datetime">End<td><input name="ENDS" value="', h($J["ENDS"]), '">
<tr><th>Every<td><input type="number" name="INTERVAL_VALUE" value="', h($J["INTERVAL_VALUE"]), '" class="size"> ', html_select("INTERVAL_FIELD", $Wd, $J["INTERVAL_FIELD"]), '<tr><th>Status<td>', html_select("STATUS", $Eh, $J["STATUS"]), '<tr><th>Comment<td><input name="EVENT_COMMENT" value="', h($J["EVENT_COMMENT"]), '" data-maxlength="64">
<tr><th><td>', checkbox("ON_COMPLETION", "PRESERVE", $J["ON_COMPLETION"] == "PRESERVE", 'On completion preserve'), '</table>
<p>';
    textarea("EVENT_DEFINITION", $J["EVENT_DEFINITION"]);
    echo '<p>
<input type="submit" value="Save">
';
    if ($aa != "") {
        echo '<input type="submit" name="drop" value="Drop">', confirm(sprintf('Drop %s?', $aa));
    }
    echo '<input type="hidden" name="token" value="', $ni, '">
</form>
';
} elseif (isset($_GET["procedure"])) {
    $da = ($_GET["name"] ? $_GET["name"] : $_GET["procedure"]);
    $Tg = (isset($_GET["function"]) ? "FUNCTION" : "PROCEDURE");
    $J = $_POST;
    $J["fields"] = (array)$J["fields"];
    if ($_POST && !process_fields($J["fields"]) && !$n) {
        $Cf = routine($_GET["procedure"], $Tg);
        $Yh = "$J[name]_adminer_" . uniqid();
        drop_create("DROP $Tg " . routine_id($da, $Cf), create_routine($Tg, $J), "DROP $Tg " . routine_id($J["name"], $J), create_routine($Tg, array("name" => $Yh) + $J), "DROP $Tg " . routine_id($Yh, $J), substr(ME, 0, -1), 'Routine has been dropped.', 'Routine has been altered.', 'Routine has been created.', $da, $J["name"]);
    }
    page_header(($da != "" ? (isset($_GET["function"]) ? 'Alter function' : 'Alter procedure') . ": " . h($da) : (isset($_GET["function"]) ? 'Create function' : 'Create procedure')), $n);
    if (!$_POST && $da != "") {
        $J = routine($_GET["procedure"], $Tg);
        $J["name"] = $da;
    }
    $lb = get_vals("SHOW CHARACTER SET");
    sort($lb);
    $Ug = routine_languages();
    echo '
<form action="" method="post" id="form">
<p>Name: <input name="name" value="', h($J["name"]), '" data-maxlength="64" autocapitalize="off">
', ($Ug ? 'Language' . ": " . html_select("language", $Ug, $J["language"]) . "\n" : ""), '<input type="submit" value="Save">
<div class="scrollable">
<table cellspacing="0" class="nowrap">
';
    edit_fields($J["fields"], $lb, $Tg);
    if (isset($_GET["function"])) {
        echo "<tr><td>" . 'Return type';
        edit_type("returns", $J["returns"], $lb, array(), ($y == "pgsql" ? array("void", "trigger") : array()));
    }
    echo '</table>
', script("editFields();"), '</div>
<p>';
    textarea("definition", $J["definition"]);
    echo '<p>
<input type="submit" value="Save">
';
    if ($da != "") {
        echo '<input type="submit" name="drop" value="Drop">', confirm(sprintf('Drop %s?', $da));
    }
    echo '<input type="hidden" name="token" value="', $ni, '">
</form>
';
} elseif (isset($_GET["sequence"])) {
    $fa = $_GET["sequence"];
    $J = $_POST;
    if ($_POST && !$n) {
        $A = substr(ME, 0, -1);
        $D = trim($J["name"]);
        if ($_POST["drop"]) query_redirect("DROP SEQUENCE " . idf_escape($fa), $A, 'Sequence has been dropped.'); elseif ($fa == "") query_redirect("CREATE SEQUENCE " . idf_escape($D), $A, 'Sequence has been created.');
        elseif ($fa != $D) query_redirect("ALTER SEQUENCE " . idf_escape($fa) . " RENAME TO " . idf_escape($D), $A, 'Sequence has been altered.');
        else
            redirect($A);
    }
    page_header($fa != "" ? 'Alter sequence' . ": " . h($fa) : 'Create sequence', $n);
    if (!$J) $J["name"] = $fa;
    echo '
<form action="" method="post">
<p><input name="name" value="', h($J["name"]), '" autocapitalize="off">
<input type="submit" value="Save">
';
    if ($fa != "") echo "<input type='submit' name='drop' value='" . 'Drop' . "'>" . confirm(sprintf('Drop %s?', $fa)) . "\n";
    echo '<input type="hidden" name="token" value="', $ni, '">
</form>
';
} elseif (isset($_GET["type"])) {
    $ga = $_GET["type"];
    $J = $_POST;
    if ($_POST && !$n) {
        $A = substr(ME, 0, -1);
        if ($_POST["drop"]) query_redirect("DROP TYPE " . idf_escape($ga), $A, 'Type has been dropped.'); else
            query_redirect("CREATE TYPE " . idf_escape(trim($J["name"])) . " $J[as]", $A, 'Type has been created.');
    }
    page_header($ga != "" ? 'Alter type' . ": " . h($ga) : 'Create type', $n);
    if (!$J) $J["as"] = "AS ";
    echo '
<form action="" method="post">
<p>
';
    if ($ga != "") echo "<input type='submit' name='drop' value='" . 'Drop' . "'>" . confirm(sprintf('Drop %s?', $ga)) . "\n"; else {
        echo "<input name='name' value='" . h($J['name']) . "' autocapitalize='off'>\n";
        textarea("as", $J["as"]);
        echo "<p><input type='submit' value='" . 'Save' . "'>\n";
    }
    echo '<input type="hidden" name="token" value="', $ni, '">
</form>
';
} elseif (isset($_GET["trigger"])) {
    $a = $_GET["trigger"];
    $D = $_GET["name"];
    $yi = trigger_options();
    $J = (array)trigger($D, $a) + array("Trigger" => $a . "_bi");
    if ($_POST) {
        if (!$n && in_array($_POST["Timing"], $yi["Timing"]) && in_array($_POST["Event"], $yi["Event"]) && in_array($_POST["Type"], $yi["Type"])) {
            $of = " ON " . table($a);
            $jc = "DROP TRIGGER " . idf_escape($D) . ($y == "pgsql" ? $of : "");
            $B = ME . "table=" . urlencode($a);
            if ($_POST["drop"]) query_redirect($jc, $B, 'Trigger has been dropped.'); else {
                if ($D != "") queries($jc);
                queries_redirect($B, ($D != "" ? 'Trigger has been altered.' : 'Trigger has been created.'), queries(create_trigger($of, $_POST)));
                if ($D != "") queries(create_trigger($of, $J + array("Type" => reset($yi["Type"]))));
            }
        }
        $J = $_POST;
    }
    page_header(($D != "" ? 'Alter trigger' . ": " . h($D) : 'Create trigger'), $n, array("table" => $a));
    echo '
<form action="" method="post" id="form">
<table cellspacing="0" class="layout">
<tr><th>Time<td>', html_select("Timing", $yi["Timing"], $J["Timing"], "triggerChange(/^" . preg_quote($a, "/") . "_[ba][iud]$/, '" . js_escape($a) . "', this.form);"), '<tr><th>Event<td>', html_select("Event", $yi["Event"], $J["Event"], "this.form['Timing'].onchange();"), (in_array("UPDATE OF", $yi["Event"]) ? " <input name='Of' value='" . h($J["Of"]) . "' class='hidden'>" : ""), '<tr><th>Type<td>', html_select("Type", $yi["Type"], $J["Type"]), '</table>
<p>Name: <input name="Trigger" value="', h($J["Trigger"]), '" data-maxlength="64" autocapitalize="off">
', script("qs('#form')['Timing'].onchange();"), '<p>';
    textarea("Statement", $J["Statement"]);
    echo '<p>
<input type="submit" value="Save">
';
    if ($D != "") {
        echo '<input type="submit" name="drop" value="Drop">', confirm(sprintf('Drop %s?', $D));
    }
    echo '<input type="hidden" name="token" value="', $ni, '">
</form>
';
} elseif (isset($_GET["user"])) {
    $ha = $_GET["user"];
    $pg = array("" => array("All privileges" => ""));
    foreach (get_rows("SHOW PRIVILEGES") as $J) {
        foreach (explode(",", ($J["Privilege"] == "Grant option" ? "" : $J["Context"])) as $Db) $pg[$Db][$J["Privilege"]] = $J["Comment"];
    }
    $pg["Server Admin"] += $pg["File access on server"];
    $pg["Databases"]["Create routine"] = $pg["Procedures"]["Create routine"];
    unset($pg["Procedures"]["Create routine"]);
    $pg["Columns"] = array();
    foreach (array("Select", "Insert", "Update", "References") as $X) $pg["Columns"][$X] = $pg["Tables"][$X];
    unset($pg["Server Admin"]["Usage"]);
    foreach ($pg["Tables"] as $z => $X) unset($pg["Databases"][$z]);
    $Xe = array();
    if ($_POST) {
        foreach ($_POST["objects"] as $z => $X) $Xe[$X] = (array)$Xe[$X] + (array)$_POST["grants"][$z];
    }
    $pd = array();
    $mf = "";
    if (isset($_GET["host"]) && ($H = $g->query("SHOW GRANTS FOR " . q($ha) . "@" . q($_GET["host"])))) {
        while ($J = $H->fetch_row()) {
            if (preg_match('~GRANT (.*) ON (.*) TO ~', $J[0], $C) && preg_match_all('~ *([^(,]*[^ ,(])( *\([^)]+\))?~', $C[1], $Ce, PREG_SET_ORDER)) {
                foreach ($Ce
                         as $X) {
                    if ($X[1] != "USAGE") $pd["$C[2]$X[2]"][$X[1]] = true;
                    if (preg_match('~ WITH GRANT OPTION~', $J[0])) $pd["$C[2]$X[2]"]["GRANT OPTION"] = true;
                }
            }
            if (preg_match("~ IDENTIFIED BY PASSWORD '([^']+)~", $J[0], $C)) $mf = $C[1];
        }
    }
    if ($_POST && !$n) {
        $nf = (isset($_GET["host"]) ? q($ha) . "@" . q($_GET["host"]) : "''");
        if ($_POST["drop"]) query_redirect("DROP USER $nf", ME . "privileges=", 'User has been dropped.'); else {
            $Ze = q($_POST["user"]) . "@" . q($_POST["host"]);
            $Wf = $_POST["pass"];
            if ($Wf != '' && !$_POST["hashed"] && !min_version(8)) {
                $Wf = $g->result("SELECT PASSWORD(" . q($Wf) . ")");
                $n = !$Wf;
            }
            $Jb = false;
            if (!$n) {
                if ($nf != $Ze) {
                    $Jb = queries((min_version(5) ? "CREATE USER" : "GRANT USAGE ON *.* TO") . " $Ze IDENTIFIED BY " . (min_version(8) ? "" : "PASSWORD ") . q($Wf));
                    $n = !$Jb;
                } elseif ($Wf != $mf) queries("SET PASSWORD FOR $Ze = " . q($Wf));
            }
            if (!$n) {
                $Qg = array();
                foreach ($Xe
                         as $ff => $od) {
                    if (isset($_GET["grant"])) $od = array_filter($od);
                    $od = array_keys($od);
                    if (isset($_GET["grant"])) $Qg = array_diff(array_keys(array_filter($Xe[$ff], 'strlen')), $od); elseif ($nf == $Ze) {
                        $kf = array_keys((array)$pd[$ff]);
                        $Qg = array_diff($kf, $od);
                        $od = array_diff($od, $kf);
                        unset($pd[$ff]);
                    }
                    if (preg_match('~^(.+)\s*(\(.*\))?$~U', $ff, $C) && (!grant("REVOKE", $Qg, $C[2], " ON $C[1] FROM $Ze") || !grant("GRANT", $od, $C[2], " ON $C[1] TO $Ze"))) {
                        $n = true;
                        break;
                    }
                }
            }
            if (!$n && isset($_GET["host"])) {
                if ($nf != $Ze) queries("DROP USER $nf"); elseif (!isset($_GET["grant"])) {
                    foreach ($pd
                             as $ff => $Qg) {
                        if (preg_match('~^(.+)(\(.*\))?$~U', $ff, $C)) grant("REVOKE", array_keys($Qg), $C[2], " ON $C[1] FROM $Ze");
                    }
                }
            }
            queries_redirect(ME . "privileges=", (isset($_GET["host"]) ? 'User has been altered.' : 'User has been created.'), !$n);
            if ($Jb) $g->query("DROP USER $Ze");
        }
    }
    page_header((isset($_GET["host"]) ? 'Username' . ": " . h("$ha@$_GET[host]") : 'Create user'), $n, array("privileges" => array('', 'Privileges')));
    if ($_POST) {
        $J = $_POST;
        $pd = $Xe;
    } else {
        $J = $_GET + array("host" => $g->result("SELECT SUBSTRING_INDEX(CURRENT_USER, '@', -1)"));
        $J["pass"] = $mf;
        if ($mf != "") $J["hashed"] = true;
        $pd[(DB == "" || $pd ? "" : idf_escape(addcslashes(DB, "%_\\"))) . ".*"] = array();
    }
    echo '<form action="" method="post">
<table cellspacing="0" class="layout">
<tr><th>Server<td><input name="host" data-maxlength="60" value="', h($J["host"]), '" autocapitalize="off">
<tr><th>Username<td><input name="user" data-maxlength="80" value="', h($J["user"]), '" autocapitalize="off">
<tr><th>Password<td><input name="pass" id="pass" value="', h($J["pass"]), '" autocomplete="new-password">
';
    if (!$J["hashed"]) echo
    script("typePassword(qs('#pass'));");
    echo(min_version(8) ? "" : checkbox("hashed", 1, $J["hashed"], 'Hashed', "typePassword(this.form['pass'], this.checked);")), '</table>

';
    echo "<table cellspacing='0'>\n", "<thead><tr><th colspan='2'>" . 'Privileges' . doc_link(array('sql' => "grant.html#priv_level"));
    $t = 0;
    foreach ($pd
             as $ff => $od) {
        echo '<th>' . ($ff != "*.*" ? "<input name='objects[$t]' value='" . h($ff) . "' size='10' autocapitalize='off'>" : "<input type='hidden' name='objects[$t]' value='*.*' size='10'>*.*");
        $t++;
    }
    echo "</thead>\n";
    foreach (array("" => "", "Server Admin" => 'Server', "Databases" => 'Database', "Tables" => 'Table', "Columns" => 'Column', "Procedures" => 'Routine',) as $Db => $bc) {
        foreach ((array)$pg[$Db] as $og => $rb) {
            echo "<tr" . odd() . "><td" . ($bc ? ">$bc<td" : " colspan='2'") . ' lang="en" title="' . h($rb) . '">' . h($og);
            $t = 0;
            foreach ($pd
                     as $ff => $od) {
                $D = "'grants[$t][" . h(strtoupper($og)) . "]'";
                $Y = $od[strtoupper($og)];
                if ($Db == "Server Admin" && $ff != (isset($pd["*.*"]) ? "*.*" : ".*")) echo "<td>"; elseif (isset($_GET["grant"])) echo "<td><select name=$D><option><option value='1'" . ($Y ? " selected" : "") . ">" . 'Grant' . "<option value='0'" . ($Y == "0" ? " selected" : "") . ">" . 'Revoke' . "</select>";
                else {
                    echo "<td align='center'><label class='block'>", "<input type='checkbox' name=$D value='1'" . ($Y ? " checked" : "") . ($og == "All privileges" ? " id='grants-$t-all'>" : ">" . ($og == "Grant option" ? "" : script("qsl('input').onclick = function () { if (this.checked) formUncheck('grants-$t-all'); };"))), "</label>";
                }
                $t++;
            }
        }
    }
    echo "</table>\n", '<p>
<input type="submit" value="Save">
';
    if (isset($_GET["host"])) {
        echo '<input type="submit" name="drop" value="Drop">', confirm(sprintf('Drop %s?', "$ha@$_GET[host]"));
    }
    echo '<input type="hidden" name="token" value="', $ni, '">
</form>
';
} elseif (isset($_GET["processlist"])) {
    if (support("kill")) {
        if ($_POST && !$n) {
            $je = 0;
            foreach ((array)$_POST["kill"] as $X) {
                if (kill_process($X)) $je++;
            }
            queries_redirect(ME . "processlist=", lang(array('%d process has been killed.', '%d processes have been killed.'), $je), $je || !$_POST["kill"]);
        }
    }
    page_header('Process list', $n);
    echo '
<form action="" method="post">
<div class="scrollable">
<table cellspacing="0" class="nowrap checkable">
', script("mixin(qsl('table'), {onclick: tableClick, ondblclick: partialArg(tableClick, true)});");
    $t = -1;
    foreach (process_list() as $t => $J) {
        if (!$t) {
            echo "<thead><tr lang='en'>" . (support("kill") ? "<th>" : "");
            foreach ($J
                     as $z => $X) echo "<th>$z" . doc_link(array('sql' => "show-processlist.html#processlist_" . strtolower($z), 'pgsql' => "monitoring-stats.html#PG-STAT-ACTIVITY-VIEW", 'oracle' => "REFRN30223",));
            echo "</thead>\n";
        }
        echo "<tr" . odd() . ">" . (support("kill") ? "<td>" . checkbox("kill[]", $J[$y == "sql" ? "Id" : "pid"], 0) : "");
        foreach ($J
                 as $z => $X) echo "<td>" . (($y == "sql" && $z == "Info" && preg_match("~Query|Killed~", $J["Command"]) && $X != "") || ($y == "pgsql" && $z == "current_query" && $X != "<IDLE>") || ($y == "oracle" && $z == "sql_text" && $X != "") ? "<code class='jush-$y'>" . shorten_utf8($X, 100, "</code>") . ' <a href="' . h(ME . ($J["db"] != "" ? "db=" . urlencode($J["db"]) . "&" : "") . "sql=" . urlencode($X)) . '">' . 'Clone' . '</a>' : h($X));
        echo "\n";
    }
    echo '</table>
</div>
<p>
';
    if (support("kill")) {
        echo ($t + 1) . "/" . sprintf('%d in total', max_connections()), "<p><input type='submit' value='" . 'Kill' . "'>\n";
    }
    echo '<input type="hidden" name="token" value="', $ni, '">
</form>
', script("tableCheck();");
} elseif (isset($_GET["select"])) {
    $a = $_GET["select"];
    $R = table_status1($a);
    $x = indexes($a);
    $p = fields($a);
    $hd = column_foreign_keys($a);
    $if = $R["Oid"];
    parse_str($_COOKIE["adminer_import"], $ya);
    $Rg = array();
    $f = array();
    $ci = null;
    foreach ($p
             as $z => $o) {
        $D = $b->fieldName($o);
        if (isset($o["privileges"]["select"]) && $D != "") {
            $f[$z] = html_entity_decode(strip_tags($D), ENT_QUOTES);
            if (is_shortable($o)) $ci = $b->selectLengthProcess();
        }
        $Rg += $o["privileges"];
    }
    list($L, $qd) = $b->selectColumnsProcess($f, $x);
    $ae = count($qd) < count($L);
    $Z = $b->selectSearchProcess($p, $x);
    $zf = $b->selectOrderProcess($p, $x);
    $_ = $b->selectLimitProcess();
    if ($_GET["val"] && is_ajax()) {
        header("Content-Type: text/plain; charset=utf-8");
        foreach ($_GET["val"] as $Ei => $J) {
            $Fa = convert_field($p[key($J)]);
            $L = array($Fa ? $Fa : idf_escape(key($J)));
            $Z[] = where_check($Ei, $p);
            $I = $m->select($a, $L, $Z, $L);
            if ($I) echo
            reset($I->fetch_row());
        }
        exit;
    }
    $kg = $Gi = null;
    foreach ($x
             as $w) {
        if ($w["type"] == "PRIMARY") {
            $kg = array_flip($w["columns"]);
            $Gi = ($L ? $kg : array());
            foreach ($Gi
                     as $z => $X) {
                if (in_array(idf_escape($z), $L)) unset($Gi[$z]);
            }
            break;
        }
    }
    if ($if && !$kg) {
        $kg = $Gi = array($if => 0);
        $x[] = array("type" => "PRIMARY", "columns" => array($if));
    }
    if ($_POST && !$n) {
        $hj = $Z;
        if (!$_POST["all"] && is_array($_POST["check"])) {
            $db = array();
            foreach ($_POST["check"] as $ab) $db[] = where_check($ab, $p);
            $hj[] = "((" . implode(") OR (", $db) . "))";
        }
        $hj = ($hj ? "\nWHERE " . implode(" AND ", $hj) : "");
        if ($_POST["export"]) {
            cookie("adminer_import", "output=" . urlencode($_POST["output"]) . "&format=" . urlencode($_POST["format"]));
            dump_headers($a);
            $b->dumpTable($a, "");
            $md = ($L ? implode(", ", $L) : "*") . convert_fields($f, $p, $L) . "\nFROM " . table($a);
            $sd = ($qd && $ae ? "\nGROUP BY " . implode(", ", $qd) : "") . ($zf ? "\nORDER BY " . implode(", ", $zf) : "");
            if (!is_array($_POST["check"]) || $kg) $G = "SELECT $md$hj$sd"; else {
                $Ci = array();
                foreach ($_POST["check"] as $X) $Ci[] = "(SELECT" . limit($md, "\nWHERE " . ($Z ? implode(" AND ", $Z) . " AND " : "") . where_check($X, $p) . $sd, 1) . ")";
                $G = implode(" UNION ALL ", $Ci);
            }
            $b->dumpData($a, "table", $G);
            exit;
        }
        if (!$b->selectEmailProcess($Z, $hd)) {
            if ($_POST["save"] || $_POST["delete"]) {
                $H = true;
                $za = 0;
                $N = array();
                if (!$_POST["delete"]) {
                    foreach ($f
                             as $D => $X) {
                        $X = process_input($p[$D]);
                        if ($X !== null && ($_POST["clone"] || $X !== false)) $N[idf_escape($D)] = ($X !== false ? $X : idf_escape($D));
                    }
                }
                if ($_POST["delete"] || $N) {
                    if ($_POST["clone"]) $G = "INTO " . table($a) . " (" . implode(", ", array_keys($N)) . ")\nSELECT " . implode(", ", $N) . "\nFROM " . table($a);
                    if ($_POST["all"] || ($kg && is_array($_POST["check"])) || $ae) {
                        $H = ($_POST["delete"] ? $m->delete($a, $hj) : ($_POST["clone"] ? queries("INSERT $G$hj") : $m->update($a, $N, $hj)));
                        $za = $g->affected_rows;
                    } else {
                        foreach ((array)$_POST["check"] as $X) {
                            $dj = "\nWHERE " . ($Z ? implode(" AND ", $Z) . " AND " : "") . where_check($X, $p);
                            $H = ($_POST["delete"] ? $m->delete($a, $dj, 1) : ($_POST["clone"] ? queries("INSERT" . limit1($a, $G, $dj)) : $m->update($a, $N, $dj, 1)));
                            if (!$H) break;
                            $za += $g->affected_rows;
                        }
                    }
                }
                $Ke = lang(array('%d item has been affected.', '%d items have been affected.'), $za);
                if ($_POST["clone"] && $H && $za == 1) {
                    $oe = last_id();
                    if ($oe) $Ke = sprintf('Item%s has been inserted.', " $oe");
                }
                queries_redirect(remove_from_uri($_POST["all"] && $_POST["delete"] ? "page" : ""), $Ke, $H);
                if (!$_POST["delete"]) {
                    edit_form($a, $p, (array)$_POST["fields"], !$_POST["clone"]);
                    page_footer();
                    exit;
                }
            } elseif (!$_POST["import"]) {
                if (!$_POST["val"]) $n = 'Ctrl+click on a value to modify it.'; else {
                    $H = true;
                    $za = 0;
                    foreach ($_POST["val"] as $Ei => $J) {
                        $N = array();
                        foreach ($J
                                 as $z => $X) {
                            $z = bracket_escape($z, 1);
                            $N[idf_escape($z)] = (preg_match('~char|text~', $p[$z]["type"]) || $X != "" ? $b->processInput($p[$z], $X) : "NULL");
                        }
                        $H = $m->update($a, $N, " WHERE " . ($Z ? implode(" AND ", $Z) . " AND " : "") . where_check($Ei, $p), !$ae && !$kg, " ");
                        if (!$H) break;
                        $za += $g->affected_rows;
                    }
                    queries_redirect(remove_from_uri(), lang(array('%d item has been affected.', '%d items have been affected.'), $za), $H);
                }
            } elseif (!is_string($Xc = get_file("csv_file", true))) $n = upload_error($Xc);
            elseif (!preg_match('~~u', $Xc)) $n = 'File must be in UTF-8 encoding.';
            else {
                cookie("adminer_import", "output=" . urlencode($ya["output"]) . "&format=" . urlencode($_POST["separator"]));
                $H = true;
                $nb = array_keys($p);
                preg_match_all('~(?>"[^"]*"|[^"\r\n]+)+~', $Xc, $Ce);
                $za = count($Ce[0]);
                $m->begin();
                $hh = ($_POST["separator"] == "csv" ? "," : ($_POST["separator"] == "tsv" ? "\t" : ";"));
                $K = array();
                foreach ($Ce[0] as $z => $X) {
                    preg_match_all("~((?>\"[^\"]*\")+|[^$hh]*)$hh~", $X . $hh, $De);
                    if (!$z && !array_diff($De[1], $nb)) {
                        $nb = $De[1];
                        $za--;
                    } else {
                        $N = array();
                        foreach ($De[1] as $t => $jb) $N[idf_escape($nb[$t])] = ($jb == "" && $p[$nb[$t]]["null"] ? "NULL" : q(str_replace('""', '"', preg_replace('~^"|"$~', '', $jb))));
                        $K[] = $N;
                    }
                }
                $H = (!$K || $m->insertUpdate($a, $K, $kg));
                if ($H) $H = $m->commit();
                queries_redirect(remove_from_uri("page"), lang(array('%d row has been imported.', '%d rows have been imported.'), $za), $H);
                $m->rollback();
            }
        }
    }
    $Oh = $b->tableName($R);
    if (is_ajax()) {
        page_headers();
        ob_start();
    } else
        page_header('Select' . ": $Oh", $n);
    $N = null;
    if (isset($Rg["insert"]) || !support("table")) {
        $N = "";
        foreach ((array)$_GET["where"] as $X) {
            if ($hd[$X["col"]] && count($hd[$X["col"]]) == 1 && ($X["op"] == "=" || (!$X["op"] && !preg_match('~[_%]~', $X["val"])))) $N .= "&set" . urlencode("[" . bracket_escape($X["col"]) . "]") . "=" . urlencode($X["val"]);
        }
    }
    $b->selectLinks($R, $N);
    if (!$f && support("table")) echo "<p class='error'>" . 'Unable to select the table' . ($p ? "." : ": " . error()) . "\n"; else {
        echo "<form action='' id='form'>\n", "<div style='display: none;'>";
        hidden_fields_get();
        echo(DB != "" ? '<input type="hidden" name="db" value="' . h(DB) . '">' . (isset($_GET["ns"]) ? '<input type="hidden" name="ns" value="' . h($_GET["ns"]) . '">' : "") : "");
        echo '<input type="hidden" name="select" value="' . h($a) . '">', "</div>\n";
        $b->selectColumnsPrint($L, $f);
        $b->selectSearchPrint($Z, $f, $x);
        $b->selectOrderPrint($zf, $f, $x);
        $b->selectLimitPrint($_);
        $b->selectLengthPrint($ci);
        $b->selectActionPrint($x);
        echo "</form>\n";
        $E = $_GET["page"];
        if ($E == "last") {
            $kd = $g->result(count_rows($a, $Z, $ae, $qd));
            $E = floor(max(0, $kd - 1) / $_);
        }
        $ch = $L;
        $rd = $qd;
        if (!$ch) {
            $ch[] = "*";
            $Eb = convert_fields($f, $p, $L);
            if ($Eb) $ch[] = substr($Eb, 2);
        }
        foreach ($L
                 as $z => $X) {
            $o = $p[idf_unescape($X)];
            if ($o && ($Fa = convert_field($o))) $ch[$z] = "$Fa AS $X";
        }
        if (!$ae && $Gi) {
            foreach ($Gi
                     as $z => $X) {
                $ch[] = idf_escape($z);
                if ($rd) $rd[] = idf_escape($z);
            }
        }
        $H = $m->select($a, $ch, $Z, $rd, $zf, $_, $E, true);
        if (!$H) echo "<p class='error'>" . error() . "\n"; else {
            if ($y == "mssql" && $E) $H->seek($_ * $E);
            $wc = array();
            echo "<form action='' method='post' enctype='multipart/form-data'>\n";
            $K = array();
            while ($J = $H->fetch_assoc()) {
                if ($E && $y == "oracle") unset($J["RNUM"]);
                $K[] = $J;
            }
            if ($_GET["page"] != "last" && $_ != "" && $qd && $ae && $y == "sql") $kd = $g->result(" SELECT FOUND_ROWS()");
            if (!$K) echo "<p class='message'>" . 'No rows.' . "\n"; else {
                $Oa = $b->backwardKeys($a, $Oh);
                echo "<div class='scrollable'>", "<table id='table' cellspacing='0' class='nowrap checkable'>", script("mixin(qs('#table'), {onclick: tableClick, ondblclick: partialArg(tableClick, true), onkeydown: editingKeydown});"), "<thead><tr>" . (!$qd && $L ? "" : "<td><input type='checkbox' id='all-page' class='jsonly'>" . script("qs('#all-page').onclick = partial(formCheck, /check/);", "") . " <a href='" . h($_GET["modify"] ? remove_from_uri("modify") : $_SERVER["REQUEST_URI"] . "&modify=1") . "'>" . 'Modify' . "</a>");
                $Ve = array();
                $nd = array();
                reset($L);
                $zg = 1;
                foreach ($K[0] as $z => $X) {
                    if (!isset($Gi[$z])) {
                        $X = $_GET["columns"][key($L)];
                        $o = $p[$L ? ($X ? $X["col"] : current($L)) : $z];
                        $D = ($o ? $b->fieldName($o, $zg) : ($X["fun"] ? "*" : $z));
                        if ($D != "") {
                            $zg++;
                            $Ve[$z] = $D;
                            $e = idf_escape($z);
                            $Ed = remove_from_uri('(order|desc)[^=]*|page') . '&order%5B0%5D=' . urlencode($z);
                            $bc = "&desc%5B0%5D=1";
                            echo "<th id='th[" . h(bracket_escape($z)) . "]'>" . script("mixin(qsl('th'), {onmouseover: partial(columnMouse), onmouseout: partial(columnMouse, ' hidden')});", ""), '<a href="' . h($Ed . ($zf[0] == $e || $zf[0] == $z || (!$zf && $ae && $qd[0] == $e) ? $bc : '')) . '">';
                            echo
                                apply_sql_function($X["fun"], $D) . "</a>";
                            echo "<span class='column hidden'>", "<a href='" . h($Ed . $bc) . "' title='" . 'descending' . "' class='text'> â†“</a>";
                            if (!$X["fun"]) {
                                echo '<a href="#fieldset-search" title="' . 'Search' . '" class="text jsonly"> =</a>', script("qsl('a').onclick = partial(selectSearch, '" . js_escape($z) . "');");
                            }
                            echo "</span>";
                        }
                        $nd[$z] = $X["fun"];
                        next($L);
                    }
                }
                $ue = array();
                if ($_GET["modify"]) {
                    foreach ($K
                             as $J) {
                        foreach ($J
                                 as $z => $X) $ue[$z] = max($ue[$z], min(40, strlen(utf8_decode($X))));
                    }
                }
                echo ($Oa ? "<th>" . 'Relations' : "") . "</thead>\n";
                if (is_ajax()) {
                    if ($_ % 2 == 1 && $E % 2 == 1) odd();
                    ob_end_clean();
                }
                foreach ($b->rowDescriptions($K, $hd) as $Ue => $J) {
                    $Di = unique_array($K[$Ue], $x);
                    if (!$Di) {
                        $Di = array();
                        foreach ($K[$Ue] as $z => $X) {
                            if (!preg_match('~^(COUNT\((\*|(DISTINCT )?`(?:[^`]|``)+`)\)|(AVG|GROUP_CONCAT|MAX|MIN|SUM)\(`(?:[^`]|``)+`\))$~', $z)) $Di[$z] = $X;
                        }
                    }
                    $Ei = "";
                    foreach ($Di
                             as $z => $X) {
                        if (($y == "sql" || $y == "pgsql") && preg_match('~char|text|enum|set~', $p[$z]["type"]) && strlen($X) > 64) {
                            $z = (strpos($z, '(') ? $z : idf_escape($z));
                            $z = "MD5(" . ($y != 'sql' || preg_match("~^utf8~", $p[$z]["collation"]) ? $z : "CONVERT($z USING " . charset($g) . ")") . ")";
                            $X = md5($X);
                        }
                        $Ei .= "&" . ($X !== null ? urlencode("where[" . bracket_escape($z) . "]") . "=" . urlencode($X) : "null%5B%5D=" . urlencode($z));
                    }
                    echo "<tr" . odd() . ">" . (!$qd && $L ? "" : "<td>" . checkbox("check[]", substr($Ei, 1), in_array(substr($Ei, 1), (array)$_POST["check"])) . ($ae || information_schema(DB) ? "" : " <a href='" . h(ME . "edit=" . urlencode($a) . $Ei) . "' class='edit'>" . 'edit' . "</a>"));
                    foreach ($J
                             as $z => $X) {
                        if (isset($Ve[$z])) {
                            $o = $p[$z];
                            $X = $m->value($X, $o);
                            if ($X != "" && (!isset($wc[$z]) || $wc[$z] != "")) $wc[$z] = (is_mail($X) ? $Ve[$z] : "");
                            $A = "";
                            if (preg_match('~blob|bytea|raw|file~', $o["type"]) && $X != "") $A = ME . 'download=' . urlencode($a) . '&field=' . urlencode($z) . $Ei;
                            if (!$A && $X !== null) {
                                foreach ((array)$hd[$z] as $r) {
                                    if (count($hd[$z]) == 1 || end($r["source"]) == $z) {
                                        $A = "";
                                        foreach ($r["source"] as $t => $vh) $A .= where_link($t, $r["target"][$t], $K[$Ue][$vh]);
                                        $A = ($r["db"] != "" ? preg_replace('~([?&]db=)[^&]+~', '\1' . urlencode($r["db"]), ME) : ME) . 'select=' . urlencode($r["table"]) . $A;
                                        if ($r["ns"]) $A = preg_replace('~([?&]ns=)[^&]+~', '\1' . urlencode($r["ns"]), $A);
                                        if (count($r["source"]) == 1) break;
                                    }
                                }
                            }
                            if ($z == "COUNT(*)") {
                                $A = ME . "select=" . urlencode($a);
                                $t = 0;
                                foreach ((array)$_GET["where"] as $W) {
                                    if (!array_key_exists($W["col"], $Di)) $A .= where_link($t++, $W["col"], $W["val"], $W["op"]);
                                }
                                foreach ($Di
                                         as $fe => $W) $A .= where_link($t++, $fe, $W);
                            }
                            $X = select_value($X, $A, $o, $ci);
                            $u = h("val[$Ei][" . bracket_escape($z) . "]");
                            $Y = $_POST["val"][$Ei][bracket_escape($z)];
                            $rc = !is_array($J[$z]) && is_utf8($X) && $K[$Ue][$z] == $J[$z] && !$nd[$z];
                            $bi = preg_match('~text|lob~', $o["type"]);
                            echo "<td id='$u'";
                            if (($_GET["modify"] && $rc) || $Y !== null) {
                                $vd = h($Y !== null ? $Y : $J[$z]);
                                echo ">" . ($bi ? "<textarea name='$u' cols='30' rows='" . (substr_count($J[$z], "\n") + 1) . "'>$vd</textarea>" : "<input name='$u' value='$vd' size='$ue[$z]'>");
                            } else {
                                $ye = strpos($X, "<i>â€¦</i>");
                                echo " data-text='" . ($ye ? 2 : ($bi ? 1 : 0)) . "'" . ($rc ? "" : " data-warning='" . h('Use edit link to modify this value.') . "'") . ">$X</td>";
                            }
                        }
                    }
                    if ($Oa) echo "<td>";
                    $b->backwardKeysPrint($Oa, $K[$Ue]);
                    echo "</tr>\n";
                }
                if (is_ajax()) exit;
                echo "</table>\n", "</div>\n";
            }
            if (!is_ajax()) {
                if ($K || $E) {
                    $Gc = true;
                    if ($_GET["page"] != "last") {
                        if ($_ == "" || (count($K) < $_ && ($K || !$E))) $kd = ($E ? $E * $_ : 0) + count($K); elseif ($y != "sql" || !$ae) {
                            $kd = ($ae ? false : found_rows($R, $Z));
                            if ($kd < max(1e4, 2 * ($E + 1) * $_)) $kd = reset(slow_query(count_rows($a, $Z, $ae, $qd))); else$Gc = false;
                        }
                    }
                    $Mf = ($_ != "" && ($kd === false || $kd > $_ || $E));
                    if ($Mf) {
                        echo(($kd === false ? count($K) + 1 : $kd - $E * $_) > $_ ? '<p><a href="' . h(remove_from_uri("page") . "&page=" . ($E + 1)) . '" class="loadmore">' . 'Load more data' . '</a>' . script("qsl('a').onclick = partial(selectLoadMore, " . (+$_) . ", '" . 'Loading' . "â€¦');", "") : ''), "\n";
                    }
                }
                echo "<div class='footer'><div>\n";
                if ($K || $E) {
                    if ($Mf) {
                        $Fe = ($kd === false ? $E + (count($K) >= $_ ? 2 : 1) : floor(($kd - 1) / $_));
                        echo "<fieldset>";
                        if ($y != "simpledb") {
                            echo "<legend><a href='" . h(remove_from_uri("page")) . "'>" . 'Page' . "</a></legend>", script("qsl('a').onclick = function () { pageClick(this.href, +prompt('" . 'Page' . "', '" . ($E + 1) . "')); return false; };"), pagination(0, $E) . ($E > 5 ? " â€¦" : "");
                            for ($t = max(1, $E - 4); $t < min($Fe, $E + 5); $t++) echo
                            pagination($t, $E);
                            if ($Fe > 0) {
                                echo($E + 5 < $Fe ? " â€¦" : ""), ($Gc && $kd !== false ? pagination($Fe, $E) : " <a href='" . h(remove_from_uri("page") . "&page=last") . "' title='~$Fe'>" . 'last' . "</a>");
                            }
                        } else {
                            echo "<legend>" . 'Page' . "</legend>", pagination(0, $E) . ($E > 1 ? " â€¦" : ""), ($E ? pagination($E, $E) : ""), ($Fe > $E ? pagination($E + 1, $E) . ($Fe > $E + 1 ? " â€¦" : "") : "");
                        }
                        echo "</fieldset>\n";
                    }
                    echo "<fieldset>", "<legend>" . 'Whole result' . "</legend>";
                    $gc = ($Gc ? "" : "~ ") . $kd;
                    echo
                        checkbox("all", 1, 0, ($kd !== false ? ($Gc ? "" : "~ ") . lang(array('%d row', '%d rows'), $kd) : ""), "var checked = formChecked(this, /check/); selectCount('selected', this.checked ? '$gc' : checked); selectCount('selected2', this.checked || !checked ? '$gc' : checked);") . "\n", "</fieldset>\n";
                    if ($b->selectCommandPrint()) {
                        echo '<fieldset', ($_GET["modify"] ? '' : ' class="jsonly"'), '><legend>Modify</legend><div>
<input type="submit" value="Save"', ($_GET["modify"] ? '' : ' title="' . 'Ctrl+click on a value to modify it.' . '"'), '>
</div></fieldset>
<fieldset><legend>Selected <span id="selected"></span></legend><div>
<input type="submit" name="edit" value="Edit">
<input type="submit" name="clone" value="Clone">
<input type="submit" name="delete" value="Delete">', confirm(), '</div></fieldset>
';
                    }
                    $id = $b->dumpFormat();
                    foreach ((array)$_GET["columns"] as $e) {
                        if ($e["fun"]) {
                            unset($id['sql']);
                            break;
                        }
                    }
                    if ($id) {
                        print_fieldset("export", 'Export' . " <span id='selected2'></span>");
                        $Jf = $b->dumpOutput();
                        echo($Jf ? html_select("output", $Jf, $ya["output"]) . " " : ""), html_select("format", $id, $ya["format"]), " <input type='submit' name='export' value='" . 'Export' . "'>\n", "</div></fieldset>\n";
                    }
                    $b->selectEmailPrint(array_filter($wc, 'strlen'), $f);
                }
                echo "</div></div>\n";
                if ($b->selectImportPrint()) {
                    echo "<div>", "<a href='#import'>" . 'Import' . "</a>", script("qsl('a').onclick = partial(toggle, 'import');", ""), "<span id='import' class='hidden'>: ", "<input type='file' name='csv_file'> ", html_select("separator", array("csv" => "CSV,", "csv;" => "CSV;", "tsv" => "TSV"), $ya["format"], 1);
                    echo " <input type='submit' name='import' value='" . 'Import' . "'>", "</span>", "</div>";
                }
                echo "<input type='hidden' name='token' value='$ni'>\n", "</form>\n", (!$qd && $L ? "" : script("tableCheck();"));
            }
        }
    }
    if (is_ajax()) {
        ob_end_clean();
        exit;
    }
} elseif (isset($_GET["variables"])) {
    $O = isset($_GET["status"]);
    page_header($O ? 'Status' : 'Variables');
    $Ui = ($O ? show_status() : show_variables());
    if (!$Ui) echo "<p class='message'>" . 'No rows.' . "\n"; else {
        echo "<table cellspacing='0'>\n";
        foreach ($Ui
                 as $z => $X) {
            echo "<tr>", "<th><code class='jush-" . $y . ($O ? "status" : "set") . "'>" . h($z) . "</code>", "<td>" . h($X);
        }
        echo "</table>\n";
    }
} elseif (isset($_GET["script"])) {
    header("Content-Type: text/javascript; charset=utf-8");
    if ($_GET["script"] == "db") {
        $Lh = array("Data_length" => 0, "Index_length" => 0, "Data_free" => 0);
        foreach (table_status() as $D => $R) {
            json_row("Comment-$D", h($R["Comment"]));
            if (!is_view($R)) {
                foreach (array("Engine", "Collation") as $z) json_row("$z-$D", h($R[$z]));
                foreach ($Lh + array("Auto_increment" => 0, "Rows" => 0) as $z => $X) {
                    if ($R[$z] != "") {
                        $X = format_number($R[$z]);
                        json_row("$z-$D", ($z == "Rows" && $X && $R["Engine"] == ($yh == "pgsql" ? "table" : "InnoDB") ? "~ $X" : $X));
                        if (isset($Lh[$z])) $Lh[$z] += ($R["Engine"] != "InnoDB" || $z != "Data_free" ? $R[$z] : 0);
                    } elseif (array_key_exists($z, $R)) json_row("$z-$D");
                }
            }
        }
        foreach ($Lh
                 as $z => $X) json_row("sum-$z", format_number($X));
        json_row("");
    } elseif ($_GET["script"] == "kill") $g->query("KILL " . number($_POST["kill"]));
    else {
        foreach (count_tables($b->databases()) as $l => $X) {
            json_row("tables-$l", $X);
            json_row("size-$l", db_size($l));
        }
        json_row("");
    }
    exit;
} else {
    $Uh = array_merge((array)$_POST["tables"], (array)$_POST["views"]);
    if ($Uh && !$n && !$_POST["search"]) {
        $H = true;
        $Ke = "";
        if ($y == "sql" && $_POST["tables"] && count($_POST["tables"]) > 1 && ($_POST["drop"] || $_POST["truncate"] || $_POST["copy"])) queries("SET foreign_key_checks = 0");
        if ($_POST["truncate"]) {
            if ($_POST["tables"]) $H = truncate_tables($_POST["tables"]);
            $Ke = 'Tables have been truncated.';
        } elseif ($_POST["move"]) {
            $H = move_tables((array)$_POST["tables"], (array)$_POST["views"], $_POST["target"]);
            $Ke = 'Tables have been moved.';
        } elseif ($_POST["copy"]) {
            $H = copy_tables((array)$_POST["tables"], (array)$_POST["views"], $_POST["target"]);
            $Ke = 'Tables have been copied.';
        } elseif ($_POST["drop"]) {
            if ($_POST["views"]) $H = drop_views($_POST["views"]);
            if ($H && $_POST["tables"]) $H = drop_tables($_POST["tables"]);
            $Ke = 'Tables have been dropped.';
        } elseif ($y != "sql") {
            $H = ($y == "sqlite" ? queries("VACUUM") : apply_queries("VACUUM" . ($_POST["optimize"] ? "" : " ANALYZE"), $_POST["tables"]));
            $Ke = 'Tables have been optimized.';
        } elseif (!$_POST["tables"]) $Ke = 'No tables.';
        elseif ($H = queries(($_POST["optimize"] ? "OPTIMIZE" : ($_POST["check"] ? "CHECK" : ($_POST["repair"] ? "REPAIR" : "ANALYZE"))) . " TABLE " . implode(", ", array_map('idf_escape', $_POST["tables"])))) {
            while ($J = $H->fetch_assoc()) $Ke .= "<b>" . h($J["Table"]) . "</b>: " . h($J["Msg_text"]) . "<br>";
        }
        queries_redirect(substr(ME, 0, -1), $Ke, $H);
    }
    page_header(($_GET["ns"] == "" ? 'Database' . ": " . h(DB) : 'Schema' . ": " . h($_GET["ns"])), $n, true);
    if ($b->homepage()) {
        if ($_GET["ns"] !== "") {
            echo "<h3 id='tables-views'>" . 'Tables and views' . "</h3>\n";
            $Th = tables_list();
            if (!$Th) echo "<p class='message'>" . 'No tables.' . "\n"; else {
                echo "<form action='' method='post'>\n";
                if (support("table")) {
                    echo "<fieldset><legend>" . 'Search data in tables' . " <span id='selected2'></span></legend><div>", "<input type='search' name='query' value='" . h($_POST["query"]) . "'>", script("qsl('input').onkeydown = partialArg(bodyKeydown, 'search');", ""), " <input type='submit' name='search' value='" . 'Search' . "'>\n", "</div></fieldset>\n";
                    if ($_POST["search"] && $_POST["query"] != "") {
                        $_GET["where"][0]["op"] = "LIKE %%";
                        search_tables();
                    }
                }
                echo "<div class='scrollable'>\n", "<table cellspacing='0' class='nowrap checkable'>\n", script("mixin(qsl('table'), {onclick: tableClick, ondblclick: partialArg(tableClick, true)});"), '<thead><tr class="wrap">', '<td><input id="check-all" type="checkbox" class="jsonly">' . script("qs('#check-all').onclick = partial(formCheck, /^(tables|views)\[/);", ""), '<th>' . 'Table', '<td>' . 'Engine' . doc_link(array('sql' => 'storage-engines.html')), '<td>' . 'Collation' . doc_link(array('sql' => 'charset-charsets.html', 'mariadb' => 'supported-character-sets-and-collations/')), '<td>' . 'Data Length' . doc_link(array('sql' => 'show-table-status.html', 'pgsql' => 'functions-admin.html#FUNCTIONS-ADMIN-DBOBJECT', 'oracle' => 'REFRN20286')), '<td>' . 'Index Length' . doc_link(array('sql' => 'show-table-status.html', 'pgsql' => 'functions-admin.html#FUNCTIONS-ADMIN-DBOBJECT')), '<td>' . 'Data Free' . doc_link(array('sql' => 'show-table-status.html')), '<td>' . 'Auto Increment' . doc_link(array('sql' => 'example-auto-increment.html', 'mariadb' => 'auto_increment/')), '<td>' . 'Rows' . doc_link(array('sql' => 'show-table-status.html', 'pgsql' => 'catalog-pg-class.html#CATALOG-PG-CLASS', 'oracle' => 'REFRN20286')), (support("comment") ? '<td>' . 'Comment' . doc_link(array('sql' => 'show-table-status.html', 'pgsql' => 'functions-info.html#FUNCTIONS-INFO-COMMENT-TABLE')) : ''), "</thead>\n";
                $S = 0;
                foreach ($Th
                         as $D => $T) {
                    $Xi = ($T !== null && !preg_match('~table|sequence~i', $T));
                    $u = h("Table-" . $D);
                    echo '<tr' . odd() . '><td>' . checkbox(($Xi ? "views[]" : "tables[]"), $D, in_array($D, $Uh, true), "", "", "", $u), '<th>' . (support("table") || support("indexes") ? "<a href='" . h(ME) . "table=" . urlencode($D) . "' title='" . 'Show structure' . "' id='$u'>" . h($D) . '</a>' : h($D));
                    if ($Xi) {
                        echo '<td colspan="6"><a href="' . h(ME) . "view=" . urlencode($D) . '" title="' . 'Alter view' . '">' . (preg_match('~materialized~i', $T) ? 'Materialized view' : 'View') . '</a>', '<td align="right"><a href="' . h(ME) . "select=" . urlencode($D) . '" title="' . 'Select data' . '">?</a>';
                    } else {
                        foreach (array("Engine" => array(), "Collation" => array(), "Data_length" => array("create", 'Alter table'), "Index_length" => array("indexes", 'Alter indexes'), "Data_free" => array("edit", 'New item'), "Auto_increment" => array("auto_increment=1&create", 'Alter table'), "Rows" => array("select", 'Select data'),) as $z => $A) {
                            $u = " id='$z-" . h($D) . "'";
                            echo($A ? "<td align='right'>" . (support("table") || $z == "Rows" || (support("indexes") && $z != "Data_length") ? "<a href='" . h(ME . "$A[0]=") . urlencode($D) . "'$u title='$A[1]'>?</a>" : "<span$u>?</span>") : "<td id='$z-" . h($D) . "'>");
                        }
                        $S++;
                    }
                    echo(support("comment") ? "<td id='Comment-" . h($D) . "'>" : "");
                }
                echo "<tr><td><th>" . sprintf('%d in total', count($Th)), "<td>" . h($y == "sql" ? $g->result("SELECT @@default_storage_engine") : ""), "<td>" . h(db_collation(DB, collations()));
                foreach (array("Data_length", "Index_length", "Data_free") as $z) echo "<td align='right' id='sum-$z'>";
                echo "</table>\n", "</div>\n";
                if (!information_schema(DB)) {
                    echo "<div class='footer'><div>\n";
                    $Ri = "<input type='submit' value='" . 'Vacuum' . "'> " . on_help("'VACUUM'");
                    $vf = "<input type='submit' name='optimize' value='" . 'Optimize' . "'> " . on_help($y == "sql" ? "'OPTIMIZE TABLE'" : "'VACUUM OPTIMIZE'");
                    echo "<fieldset><legend>" . 'Selected' . " <span id='selected'></span></legend><div>" . ($y == "sqlite" ? $Ri : ($y == "pgsql" ? $Ri . $vf : ($y == "sql" ? "<input type='submit' value='" . 'Analyze' . "'> " . on_help("'ANALYZE TABLE'") . $vf . "<input type='submit' name='check' value='" . 'Check' . "'> " . on_help("'CHECK TABLE'") . "<input type='submit' name='repair' value='" . 'Repair' . "'> " . on_help("'REPAIR TABLE'") : ""))) . "<input type='submit' name='truncate' value='" . 'Truncate' . "'> " . on_help($y == "sqlite" ? "'DELETE'" : "'TRUNCATE" . ($y == "pgsql" ? "'" : " TABLE'")) . confirm() . "<input type='submit' name='drop' value='" . 'Drop' . "'>" . on_help("'DROP TABLE'") . confirm() . "\n";
                    $k = (support("scheme") ? $b->schemas() : $b->databases());
                    if (count($k) != 1 && $y != "sqlite") {
                        $l = (isset($_POST["target"]) ? $_POST["target"] : (support("scheme") ? $_GET["ns"] : DB));
                        echo "<p>" . 'Move to other database' . ": ", ($k ? html_select("target", $k, $l) : '<input name="target" value="' . h($l) . '" autocapitalize="off">'), " <input type='submit' name='move' value='" . 'Move' . "'>", (support("copy") ? " <input type='submit' name='copy' value='" . 'Copy' . "'> " . checkbox("overwrite", 1, $_POST["overwrite"], 'overwrite') : ""), "\n";
                    }
                    echo "<input type='hidden' name='all' value=''>";
                    echo
                    script("qsl('input').onclick = function () { selectCount('selected', formChecked(this, /^(tables|views)\[/));" . (support("table") ? " selectCount('selected2', formChecked(this, /^tables\[/) || $S);" : "") . " }"), "<input type='hidden' name='token' value='$ni'>\n", "</div></fieldset>\n", "</div></div>\n";
                }
                echo "</form>\n", script("tableCheck();");
            }
            echo '<p class="links"><a href="' . h(ME) . 'create=">' . 'Create table' . "</a>\n", (support("view") ? '<a href="' . h(ME) . 'view=">' . 'Create view' . "</a>\n" : "");
            if (support("routine")) {
                echo "<h3 id='routines'>" . 'Routines' . "</h3>\n";
                $Vg = routines();
                if ($Vg) {
                    echo "<table cellspacing='0'>\n", '<thead><tr><th>' . 'Name' . '<td>' . 'Type' . '<td>' . 'Return type' . "<td></thead>\n";
                    odd('');
                    foreach ($Vg
                             as $J) {
                        $D = ($J["SPECIFIC_NAME"] == $J["ROUTINE_NAME"] ? "" : "&name=" . urlencode($J["ROUTINE_NAME"]));
                        echo '<tr' . odd() . '>', '<th><a href="' . h(ME . ($J["ROUTINE_TYPE"] != "PROCEDURE" ? 'callf=' : 'call=') . urlencode($J["SPECIFIC_NAME"]) . $D) . '">' . h($J["ROUTINE_NAME"]) . '</a>', '<td>' . h($J["ROUTINE_TYPE"]), '<td>' . h($J["DTD_IDENTIFIER"]), '<td><a href="' . h(ME . ($J["ROUTINE_TYPE"] != "PROCEDURE" ? 'function=' : 'procedure=') . urlencode($J["SPECIFIC_NAME"]) . $D) . '">' . 'Alter' . "</a>";
                    }
                    echo "</table>\n";
                }
                echo '<p class="links">' . (support("procedure") ? '<a href="' . h(ME) . 'procedure=">' . 'Create procedure' . '</a>' : '') . '<a href="' . h(ME) . 'function=">' . 'Create function' . "</a>\n";
            }
            if (support("sequence")) {
                echo "<h3 id='sequences'>" . 'Sequences' . "</h3>\n";
                $jh = get_vals("SELECT sequence_name FROM information_schema.sequences WHERE sequence_schema = current_schema() ORDER BY sequence_name");
                if ($jh) {
                    echo "<table cellspacing='0'>\n", "<thead><tr><th>" . 'Name' . "</thead>\n";
                    odd('');
                    foreach ($jh
                             as $X) echo "<tr" . odd() . "><th><a href='" . h(ME) . "sequence=" . urlencode($X) . "'>" . h($X) . "</a>\n";
                    echo "</table>\n";
                }
                echo "<p class='links'><a href='" . h(ME) . "sequence='>" . 'Create sequence' . "</a>\n";
            }
            if (support("type")) {
                echo "<h3 id='user-types'>" . 'User types' . "</h3>\n";
                $Pi = types();
                if ($Pi) {
                    echo "<table cellspacing='0'>\n", "<thead><tr><th>" . 'Name' . "</thead>\n";
                    odd('');
                    foreach ($Pi
                             as $X) echo "<tr" . odd() . "><th><a href='" . h(ME) . "type=" . urlencode($X) . "'>" . h($X) . "</a>\n";
                    echo "</table>\n";
                }
                echo "<p class='links'><a href='" . h(ME) . "type='>" . 'Create type' . "</a>\n";
            }
            if (support("event")) {
                echo "<h3 id='events'>" . 'Events' . "</h3>\n";
                $K = get_rows("SHOW EVENTS");
                if ($K) {
                    echo "<table cellspacing='0'>\n", "<thead><tr><th>" . 'Name' . "<td>" . 'Schedule' . "<td>" . 'Start' . "<td>" . 'End' . "<td></thead>\n";
                    foreach ($K
                             as $J) {
                        echo "<tr>", "<th>" . h($J["Name"]), "<td>" . ($J["Execute at"] ? 'At given time' . "<td>" . $J["Execute at"] : 'Every' . " " . $J["Interval value"] . " " . $J["Interval field"] . "<td>$J[Starts]"), "<td>$J[Ends]", '<td><a href="' . h(ME) . 'event=' . urlencode($J["Name"]) . '">' . 'Alter' . '</a>';
                    }
                    echo "</table>\n";
                    $Ec = $g->result("SELECT @@event_scheduler");
                    if ($Ec && $Ec != "ON") echo "<p class='error'><code class='jush-sqlset'>event_scheduler</code>: " . h($Ec) . "\n";
                }
                echo '<p class="links"><a href="' . h(ME) . 'event=">' . 'Create event' . "</a>\n";
            }
            if ($Th) echo
            script("ajaxSetHtml('" . js_escape(ME) . "script=db');");
        }
    }
}
page_footer();