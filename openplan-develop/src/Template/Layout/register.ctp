<!DOCTYPE html>
<html lang="es" class="full-height">
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
        .intro-2 {
                   background: url("http://mdbootstrap.com/img/Photos/Others/forest1.jpg")no-repeat center center;
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
               .hm-gradient .full-bg-img {
                   background: -webkit-linear-gradient(98deg, rgba(22, 91, 231, 0.5), rgba(255, 32, 32, 0.5) 100%);
                   background: -webkit-gradient(linear, 98deg, from(rgba(22, 91, 231, 0.5)), to(rgba(255, 32, 32, 0.5)));
                   background: linear-gradient(to 98deg, rgba(22, 91, 231, 0.5), rgba(255, 32, 32, 0.5) 100%); 
               }       
               .card {
                   background-color: rgba(255, 255, 255, 0.85);
               }
               
               .md-form .prefix {
                   font-size: 1.5rem;
                   margin-top: 1rem;
               }
       /*
               .md-form label {
                   color: #ffffff;
               }
       */
               h6 {
                   line-height: 1.7;
               }
               @media (max-width: 450px) and (max-height: 750px) {
                   .full-height,
                   .full-height body,
                   .full-height header,
                   .full-height header .view {
                       height: 1400px; 
                   } 
               }
               @media (min-width: 451px) and (max-width: 767px) and (max-height: 1023px) {
                   .full-height,
                   .full-height body,
                   .full-height header,
                   .full-height header .view {
                       height: 1200px; 
                   } 
               }
               @media (min-width: 800px) and (max-width: 1025px) {
                   .full-height,
                   .full-height body,
                   .full-height header,
                   .full-height header .view {
                       height: 900px; 
                   } 
               }
               @media (min-width: 1026px) and (max-height: 800px) {
                   .full-height,
                   .full-height body,
                   .full-height header,
                   .full-height header .view {
                       height: 1060px; 
                   } 
               }
    </style>

</head>

<body>


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
    
    <!--Main Navigation-->
        <section class="view intro-2 hm-gradient hm-indigo-slight">
            <div class="full-bg-img">
                <div class="container flex-center">
                    <?php echo $this->element('Usermgmt.message_notification'); ?>
                    <br/>
                    <?= $this->fetch('content') ?>
                </div>            
            </div>        
        </section>    
    </header>

    <!--Main Layout-->
    <main>
    
        <div class="container">
            


        </div>
    
    </main>
    <!--Main Layout-->
    
    <!--Footer-->
    <footer>
    
    
    
    </footer>
    <!--Footer-->
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