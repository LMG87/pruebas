<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = 'CakePHP: the rapid development php framework';
?>
<!DOCTYPE html>
<html>
<head land="es">
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <?= $this->fetch('meta') ?>
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <script language="javascript">
        var urlForJs="<?php echo SITE_URL ?>";
    </script>
    <?php
        echo $this->Html->meta('icon');
        /* Bootstrap CSS */
        echo $this->Html->css('/plugins/bootstrap/css/bootstrap.min.css?q='.QRDN);

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
        echo $this->Html->css('https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
        echo $this->Html->css('style.css');
        echo $this->Html->css('mdb.min.css');
        /* Jquery latest version taken from http://jquery.com */
        echo $this->Html->script('/plugins/jquery-3.3.1.min.js');

        /* Jquery latest version taken from https://popper.js.org/ */
        echo $this->Html->script('/plugins/popper.min.js');

        /* Bootstrap JS */
        echo $this->Html->script('/plugins/bootstrap/js/bootstrap.min.js?q='.QRDN);

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

        echo $this->fetch('meta');
        echo $this->fetch('css');
        echo $this->fetch('script');
    ?>
    <?php /*
        echo $this->Html->meta('icon'); ?>
       <?= $this->Html->css('https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css') ?>
       <!-- Bootstrap core CSS -->
       <?= $this->Html->css('bootstrap.min.css') ?>
       <!-- Material Design Bootstrap -->
       <?= $this->Html->css('mdb.min.css') ?>
       <?= $this->Html->css('style.css') ?>
       <?= $this->fetch('css') */ ?>
</head>
<body>
    <!--Main Navigation-->
    <header>

        <nav class="navbar navbar-expand-lg navbar-dark info-color">
            <div class="container">
                <a class="navbar-brand" href="#">
                    <strong>Navbar</strong>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="#">Home
                                <span class="sr-only">(current)</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Features</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Pricing</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Opinions</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav nav-flex-icons">
                        <li class="nav-item">
                            <a class="nav-link">
                                <i class="fa fa-facebook"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link">
                                <i class="fa fa-twitter"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link">
                                <i class="fa fa-instagram"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

    </header>
    <!--Main Navigation-->
    <?= $this->Flash->render() ?>
    <?php //if($this->UserAuth->isLogged()) { echo $this->element('usermgmt/dashboard'); } ?>
    <?php if($this->UserAuth->isLogged()) { echo $this->element('Usermgmt.dashboard'); } ?>
    <?php echo $this->element('Usermgmt.message_notification'); ?>
    <div class="container clearfix">
        <?= $this->fetch('content') ?>
        <div style="clear:both"></div>
    </div>
    <footer>
        
    </footer>
    <?php /* ?>
    <!--  SCRIPTS  -->
    <!-- JQuery -->
    <?= $this->Html->script('jquery-3.3.1.min.js') ?>
    <!-- Bootstrap tooltips -->
    <?= $this->Html->script('popper.min.js') ?>
    <!-- Bootstrap core JavaScript -->
    <?= $this->Html->script('bootstrap.min.js') ?>
    <?php  */ ?>
    <!-- MDB core JavaScript -->
    <?= $this->Html->script('mdb.min.js') ?>
    <script>
        new WOW().init();
    </script>
    <?= $this->fetch('script') ?>
    <script>
        // Material Select Initialization
        $(document).ready(function() {
            $('.mdb-select').material_select();
        });
    </script>

</body>
</html>
