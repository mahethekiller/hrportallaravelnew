<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MigrateLegacyData extends Command
{
    protected $signature = 'app:migrate-legacy-data';
    protected $description = 'Clones all tables from hrsale database and optionally renames them and standardizes schemas.';

    public function handle()
    {
        \Illuminate\Support\Facades\Config::set('database.connections.legacy_mysql', [
            'driver' => 'mysql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => 'hrsale',
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => false,
            'engine' => null,
        ]);

        $this->info("Fetching tables from legacy database...");
        
        $tables = \Illuminate\Support\Facades\DB::connection('legacy_mysql')->select('SHOW TABLES');
        
        foreach ($tables as $tableRow) {
            $tableName = array_values((array)$tableRow)[0];
            if ($tableName == 'ci_sessions') continue;

            $newTableName = str_replace('xin_', '', $tableName);

            if (\Illuminate\Support\Facades\Schema::connection('mysql')->hasTable($newTableName)) {
                $this->warn("Dropping existing local table: {$newTableName}");
                \Illuminate\Support\Facades\Schema::connection('mysql')->drop($newTableName);
            }

            $this->info("Cloning table: {$tableName} -> {$newTableName}");
            
            try {
                \Illuminate\Support\Facades\DB::connection('mysql')->statement("CREATE TABLE {$newTableName} LIKE hrsale.{$tableName}");
                \Illuminate\Support\Facades\DB::connection('mysql')->statement("INSERT INTO {$newTableName} SELECT * FROM hrsale.{$tableName}");
            } catch (\Exception $e) {
                $this->error("Failed to copy table {$tableName}: " . $e->getMessage());
            }
        }

        $this->info("Done! Cloned all tables successfully.");
    }
}
