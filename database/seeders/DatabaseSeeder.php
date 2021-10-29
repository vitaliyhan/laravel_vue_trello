<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         \App\Models\User::factory(10)->create();
         \App\Models\Desk::factory(2)->create();
         \App\Models\DeskList::factory(2)->create();
         \App\Models\Card::factory(2)->create();
         \App\Models\Task::factory(2)->create();
    }
}
