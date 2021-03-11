<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\File[]|\Cake\Collection\CollectionInterface $files
 */
?>
<div class="row">
    <div class="col-sm-3">
        <nav class="large-3 medium-4 columns" id="actions-sidebar">
            <ul class="list-group">
                <li class="heading list-group-item active waves-effect"><?= __('Actions') ?></li>
                <li class="list-group-item  waves-effect"><?= $this->Html->link(__('New File'), ['action' => 'add']) ?></li>
                                                <li class="list-group-item  waves-effect"><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
                <li class="list-group-item  waves-effect"><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
                                                <li class="list-group-item  waves-effect"><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?></li>
                <li class="list-group-item  waves-effect"><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?></li>
                                            </ul>
        </nav>
    </div>
    <div class="col-sm-9">
        <div class="files index large-9 medium-8 columns content">
            <h3><?= __('Files') ?></h3>
            <table cellpadding="0" cellspacing="0" class="table">
                <thead>
                    <tr>
                                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('path') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('item_id') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('status') ?></th>
                                <th scope="col" class="actions"><?= __('Actions') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($files as $file): ?>
                    <tr>
                                                                                        <td><?= $this->Number->format($file->id) ?></td>
                                                                                                        <td><?= h($file->name) ?></td>
                                                                                                        <td><?= h($file->path) ?></td>
                                                                                <td><?= $file->has('user') ? $this->Html->link($file->user->id, ['controller' => 'Users', 'action' => 'view', $file->user->id]) : '' ?></td>
                                                                                        <td><?= $file->has('item') ? $this->Html->link($file->item->name, ['controller' => 'Items', 'action' => 'view', $file->item->id]) : '' ?></td>
                                                                                                                <td><?= h($file->created) ?></td>
                                                                                                        <td><?= h($file->modified) ?></td>
                                                                                                        <td><?= h($file->status) ?></td>
                                                        <td class="actions">
                            <?= $this->Html->link(__('View'), ['action' => 'view', $file->id]) ?>
                            <?= $this->Html->link(__('Edit'), ['action' => 'edit', $file->id]) ?>
                            <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $file->id], ['confirm' => __('Are you sure you want to delete # {0}?', $file->id)]) ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
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
        </div>
    </div>
</div>


