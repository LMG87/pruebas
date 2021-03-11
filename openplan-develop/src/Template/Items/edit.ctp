<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Item $item
 */
?>
<div class="row">
    <div class="col-sm-3">
        <nav class="large-3 medium-4 columns" id="actions-sidebar">
            <ul class="list-group">
                <li class="heading list-group-item active waves-effect"><?= __('Actions') ?></li>
                        <li class="heading list-group-item  waves-effect"><?= $this->Form->postLink(
                        __('Delete'),
                        ['action' => 'delete', $item->id],
                        ['confirm' => __('Are you sure you want to delete # {0}?', $item->id)]
                    )
                ?></li>
                        <li class="heading list-group-item  waves-effect"><?= $this->Html->link(__('List Items'), ['action' => 'index']) ?></li>
                        <li class="heading list-group-item  waves-effect"><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
                <li class="heading list-group-item  waves-effect"><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
                <li class="heading list-group-item  waves-effect"><?= $this->Html->link(__('List Rooms'), ['controller' => 'Rooms', 'action' => 'index']) ?></li>
                <li class="heading list-group-item  waves-effect"><?= $this->Html->link(__('New Room'), ['controller' => 'Rooms', 'action' => 'add']) ?></li>
                <li class="heading list-group-item  waves-effect"><?= $this->Html->link(__('List Type Items'), ['controller' => 'TypeItems', 'action' => 'index']) ?></li>
                <li class="heading list-group-item  waves-effect"><?= $this->Html->link(__('New Type Item'), ['controller' => 'TypeItems', 'action' => 'add']) ?></li>
                <li class="heading list-group-item  waves-effect"><?= $this->Html->link(__('List Companies'), ['controller' => 'Companies', 'action' => 'index']) ?></li>
                <li class="heading list-group-item  waves-effect"><?= $this->Html->link(__('New Company'), ['controller' => 'Companies', 'action' => 'add']) ?></li>
                        <li class="heading list-group-item  waves-effect"><?= $this->Html->link(__('List Actions'), ['controller' => 'Actions', 'action' => 'index']) ?></li>
                <li class="heading list-group-item  waves-effect"><?= $this->Html->link(__('New Action'), ['controller' => 'Actions', 'action' => 'add']) ?></li>
                    </ul>
        </nav>
    </div>
    <div class="col-sm-9">
        
        <div class="items form large-9 medium-8 columns content">
            <?= $this->Form->create($item) ?>
            <fieldset>
                <legend><?= __('Edit Item') ?></legend>
                <?php
                            echo $this->Form->control('name');
                    echo $this->Form->control('description');
                    echo $this->Form->control('user_id', ['options' => $users]);
                    echo $this->Form->control('room_id', ['options' => $rooms, 'empty' => true]);
                    echo $this->Form->control('type_item_id', ['options' => $typeItems]);
                    echo $this->Form->control('company_id', ['options' => $companies]);
                    echo $this->Form->control('actions._ids', ['options' => $actions]);
                        ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>

    </div>
</div>
