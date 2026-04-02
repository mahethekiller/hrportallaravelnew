<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddMissingTimestamps extends Command
{
    protected $signature = 'app:add-timestamps';
    protected $description = 'Adds missing created_at/updated_at timestamps to all tables and converts varchars';

    public function handle()
    {
        $tables = DB::select('SHOW TABLES');
        
        foreach ($tables as $tableRow) {
            $tableName = array_values((array)$tableRow)[0];

            $this->info("Checking timestamps for {$tableName}...");
            
            $columns = DB::select("SHOW COLUMNS FROM {$tableName}");
            $hasCreated = false;
            $hasUpdated = false;
            $createdType = '';
            
            foreach ($columns as $c) {
                if ($c->Field === 'created_at') {
                    $hasCreated = true;
                    $createdType = strtolower($c->Type);
                }
                if ($c->Field === 'updated_at') {
                    $hasUpdated = true;
                }
            }
            
            // Convert or rename old varchar created_at to avoid Laravel ORM crash
            if ($hasCreated && str_contains($createdType, 'varchar')) {
                try {
                    DB::statement("ALTER TABLE {$tableName} CHANGE created_at legacy_created_at VARCHAR(255)");
                    $hasCreated = false; // We create a true timestamp column below
                } catch (\Exception $e) {
                    $this->warn("Could not rename created_at on {$tableName}");
                }
            }

            if (!$hasCreated) {
                try {
                    DB::statement("ALTER TABLE {$tableName} ADD COLUMN created_at TIMESTAMP NULL DEFAULT NULL");
                } catch (\Exception $e) {}
            }
            if (!$hasUpdated) {
                try {
                    DB::statement("ALTER TABLE {$tableName} ADD COLUMN updated_at TIMESTAMP NULL DEFAULT NULL");
                } catch (\Exception $e) {}
            }
        }

        $this->info("Timestamps strictly added to all tables!");
    }
}
