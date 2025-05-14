<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class ImportAdminData extends Command
{
    protected $signature = 'import:admin-data {file=admin.json}';
    protected $description = 'Import admins from a JSON file in storage/app';

    public function handle()
    {
        $file = $this->argument('file');
        $path = storage_path("app/{$file}");
        if (! file_exists($path)) {
            $this->error("File not found: {$path}");
            return 1;
        }

        $data = json_decode(file_get_contents($path), true);
        foreach ($data as $item) {
            // Use updateOrCreate so you can re-run without duplicates
            Admin::updateOrCreate(
                ['email' => $item['email']],
                [
                    'name'     => $item['name'],
                    'password' => Hash::make($item['password']),
                ]
            );
            $this->info("Imported admin: {$item['email']}");
        }

        $this->info("All done!");
        return 0;
    }
}
