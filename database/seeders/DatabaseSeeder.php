<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\ActionSeeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(CategoriesDefaultSeeder::class);
        $this->call(SkillsDefaultSeeder::class);
        $this->call(UsersDefaultSeeder::class);
        $this->call(ActionSeeder::class);
    }
}
