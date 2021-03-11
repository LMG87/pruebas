<?php
use Cake\Utility\Inflector;
$actionUrl = Inflector::camelize($this->request->getParam('controller')).'/'.$this->request->getParam('action');
$activeClass = 'active';
$inactiveClass = '';
?>    
    <header>
      <!--Navbar-->
      <nav class="navbar navbar-expand-lg navbar-dark  double-nav">
        <!-- SideNav slide-out button -->
        <div class="float-left">
            <a href="#" data-activates="slide-out" class="button-collapse">
                <i class="fa fa-bars"></i>
            </a>
        </div>
        <?php if (isset($company)): ?>
          <!-- Breadcrumb-->
          <div class="breadcrumb-dn mr-auto">
              <ol class="breadcrumb clearfix d-none d-md-inline-flex pt-0">
                  <li class="breadcrumb-item">
                    <?php echo $this->Html->link($company->name, '/company/'.$company->id, ['class' => 'white-text']) ?>
                  </li>
                  <?php if ($room): ?>
                    <li class="breadcrumb-item active"><?php echo $room->name; ?></li>
                  <?php endif ?>
              </ol>
          </div>
        <?php endif ?>
        <?php if ($this->UserAuth->isAdmin()): ?>
        <ul class="nav navbar-nav nav-flex-icons ml-auto">

          <?php $activecls = ($actionUrl == 'Users/dashboard') ? $activeClass : $inactiveClass; ?>
          <li class="nav-item <?php echo $activecls; ?>"><?php echo $this->Html->link(__('Inicio'), ['controller'=>'Users', 'action'=>'dashboard','plugin' => 'Usermgmt'], ['class'=>'nav-link '.$activecls]); ?></li>

          <?php $activecls = ($actionUrl == 'Companies/index' or $actionUrl == 'Companies/view' or $actionUrl == 'Companies/edit') ? $activeClass : $inactiveClass; ?>
          <li class="nav-item <?php echo $activecls; ?>"><?php echo $this->Html->link(__('Companies'), ['controller'=>'Companies', 'action'=>'index','plugin' => false], ['class'=>'nav-link '.$activecls]); ?></li>


          <?php $activecls = ($actionUrl == 'Rooms/index' or $actionUrl == 'Rooms/view' or $actionUrl == 'Rooms/edit') ? $activeClass : $inactiveClass; ?>
          <li class="nav-item <?php echo $activecls; ?>"><?php echo $this->Html->link(__('Rooms'), ['controller'=>'Rooms', 'action'=>'index','plugin' => false], ['class'=>'nav-link '.$activecls]); ?></li>


          <?php $activecls = ($actionUrl == 'TypeItems/index' or $actionUrl == 'TypeItems/view' or $actionUrl == 'TypeItems/edit') ? $activeClass : $inactiveClass; ?>
          <li class="nav-item <?php echo $activecls; ?>"><?php echo $this->Html->link(__('Tipo de Items'), ['controller'=>'TypeItems', 'action'=>'index','plugin' => false], ['class'=>'nav-link '.$activecls]); ?></li>

          <?php $activecls = ($actionUrl == 'Items/index' or $actionUrl == 'Items/view' or $actionUrl == 'Items/edit') ? $activeClass : $inactiveClass; ?>
          <li class="nav-item <?php echo $activecls; ?>"><?php echo $this->Html->link(__('Items'), ['controller'=>'Items', 'action'=>'index','plugin' => false], ['class'=>'nav-link '.$activecls]); ?></li>


          <?php $activecls = ($actionUrl == 'Roles/index' or $actionUrl == 'Roles/view' or $actionUrl == 'Roles/edit') ? $activeClass : $inactiveClass; ?>
          <li class="nav-item <?php echo $activecls; ?>"><?php echo $this->Html->link(__('Roles'), ['controller'=>'Roles', 'action'=>'index','plugin' => false], ['class'=>'nav-link '.$activecls]); ?></li>

          <?php $activecls = ($actionUrl == 'Collaborators/index' or $actionUrl == 'Collaborators/view' or $actionUrl == 'Collaborators/edit') ? $activeClass : $inactiveClass; ?>
          <li class="nav-item <?php echo $activecls; ?>"><?php echo $this->Html->link(__('Collaborators'), ['controller'=>'Collaborators', 'action'=>'index','plugin' => false], ['class'=>'nav-link '.$activecls]); ?></li>

          <?php $activecls = ($actionUrl == 'Actions/index' or $actionUrl == 'Actions/view' or $actionUrl == 'Actions/edit') ? $activeClass : $inactiveClass; ?>
          <li class="nav-item <?php echo $activecls; ?>"><?php echo $this->Html->link(__('Actions'), ['controller'=>'Actions', 'action'=>'index','plugin' => false], ['class'=>'nav-link '.$activecls]); ?></li>

          <?php $activecls = ($actionUrl == 'RelationMembers/index' or $actionUrl == 'RelationMembers/view' or $actionUrl == 'RelationMembers/edit') ? $activeClass : $inactiveClass; ?>
          <li class="nav-item <?php echo $activecls; ?>"><?php echo $this->Html->link(__('Relation Members'), ['controller'=>'RelationMembers', 'action'=>'index','plugin' => false], ['class'=>'nav-link '.$activecls]); ?></li>

          <?php $activecls = ($actionUrl == 'Comments/index' or $actionUrl == 'Comments/view' or $actionUrl == 'Comments/edit') ? $activeClass : $inactiveClass; ?>
          <li class="nav-item <?php echo $activecls; ?>"><?php echo $this->Html->link(__('Comments'), ['controller'=>'Comments', 'action'=>'index','plugin' => false], ['class'=>'nav-link '.$activecls]); ?></li>

          <?php $activecls = ($actionUrl == 'Files/index' or $actionUrl == 'Files/view' or $actionUrl == 'Files/edit') ? $activeClass : $inactiveClass; ?>
          <li class="nav-item <?php echo $activecls; ?>"><?php echo $this->Html->link(__('Files'), ['controller'=>'Files', 'action'=>'index','plugin' => false], ['class'=>'nav-link '.$activecls]); ?></li>
        </ul>
        <?php endif ?>
        <!-- Links -->
        <ul class="nav navbar-nav nav-flex-icons ml-auto">
          <?php 
            $activecls = ($actionUrl == 'UserContacts/contactUs') ? $activeClass : $inactiveClass;
            echo "<li class='nav-item ".$activecls."'>".$this->Html->link(__('<i class="fa fa-envelope"></i>
                    <span class="clearfix d-none d-sm-inline-block">Contacto</span>'), '/contactUs', ['class'=>'nav-link', 'escape'=>false])."</li>";
           ?>
            <?php /*<li class="nav-item">
                <a class="nav-link">
                    <i class="fa fa-gear"></i>
                    <span class="clearfix d-none d-sm-inline-block">Settings</span>
                </a>
            </li>*/ ?>
            <?php if($this->UserAuth->isLogged()) {
              echo "<li class='nav-item dropdown'>";

                echo $this->Html->link(__('<i class="fa fa-user"></i><span class="clearfix d-none d-sm-inline-block">Mi cuenta</span>'), '#', ['escape'=>false, 'class'=>'nav-link dropdown-toggle waves-effect waves-light', 'data-toggle'=>'dropdown', 'aria-haspopup'=>'true', 'aria-expanded'=>'false']);
                
                echo "<div class='dropdown-menu dropdown-menu-right'>";
                  if($this->UserAuth->HP('Users', 'myprofile', 'Usermgmt')) {
                    $activecls = ($actionUrl == 'Users/myprofile') ? $activeClass : $inactiveClass;

                    echo $this->Html->link(__('Mi perfil'), ['controller'=>'Users', 'action'=>'myprofile', 'plugin'=>'Usermgmt'], ['class'=>'dropdown-item '.$activecls]);
                  }
                  if($this->UserAuth->HP('Users', 'editProfile', 'Usermgmt')) {
                    $activecls = ($actionUrl == 'Users/editProfile') ? $activeClass : $inactiveClass;

                    echo $this->Html->link(__('Editar perfil'), ['controller'=>'Users', 'action'=>'editProfile', 'plugin'=>'Usermgmt'], ['class'=>'dropdown-item '.$activecls]);
                  }
                  if($this->UserAuth->HP('Users', 'changePassword', 'Usermgmt')) {
                    $activecls = ($actionUrl == 'Users/changePassword') ? $activeClass : $inactiveClass;

                    echo $this->Html->link(__('Cambiar contraseña'), ['controller'=>'Users', 'action'=>'changePassword', 'plugin'=>'Usermgmt'], ['class'=>'dropdown-item '.$activecls]);
                  }

                  if($this->UserAuth->HP('Users', 'deleteAccount', 'Usermgmt') && ALLOW_DELETE_ACCOUNT && !$this->UserAuth->isAdmin()) {
                    echo $this->Form->postLink(__('Eliminar cuenta'), ['controller'=>'Users', 'action'=>'deleteAccount', 'plugin'=>'Usermgmt'], ['escape'=>false, 'confirm'=>__('Are you sure you want to delete your account?')]);
                  }
                  if($this->UserAuth->isLogged()) {
                    echo $this->Html->link(__('Desconectar'), ['controller'=>'Users', 'action'=>'logout', 'plugin'=>'Usermgmt'], ['class'=>'dropdown-item']);
                  } else {
                    $activecls = ($actionUrl == 'Users/login') ? $activeClass : $inactiveClass;
                    echo $this->Html->link(__('Registrarse'), ['controller'=>'Users', 'action'=>'login', 'plugin'=>'Usermgmt'], ['class'=>'dropdown-item '.$activecls]);
                  }
                echo "</div>";
              echo "</li>";
            } ?>
        </ul>
      </nav>
      <!--/.Navbar-->
      <!-- Sidebar navigation -->
      <div id="slide-out" class="side-nav fixed">
        <ul class="custom-scrollbar">
          <!-- Logo -->
          <li>
            <div class="logo-wrapper waves-light">
              <a href="/"><img src="<?php echo $this->Url->image('logo.png'); ?>" class="img-fluid flex-center"></a>
            </div>
          </li>

          <!--/. Logo -->
          <!--Search Form-->
          <li>
            <form class="search-form" role="search">
              <div class="md-form my-0 waves-light">
                <input type="text" class="form-control py-2" placeholder="Search">
              </div>
            </form>
          </li>
          <!--/.Search Form-->
          <!-- Side navigation links -->
          <li>
            <ul class="collapsible collapsible-accordion">
              <?php $activecls = ($actionUrl == 'Items/allItemsCompany') ? $activeClass : $inactiveClass; ?>
              <li id="sideBCompanies"><a class="collapsible-header waves-effect arrow-r <?php echo $activecls; ?>"><i class="fa fa-building-o"></i> Mis Empresas <i class="fa fa-angle-down rotate-icon"></i></a>
                <div class="collapsible-body">
                  <?php// print_r($companies); ?>
                  <?php if (count($companies)>0) { ?>
                  <ul>
                    <?php foreach ($companies as $comp) { ?>
                      <?php
                      if (!isset($company_id)) { $company_id=null; }
                      $activeclss = ($comp->company_id == $company_id) ? $activeClass : $inactiveClass;
                      //print_r($actionUrl);
                      echo "<li>".$this->Html->link(
                          $comp->company_name,
                          '/company/'.$comp->company_id,
                          ['class' => 'waves-effect '.$activeclss])."</li>";
                      ?>
                    <?php } ?>
                  </ul>
                  <?php } ?>
                </div>
              </li>
              <li><a class="collapsible-header waves-effect arrow-r"><i class="fa fa-desktop"></i> Mis Salas <i class="fa fa-angle-down rotate-icon"></i></a>
                <div class="collapsible-body">
                    <ul>
                      <?php if (isset($company_id)): ?>
                        <li><a href="#" id="addModalRoom" class="waves-effect" data-toggle="modal" data-target="#modalNewRoom"><i class="fa fa-plus"></i> Nueva Sala</a></li>
                        <?php foreach ($roomsCompany as $key => $value){ ?>
                        <li><a href="/company/<?php echo $company_id."/room/".$key; ?>" class="waves-effect"><?php echo $value; ?></a></li>
                        <?php } ?>
                      <?php else: ?>
                        <li><a id="selectCompany" class="waves-effect">Primero selecciona una empresa</a></li>
                      <?php endif ?>
                    </ul> 
                </div>
              </li>
            </ul>
          </li>
          
          <!--/. Side navigation links -->
        </ul>
      </div>
      <!--/. Sidebar navigation -->
</header>
<!--Main Navigation-->
<?php isset($room_id) ? $foreign_key=$room_id : $foreign_key=$company_id; ?>
<?php isset($room_id) ? $model='room' : $model='company'; ?>
<?php if(isset($company)){ ?>
<?php if ($typeRelation!=3 && ($typeRelation!=2 && !is_array($room_id)) or !is_array($foreign_key)): ?>
<section class="placeBoard sticky-top">
  <?php //print_r($room_id); ?>
  <div class="container">
    <div class="row align-items-center">
      <div class="col-sm-6">
        <div class="leftActions text-left">Mostrando Items de <strong><?php echo $this->Html->link($company->name, '/company/'.$company->id, ['class' => 'black-text']) ?></strong> <?php if ($room): ?> / <strong><?php echo $room->name; ?></strong><?php endif ?></div>
      </div>
      <div class="col-sm-6">
        <div class="rightActions text-right">
          <div class="btn-group" role="group" aria-label="Basic example">

            

              <button type="button" id="btnAddUser" class="btn btn-dark" data-toggle="modal" data-target="#modalNuevoUsuario" data-backdrop="static" data-keyboard="false" data-model="<?php echo $model; ?>" data-foreingkey="<?php echo $foreign_key; ?>"><i class="fa  fa-user-plus fa-sm pr-2" aria-hidden="true"></i> Usuario</button>
              <button type="button" class="btn btn-dark"  data-toggle="modal" data-target="#modalNuevoItem"><i class="fa fa-vcard fa-sm pr-2" aria-hidden="true"></i>Item</button>
          </div>
        </div>
      </div>
    </div>
  </div>  
</section>
<?php endif ?>
<?php } ?>
<!-- Modales -->
<?php echo $this->element('modales'); ?>



