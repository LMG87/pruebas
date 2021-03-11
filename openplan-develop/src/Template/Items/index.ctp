<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Item[]|\Cake\Collection\CollectionInterface $items
 */
?>
<div class="row">
    <div class="col-sm-3">
        <nav class="large-3 medium-4 columns" id="actions-sidebar">
            <ul class="list-group">
                <li class="heading list-group-item active waves-effect"><?= __('Actions') ?></li>
                <li class="list-group-item  waves-effect"><?= $this->Html->link(__('New Item'), ['action' => 'add']) ?></li>
                                                <li class="list-group-item  waves-effect"><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
                <li class="list-group-item  waves-effect"><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
                                                <li class="list-group-item  waves-effect"><?= $this->Html->link(__('List Rooms'), ['controller' => 'Rooms', 'action' => 'index']) ?></li>
                <li class="list-group-item  waves-effect"><?= $this->Html->link(__('New Room'), ['controller' => 'Rooms', 'action' => 'add']) ?></li>
                                                <li class="list-group-item  waves-effect"><?= $this->Html->link(__('List Type Items'), ['controller' => 'TypeItems', 'action' => 'index']) ?></li>
                <li class="list-group-item  waves-effect"><?= $this->Html->link(__('New Type Item'), ['controller' => 'TypeItems', 'action' => 'add']) ?></li>
                                                <li class="list-group-item  waves-effect"><?= $this->Html->link(__('List Companies'), ['controller' => 'Companies', 'action' => 'index']) ?></li>
                <li class="list-group-item  waves-effect"><?= $this->Html->link(__('New Company'), ['controller' => 'Companies', 'action' => 'add']) ?></li>
                                                                <li class="list-group-item  waves-effect"><?= $this->Html->link(__('List Actions'), ['controller' => 'Actions', 'action' => 'index']) ?></li>
                <li class="list-group-item  waves-effect"><?= $this->Html->link(__('New Action'), ['controller' => 'Actions', 'action' => 'add']) ?></li>
                                            </ul>
        </nav>
    </div>
    <div class="col-sm-9">
        <div class="items index large-9 medium-8 columns content">
            <h3><?= __('Items') ?></h3>
            <table cellpadding="0" cellspacing="0" class="table">
                <thead>
                    <tr>
                                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('room_id') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('type_item_id') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('company_id') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                                <th scope="col" class="actions"><?= __('Actions') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item): ?>
                    <tr>
                                                                                        <td><?= $this->Number->format($item->id) ?></td>
                                                                                                        <td><?= h($item->name) ?></td>
                                                                                <td><?= $item->has('user') ? $this->Html->link($item->user->id, ['controller' => 'Users', 'action' => 'view', $item->user->id]) : '' ?></td>
                                                                                        <td><?= $item->has('room') ? $this->Html->link($item->room->name, ['controller' => 'Rooms', 'action' => 'view', $item->room->id]) : '' ?></td>
                                                                                        <td><?= $item->has('type_item') ? $this->Html->link($item->type_item->name, ['controller' => 'TypeItems', 'action' => 'view', $item->type_item->id]) : '' ?></td>
                                                                                        <td><?= $item->has('company') ? $this->Html->link($item->company->name, ['controller' => 'Companies', 'action' => 'view', $item->company->id]) : '' ?></td>
                                                                                                                <td><?= h($item->created) ?></td>
                                                                                                        <td><?= h($item->modified) ?></td>
                                                        <td class="actions">
                            <?= $this->Html->link(__('View'), ['action' => 'view', $item->id]) ?>
                            <?= $this->Html->link(__('Edit'), ['action' => 'edit', $item->id]) ?>
                            <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $item->id], ['confirm' => __('Are you sure you want to delete # {0}?', $item->id)]) ?>
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


