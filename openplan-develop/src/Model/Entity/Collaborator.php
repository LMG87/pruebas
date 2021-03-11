<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Collaborator Entity
 *
 * @property int $id
 * @property int $user_id
 * @property string $user_email
 * @property string $menssage
 * @property string $model
 * @property int $foreign_key
 * @property int $role_id
 * @property string $token
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Role $role
 */
class Collaborator extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'user_id' => true,
        'user_email' => true,
        'menssage' => true,
        'model' => true,
        'foreign_key' => true,
        'role_id' => true,
        'token' => true,
        'created' => true,
        'modified' => true,
        'user' => true,
        'role' => true
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'token'
    ];
}
