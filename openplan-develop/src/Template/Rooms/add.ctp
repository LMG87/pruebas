<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Room $room
 */
?>
<div class="row">
    <div class="col-sm-3">
        <nav class="large-3 medium-4 columns" id="actions-sidebar">
            <ul class="list-group">
                <li class="heading list-group-item active waves-effect"><?= __('Actions') ?></li>
                        <li class="heading list-group-item  waves-effect"><?= $this->Html->link(__('List Rooms'), ['action' => 'index']) ?></li>
                        <li class="heading list-group-item  waves-effect"><?= $this->Html->link(__('List Parent Rooms'), ['controller' => 'Rooms', 'action' => 'index']) ?></li>
                <li class="heading list-group-item  waves-effect"><?= $this->Html->link(__('New Parent Room'), ['controller' => 'Rooms', 'action' => 'add']) ?></li>
                <li class="heading list-group-item  waves-effect"><?= $this->Html->link(__('List Companies'), ['controller' => 'Companies', 'action' => 'index']) ?></li>
                <li class="heading list-group-item  waves-effect"><?= $this->Html->link(__('New Company'), ['controller' => 'Companies', 'action' => 'add']) ?></li>
                        <li class="heading list-group-item  waves-effect"><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?></li>
                <li class="heading list-group-item  waves-effect"><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?></li>
                    </ul>
        </nav>
    </div>
    <div class="col-sm-9">
        
        <div class="rooms form large-9 medium-8 columns content">
            <?= $this->Form->create($room) ?>
            <fieldset>
                <legend><?= __('Add Room') ?></legend>
                <?php
                            echo $this->Form->control('parent_id', ['options' => $parentRooms, 'empty' => true]);
                    echo $this->Form->control('name');
                    echo $this->Form->control('company_id', ['options' => $companies]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>

    </div>
</div>
