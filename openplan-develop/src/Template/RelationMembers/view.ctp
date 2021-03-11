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
                <li class="heading list-group-item waves-effect"><?= $this->Html->link(__('Edit Relation Member'), ['action' => 'edit', $relationMember->id]) ?> </li>
                <li class="heading list-group-item waves-effect"><?= $this->Form->postLink(__('Delete Relation Member'), ['action' => 'delete', $relationMember->id], ['confirm' => __('Are you sure you want to delete # {0}?', $relationMember->id)]) ?> </li>
                <li class="heading list-group-item waves-effect"><?= $this->Html->link(__('List Relation Members'), ['action' => 'index']) ?> </li>
                <li class="heading list-group-item waves-effect"><?= $this->Html->link(__('New Relation Member'), ['action' => 'add']) ?> </li>
                                                <li class="heading list-group-item waves-effect"><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
                <li class="heading list-group-item waves-effect"><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
                                                <li class="heading list-group-item waves-effect"><?= $this->Html->link(__('List Roles'), ['controller' => 'Roles', 'action' => 'index']) ?> </li>
                <li class="heading list-group-item waves-effect"><?= $this->Html->link(__('New Role'), ['controller' => 'Roles', 'action' => 'add']) ?> </li>
                                                                                            </ul>
        </nav>
    </div>
    <div class="col-sm-9">
        <div class="relationMembers view large-9 medium-8 columns content">
            <h3><?= h($relationMember->id) ?></h3>
            <table class="vertical-table table">
                                                <tr>
                    <th scope="row"><?= __('User') ?></th>
                    <td><?= $relationMember->has('user') ? $this->Html->link($relationMember->user->id, ['controller' => 'Users', 'action' => 'view', $relationMember->user->id]) : '' ?></td>
                </tr>
                                                <tr>
                    <th scope="row"><?= __('Role') ?></th>
                    <td><?= $relationMember->has('role') ? $this->Html->link($relationMember->role->name, ['controller' => 'Roles', 'action' => 'view', $relationMember->role->id]) : '' ?></td>
                </tr>
                                        <tr>
                    <th scope="row"><?= __('Model') ?></th>
                    <td><?= h($relationMember->model) ?></td>
                </tr>
                                                                <tr>
                    <th scope="row"><?= __('Id') ?></th>
                    <td><?= $this->Number->format($relationMember->id) ?></td>
                </tr>
                        <tr>
                    <th scope="row"><?= __('Foreign Key') ?></th>
                    <td><?= $this->Number->format($relationMember->foreign_key) ?></td>
                </tr>
                                                <tr>
                    <th scope="row"><?= __('Created') ?></th>
                    <td><?= h($relationMember->created) ?></td>
                </tr>
                        <tr>
                    <th scope="row"><?= __('Modified') ?></th>
                    <td><?= h($relationMember->modified) ?></td>
                </tr>
                                    </table>
                                </div>
    </div>
</div>


