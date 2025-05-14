<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'test2@example.com'], // Check by email
            ['name' => 'Test User'] // Update or insert with this name
        );
        
    $this->call([
    AdminSeeder::class,
    AllowedStudentSeeder::class, // <- Add this line
]);

}
}