<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Comment $comment
 */
?>
<div class="row">
    <div class="col-sm-3">
        <nav class="large-3 medium-4 columns" id="actions-sidebar">
            <ul class="list-group">
                <li class="heading list-group-item active waves-effect"><?= __('Actions') ?></li>
                <li class="heading list-group-item waves-effect"><?= $this->Html->link(__('Edit Comment'), ['action' => 'edit', $comment->id]) ?> </li>
                <li class="heading list-group-item waves-effect"><?= $this->Form->postLink(__('Delete Comment'), ['action' => 'delete', $comment->id], ['confirm' => __('Are you sure you want to delete # {0}?', $comment->id)]) ?> </li>
                <li class="heading list-group-item waves-effect"><?= $this->Html->link(__('List Comments'), ['action' => 'index']) ?> </li>
                <li class="heading list-group-item waves-effect"><?= $this->Html->link(__('New Comment'), ['action' => 'add']) ?> </li>
                                                <li class="heading list-group-item waves-effect"><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
                <li class="heading list-group-item waves-effect"><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
                                                <li class="heading list-group-item waves-effect"><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?> </li>
                <li class="heading list-group-item waves-effect"><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?> </li>
                                                                                            </ul>
        </nav>
    </div>
    <div class="col-sm-9">
        <div class="comments view large-9 medium-8 columns content">
            <h3><?= h($comment->id) ?></h3>
            <table class="vertical-table table">

                                                <tr>
                    <th scope="row"><?= __('Parent Comment') ?></th>
                    <td><?= $comment->has('parent_comment') ? $this->Html->link($comment->parent_comment->name, ['controller' => 'Comments', 'action' => 'view', $comment->parent_comment->id]) : '' ?></td>
                </tr>

                                                <tr>
                    <th scope="row"><?= __('User') ?></th>
                    <td><?= $comment->has('user') ? $this->Html->link($comment->user->id, ['controller' => 'Users', 'action' => 'view', $comment->user->id]) : '' ?></td>
                </tr>
                                                <tr>
                    <th scope="row"><?= __('Item') ?></th>
                    <td><?= $comment->has('item') ? $this->Html->link($comment->item->name, ['controller' => 'Items', 'action' => 'view', $comment->item->id]) : '' ?></td>
                </tr>
                                                                <tr>
                    <th scope="row"><?= __('Id') ?></th>
                    <td><?= $this->Number->format($comment->id) ?></td>
                </tr>
                        <tr>
                    <th scope="row"><?= __('Parent Id') ?></th>
                    <td><?= $this->Number->format($comment->parent_id) ?></td>
                </tr>
                        <tr>
                    <th scope="row"><?= __('Lft') ?></th>
                    <td><?= $this->Number->format($comment->lft) ?></td>
                </tr>
                        <tr>
                    <th scope="row"><?= __('Rght') ?></th>
                    <td><?= $this->Number->format($comment->rght) ?></td>
                </tr>
                                                <tr>
                    <th scope="row"><?= __('Created') ?></th>
                    <td><?= h($comment->created) ?></td>
                </tr>
                        <tr>
                    <th scope="row"><?= __('Modified') ?></th>
                    <td><?= h($comment->modified) ?></td>
                </tr>
                                    </table>
                            <div class="">
                <h4><?= __('Message') ?></h4>
                <?= $this->Text->autoParagraph(h($comment->message)); ?>
            </div>
                                        </div>
    </div>
</div>


