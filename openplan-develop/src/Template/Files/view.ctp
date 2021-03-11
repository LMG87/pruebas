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
                <li class="heading list-group-item waves-effect"><?= $this->Html->link(__('Edit File'), ['action' => 'edit', $file->id]) ?> </li>
                <li class="heading list-group-item waves-effect"><?= $this->Form->postLink(__('Delete File'), ['action' => 'delete', $file->id], ['confirm' => __('Are you sure you want to delete # {0}?', $file->id)]) ?> </li>
                <li class="heading list-group-item waves-effect"><?= $this->Html->link(__('List Files'), ['action' => 'index']) ?> </li>
                <li class="heading list-group-item waves-effect"><?= $this->Html->link(__('New File'), ['action' => 'add']) ?> </li>
                                                <li class="heading list-group-item waves-effect"><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
                <li class="heading list-group-item waves-effect"><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
                                                <li class="heading list-group-item waves-effect"><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?> </li>
                <li class="heading list-group-item waves-effect"><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?> </li>
                                                                                            </ul>
        </nav>
    </div>
    <div class="col-sm-9">
        <div class="files view large-9 medium-8 columns content">
            <h3><?= h($file->name) ?></h3>
            <table class="vertical-table table">
                                        <tr>
                    <th scope="row"><?= __('Name') ?></th>
                    <td><?= h($file->name) ?></td>
                </tr>
                                        <tr>
                    <th scope="row"><?= __('Path') ?></th>
                    <td><?= h($file->path) ?></td>
                </tr>
                                                <tr>
                    <th scope="row"><?= __('User') ?></th>
                    <td><?= $file->has('user') ? $this->Html->link($file->user->id, ['controller' => 'Users', 'action' => 'view', $file->user->id]) : '' ?></td>
                </tr>
                                                <tr>
                    <th scope="row"><?= __('Item') ?></th>
                    <td><?= $file->has('item') ? $this->Html->link($file->item->name, ['controller' => 'Items', 'action' => 'view', $file->item->id]) : '' ?></td>
                </tr>
                                                                <tr>
                    <th scope="row"><?= __('Id') ?></th>
                    <td><?= $this->Number->format($file->id) ?></td>
                </tr>
                                                <tr>
                    <th scope="row"><?= __('Created') ?></th>
                    <td><?= h($file->created) ?></td>
                </tr>
                        <tr>
                    <th scope="row"><?= __('Modified') ?></th>
                    <td><?= h($file->modified) ?></td>
                </tr>
                                                <tr>
                    <th scope="row"><?= __('Status') ?></th>
                    <td><?= $file->status ? __('Yes') : __('No'); ?></td>
                </tr>
                            </table>
                                </div>
    </div>
</div>


