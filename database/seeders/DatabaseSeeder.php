<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        // \App\Models\User::factory(10)->create();
        $this->call(RoleTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(CategoryTableSeeder::class);
        $this->call(LocationTableSeeder::class);
        $this->call(FurnishingTableSeeder::class);
        $this->call(ConditionTableSeeder::class);
        $this->call(PropertyTypeTableSeeder::class);
        $this->call(BlogCategoryTableSeeder::class);
        $this->call(ServiceTableSeeder::class);
        $this->call(AboutTableSeeder::class);
        $this->call(ContactTableSeeder::class);
        $this->call(SocialLinkTableSeeder::class);
        $this->call(LandlordTableSeeder::class);

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
