<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Collaborator $collaborator
 */
?>
<div class="row">
    <div class="col-sm-3">
        <nav class="large-3 medium-4 columns" id="actions-sidebar">
            <ul class="list-group">
                <li class="heading list-group-item active waves-effect"><?= __('Actions') ?></li>
                <li class="heading list-group-item waves-effect"><?= $this->Html->link(__('Edit Collaborator'), ['action' => 'edit', $collaborator->id]) ?> </li>
                <li class="heading list-group-item waves-effect"><?= $this->Form->postLink(__('Delete Collaborator'), ['action' => 'delete', $collaborator->id], ['confirm' => __('Are you sure you want to delete # {0}?', $collaborator->id)]) ?> </li>
                <li class="heading list-group-item waves-effect"><?= $this->Html->link(__('List Collaborators'), ['action' => 'index']) ?> </li>
                <li class="heading list-group-item waves-effect"><?= $this->Html->link(__('New Collaborator'), ['action' => 'add']) ?> </li>
                                                <li class="heading list-group-item waves-effect"><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
                <li class="heading list-group-item waves-effect"><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
                                                <li class="heading list-group-item waves-effect"><?= $this->Html->link(__('List Roles'), ['controller' => 'Roles', 'action' => 'index']) ?> </li>
                <li class="heading list-group-item waves-effect"><?= $this->Html->link(__('New Role'), ['controller' => 'Roles', 'action' => 'add']) ?> </li>
                                                                                            </ul>
        </nav>
    </div>
    <div class="col-sm-9">
        <div class="collaborators view large-9 medium-8 columns content">
            <h3><?= h($collaborator->id) ?></h3>
            <table class="vertical-table table">
                                                <tr>
                    <th scope="row"><?= __('User') ?></th>
                    <td><?= $collaborator->has('user') ? $this->Html->link($collaborator->user->id, ['controller' => 'Users', 'action' => 'view', $collaborator->user->id]) : '' ?></td>
                </tr>
                                        <tr>
                    <th scope="row"><?= __('User Email') ?></th>
                    <td><?= h($collaborator->user_email) ?></td>
                </tr>
                                        <tr>
                    <th scope="row"><?= __('Model') ?></th>
                    <td><?= h($collaborator->model) ?></td>
                </tr>
                                                <tr>
                    <th scope="row"><?= __('Role') ?></th>
                    <td><?= $collaborator->has('role') ? $this->Html->link($collaborator->role->name, ['controller' => 'Roles', 'action' => 'view', $collaborator->role->id]) : '' ?></td>
                </tr>
                                                                <tr>
                    <th scope="row"><?= __('Id') ?></th>
                    <td><?= $this->Number->format($collaborator->id) ?></td>
                </tr>
                        <tr>
                    <th scope="row"><?= __('Foreign Key') ?></th>
                    <td><?= $this->Number->format($collaborator->foreign_key) ?></td>
                </tr>
                                                <tr>
                    <th scope="row"><?= __('Created') ?></th>
                    <td><?= h($collaborator->created) ?></td>
                </tr>
                        <tr>
                    <th scope="row"><?= __('Modified') ?></th>
                    <td><?= h($collaborator->modified) ?></td>
                </tr>
                                    </table>
                            <div class="">
                <h4><?= __('Menssage') ?></h4>
                <?= $this->Text->autoParagraph(h($collaborator->menssage)); ?>
            </div>
                                        </div>
    </div>
</div>


