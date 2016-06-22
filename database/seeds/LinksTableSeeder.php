<?php

use Illuminate\Database\Seeder;

class LinksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'link_name' => str_random(5),
                'link_title' => str_random(10).'@gmail.com',
                'link_order' => 1,
                'link_url' => 'http://www.baidu.com',
            ] ,
            [
                'link_name' => str_random(5),
                'link_title' => str_random(10).'@gmail.com',
                'link_order' => 2,
                'link_url' => 'git.oschina.net',
            ],
            [
                'link_name' => str_random(5),
                'link_title' => str_random(10).'@gmail.com',
                'link_order' => 3,
                'link_url' => 'http://s.tool.chinaz.com/baidu/words.aspx',
            ]
        ];
        DB::table('links')->insert($data);
    }
}
