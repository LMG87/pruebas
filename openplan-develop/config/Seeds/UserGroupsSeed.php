<?php
use Migrations\AbstractSeed;

/**
 * UserGroups seed.
 */
class UserGroupsSeed extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeds is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'id' => '1',
                'parent_id' => '0',
                'name' => 'Admin',
                'description' => NULL,
                'registration_allowed' => '0',
                'created' => '2018-08-29 14:37:16',
                'modified' => '2018-08-29 14:37:16',
            ],
            [
                'id' => '2',
                'parent_id' => '0',
                'name' => 'User',
                'description' => '',
                'registration_allowed' => '1',
                'created' => '2018-08-29 14:37:16',
                'modified' => '2018-08-30 10:41:18',
            ],
            [
                'id' => '3',
                'parent_id' => '0',
                'name' => 'Guest',
                'description' => NULL,
                'registration_allowed' => '0',
                'created' => '2018-08-29 14:37:16',
                'modified' => '2018-08-29 14:37:16',
            ],
        ];

        $table = $this->table('user_groups');
        $table->insert($data)->save();
    }
}
