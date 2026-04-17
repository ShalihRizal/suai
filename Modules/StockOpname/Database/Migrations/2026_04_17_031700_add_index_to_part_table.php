<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Adds indexes on the `part` table to speed up STO queries.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('part', function (Blueprint $table) {
            // Index for exact part_no lookups (getdataByParam / getdataByPartNo)
            if (!$this->indexExists('part', 'part_part_no_index')) {
                $table->index('part_no', 'part_part_no_index');
            }

            // Composite index for category + STO status filter (used by all *index methods)
            if (!$this->indexExists('part', 'part_category_has_sto_index')) {
                $table->index(['part_category_id', 'has_sto'], 'part_category_has_sto_index');
            }

            // Index for has_sto alone (aggregate queries: SUM where has_sto = ?)
            if (!$this->indexExists('part', 'part_has_sto_index')) {
                $table->index('has_sto', 'part_has_sto_index');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('part', function (Blueprint $table) {
            $sm = Schema::getConnection()->getDoctrineSchemaManager();
            $doctrineTable = $sm->listTableDetails('part');

            if ($doctrineTable->hasIndex('part_part_no_index')) {
                $table->dropIndex('part_part_no_index');
            }
            if ($doctrineTable->hasIndex('part_category_has_sto_index')) {
                $table->dropIndex('part_category_has_sto_index');
            }
            if ($doctrineTable->hasIndex('part_has_sto_index')) {
                $table->dropIndex('part_has_sto_index');
            }
        });
    }

    /**
     * Check if an index already exists (safe to run on existing DBs).
     */
    private function indexExists(string $table, string $indexName): bool
    {
        $indexes = \DB::select("SHOW INDEX FROM `{$table}` WHERE Key_name = ?", [$indexName]);
        return !empty($indexes);
    }
};
