<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TypeItem $typeItem
 */
?>
<div class="row">
    <div class="col-sm-3">
        <nav class="large-3 medium-4 columns" id="actions-sidebar">
            <ul class="list-group">
                <li class="heading list-group-item active waves-effect"><?= __('Actions') ?></li>
                        <li class="heading list-group-item  waves-effect"><?= $this->Html->link(__('List Type Items'), ['action' => 'index']) ?></li>
                        <li class="heading list-group-item  waves-effect"><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?></li>
                <li class="heading list-group-item  waves-effect"><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?></li>
                    </ul>
        </nav>
    </div>
    <div class="col-sm-9">
        
        <div class="typeItems form large-9 medium-8 columns content">
            <?= $this->Form->create($typeItem) ?>
            <fieldset>
                <legend><?= __('Add Type Item') ?></legend>
                <?php
                            echo $this->Form->control('name');
                    echo $this->Form->control('description');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>

    </div>
</div>
