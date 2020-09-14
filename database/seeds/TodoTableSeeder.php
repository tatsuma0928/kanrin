<?php

use Illuminate\Database\Seeder;

class TodoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('todo')->insert([
            [
                'user_id' => '1',
                'content' => '楽しむ'

            ],
        ]);
        //
    }
}
