<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\RelationMember[]|\Cake\Collection\CollectionInterface $relationMembers
 */
?>
<div class="row">
    <div class="col-sm-3">
        <nav class="large-3 medium-4 columns" id="actions-sidebar">
            <ul class="list-group">
                <li class="heading list-group-item active waves-effect"><?= __('Actions') ?></li>
                <li class="list-group-item  waves-effect"><?= $this->Html->link(__('New Relation Member'), ['action' => 'add']) ?></li>
                                                <li class="list-group-item  waves-effect"><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
                <li class="list-group-item  waves-effect"><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
                                                <li class="list-group-item  waves-effect"><?= $this->Html->link(__('List Roles'), ['controller' => 'Roles', 'action' => 'index']) ?></li>
                <li class="list-group-item  waves-effect"><?= $this->Html->link(__('New Role'), ['controller' => 'Roles', 'action' => 'add']) ?></li>
                                            </ul>
        </nav>
    </div>
    <div class="col-sm-9">
        <div class="relationMembers index large-9 medium-8 columns content">
            <h3><?= __('Relation Members') ?></h3>
            <table cellpadding="0" cellspacing="0" class="table">
                <thead>
                    <tr>
                                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('role_id') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('model') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('foreign_key') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                                <th scope="col" class="actions"><?= __('Actions') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($relationMembers as $relationMember): ?>
                    <tr>
                                                                                        <td><?= $this->Number->format($relationMember->id) ?></td>
                                                                                <td><?= $relationMember->has('user') ? $this->Html->link($relationMember->user->id, ['controller' => 'Users', 'action' => 'view', $relationMember->user->id]) : '' ?></td>
                                                                                        <td><?= $relationMember->has('role') ? $this->Html->link($relationMember->role->name, ['controller' => 'Roles', 'action' => 'view', $relationMember->role->id]) : '' ?></td>
                                                                                                                <td><?= h($relationMember->model) ?></td>
                                                                                                        <td><?= $this->Number->format($relationMember->foreign_key) ?></td>
                                                                                                        <td><?= h($relationMember->created) ?></td>
                                                                                                        <td><?= h($relationMember->modified) ?></td>
                                                        <td class="actions">
                            <?= $this->Html->link(__('View'), ['action' => 'view', $relationMember->id]) ?>
                            <?= $this->Html->link(__('Edit'), ['action' => 'edit', $relationMember->id]) ?>
                            <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $relationMember->id], ['confirm' => __('Are you sure you want to delete # {0}?', $relationMember->id)]) ?>
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


