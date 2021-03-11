<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TypeItem $typeItem
 */
?>
<div class="row">
    <div class="col-sm-3">
        <nav class="large-3 medium-4 columns" id="actions-sidebar">
            <ul class="list-group">
                <li class="heading list-group-item active waves-effect"><?= __('Actions') ?></li>
                <li class="heading list-group-item waves-effect"><?= $this->Html->link(__('Edit Type Item'), ['action' => 'edit', $typeItem->id]) ?> </li>
                <li class="heading list-group-item waves-effect"><?= $this->Form->postLink(__('Delete Type Item'), ['action' => 'delete', $typeItem->id], ['confirm' => __('Are you sure you want to delete # {0}?', $typeItem->id)]) ?> </li>
                <li class="heading list-group-item waves-effect"><?= $this->Html->link(__('List Type Items'), ['action' => 'index']) ?> </li>
                <li class="heading list-group-item waves-effect"><?= $this->Html->link(__('New Type Item'), ['action' => 'add']) ?> </li>
                                                                                <li class="heading list-group-item waves-effect"><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?> </li>
                <li class="heading list-group-item waves-effect"><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?> </li>
                                                            </ul>
        </nav>
    </div>
    <div class="col-sm-9">
        <div class="typeItems view large-9 medium-8 columns content">
            <h3><?= h($typeItem->name) ?></h3>
            <table class="vertical-table table">
                                        <tr>
                    <th scope="row"><?= __('Name') ?></th>
                    <td><?= h($typeItem->name) ?></td>
                </tr>
                                                                <tr>
                    <th scope="row"><?= __('Id') ?></th>
                    <td><?= $this->Number->format($typeItem->id) ?></td>
                </tr>
                                                <tr>
                    <th scope="row"><?= __('Created') ?></th>
                    <td><?= h($typeItem->created) ?></td>
                </tr>
                        <tr>
                    <th scope="row"><?= __('Modified') ?></th>
                    <td><?= h($typeItem->modified) ?></td>
                </tr>
                                    </table>
                            <div class="">
                <h4><?= __('Description') ?></h4>
                <?= $this->Text->autoParagraph(h($typeItem->description)); ?>
            </div>
                                                            <div class="related">
                <h4><?= __('Related Items') ?></h4>
                <?php if (!empty($typeItem->items)): ?>
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
                    <?php foreach ($typeItem->items as $items): ?>
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
                </div>
    </div>
</div>


