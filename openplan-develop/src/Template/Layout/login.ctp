<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Required meta tags always come first -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Iniciar sesión - <?php echo $this->fetch('title');?></title>
    <script language="javascript">
        var urlForJs="<?php echo SITE_URL ?>";
    </script>
    <?php
        //mdb bootstratp
        echo $this->Html->css('https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
        echo $this->Html->css('bootstrap.min.css');
        echo $this->Html->css('mdb.min.css');
        echo $this->Html->css('style.css');

        /* Usermgmt*/
        echo $this->Html->meta('icon');
        /* Usermgmt Plugin CSS */
        echo $this->Html->css('/usermgmt/css/umstyle.css?q='.QRDN);
        /* Bootstrap Datepicker is taken from https://github.com/eternicode/bootstrap-datepicker */
        echo $this->Html->css('/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css?q='.QRDN);
        /* Bootstrap Datepicker is taken from https://github.com/smalot/bootstrap-datetimepicker */
        echo $this->Html->css('/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css?q='.QRDN);
        /* Chosen is taken from https://github.com/harvesthq/chosen/releases/ */
        echo $this->Html->css('/plugins/chosen/chosen.min.css?q='.QRDN);
        /* Toastr is taken from https://github.com/CodeSeven/toastr */
        echo $this->Html->css('/plugins/toastr/build/toastr.min.css?q='.QRDN);
        /* Jquery latest version taken from http://jquery.com */
        echo $this->Html->script('jquery-3.3.1.min.js');
        //fetch
        echo $this->fetch('meta');
        echo $this->fetch('css');
       // echo $this->fetch('script');
    ?>
    <style>          
        header{
         /* height: 66px;*/
        }
        .view {
            height: 100vh;
        }
        .intro-2 {
            background: url("http://mdbootstrap.com/img/Photos/Horizontal/Nature/full page/img%20(11).jpg")no-repeat center center;
            background-size: cover;
        }
        .top-nav-collapse {
            background-color: #3f51b5 !important; 
        }
        .navbar:not(.top-nav-collapse) {
            background: transparent !important;
        }
        @media (max-width: 768px) {
            .navbar:not(.top-nav-collapse) {
                background: #3f51b5 !important;
            } 
        }
        
        .card {
            background-color: rgba(229, 228, 255, 0.2);
        }

         .md-form .prefix {
            font-size: 1.5rem;
            margin-top: 1rem;
        }
        .md-form label {
            color: #ffffff;
        }
        h6 {
            line-height: 1.7;
        }
        @media (max-width: 740px) {
            .full-height,
            .full-height body,
            .full-height header,
            .full-height header .view {
                height: 750px; 
            } 
        }
        @media (min-width: 741px) and (max-height: 638px) {
            .full-height,
            .full-height body,
            .full-height header,
            .full-height header .view {
                height: 750px; 
            } 
        }

        .card {
            margin-top: 30px;
            /*margin-bottom: -45px;*/

        }

        .md-form input[type=text]:focus:not([readonly]),
        .md-form input[type=password]:focus:not([readonly]) {
            border-bottom: 1px solid #8EDEF8;
            box-shadow: 0 1px 0 0 #8EDEF8;
        }
        .md-form input[type=text]:focus:not([readonly])+label,
        .md-form input[type=password]:focus:not([readonly])+label {
            color: #8EDEF8;
        }

        .md-form .form-control {
            color: #fff;
        }
    </style>

</head>

<body class="grey lighten-3">


    <!--Main Navigation-->
    <header>

        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-dark fixed-top scrolling-navbar">
            <div class="container">

                <!-- Brand -->
                <a class="navbar-brand" href="#"><strong>COMUNICATEC</strong></a>

                <!-- Collapse -->
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-7" aria-controls="navbarSupportedContent-7" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <!-- Links -->
                <div class="collapse navbar-collapse" id="navbarSupportedContent-7">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Link</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Profile</a>
                        </li>
                    </ul>
                    <form class="form-inline">
                        <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
                    </form>
                </div>
            </div>
        </nav>
        <!-- Navbar -->       
    </header>
    <!--Main Navigation-->
    <section class="view intro-2 hm-stylish-strong">
        <div class="full-bg-img flex-center">
        <!--<div class="mask rgba-stylish-strong h-100 d-flex justify-content-center align-items-center waves-effect waves-light">-->
            <div class="container">
                <?php echo $this->element('Usermgmt.message_notification'); ?>
                <br/>
                <?= $this->fetch('content') ?>
            </div>            
        </div>        
    </section>    
    <?php 
        //archivos JS
        /* Jquery latest version taken from https://popper.js.org/ */
        echo $this->Html->script('popper.min.js');
        /* Bootstrap JS */
        echo $this->Html->script('bootstrap.min.js?q='.QRDN);
        /* Bootstrap Datepicker is taken from https://github.com/eternicode/bootstrap-datepicker */
        echo $this->Html->script('/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js?q='.QRDN);
        /* Bootstrap Datepicker is taken from https://github.com/smalot/bootstrap-datetimepicker */
        echo $this->Html->script('/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js?q='.QRDN);
        /* Bootstrap Typeahead is taken from https://github.com/biggora/bootstrap-ajax-typeahead */
        echo $this->Html->script('/plugins/bootstrap-ajax-typeahead/js/bootstrap-typeahead.min.js?q='.QRDN);
        /* Chosen is taken from https://github.com/harvesthq/chosen/releases/ */
        echo $this->Html->script('/plugins/chosen/chosen.jquery.min.js?q='.QRDN);
        /* Toastr is taken from https://github.com/CodeSeven/toastr */
        echo $this->Html->script('/plugins/toastr/build/toastr.min.js?q='.QRDN);
        /* Usermgmt Plugin JS */
        echo $this->Html->script('/usermgmt/js/umscript.js?q='.QRDN);
        echo $this->Html->script('/usermgmt/js/ajaxValidation.js?q='.QRDN);
        echo $this->Html->script('/usermgmt/js/chosen/chosen.ajaxaddition.jquery.js?q='.QRDN); 
        echo $this->Html->script('mdb.min.js');
     ?>
    <script>
        new WOW().init();
    </script>
    <?php //fetch scripts ?>
    <?= $this->fetch('script') ?>
</body>
</html>