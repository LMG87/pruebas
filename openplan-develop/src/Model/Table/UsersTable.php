<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @property \App\Model\Table\UserGroupsTable|\Cake\ORM\Association\BelongsTo $UserGroups
 * @property \App\Model\Table\ActionsItemsTable|\Cake\ORM\Association\HasMany $ActionsItems
 * @property \App\Model\Table\CollaboratorsTable|\Cake\ORM\Association\HasMany $Collaborators
 * @property \App\Model\Table\ItemsTable|\Cake\ORM\Association\HasMany $Items
 * @property \App\Model\Table\LoginTokensTable|\Cake\ORM\Association\HasMany $LoginTokens
 * @property \App\Model\Table\RelationMembersTable|\Cake\ORM\Association\HasMany $RelationMembers
 * @property \App\Model\Table\ScheduledEmailRecipientsTable|\Cake\ORM\Association\HasMany $ScheduledEmailRecipients
 * @property \App\Model\Table\UserActivitiesTable|\Cake\ORM\Association\HasMany $UserActivities
 * @property \App\Model\Table\UserContactsTable|\Cake\ORM\Association\HasMany $UserContacts
 * @property \App\Model\Table\UserDetailsTable|\Cake\ORM\Association\HasMany $UserDetails
 * @property \App\Model\Table\UserEmailRecipientsTable|\Cake\ORM\Association\HasMany $UserEmailRecipients
 * @property \App\Model\Table\UserEmailSignaturesTable|\Cake\ORM\Association\HasMany $UserEmailSignatures
 * @property \App\Model\Table\UserEmailTemplatesTable|\Cake\ORM\Association\HasMany $UserEmailTemplates
 * @property \App\Model\Table\UserSocialsTable|\Cake\ORM\Association\HasMany $UserSocials
 *
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UsersTable extends Table
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

        $this->setTable('users');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('UserGroups', [
            'foreignKey' => 'user_group_id'
        ]);
        $this->hasMany('ActionsItems', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('Collaborators', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('Items', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('LoginTokens', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('RelationMembers', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('ScheduledEmailRecipients', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('UserActivities', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('UserContacts', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('UserDetails', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('UserEmailRecipients', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('UserEmailSignatures', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('UserEmailTemplates', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('UserSocials', [
            'foreignKey' => 'user_id'
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
            ->scalar('username')
            ->maxLength('username', 100)
            ->allowEmpty('username');

        $validator
            ->scalar('password')
            ->maxLength('password', 255)
            ->allowEmpty('password');

        $validator
            ->email('email')
            ->allowEmpty('email');

        $validator
            ->scalar('first_name')
            ->maxLength('first_name', 100)
            ->allowEmpty('first_name');

        $validator
            ->scalar('last_name')
            ->maxLength('last_name', 100)
            ->allowEmpty('last_name');

        $validator
            ->scalar('gender')
            ->maxLength('gender', 20)
            ->allowEmpty('gender');

        $validator
            ->scalar('photo')
            ->maxLength('photo', 50)
            ->allowEmpty('photo');

        $validator
            ->date('bday')
            ->allowEmpty('bday');

        $validator
            ->integer('active')
            ->allowEmpty('active');

        $validator
            ->integer('email_verified')
            ->requirePresence('email_verified', 'create')
            ->notEmpty('email_verified');

        $validator
            ->dateTime('last_login')
            ->allowEmpty('last_login');

        $validator
            ->scalar('ip_address')
            ->maxLength('ip_address', 50)
            ->allowEmpty('ip_address');

        $validator
            ->integer('created_by')
            ->allowEmpty('created_by');

        $validator
            ->integer('modified_by')
            ->allowEmpty('modified_by');

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
        $rules->add($rules->isUnique(['username']));
        $rules->add($rules->isUnique(['email']));
        $rules->add($rules->existsIn(['user_group_id'], 'UserGroups'));

        return $rules;
    }

    /*public function findOwnedBy(Query $query, array $options)
    {
        $user = $options['user'];
        return $query->where(['user_email' => $user->user_email]);
    }*/
}
