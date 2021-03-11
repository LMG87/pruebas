<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Item $item
 */
?>
<div class="row">
    <div class="col-sm-3">
        <nav class="large-3 medium-4 columns" id="actions-sidebar">
            <ul class="list-group">
                <li class="heading list-group-item active waves-effect"><?= __('Actions') ?></li>
                <li class="heading list-group-item waves-effect"><?= $this->Html->link(__('Edit Item'), ['action' => 'edit', $item->id]) ?> </li>
                <li class="heading list-group-item waves-effect"><?= $this->Form->postLink(__('Delete Item'), ['action' => 'delete', $item->id], ['confirm' => __('Are you sure you want to delete # {0}?', $item->id)]) ?> </li>
                <li class="heading list-group-item waves-effect"><?= $this->Html->link(__('List Items'), ['action' => 'index']) ?> </li>
                <li class="heading list-group-item waves-effect"><?= $this->Html->link(__('New Item'), ['action' => 'add']) ?> </li>
                                                <li class="heading list-group-item waves-effect"><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
                <li class="heading list-group-item waves-effect"><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
                                                <li class="heading list-group-item waves-effect"><?= $this->Html->link(__('List Rooms'), ['controller' => 'Rooms', 'action' => 'index']) ?> </li>
                <li class="heading list-group-item waves-effect"><?= $this->Html->link(__('New Room'), ['controller' => 'Rooms', 'action' => 'add']) ?> </li>
                                                <li class="heading list-group-item waves-effect"><?= $this->Html->link(__('List Type Items'), ['controller' => 'TypeItems', 'action' => 'index']) ?> </li>
                <li class="heading list-group-item waves-effect"><?= $this->Html->link(__('New Type Item'), ['controller' => 'TypeItems', 'action' => 'add']) ?> </li>
                                                <li class="heading list-group-item waves-effect"><?= $this->Html->link(__('List Companies'), ['controller' => 'Companies', 'action' => 'index']) ?> </li>
                <li class="heading list-group-item waves-effect"><?= $this->Html->link(__('New Company'), ['controller' => 'Companies', 'action' => 'add']) ?> </li>
                                                                                                <li class="heading list-group-item waves-effect"><?= $this->Html->link(__('List Actions'), ['controller' => 'Actions', 'action' => 'index']) ?> </li>
                <li class="heading list-group-item waves-effect"><?= $this->Html->link(__('New Action'), ['controller' => 'Actions', 'action' => 'add']) ?> </li>
                                            </ul>
        </nav>
    </div>
    <div class="col-sm-9">
        <div class="items view large-9 medium-8 columns content">
            <h3><?= h($item->name) ?></h3>
            <table class="vertical-table table">
                                        <tr>
                    <th scope="row"><?= __('Name') ?></th>
                    <td><?= h($item->name) ?></td>
                </tr>
                                                <tr>
                    <th scope="row"><?= __('User') ?></th>
                    <td><?= $item->has('user') ? $this->Html->link($item->user->id, ['controller' => 'Users', 'action' => 'view', $item->user->id]) : '' ?></td>
                </tr>
                                                <tr>
                    <th scope="row"><?= __('Room') ?></th>
                    <td><?= $item->has('room') ? $this->Html->link($item->room->name, ['controller' => 'Rooms', 'action' => 'view', $item->room->id]) : '' ?></td>
                </tr>
                                                <tr>
                    <th scope="row"><?= __('Type Item') ?></th>
                    <td><?= $item->has('type_item') ? $this->Html->link($item->type_item->name, ['controller' => 'TypeItems', 'action' => 'view', $item->type_item->id]) : '' ?></td>
                </tr>
                                                <tr>
                    <th scope="row"><?= __('Company') ?></th>
                    <td><?= $item->has('company') ? $this->Html->link($item->company->name, ['controller' => 'Companies', 'action' => 'view', $item->company->id]) : '' ?></td>
                </tr>
                                                                <tr>
                    <th scope="row"><?= __('Id') ?></th>
                    <td><?= $this->Number->format($item->id) ?></td>
                </tr>
                                                <tr>
                    <th scope="row"><?= __('Created') ?></th>
                    <td><?= h($item->created) ?></td>
                </tr>
                        <tr>
                    <th scope="row"><?= __('Modified') ?></th>
                    <td><?= h($item->modified) ?></td>
                </tr>
                                    </table>
                            <div class="">
                <h4><?= __('Description') ?></h4>
                <?= $this->Text->autoParagraph(h($item->description)); ?>
            </div>
                                                            <div class="related">
                <h4><?= __('Related Actions') ?></h4>
                <?php if (!empty($item->actions)): ?>
                <table cellpadding="0" cellspacing="0" class="table">
                    <tr>
                                <th scope="col"><?= __('Id') ?></th>
                                <th scope="col"><?= __('Name') ?></th>
                                <th scope="col"><?= __('Description') ?></th>
                                <th scope="col"><?= __('Created') ?></th>
                                <th scope="col"><?= __('Modified') ?></th>
                                <th scope="col" class="actions"><?= __('Actions') ?></th>
                    </tr>
                    <?php foreach ($item->actions as $actions): ?>
                    <tr>
                                <td><?= h($actions->id) ?></td>
                                <td><?= h($actions->name) ?></td>
                                <td><?= h($actions->description) ?></td>
                                <td><?= h($actions->created) ?></td>
                                <td><?= h($actions->modified) ?></td>
                                        <td class="actions">
                            <?= $this->Html->link(__('View'), ['controller' => 'Actions', 'action' => 'view', $actions->id]) ?>
                            <?= $this->Html->link(__('Edit'), ['controller' => 'Actions', 'action' => 'edit', $actions->id]) ?>
                            <?= $this->Form->postLink(__('Delete'), ['controller' => 'Actions', 'action' => 'delete', $actions->id], ['confirm' => __('Are you sure you want to delete # {0}?', $actions->id)]) ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
                <?php endif; ?>
            </div>
                </div>
    </div>
</div>


