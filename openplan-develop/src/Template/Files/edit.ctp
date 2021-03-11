<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\File $file
 */
?>
<div class="row">
    <div class="col-sm-3">
        <nav class="large-3 medium-4 columns" id="actions-sidebar">
            <ul class="list-group">
                <li class="heading list-group-item active waves-effect"><?= __('Actions') ?></li>
                        <li class="heading list-group-item  waves-effect"><?= $this->Form->postLink(
                        __('Delete'),
                        ['action' => 'delete', $file->id],
                        ['confirm' => __('Are you sure you want to delete # {0}?', $file->id)]
                    )
                ?></li>
                        <li class="heading list-group-item  waves-effect"><?= $this->Html->link(__('List Files'), ['action' => 'index']) ?></li>
                        <li class="heading list-group-item  waves-effect"><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
                <li class="heading list-group-item  waves-effect"><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
                <li class="heading list-group-item  waves-effect"><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?></li>
                <li class="heading list-group-item  waves-effect"><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?></li>
                    </ul>
        </nav>
    </div>
    <div class="col-sm-9">
        
        <div class="files form large-9 medium-8 columns content">
            <?= $this->Form->create($file) ?>
            <fieldset>
                <legend><?= __('Edit File') ?></legend>
                <?php
                            echo $this->Form->control('name');
                    echo $this->Form->control('path');
                    echo $this->Form->control('user_id', ['options' => $users]);
                    echo $this->Form->control('item_id', ['options' => $items]);
                    echo $this->Form->control('status');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>

    </div>
</div>
