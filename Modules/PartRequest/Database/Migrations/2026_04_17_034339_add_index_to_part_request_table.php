<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Adds indexes on part_request table to speed up:
     *  - getById JOIN on part_id (used by the Out-to Expense/CIP modal)
     *  - getAllByParams filter on part_category_id + status (used by all *index methods)
     *  - date-range queries on created_at
     *
     * @return void
     */
    public function up()
    {
        Schema::table('part_request', function (Blueprint $table) {
            // Index for the JOIN on part_id (getById modal lookup)
            if (!$this->indexExists('part_request', 'pr_part_id_index')) {
                $table->index('part_id', 'pr_part_id_index');
            }

            // Index for status filter (getAllByParams used by notification views)
            if (!$this->indexExists('part_request', 'pr_status_index')) {
                $table->index('status', 'pr_status_index');
            }

            // Index for date-range filter
            if (!$this->indexExists('part_request', 'pr_created_at_index')) {
                $table->index('created_at', 'pr_created_at_index');
            }
        });
    }

    /**
     * @return void
     */
    public function down()
    {
        Schema::table('part_request', function (Blueprint $table) {
            $sm = Schema::getConnection()->getDoctrineSchemaManager();
            $doctrineTable = $sm->listTableDetails('part_request');

            if ($doctrineTable->hasIndex('pr_part_id_index')) {
                $table->dropIndex('pr_part_id_index');
            }
            if ($doctrineTable->hasIndex('pr_status_index')) {
                $table->dropIndex('pr_status_index');
            }
            if ($doctrineTable->hasIndex('pr_created_at_index')) {
                $table->dropIndex('pr_created_at_index');
            }
        });
    }

    private function indexExists(string $table, string $indexName): bool
    {
        $indexes = \DB::select("SHOW INDEX FROM `{$table}` WHERE Key_name = ?", [$indexName]);
        return !empty($indexes);
    }
};
