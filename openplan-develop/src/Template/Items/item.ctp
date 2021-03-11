<?php //debug($relationItem); ?>
<div class="sidenav">
    <div class="teal lighten-5 p-3 commentsItem">
        <h6 class="mb-0"><i class="fa fa-commenting-o mr-2"></i> Comentarios <small><strong class="countComments"><?php echo count($item->comments); ?></strong></small></h6>
    </div>

    <div class="bodyComments pb-3">
            <?php if (count($item->comments)>3): ?>
            <div class="m-auto d-table">
                <button id="showEarlierComments" class="btn btn-flat waves-effect waves-effect" type="button"><i class="fa fa-chevron-down"></i>  Mostrar comentarios anteriores</button>
            </div>
            <?php endif ?>
            <ul class="listComments m-0 p-0">

                <?php $totalComment=count($item->comments); if ($totalComment>0):  ?>
                <?php $index=0; foreach ($item->comments as $comment): ?> 
                    <?php 
                        $rest1 = substr($comment->user->first_name, 0,1);
                        $rest2 = substr($comment->user->last_name, 0,1);
                        $lettericon=strtoupper($rest1.$rest2);
                        $display="block";
                        $index++;
                        if ($totalComment>3) {
                            $lastComments=$totalComment-3;
                            if ($index<=$lastComments) {
                                $display="none";
                            }
                        }
                        $buttonX='';
                        $eComment='';
                        if ($relationItem->role_id==3 && $relationItem->user_id==$comment->user_id or ($relationItem->role_id==1 or $relationItem->role_id==2)):
                            $buttonX='<button type="button" class="close"><span aria-hidden="true">×</span></button>';
                            $eComment='<div class="editComment" style="display:none;"><textarea placeholder="Adicionar comentario..." name="message<?php echo $comment->id; ?>" data-itemid="'.$comment->item_id.'" data-commentid="'.$comment->id.'" class="p-0 form-control border-0 zonContentComment shadow-sm rounded pl-3 pr-3 pt-3 pb-3 mt-0">'.$comment->message.'</textarea><div class="text-right"><div class="btn-group" role="group"><button type="button" id="addC" class="btn btn-blue-grey btn-sm waves-effect waves-light">Editar</button><button type="button" id="cancelC" class="btn btn-blue-grey btn-sm waves-effect waves-light">Cancelar</button></div></div></div>';
                        endif ?>

                    <li id="Comment_<?php echo $comment->id; ?>" class="listComment pb-0" style="display:<?php echo $display; ?>;padding-left: 0px;"><div class="d-flex flex-row  pb-3 pl-3 pr-3 pt-3"><div><div class="zonIcon"><?php echo $lettericon; ?></div></div><div class="zoncomment" data-commentid="<?php echo $comment->id; ?>"><?php echo $buttonX; ?><div class="zonName"><strong><?php echo $comment->user->first_name." ".$comment->user->last_name; ?></strong></div><div class="zonDate"><small class="text-muted"><?= $this->Time->i18nFormat($comment->created, 'dd MMMM YYYY HH:mm') ?></small></div><div id="contetmessage"  class="repose"><div class="zonContentComment shadow-sm rounded"><?php echo $comment->message; ?></div><?php echo $eComment; ?></div></div></div></li>

                <?php endforeach ?>
                <?php endif ?>
                

            </ul>
        
        <div class="d-flex flex-row  pb-5 pl-3 pr-3 pt-3" id="blockAddComment">
            <div>
                <div class="zonIcon">
                    <?php echo $letterIcon; ?>
                </div>
            </div>
            <div class="zoncomment" id="actionComment">
                <textarea placeholder="Adicionar comentario..." id="addComment" name="addComment" data-itemid="<?php echo $item->id; ?>" class="p-0 form-control border-0 zonContentComment shadow-sm rounded pl-3 pr-3 pt-3 pb-3 mt-0"></textarea>
                <div class="zonCommentButton text-right" style="display: none;">
                    <div class="btn-group" role="group">
                      <button type="button" id="addC" class="btn btn-blue-grey btn-sm waves-effect waves-light">Adicionar</button>
                      <button type="button" id="cancelC" class="btn btn-blue-grey btn-sm waves-effect waves-light">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>                   
    </div>
</div>

<div class="mainItem"  ondrop="upload_file(event)" ondragover="upload_fileover(event); return false;" ondragleave="upload_fileout(event); return false;">
    <div class="backDrop" style="display: none;">
        Suelta la carga del archivo
    </div>
    <!--
<div class="fixed-action-btn smooth-scroll" style="">
    <a href="#top-section" class="btn-floating scrollToBottom btn-floating btn-md blue-gradient">
        <i class="fa fa-arrow-up"></i>
    </a>
</div>
    -->

    <section id="itemSingle">
        <!-- Card -->
        <div class="card card-cascade wider reverse">

          <!-- Card image -->
          <div class="view view-cascade overlay">
            <img class="card-img-top" src="https://mdbootstrap.com/img/Photos/Slides/img%20(70).jpg" alt="Card image cap">
            <a href="#!">
              <div class="mask rgba-white-slight"></div>
            </a>
          </div>
          <!-- Card footer -->
            <div class="rounded-bottom mdb-color lighten-3 text-center pt-3 mb-3">
              <ul class="list-unstyled list-inline font-small">
                <li class="list-inline-item pr-2 white-text"><i class="fa fa-clock-o pr-1"></i><?= $this->Time->i18nFormat($item->created, 'dd MMMM YYYY HH:mm') ?></li>
                <li class="list-inline-item pr-2"><a href="#" class="white-text"><i class="fa fa-comments-o pr-1"></i><span class="countComments"><?php echo count($item->comments); ?></span></a></li>

                <li class="list-inline-item pr-2 white-text"><strong>Creado por:</strong> <?= $item->has('user') ? $this->Html->link($item->user->first_name." ".$item->user->last_name, ['controller' => 'Users', 'action' => 'view', $item->user->id]) : '' ?></li>
                 <li class="list-inline-item pr-2 white-text"><strong>Tipo:</strong> <?= $item->has('type_item') ? $this->Html->link($item->type_item->name, ['controller' => 'TypeItems', 'action' => 'view', $item->type_item->id]) : '' ?></li>
                 <li class="list-inline-item pr-2 white-text"><strong>Sala:</strong> <?= $item->has('room') ? $this->Html->link($item->room->name, ['controller' => 'Rooms', 'action' => 'view', $item->room->id]) : 'Sin definir' ?></li>
                <?php if ($item->type_item_id==1 && $item->additional_fields): ?>
                    <li class="list-inline-item pr-2 white-text"><strong>Fecha reunión:</strong> <?= $item->additional_fields['fecha_reunion'] ?> <?= $item->additional_fields['hora_reunion'] ?></li>
                <?php elseif ($item->type_item_id==2): ?>
                    <li class="list-inline-item pr-2 white-text"><strong>Fecha vencimiento:</strong> <?= $this->Time->i18nFormat($item->additional_fields['hora_vencimiento'], 'dd MMMM YYYY HH:mm') ?></li>
                <?php endif ?>
              </ul>
            </div>

          <!-- Card content -->
          <div class="card-body card-body-cascade text-center">

            <!-- Title -->
            <div class="headerItem">
                <div class="holder_item">
                    <?php 
                        echo $this->Form->text('Items.name', ['id' => 'name']);
                     ?>
                </div>
                <div class="itemButton text-right pt-5" style="display: none;">
                    <div class="btn-group" role="group">
                      <button type="button" id="addC" class="btn btn-blue-grey btn-sm waves-effect waves-light">Guardar</button>
                      <button type="button" id="cancelC" class="btn btn-blue-grey btn-sm waves-effect waves-light">Cancelar</button>
                    </div>
                </div>
            </div>
            <h4 class="card-title"><strong><?= h($item->name) ?></strong></h4>
            <!-- Subtitle -->
            <h6 class="font-weight-bold indigo-text py-2"><?= $item->has('company') ? $this->Html->link($item->company->name, ['controller' => 'Companies', 'action' => 'view', $item->company->id]) : '' ?></h6>
            <!-- Text -->
            <div class="descriptionItem text-left">
                <div class="card-text"><?= $item->description ?></div>
                <div class="holder_item2">
                    <?php 
                        echo $this->Form->textarea('Items.description', [ 'id' => 'description', 'value'=>$item->description]);
                     ?>
                </div>
                <div class="itemButton text-right" style="display: none;">
                    <div class="btn-group" role="group">
                      <button type="button" id="addC" class="btn btn-blue-grey btn-sm waves-effect waves-light">Guardar</button>
                      <button type="button" id="cancelC" class="btn btn-blue-grey btn-sm waves-effect waves-light">Cancelar</button>
                    </div>
                </div>
            </div>
            
          </div>
          

        </div>
        <!-- Card -->
        <div class="blockFilesItem mt-4">
            <div class="teal white  filesItem p-2 px-3">
                <div class="row align-items-center">
                    <div class="col">
                        <h6 class="mb-0"><i class="fa fa-paperclip mr-2"></i> Archivos adjuntos <small><strong class="countAttachments"><?php echo count($item->files); ?></strong></small></h6>
                    </div>
                    <div class="col text-right">
                        <div id="drop_file_zone">
                            <div id="drag_upload_file">
                                <button class="btn btn-dark btn-sm waves-effect waves-light" onclick="file_explorer();">Adjuntar archivo</button> <span class="text-muted small">o arrastrar y soltar para subir</span>
                                <input type="file" name="file[]" id="selectfile" class="d-none" multiple>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row" id="listFiles">
                <?php foreach ($item->files as $file): ?>
                    <?php 
                    $buttonX='';
                    if ($relationItem->role_id==3 && $relationItem->user_id==$file->user_id or ($relationItem->role_id==1 or $relationItem->role_id==2)):
                        $buttonX='<a href="#" id="deleteFile" class="btn btn-git btn-md waves-effect waves-light"><i class="fa fa-trash"></i></a>';
                    endif;
                     ?>
                    <div class="col-sm-3 mt-4 blockfile<?php echo $file->id; ?>">
                        <div class="blonit text-center rounded bg-light shadow p-1 z-depth-1 view overlay" id="attFile" data-fileid="<?php echo $file->id; ?>">
                            
                            <div class="tipoIcon fs-5 text-dark">
                                <i class="fa <?php echo $file->icon; ?>"></i>
                            </div>
                            <div class="filecontent text-secondary">
                                <strong class="text-dark" style=""><?php echo $file->name; ?></strong><br>
                                <p><small><?php echo $file->user->first_name." ".$file->user->last_name; ?><br> <?= $this->Time->i18nFormat($file->created, 'dd MMMM YYYY HH:mm') ?><br> <?php echo $file->size; ?></small></p>
                            </div>
                            <div class="mask flex-center rgba-white-strong">
                                <div class="text-center">
                                    <?php /* ?><p><strong class="fs-4"><?php echo $file->name; ?></strong></p> */ ?>
                                    <a href="/files/download/<?php echo $file->filename; ?>" class="btn btn-vk btn-md waves-effect waves-light">
                                        <i class="fa fa-download"></i>
                                    </a>
                                    <?php echo $buttonX; ?>
                                </div>                                
                            </div>   
                        </div>                                      
                    </div>
                <?php endforeach ?>
            </div>
        </div>
    </section>
</div>