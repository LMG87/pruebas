<?php
use Migrations\AbstractSeed;

/**
 * Users seed.
 */
class UsersSeed extends AbstractSeed
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
                'user_group_id' => '1',
                'username' => 'admin',
                'password' => '$2y$10$.dezXbhZdar0R0YWE45R3.NshUKQn6OXXqlWdcJe1tevJSWo469ei',
                'email' => 'admin@admin.com',
                'first_name' => 'Admin',
                'last_name' => '',
                'gender' => NULL,
                'photo' => NULL,
                'bday' => NULL,
                'active' => '1',
                'email_verified' => '1',
                'last_login' => '2018-11-13 15:38:34',
                'ip_address' => NULL,
                'created' => '2018-08-29 14:37:15',
                'modified' => '2018-11-13 15:38:34',
                'created_by' => NULL,
                'modified_by' => NULL,
            ],
            [
                'id' => '2',
                'user_group_id' => '2',
                'username' => 'user1',
                'password' => '$2y$10$kDxUcrmbT0bY0xyd22ZyluF5OGXug0yLcYoZSkxOPSJbRA8iSa1Um',
                'email' => 'usuario@conecattec.com',
                'first_name' => 'usuario1',
                'last_name' => 'usuario1',
                'gender' => NULL,
                'photo' => NULL,
                'bday' => NULL,
                'active' => '1',
                'email_verified' => '1',
                'last_login' => '2018-11-14 10:56:47',
                'ip_address' => NULL,
                'created' => '2018-08-30 10:33:24',
                'modified' => '2018-11-14 10:56:47',
                'created_by' => '1',
                'modified_by' => NULL,
            ],
            [
                'id' => '29',
                'user_group_id' => '2',
                'username' => 'jefrey',
                'password' => '$2y$10$uEPEjXGCqarf.PgOWPfglOvzY42d9NkBYpzdOUYTwJ4KSvDmVwVee',
                'email' => 'jefrey.conectatec@gmail.com',
                'first_name' => 'martinez',
                'last_name' => 'lasjkal',
                'gender' => NULL,
                'photo' => NULL,
                'bday' => NULL,
                'active' => '1',
                'email_verified' => '1',
                'last_login' => '2018-11-13 04:17:24',
                'ip_address' => '192.168.1.85',
                'created' => '2018-11-08 05:59:59',
                'modified' => '2018-11-13 04:17:24',
                'created_by' => NULL,
                'modified_by' => NULL,
            ],
        ];

        $table = $this->table('users');
        $table->insert($data)->save();
    }
}
