
<!doctype html>
<html ng-app="courseQuestion" ng-controller="mainController as mCtrl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title></title>

        <link ng-href='<?php echo base_url(); ?>assets/bootstrap/css/{{mCtrl.themeName}}.min.css' rel="stylesheet">        
        <!--<link ng-href='<?php echo base_url(); ?>assets/bootstrap/css/bootstrap-theme.min.css' rel="stylesheet">-->
        <link ng-href='<?php echo base_url(); ?>assets/bootstrap/css/bootstrap-rtl.min.css' rel="stylesheet">
        <link ng-href='<?php echo base_url(); ?>assets/bootstrap/css/bootstrap-modal-bs3patch.css' rel="stylesheet">
        <link ng-href='<?php echo base_url(); ?>assets/bootstrap/css/bootstrap-modal.css' rel="stylesheet">
        <link ng-href='<?php echo base_url(); ?>assets/bootstrap/css/font-awesome.min.css' rel="stylesheet">
        <!--[if lt IE 9]>
            <script src='<?php echo base_url(); ?>assets/js/html5.js'></script>
        <![endif]-->

        <!-- script references -->
        <script src='<?php echo base_url(); ?>assets/js/jquery-1.10.2.min.js'></script>

        <!--bootstrap integrated libriries-->
        <script src='<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js'></script>
        <script src='<?php echo base_url(); ?>assets/bootstrap/js/bootstrap-modal.js'></script>
        <script src='<?php echo base_url(); ?>assets/bootstrap/js/bootstrap-modalmanager.js'></script>

        <script src='<?php echo base_url(); ?>assets/angularjs/angular.js'></script>
        <script src='<?php echo base_url(); ?>assets/angularjs/angular-animate.js'></script>
        <script src='<?php echo base_url(); ?>assets/angularjs/angular-ui-router.min.js'></script>


        <script src='<?php echo base_url(); ?>angular/studentApp.js'></script>

        <!-- CONTROLLERS -->
        <!--<script src='<?php echo base_url(); ?>angular/controller/courceCtrl.js'></script>-->
        <!--<script src='<?php echo base_url(); ?>angular/controller/questionCtrl.js'></script>-->
        <script src='<?php echo base_url(); ?>angular/controller/studentExaminationCtrl.js'></script>
        <script src='<?php echo base_url(); ?>angular/controller/studentExaminationListCtrl.js'></script>
        <script src='<?php echo base_url(); ?>angular/controller/studentHomeCtrl.js'></script>


        <!-- SERVICES -->
        <script src='<?php echo base_url(); ?>angular/service/serviceModule.js'></script>
        <!--<script src='<?php echo base_url(); ?>angular/service/courceFactory.js'></script>-->
        <!--<script src='<?php echo base_url(); ?>angular/service/questionFactory.js'></script>-->
        <script src='<?php echo base_url(); ?>angular/service/studentExaminationFactory.js'></script>
        <script src='<?php echo base_url(); ?>angular/service/studentHomeFactory.js'></script>


        <!-- DIRECTIVE -->
        <script src='<?php echo base_url(); ?>angular/directive/studentNavbar.js'></script>
        <!--<script src='<?php echo base_url(); ?>angular/directive/rightmenu.js'></script>-->

        <!-- toastr -->
        <link href='<?php echo base_url(); ?>assets/toastr/toastr.min.css' rel="stylesheet">
        <script src='<?php echo base_url(); ?>assets/toastr/toastr.min.js'></script>

        <!-- oi select -->
        <link href='<?php echo base_url(); ?>assets/oiselect/select.min.css' rel="stylesheet">
        <script src='<?php echo base_url(); ?>assets/oiselect/select.js'></script>

        <!-- chart -->
        <script src='<?php echo base_url(); ?>assets/chart/chart.js'></script>
        <script src='<?php echo base_url(); ?>assets/chart/angular-chart.js'></script>

        <link ng-href='<?php echo base_url(); ?>assets/custom.css' rel="stylesheet">

        <!-- Global site tag (gtag.js) - Google Analytics -->
        <!--<script async src="https://www.googletagmanager.com/gtag/js?id=UA-111999648-1"></script>
        <script>
          //window.dataLayer = window.dataLayer || [];
          //function gtag(){dataLayer.push(arguments);}
         // gtag('js', new Date());
        
         // gtag('config', 'UA-111999648-1');
        </script>-->


    </head>

    <body dir="rtl">

        <div class="container" >
            <student-navbar></student-navbar>
            <!--<right-menu></right-menu>-->

            <!--view-->
            <div class="row">
                <div class="col-sm-12">
                    <div ui-view></div>
                </div>
            </div>
        </div><!-- .container-fluid -->


        <!-- MODAL FORMS ------------------------------------------------------>
        <!--------------------------------------------------------------------->




        <script>
    var baseUrl = '<?= base_url(); ?>';
    var siteUrl = '<?= site_url(); ?>';
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-center",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
        </script>

    </body>
</html>