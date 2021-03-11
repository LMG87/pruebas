<?php 
use Cake\Utility\Inflector;
$actionUrl = Inflector::camelize($this->request->getParam('controller')).'/'.$this->request->getParam('action');
 ?>
<?php if (isset($company)): ?>
    <?php if ($actionUrl!='Items/item'): ?>
        <?php if ($typeRelation!=3): ?>   
        <!--Modal: Login with Avatar Form-->
        <div class="modal fade" id="modalNewRoom" tabindex="-1" role="dialog" aria-labelledby="modalNewRoomLabel" aria-hidden="true">
            <div class="modal-dialog cascading-modal modal-avatar modal-sm" role="document">
                <!--Content-->
                <div class="modal-content">
                    <?php echo $this->Form->create(null, ['id'=>'newRoom','url' => ['controller' => 'Rooms','action' => 'addFront']]);?>
                    <!--Body-->
                    <div class="modal-body text-center mb-1">
                        <h5 class="mt-1 mb-5">Nueva Sala</h5>
                        <div class="md-form ml-0 mr-0">
                            <!--Blue select-->
                            <?php 
                            isset($room_id) ? $defaultRoom=$room_id[0] : $defaultRoom='';
                                echo $this->Form->select('Rooms.parent_id', $rooms, ['id'=>'room-parent_id', 'default' => $defaultRoom, 'disabled' => array(''),'empty' => 'Selecciona una opción','class'=>'mdb-select colorful-select dropdown-ins']);
                             ?>
                            <label data-error="wrong" data-success="right" for="room-parent_id">Sala Padre</label>
                        </div>
                        <div class="md-form ml-0 mr-0">
                            <?php 
                                echo $this->Form->text('Rooms.name', ['required','class' => 'form-control form-control-sm validate ml-0', 'id' => 'name']);
                             ?>
                            <label data-error="wrong" data-success="right" for="name">Nombre</label>
                        </div>
                        <div class="text-center mt-4">
                            <?php echo $this->Form->button('Crear <i class="fa fa-plus ml-1"></i>', ['type' => 'submit', 'escape' => false, 'class'=>'btn btn-ins mt-1']); ?>
                        </div>
                    </div>
                    <?php isset($company_id) ? true : $company_id="" ; ?>
                    <?php echo $this->Form->hidden('Rooms.company_id', ['id' => 'company_id', 'value'=>$company_id]); ?>
                    <?php echo $this->Form->end();?>
                </div>
                <!--/.Content-->
            </div>
        </div>
        <!--Modal: Login with Avatar Form-->
        <?php endif ?>
    <?php endif ?>




<div class="modal fade" id="modalNuevoUsuario" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <?php echo $this->Form->create(null, ['id'=>'newCollaborator','url' => ['controller' => 'Collaborators', 'action' => 'addFront']]);?>
            <div class="modal-header text-center">
                <h4 class="modal-title w-100 font-weight-bold">Invitar Usuario <br> <small><?php echo $this->Html->link($company->name, '/company/'.$company->id, ['class' => 'black-text']) ?> <?php if ($room): ?>/ <?php echo $room->name; ?><?php endif ?></small></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body mx-3">
                <div id="process0">
                    <div class="form-row">
                        <div class="col">
                            <div class="md-form mb-5">
                                <i class="fa fa-envelope prefix grey-text"></i>
                                <div class="group_select2">
                                    <?php 
                                        echo $this->Form->select('Collaborators.user_emails', '', ['id'=>'users-emails', 'required', 'multiple'=>true,'class'=>'browser-default  custom-select']);
                                     ?>
                                </div>                                
                                 <!--
                                <label data-error="wrong" data-success="right" for="collaborator-email">Email</label>-->
                            </div>
                        </div>                  
                    </div>
                    <!--
                    <div class="form-row">
                        <div class="col">
                            <div class="md-form mb-5">
                                <i class="fa fa-envelope prefix grey-text"></i>
                                <?php echo $this->Form->email('Collaborators.user_email', ['required','class' => 'form-control validate', 'id'=>'users-email']); ?>
                                <label data-error="wrong" data-success="right" for="collaborator-email">Email</label>
                            </div>
                        </div>                  
                    </div>
                    -->
                    <div class="form-row">
                        <div class="col">
                            <div class="md-form">
                                <i class="fa fa-pencil prefix grey-text"></i>
                                <?php echo $this->Form->textarea('Collaborators.menssage', ['required','class' => 'md-textarea form-control validate', 'id'=>'collaborator-menssage', 'rows'=>4]); ?>
                                <label data-error="wrong" data-success="right" for="collaborator-menssage">Mensaje</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col">
                            <div class="md-form">
                                <i class="fa fa-pencil-square-o prefix grey-text"></i>
                                <?php 
                                    echo $this->Form->select('Collaborators.role_id', $roles, ['id'=>'collaborator-roles', 'default' => '', 'disabled' => array(''),'empty' => 'Selecciona una opción', 'required','class'=>'mdb-select colorful-select dropdown-ins selectCol']);
                                 ?>
                                <label data-error="wrong" data-success="right" for="collaborator-roles">Rol</label>
                                <!--/Blue select-->
                            </div>
                        </div>
                    </div>
                </div>
                <div id="process1">
                    
                </div>
            </div>
            
            <div class="modal-footer d-flex justify-content-center">
                <?php echo $this->Form->button('Enviar <i class="fa fa-paper-plane-o ml-1"></i>', ['type' => 'submit', 'escape' => false, 'class'=>'btn btn-unique']); ?>
                <button style="display: none;" type="button" data-dismiss="modal" class="btn btn-unique waves-effect aceptModal waves-light">Aceptar</button>
                <button style="display: none;" type="button" class="btn btn-unique waves-effect sendNotiModal waves-light">Enviar notificación</button>
                <button type="button" data-dismiss="modal" class="btn btn-blue-grey waves-effect cancelModal waves-light">Cancelar <i class="fa fa-close ml-1"></i></button>
            </div>
            <?php isset($room_id) ? $foreign_key=$room_id : $foreign_key=$company_id; ?>
            <?php isset($room_id) ? $model='room' : $model='company'; ?>
            <?php echo $this->Form->hidden('Collaborators.model', ['value' => $model, 'id' => 'model']); ?>

            <?php echo $this->Form->hidden('Collaborators.foreign_key', ['value' => $foreign_key, 'id' => 'foreign_key']); ?>

            <?php echo $this->Form->hidden('process', ['value' => 0, 'id' => 'process']); ?>
            <?php echo $this->Form->end();?>
        </div>
    </div>
</div>
    <?php if ($actionUrl!='Items/item'): ?>
        <?php if ($typeRelation!=3): ?>
        <div class="modal fade" id="modalNuevoItem" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="backDrop" style="display: none;">
                    Suelta la carga del archivo
                </div>
                <div class="modal-content" ondrop="upload_fileI(event)" ondragover="upload_fileover(event); return false;" ondragleave="upload_fileout(event); return false;">
                    <?php echo $this->Form->create(null, ['id'=>'newItem','url' => ['action' => 'addFront']]);?>
                    <div class="modal-header text-center">
                        <h4 class="modal-title w-100 font-weight-bold">Crear Item<br> <small><?php echo $this->Html->link($company->name, '/company/'.$company->id, ['class' => 'black-text']) ?><?php if ($room): ?> / <?php echo $room->name; ?><?php endif ?></small></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body mx-3">
                        <div class="form-row">
                            <div class="col">
                                <div class="md-form" style="margin-bottom: 4rem;">
                                    <i style="margin-top: .5rem;" class="fa fa-lock prefix grey-text"></i>
                                    <!-- Material unchecked -->
                                    <div class="form-check" style="margin-left: 3rem;">
                                        <?php echo $this->Form->checkbox('Items.private', ['id'=>'item-private','hiddenField' => false]); ?>
                                        <label class="form-check-label" for="item-private">Privado</label>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <div class="md-form">
                                    <i class="fa fa-list-alt prefix grey-text"></i>
                                    <?php 
                                        echo $this->Form->select('Items.type_item_id', $type_items, ['default' => '', 'disabled' => array(''),'empty' => 'Selecciona una opción', 'required','id'=>'item-type_item_id', 'required', 'class'=>'selectCol mdb-select colorful-select dropdown-ins']);
                                     ?>
                                    <label data-error="wrong" data-success="right" for="item-type_item_id">Tipo item</label>
                                    <!--/Blue select-->
                                </div>
                            </div>
                        </div>
                        <div class="form-row fecha_reunion" style="display: none;">
                            <div class="col-sm-6">
                                <div class="md-form mb-5">
                                    <i class="fa fa-calendar prefix grey-text"></i>
                                    <?php 
                                        echo $this->Form->text('Items.fecha_reunion', ['class' => 'form-control pickadate', 'id' => 'fecha_reunion']);
                                     ?>
                                    <label data-error="wrong" data-success="right" for="fecha_reunion">Fecha reunión</label>
                                </div>
                            </div>  
                            <div class="col-sm-6">
                                <div class="md-form mb-5">
                                    <i class="fa fa-clock-o prefix grey-text"></i>
                                    <?php 
                                        echo $this->Form->text('Items.hora_reunion', ['class' => 'form-control pickadatetime', 'id' => 'hora_reunion']);
                                     ?>
                                    <label data-error="wrong" data-success="right" for="hora_reunion">Hora reunión</label>
                                </div>
                            </div>                  
                        </div>
                        <div class="form-row fecha_vencimiento" style="display: none;">
                            <div class="col-sm-6">
                                <div class="md-form mb-5">
                                    <i class="fa fa-calendar prefix grey-text"></i>
                                    <?php 
                                        echo $this->Form->text('Items.fecha_vencimiento', ['class' => 'form-control pickadate', 'id' => 'fecha_vencimiento']);
                                     ?>
                                    <label data-error="wrong" data-success="right" for="fecha_vencimiento">Fecha vencimiento</label>
                                </div>
                            </div>    
                            <div class="col-sm-6">
                                <div class="md-form mb-5">
                                    <i class="fa fa-clock-o prefix grey-text"></i>
                                    <?php 
                                        echo $this->Form->text('Items.hora_vencimiento', ['class' => 'form-control pickadatetime', 'id' => 'hora_vencimiento']);
                                     ?>
                                    <label data-error="wrong" data-success="right" for="hora_vencimiento">Hora vencimiento</label>
                                </div>
                            </div>                
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <div class="md-form mb-5">
                                    <i class="fa fa-font prefix grey-text"></i>
                                    <?php 
                                        echo $this->Form->text('Items.name', ['required','class' => 'form-control validate', 'id' => 'ItemName']);
                                     ?>
                                    <label data-error="wrong" data-success="right" for="ItemName">Nombre</label>
                                </div>
                            </div>                  
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <div class="md-form">
                                    <i class="fa fa-pencil prefix grey-text"></i>
                                        <?php 
                                            echo $this->Form->textarea('Items.description', ['required','class' => 'md-textarea form-control validate', 'id' => 'description1', 'rows' => 4]);
                                         ?>
                                    <label data-error="wrong" data-success="right" for="description1">Descripción</label>
                                </div>
                            </div>
                        </div> 
                        <div class="form-row">
                            <div class="col">
                                <div class="md-form">
                                    <div id="drop_file_zone">
                                        <div id="drag_upload_file">
                                            <button class="btn btn-dark btn-sm waves-effect waves-light" onclick="file_explorerI();" type="button">Adjuntar archivo</button> <span class="text-muted small">o arrastrar y soltar para subir</span>
                                            <?php 
                                                echo $this->Form->file('Items.file', ['class' => 'd-none', 'id' => 'selectfile', 'multiple' => 'multiple']);
                                             ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>             
                    </div>
                    <div class="modal-footer d-flex justify-content-center">
                        <?php echo $this->Form->button('Crear <i class="fa fa-calendar-plus-o ml-1"></i>', ['type' => 'submit', 'escape' => false, 'class'=>'btn btn-unique']); ?>
                    </div>
                    <?php //isset($room_id) ? true : $room_id="" ; ?>
                    <?php if (isset($room_id)): echo $this->Form->hidden('Items.room_id', ['id' => 'room_id', 'value'=>$room_id]); endif ?>
                    <?php isset($company_id) ? true : $company_id="" ; ?>
                    <?php echo $this->Form->hidden('Items.company_id', ['id' => 'company_id', 'value'=>$company_id]); ?>
                    <?php echo $this->Form->end();?>
                </div>
            </div>
        </div>
        <?php endif ?>
    <?php endif ?>
<?php endif ?>
<div class="modal fade" id="modalWithouCompanies" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h4 class="modal-title w-100 font-weight-bold">Sin empresas asignadas</h4>
            </div>
            <div class="modal-body mx-3">
                Lo sentimos pero no hay empresas asignadas a tu perfil, solicita una para poder utilizar el sistema.
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <?php echo $this->Html->link(__('Salir <i class="fa fa-sign-out ml-1"></i>'), ['controller'=>'Users', 'action'=>'logout', 'plugin'=>'Usermgmt'], ['escape' => false,'class'=>'btn btn-unique']); ?>
            </div>
        </div>
    </div>
</div>

<?php if ($actionUrl!='Items/item'): ?>
    <div class="modal fade" id="modalItem" role="dialog" aria-labelledby="ItemLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            
            <div class="backDrop" style="display: none;">
                Suelta la carga del archivo
            </div>
            <div class="modal-content"  ondrop="upload_file(event)" ondragover="upload_fileover(event); return false;" ondragleave="upload_fileout(event); return false;">
                <div class="text-right m-2 moreItem dropdown">
                    <!-- Basic dropdown -->
                    <button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-dark btn-sm px-3"><i class="fa fa-bars" aria-hidden="true"></i></button>
                    <div class="dropdown-menu dropdown-dark p-0">
                        <?php echo $this->Html->link(__('<i class="fa fa-eye ml-1"></i> Ver más'), '#', ['escape' => false,'class'=>'dropdown-item','id'=>'btn_view_more']); ?>
                        <button class="dropdown-item" id="deleteItem"><i class="fa fa-trash mr-2"></i> Eliminar</button>

                    </div>
                    <!-- Basic dropdown -->
                </div>
                <div class="modal-header text-center">
                    <div class="holder_item">
                        <?php 
                            echo $this->Form->text('Items.name', ['id' => 'name']);
                         ?>
                    </div>
                    <div class="itemButton text-right" style="display: none;">
                        <div class="btn-group" role="group">
                          <button type="button" id="addC" class="btn btn-blue-grey btn-sm waves-effect waves-light">Guardar</button>
                          <button type="button" id="cancelC" class="btn btn-blue-grey btn-sm waves-effect waves-light">Cancelar</button>
                        </div>
                    </div>
                    <h4 class="modal-title w-100 font-weight-bold"><span></span>Sin empresas asignadas</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body mx-0 p-0">
                    <div class="mdb-color lighten-5 p-3">
                        <div class="barInfo">
                            <ul class="list-unstyled list-inline small mb-0">
                              <li class="list-inline-item black-text dateItem"><i class="fa fa-clock-o pr-1"></i><span>10/11/18, 4:46 AM</span></li>
                              <li class="list-inline-item black-text byItem"><strong>Creado por:</strong> <span>jeff</span></li>
                               <li class="list-inline-item black-text typeItem"><strong>Tipo:</strong> <span>tipo item tarea</span></li>
                               <li class="list-inline-item black-text companyItem"><strong>Empresa:</strong> <span>informatica</span></li>
                               <li class="list-inline-item black-text roomItem"><strong>Sala:</strong> <span>informatica</span></li>
                               <li class="list-inline-item commentsItem"><a href="#" class="black-text"><strong><i class="fa fa-comments-o pr-1"></i></strong><span class="countComments">12</span></a></li>
                               <li class="list-inline-item attachmentsItem"><a href="#" class="black-text"><strong><i class="fa fa-paperclip pr-1"></i></strong><span class="countAttachments">3</span></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="p-3 text-muted"><small>Descripción</small></div>
                    <div class="descriptionItem px-3 pb-3">
                        <div class="contentText">
                            
                        </div>

                        <div class="holder_item2">
                            <?php 
                                echo $this->Form->textarea('Items.description', [ 'id' => 'description']);
                             ?>
                        </div>
                        <div class="itemButton text-right" style="display: none;">
                            <div class="btn-group" role="group">
                              <button type="button" id="addC" class="btn btn-blue-grey btn-sm waves-effect waves-light">Guardar</button>
                              <button type="button" id="cancelC" class="btn btn-blue-grey btn-sm waves-effect waves-light">Cancelar</button>
                            </div>
                        </div>
                    </div>
                    <div id="viewMore"><i class="fa fa-chevron-down z-depth-1" aria-hidden="true"></i></div>
                    
                    <div class="teal lighten-5 p-3 filesItem">
                        <h6 class="mb-0"><i class="fa fa-paperclip mr-2"></i> Archivos adjuntos <small><strong class="countAttachments">2</strong></small></h6>
                    </div> 
                    <dl class="row p-3 align-items-center m-0" id="blockAttachments">

                      <dt class="col-sm-1 h4 m-0"><i class="fa fa-file-pdf-o"></i></dt>
                      <dd class="col-sm-11 small"><a href="#"><strong class="text-dark">archivo.pdf</strong><br> <span class="text-muted">Yalhen Clarissa, 10/11/18, 4:46 AM, 447 KB</span></a></dd>

                    </dl> 
                    <div class="px-4 pt-0 pb-3">

                        <div id="drop_file_zone">
                            <div id="drag_upload_file">
                                <button class="btn btn-dark btn-sm waves-effect waves-light" onclick="file_explorer();">Adjuntar archivo</button> <span class="text-muted small">o arrastrar y soltar para subir</span>
                                <input type="file" name="file[]" id="selectfile" class="d-none" multiple>
                            </div>
                        </div>

                        

                    </div>
                    <div class="teal lighten-5 p-3 commentsItem">
                        <h6 class="mb-0"><i class="fa fa-commenting-o mr-2"></i> Comentarios <small><strong class="countComments">3</strong></small></h6>
                    </div> 
                    <div class="bodyComments">
                        <div class="m-auto d-table">
                            <button id="showEarlierComments" class="btn btn-flat" type="button" style="display: none;"><i class="fa fa-chevron-down"></i>  Mostrar comentarios anteriores</button>
                        </div>
                        <ul class="listComments m-0 p-0">
                        </ul>
                        <div class="d-flex flex-row  pb-3 pl-3 pr-3 pt-3" id="blockAddComment">
                            <div>
                                <div class="zonIcon">
                                    <?php echo $letterIcon; ?>
                                </div>
                            </div>
                            <div class="zoncomment" id="actionComment">
                                <textarea placeholder="Adicionar comentario..." id="addComment" name="addComment" data-itemId="right" class="p-0 form-control border-0 zonContentComment shadow-sm rounded pl-3 pr-3 pt-3 pb-3 mt-0"></textarea>
                                <div class="zonCommentButton text-right" style="display: none;">
                                    <div class="btn-group" role="group">
                                      <button type="button" id="addC" class="btn btn-blue-grey btn-sm">Adicionar</button>
                                      <button type="button" id="cancelC" class="btn btn-blue-grey btn-sm">Cancelar</button>
                                    </div>
                                </div>
                            </div>
                        </div>                   
                    </div>             
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <?php echo $this->Html->link(__('Ver más <i class="fa fa-eye ml-1"></i>'), '#', ['escape' => false,'class'=>'btn btn-sm btn-unique','id'=>'btn_view_more']); ?>
                </div>
            </div>
        </div>
    </div>
<?php endif ?>
<?php// debug($actionUrl); ?>