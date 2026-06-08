<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class InAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'in/css/statistics.css',
        'in/css/bootstrap.min.css',
        'in/font-awesome/css/font-awesome.css',
        'in/css/plugins/footable/footable.core.css',
        'in/css/plugins/iCheck/custom.css',
        'in/css/plugins/chosen/bootstrap-chosen.css',
        'in/css/plugins/sweetalert/sweetalert.css',
        'in/css/plugins/summernote/summernote.css',
        'in/css/plugins/summernote/summernote-bs3.css',
        'in/css/plugins/steps/jquery.steps.css',
        'in/css/plugins/datapicker/datepicker3.css',
        'in/css/plugins/daterangepicker/daterangepicker-bs3.css',
        'in/css/plugins/switchery/switchery.css',
        'in/css/plugins/dropzone/basic.css',
        'in/css/plugins/dropzone/dropzone.css',
        'in/css/plugins/dualListbox/bootstrap-duallistbox.min.css',
        'in/css/plugins/ladda/ladda-themeless.min.css',
        'in/css/plugins/fullcalendar/fullcalendar.css',
        'in/css/plugins/jasny/jasny-bootstrap.min.css',
        'in/css/plugins/ionRangeSlider/ion.rangeSlider.css',
        'in/css/plugins/ionRangeSlider/ion.rangeSlider.skinFlat.css',
        'in/css/animate.css',
        'in/css/style.css',
    ];
    public $js = [
        // Mainly scripts -->
        'in/js/plugins/fullcalendar/moment.min.js',
        'in/js/plugins/fullcalendar/ru.js',
//        'in/js/jquery-3.1.1.min.js',
        'in/js/bootstrap.min.js',
        'in/js/plugins/metisMenu/jquery.metisMenu.js',
        'in/js/plugins/slimscroll/jquery.slimscroll.min.js',
        'in/js/plugins/morris/raphael-2.1.0.min.js',
        'in/js/plugins/morris/morris.js',
        'in/js/jquery.countdown.pack.js',
        // Chosen -->
        'in/js/plugins/chosen/chosen.jquery.js',
        // Flot -->
        'in/js/plugins/flot/jquery.flot.js',
        'in/js/plugins/flot/jquery.flot.tooltip.min.js',
        'in/js/plugins/flot/jquery.flot.spline.js',
        'in/js/plugins/flot/jquery.flot.resize.js',
        'in/js/plugins/flot/jquery.flot.pie.js',

        // DROPZONE -->


        // Peity -->
        'in/js/plugins/peity/jquery.peity.min.js',
        'in/js/demo/peity-demo.js',

        // FooTable -->
        'in/js/plugins/footable/footable.all.min.js',

        // iCheck -->
        'in/js/plugins/iCheck/icheck.min.js',

        // Jvectormap -->
        'in/js/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js',
        'in/js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js',

        // DataMaps -->
        'in/js/plugins/typehead/bootstrap3-typeahead.min.js',
        'in/js/plugins/d3/d3.min.js',
        'in/js/plugins/topojson/topojson.js',
        'in/js/plugins/datamaps/datamaps.all.min.js',

        // Custom and plugin javascript -->
        'in/js/inspinia.js',
        'in/js/plugins/pace/pace.min.js',

        'in/js/plugins/pdfjs/pdf.js',

        // Steps -->
        'in/js/plugins/steps/jquery.steps.min.js',

        // Jquery Validate -->
        'in/js/plugins/validate/jquery.validate.min.js',

        // Dual Listbox -->
        'in/js/plugins/dualListbox/jquery.bootstrap-duallistbox.js',

        // SUMMERNOTE -->
        'in/js/plugins/summernote/summernote.min.js',

        // Sweet alert -->
        // 'in/js/plugins/sweetalert/sweetalert.min.js',

        // Input Mask-->
//        'in/js/plugins/jasny/jasny-bootstrap.min.js',

        // Typehead -->
        'in/js/plugins/typehead/bootstrap3-typeahead.min.js',

        // jQuery UI -->
        'in/js/plugins/jquery-ui/jquery-ui.min.js',

        // Nestable List -->
        'in/js/plugins/nestable/jquery.nestable.js',

        // GITTER -->
        'in/js/plugins/gritter/jquery.gritter.min.js',

        // Sparkline -->
        'in/js/plugins/sparkline/jquery.sparkline.min.js',

        // Sparkline demo data  -->
        'in/js/demo/sparkline-demo.js',

        // ChartJS-->
        'in/js/plugins/chartJs/Chart.min.js',

        // Full Calendar -->
        'in/js/plugins/fullcalendar/fullcalendar.min.js',

        // Toastr -->
        'in/js/plugins/toastr/toastr.min.js',

        // Data picker -->
        'in/js/plugins/datapicker/bootstrap-datepicker.js',

        // Switchery -->
        'in/js/plugins/switchery/switchery.js',

        // Date range picker -->
        'in/js/plugins/daterangepicker/daterangepicker.js',

        //-- Ladda -->
        'in/js/plugins/ladda/spin.min.js',
        'in/js/plugins/ladda/ladda.min.js',
        'in/js/plugins/ladda/ladda.jquery.min.js',

        //-- d3 and c3 charts -->
        'in/js/plugins/d3/d3.min.js',
        'in/js/plugins/c3/c3.min.js',

//        ion range slider
        'in/js/plugins/ionRangeSlider/ion.rangeSlider.min.js',

//        datatables
        'in/js/plugins/dataTables/datatables.min.js',
        'in/js/plugins/select2/select2.full.min.js',
        // Custom scripts -->
        'in/js/jquery.cookie.js',
        'in/js/script.js',


        'in/js/statistics.js',

    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
    ];
}

    
