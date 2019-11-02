<?php

use Illuminate\Database\Seeder;
use App\Models as Model;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Model\UsersInfo::class, 1000)->create();
    }
}
