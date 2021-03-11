<!-- Timeline -->
<?php 
    $this->Paginator->setTemplates([
        'nextActive' => '<a class="btn btn-dark btn-sm waves-effect waves-light ml-auto mr-auto d-table mb-4" href="{{url}}">{{text}}</a>',
        'nextDisabled' => '<a class="btn btn-dark disabled btn-sm waves-effect waves-light ml-auto mr-auto d-table mb-4" href="{{url}}">{{text}}</a>'
    ]);
 ?>
<?php //debug($items); ?>
<div class="fixed-action-btn smooth-scroll" style="">
    <a href="#top-section" class="btn-floating scrollToBottom btn-floating btn-md blue-gradient">
        <i class="fa fa-arrow-up"></i>
    </a>
</div>
<div id="sectNbutton" style="display: none;"><button class="btn btn-md btn-outline-primary btn-rounded waves-effect mx-auto d-table"> Nuevos items <span class="fa fa-arrow-up"></span></button></div>
<section id=timelineContent>
    
    <div id="timeline">
    <?php $count=0; foreach ($items as $item): $count++; $rightF=""; if ($count==2) { $rightF="right"; $count=0; } ?>
        <div class="timeline-item" floatType="<?php echo $rightF; ?>">
          <div class="timeline-icon"><?= $this->Time->i18nFormat($item->created, 'dd MMMM YYYY HH:mm') ?></div>
          
          <?php //echo ; ?>

          <div class="timeline-content <?= h($rightF) ?>"  data-itemId="<?= $item->id ?>">
           <?php /* <h2><?= h($item->id) ?></h2>*/ ?>
           
           
            <h2><?php if ($item->private): echo '<i data-toggle="tooltip" data-placement="top" title="Item privado" class="fa fa-lock prefix grey-text"></i> '; endif ?><?= h($item->name) ?></h2>
            <div class="row">
                <div class="col-sm-9">
                    <p><strong>Creado por:</strong> <?= $item->has('user') ? $this->Html->link($item->user->first_name." ".$item->user->last_name, ['controller' => 'Users', 'action' => 'view', $item->user->id]) : '' ?>,
                     <strong>Tipo:</strong> <?= $item->has('type_item') ? $this->Html->link($item->type_item->name, ['controller' => 'TypeItems', 'action' => 'view', $item->type_item->id]) : '' ?>, 
                     <strong>Sala:</strong> <?= $item->has('room') ? $this->Html->link($item->room->name, ['controller' => 'Rooms', 'action' => 'view', $item->room->id]) : 'Sin definir' ?>,
                    <strong>Empresa: </strong><?= $item->has('company') ? $this->Html->link($item->company->name, ['controller' => 'Companies', 'action' => 'view', $item->company->id]) : '' ?></p>
                </div>
                <div class="col-sm-3 text-right">
                    <button type="button" data-keyboard="false" id="btnAddUser" data-toggle="modal" data-target="#modalNuevoUsuario" class="btn btn-dark btn-sm" data-model="item" data-foreingkey="<?php echo $item->id; ?>"><i class="fa  fa-user-plus fa-sm pr-2" aria-hidden="true"></i></button>
                </div>
            </div>
            <div class="additionals_fields">
                <?php if ($item->type_item_id==1 && $item->additional_fields): ?>
                    <p><strong>Fecha reunión:</strong>  <?php echo $item->additional_fields['fecha_reunion']; ?> <?php echo $item->additional_fields['hora_reunion']; ?></p>
                <?php elseif ($item->type_item_id==2 && $item->additional_fields): ?>
                    <p><strong>Fecha vencimiento:</strong>  <?php echo $item->additional_fields['fecha_vencimiento']; ?> <?php echo $item->additional_fields['hora_vencimiento']; ?></p>
                <?php endif ?>
                
            </div>
            <div class="bodytextItem"><?= $item->description ?></div>
            
            <?php /* ?><a href="#?<?= $this->Number->format($item->id) ?>" class="btn btn-primary btn-rounded">ampliar</a> */?>
          </div>
        </div>
    <?php endforeach; ?>
    </div>
    <div class="buttonSectionTop"><?php echo $this->Paginator->next('Cargar anteriores'); ?></div>
</section>

<?php /* ?>
<div class="paginator">
    <ul class="pagination">
        <?= $this->Paginator->first('<< ' . __('first')) ?>
        <?= $this->Paginator->prev('< ' . __('previous')) ?>
        <?= $this->Paginator->numbers() ?>
        <?= $this->Paginator->next(__('next') . ' >') ?>
        <?= $this->Paginator->last(__('last') . ' >>') ?>
    </ul>
    <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
</div>
*/
?>
<!-- Timeline -->
