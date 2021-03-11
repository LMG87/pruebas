<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Dashboard - <?php echo $this->fetch('title');?></title>
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
            echo $this->Html->script('/plugins/ckeditor/ckeditor.js?q='.QRDN); 
            //fetch
            echo $this->fetch('meta');
            echo $this->fetch('css');
           // echo $this->fetch('script');
        ?>
</head>

<body class="mdb-skin fixed-sn">
    <!--Main Navigation-->
    <?php echo $this->element('headerDashboard'); ?>
    <!--Main layout-->
    <main >
        <div class="container-fluid">
           <!--Section: Main panel-->
           <section class="card card-cascade narrower mb-5">
                <div class="row">
                    <!--Grid column-->
                    <div class="col-md-12">
                        <!--Panel Header-->
                        <div class="view view-cascade py-3 gradient-card-header info-color-dark">
                            <h5 class="mb-0">Bienvenido</h5>
                        </div>
                        <!--/Panel Header-->
                        <!--Panel content-->
                        <div class="card-body card-body-cascade">
                            <?php if($this->UserAuth->isLogged()) { echo $this->element('Usermgmt.dashboard'); } ?>
                            <?php echo $this->element('Usermgmt.message_notification'); ?>
                            <br/>
                            <?= $this->fetch('content') ?>
                            <div style="clear:both"></div>


                        </div>
                        <!--Panel content-->
                    </div>
                    <!--Grid column-->                               
                </div>           
           </section>
           <!--Section: Main panel-->

       </div>
    </main>
    <!--Main layout-->
    <?php echo $this->element('footerDashboard'); ?>

    <!-- SCRIPTS -->
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
        // SideNav Initialization
        $(".button-collapse").sideNav();
        $(document).ready(function() {
           $('select').material_select();
         });
    </script>
    <?php echo $this->element('bootScripts'); ?>
    <?php //fetch scripts ?>
    <?= $this->fetch('script') ?>
</body>
</html>