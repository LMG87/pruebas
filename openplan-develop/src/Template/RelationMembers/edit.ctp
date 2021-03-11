<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\RelationMember $relationMember
 */
?>
<div class="row">
    <div class="col-sm-3">
        <nav class="large-3 medium-4 columns" id="actions-sidebar">
            <ul class="list-group">
                <li class="heading list-group-item active waves-effect"><?= __('Actions') ?></li>
                        <li class="heading list-group-item  waves-effect"><?= $this->Form->postLink(
                        __('Delete'),
                        ['action' => 'delete', $relationMember->id],
                        ['confirm' => __('Are you sure you want to delete # {0}?', $relationMember->id)]
                    )
                ?></li>
                        <li class="heading list-group-item  waves-effect"><?= $this->Html->link(__('List Relation Members'), ['action' => 'index']) ?></li>
                        <li class="heading list-group-item  waves-effect"><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
                <li class="heading list-group-item  waves-effect"><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
                <li class="heading list-group-item  waves-effect"><?= $this->Html->link(__('List Roles'), ['controller' => 'Roles', 'action' => 'index']) ?></li>
                <li class="heading list-group-item  waves-effect"><?= $this->Html->link(__('New Role'), ['controller' => 'Roles', 'action' => 'add']) ?></li>
                    </ul>
        </nav>
    </div>
    <div class="col-sm-9">
        
        <div class="relationMembers form large-9 medium-8 columns content">
            <?= $this->Form->create($relationMember) ?>
            <fieldset>
                <legend><?= __('Edit Relation Member') ?></legend>
                <?php
                            echo $this->Form->control('user_id', ['options' => $users]);
                    echo $this->Form->control('role_id', ['options' => $roles]);
                    echo $this->Form->control('model');
                    echo $this->Form->control('foreign_key');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>

    </div>
</div>
