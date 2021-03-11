<?php
use Migrations\AbstractSeed;

/**
 * SettingOptions seed.
 */
class SettingOptionsSeed extends AbstractSeed
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
                'title' => 'Tinymce',
                'created' => '2018-08-29 14:37:15',
                'modified' => '2018-08-29 14:37:15',
            ],
            [
                'id' => '2',
                'title' => 'Ckeditor',
                'created' => '2018-08-29 14:37:15',
                'modified' => '2018-08-29 14:37:15',
            ],
        ];

        $table = $this->table('setting_options');
        $table->insert($data)->save();
    }
}
