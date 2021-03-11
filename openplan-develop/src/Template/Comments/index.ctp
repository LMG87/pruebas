<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Comment[]|\Cake\Collection\CollectionInterface $comments
 */
?>
<div class="row">
    <div class="col-sm-3">
        <nav class="large-3 medium-4 columns" id="actions-sidebar">
            <ul class="list-group">
                <li class="heading list-group-item active waves-effect"><?= __('Actions') ?></li>
                <li class="list-group-item  waves-effect"><?= $this->Html->link(__('New Comment'), ['action' => 'add']) ?></li>
                                                <li class="list-group-item  waves-effect"><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
                <li class="list-group-item  waves-effect"><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
                                                <li class="list-group-item  waves-effect"><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?></li>
                <li class="list-group-item  waves-effect"><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?></li>
                                            </ul>
        </nav>
    </div>
    <div class="col-sm-9">
        <div class="comments index large-9 medium-8 columns content">
            <h3><?= __('Comments') ?></h3>
            <table cellpadding="0" cellspacing="0" class="table">
                <thead>
                    <tr>
                                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('parent_id') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('lft') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('rght') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('item_id') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                                <th scope="col" class="actions"><?= __('Actions') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($comments as $comment): ?>
                    <tr>
                                                                                        <td><?= $this->Number->format($comment->id) ?></td>
                                                                                        <td><?= $comment->has('parent_comment') ? $this->Html->link($comment->parent_comment->id, ['controller' => 'Comments', 'action' => 'view', $comment->parent_comment->id]) : '' ?></td>
                                                                                                        <td><?= $this->Number->format($comment->lft) ?></td>
                                                                                                        <td><?= $this->Number->format($comment->rght) ?></td>
                                                                                <td><?= $comment->has('user') ? $this->Html->link($comment->user->id, ['controller' => 'Users', 'action' => 'view', $comment->user->id]) : '' ?></td>
                                                                                        <td><?= $comment->has('item') ? $this->Html->link($comment->item->name, ['controller' => 'Items', 'action' => 'view', $comment->item->id]) : '' ?></td>
                                                                                                                <td><?= h($comment->created) ?></td>
                                                                                                        <td><?= h($comment->modified) ?></td>
                                                        <td class="actions">
                            <?= $this->Html->link(__('View'), ['action' => 'view', $comment->id]) ?>
                            <?= $this->Html->link(__('Edit'), ['action' => 'edit', $comment->id]) ?>
                            <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $comment->id], ['confirm' => __('Are you sure you want to delete # {0}?', $comment->id)]) ?>
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


