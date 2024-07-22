<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ImportWorldSqlSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Path to the SQL file
        $path = database_path('sql/world.sql');

        // Check if the file exists
        if (!File::exists($path)) {
            $this->command->error("SQL file does not exist at path: {$path}");
            return;
        }

        // Read the file content
        $sql = File::get($path);

        // Execute the SQL statements
        DB::unprepared($sql);

        $this->command->info('Database seeded with SQL file.');
    }
}
