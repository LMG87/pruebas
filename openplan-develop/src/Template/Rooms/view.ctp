<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Room $room
 */
?>
<div class="row">
    <div class="col-sm-3">
        <nav class="large-3 medium-4 columns" id="actions-sidebar">
            <ul class="list-group">
                <li class="heading list-group-item active waves-effect"><?= __('Actions') ?></li>
                <li class="heading list-group-item waves-effect"><?= $this->Html->link(__('Edit Room'), ['action' => 'edit', $room->id]) ?> </li>
                <li class="heading list-group-item waves-effect"><?= $this->Form->postLink(__('Delete Room'), ['action' => 'delete', $room->id], ['confirm' => __('Are you sure you want to delete # {0}?', $room->id)]) ?> </li>
                <li class="heading list-group-item waves-effect"><?= $this->Html->link(__('List Rooms'), ['action' => 'index']) ?> </li>
                <li class="heading list-group-item waves-effect"><?= $this->Html->link(__('New Room'), ['action' => 'add']) ?> </li>
                                                <li class="heading list-group-item waves-effect"><?= $this->Html->link(__('List Parent Rooms'), ['controller' => 'Rooms', 'action' => 'index']) ?> </li>
                <li class="heading list-group-item waves-effect"><?= $this->Html->link(__('New Parent Room'), ['controller' => 'Rooms', 'action' => 'add']) ?> </li>
                                                <li class="heading list-group-item waves-effect"><?= $this->Html->link(__('List Companies'), ['controller' => 'Companies', 'action' => 'index']) ?> </li>
                <li class="heading list-group-item waves-effect"><?= $this->Html->link(__('New Company'), ['controller' => 'Companies', 'action' => 'add']) ?> </li>
                                                                                <li class="heading list-group-item waves-effect"><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?> </li>
                <li class="heading list-group-item waves-effect"><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?> </li>
                                                <li class="heading list-group-item waves-effect"><?= $this->Html->link(__('List Child Rooms'), ['controller' => 'Rooms', 'action' => 'index']) ?> </li>
                <li class="heading list-group-item waves-effect"><?= $this->Html->link(__('New Child Room'), ['controller' => 'Rooms', 'action' => 'add']) ?> </li>
                                                            </ul>
        </nav>
    </div>
    <div class="col-sm-9">
        <div class="rooms view large-9 medium-8 columns content">
            <h3><?= h($room->name) ?></h3>
            <table class="vertical-table table">
                                                <tr>
                    <th scope="row"><?= __('Parent Room') ?></th>
                    <td><?= $room->has('parent_room') ? $this->Html->link($room->parent_room->name, ['controller' => 'Rooms', 'action' => 'view', $room->parent_room->id]) : '' ?></td>
                </tr>
                                        <tr>
                    <th scope="row"><?= __('Name') ?></th>
                    <td><?= h($room->name) ?></td>
                </tr>
                                                <tr>
                    <th scope="row"><?= __('Company') ?></th>
                    <td><?= $room->has('company') ? $this->Html->link($room->company->name, ['controller' => 'Companies', 'action' => 'view', $room->company->id]) : '' ?></td>
                </tr>
                                                                <tr>
                    <th scope="row"><?= __('Id') ?></th>
                    <td><?= $this->Number->format($room->id) ?></td>
                </tr>
                        <tr>
                    <th scope="row"><?= __('Lft') ?></th>
                    <td><?= $this->Number->format($room->lft) ?></td>
                </tr>
                        <tr>
                    <th scope="row"><?= __('Rght') ?></th>
                    <td><?= $this->Number->format($room->rght) ?></td>
                </tr>
                                                <tr>
                    <th scope="row"><?= __('Created') ?></th>
                    <td><?= h($room->created) ?></td>
                </tr>
                        <tr>
                    <th scope="row"><?= __('Modified') ?></th>
                    <td><?= h($room->modified) ?></td>
                </tr>
                                    </table>
                                                    <div class="related">
                <h4><?= __('Related Items') ?></h4>
                <?php if (!empty($room->items)): ?>
                <table cellpadding="0" cellspacing="0" class="table">
                    <tr>
                                <th scope="col"><?= __('Id') ?></th>
                                <th scope="col"><?= __('Name') ?></th>
                                <th scope="col"><?= __('Description') ?></th>
                                <th scope="col"><?= __('User Id') ?></th>
                                <th scope="col"><?= __('Room Id') ?></th>
                                <th scope="col"><?= __('Type Item Id') ?></th>
                                <th scope="col"><?= __('Company Id') ?></th>
                                <th scope="col"><?= __('Created') ?></th>
                                <th scope="col"><?= __('Modified') ?></th>
                                <th scope="col" class="actions"><?= __('Actions') ?></th>
                    </tr>
                    <?php foreach ($room->items as $items): ?>
                    <tr>
                                <td><?= h($items->id) ?></td>
                                <td><?= h($items->name) ?></td>
                                <td><?= h($items->description) ?></td>
                                <td><?= h($items->user_id) ?></td>
                                <td><?= h($items->room_id) ?></td>
                                <td><?= h($items->type_item_id) ?></td>
                                <td><?= h($items->company_id) ?></td>
                                <td><?= h($items->created) ?></td>
                                <td><?= h($items->modified) ?></td>
                                        <td class="actions">
                            <?= $this->Html->link(__('View'), ['controller' => 'Items', 'action' => 'view', $items->id]) ?>
                            <?= $this->Html->link(__('Edit'), ['controller' => 'Items', 'action' => 'edit', $items->id]) ?>
                            <?= $this->Form->postLink(__('Delete'), ['controller' => 'Items', 'action' => 'delete', $items->id], ['confirm' => __('Are you sure you want to delete # {0}?', $items->id)]) ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
                <?php endif; ?>
            </div>
                                    <div class="related">
                <h4><?= __('Related Rooms') ?></h4>
                <?php if (!empty($room->child_rooms)): ?>
                <table cellpadding="0" cellspacing="0" class="table">
                    <tr>
                                <th scope="col"><?= __('Id') ?></th>
                                <th scope="col"><?= __('Parent Id') ?></th>
                                <th scope="col"><?= __('Lft') ?></th>
                                <th scope="col"><?= __('Rght') ?></th>
                                <th scope="col"><?= __('Name') ?></th>
                                <th scope="col"><?= __('Company Id') ?></th>
                                <th scope="col"><?= __('Created') ?></th>
                                <th scope="col"><?= __('Modified') ?></th>
                                <th scope="col" class="actions"><?= __('Actions') ?></th>
                    </tr>
                    <?php foreach ($room->child_rooms as $childRooms): ?>
                    <tr>
                                <td><?= h($childRooms->id) ?></td>
                                <td><?= h($childRooms->parent_id) ?></td>
                                <td><?= h($childRooms->lft) ?></td>
                                <td><?= h($childRooms->rght) ?></td>
                                <td><?= h($childRooms->name) ?></td>
                                <td><?= h($childRooms->company_id) ?></td>
                                <td><?= h($childRooms->created) ?></td>
                                <td><?= h($childRooms->modified) ?></td>
                                        <td class="actions">
                            <?= $this->Html->link(__('View'), ['controller' => 'Rooms', 'action' => 'view', $childRooms->id]) ?>
                            <?= $this->Html->link(__('Edit'), ['controller' => 'Rooms', 'action' => 'edit', $childRooms->id]) ?>
                            <?= $this->Form->postLink(__('Delete'), ['controller' => 'Rooms', 'action' => 'delete', $childRooms->id], ['confirm' => __('Are you sure you want to delete # {0}?', $childRooms->id)]) ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
                <?php endif; ?>
            </div>
                </div>
    </div>
</div>


