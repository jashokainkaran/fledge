<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Clear out old admins to prevent duplicates
        Admin::truncate();

        // Read and decode Admin.json from storage/app
        $json   = File::get(storage_path('app/Admin.json'));
        $admins = json_decode($json, true);

        foreach ($admins as $adminData) {
            Admin::create([
                'name'     => $adminData['name'],
                'email'    => $adminData['email'],
                'password' => Hash::make($adminData['password']),
            ]);
        }
    }
}
