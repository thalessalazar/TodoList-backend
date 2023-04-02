<?php

namespace Database\Seeders;

use App\Models\Todo;
use App\Models\TodoTask;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \App\Models\User;

class TodoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::all()->each(function (User $user) {
            $user->todos()->saveMany(
                Todo::factory(10)->make()
            )->each(
                    function (Todo $todo) {
                        $todo->tasks()->saveMany(
                            TodoTask::factory(10)->make()
                        );
                    }
                );
        });
    }
}
