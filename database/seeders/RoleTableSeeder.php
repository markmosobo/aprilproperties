<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'id' => '1',
            'name' => 'admin'
        ]);

        Role::create([
            'id' => '2',
            'name' => 'agent'
        ]);

        Role::create([
            'id' => '3',
            'name' => 'buyer'
        ]);
    }
}
