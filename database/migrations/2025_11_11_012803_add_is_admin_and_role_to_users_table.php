<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Helper: cek eksistensi kolom yang kompatibel dengan SQLite dan MySQL/Postgres.
     */
    protected function columnExists(string $table, string $column): bool
    {
        $driver = DB::connection()->getDriverName();

        if ($driver === 'sqlite') {
            // SQLite: gunakan PRAGMA table_info
            $columns = DB::select("PRAGMA table_info('$table')");
            foreach ($columns as $c) {
                if (isset($c->name) && $c->name === $column) {
                    return true;
                }
            }
            return false;
        }

        // Untuk MySQL / PgSQL gunakan Schema::hasColumn
        return Schema::hasColumn($table, $column);
    }

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $tableName = 'users';

        // Tambah kolom is_admin jika belum ada
        if (!$this->columnExists($tableName, 'is_admin')) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->boolean('is_admin')->default(false);
            });
        }

        // Tambah kolom role jika belum ada
        if (!$this->columnExists($tableName, 'role')) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->string('role')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tableName = 'users';

        if ($this->columnExists($tableName, 'role')) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->dropColumn('role');
            });
        }

        if ($this->columnExists($tableName, 'is_admin')) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->dropColumn('is_admin');
            });
        }
    }
};