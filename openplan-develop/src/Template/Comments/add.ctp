<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Comment $comment
 */
?>
<div class="row">
    <div class="col-sm-3">
        <nav class="large-3 medium-4 columns" id="actions-sidebar">
            <ul class="list-group">
                <li class="heading list-group-item active waves-effect"><?= __('Actions') ?></li>
                        <li class="heading list-group-item  waves-effect"><?= $this->Html->link(__('List Comments'), ['action' => 'index']) ?></li>
                        <li class="heading list-group-item  waves-effect"><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
                <li class="heading list-group-item  waves-effect"><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
                <li class="heading list-group-item  waves-effect"><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?></li>
                <li class="heading list-group-item  waves-effect"><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?></li>
                    </ul>
        </nav>
    </div>
    <div class="col-sm-9">
        
        <div class="comments form large-9 medium-8 columns content">
            <?= $this->Form->create($comment) ?>
            <fieldset>
                <legend><?= __('Add Comment') ?></legend>
                <?php
                            echo $this->Form->control('parent_id', ['options' => $parentComments, 'empty' => true]);
                            //echo $this->Form->control('parent_id', ['options' => $parentRooms, 'empty' => true]);
                    echo $this->Form->control('lft');
                    echo $this->Form->control('rght');
                    echo $this->Form->control('user_id', ['options' => $users]);
                    echo $this->Form->control('item_id', ['options' => $items]);
                    echo $this->Form->control('message');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>

    </div>
</div>
