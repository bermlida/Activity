<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert(['name' => '一般使用者']);

        DB::table('roles')->insert(['name' => '主辦單位']);
    }
}
