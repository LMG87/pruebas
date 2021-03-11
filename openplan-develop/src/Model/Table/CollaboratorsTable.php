<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Event\Event;
use Cake\ORM\Entity;
/**
 * Collaborators Model
 *
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\RolesTable|\Cake\ORM\Association\BelongsTo $Roles
 *
 * @method \App\Model\Entity\Collaborator get($primaryKey, $options = [])
 * @method \App\Model\Entity\Collaborator newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Collaborator[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Collaborator|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Collaborator|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Collaborator patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Collaborator[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Collaborator findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CollaboratorsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('collaborators');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Roles', [
            'foreignKey' => 'role_id',
            'joinType' => 'INNER'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('user_email')
            ->maxLength('user_email', 255)
            ->requirePresence('user_email', 'create')
            ->notEmpty('user_email');

        $validator
            ->scalar('menssage')
            ->requirePresence('menssage', 'create')
            ->notEmpty('menssage');

        $validator
            ->scalar('model')
            ->maxLength('model', 10)
            ->requirePresence('model', 'create')
            ->notEmpty('model');

        $validator
            ->integer('foreign_key')
            ->requirePresence('foreign_key', 'create')
            ->notEmpty('foreign_key');

        $validator
            ->scalar('token')
            ->maxLength('token', 50)
            ->requirePresence('token', 'create')
            ->notEmpty('token');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        $rules->add($rules->existsIn(['role_id'], 'Roles'));

        return $rules;
    }

    /*public function beforeSave(Event $event, Entity $entity) {
        if ($entity->isNew()) {
            print_r("crear");
            return true;
        }
        print_r("update");
        // edit code
    }*/
}
