<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

// Test the query directly
try {
    $data = DB::table('part')
        ->leftJoin('part_category', 'part.part_category_id', '=', 'part_category.part_category_id')
        ->select('part.*', 'part_category.part_category_name')
        ->orderBy('part.part_id', 'asc')
        ->limit(3)
        ->get();

    echo "Records found: " . count($data) . "\n";
    foreach ($data as $row) {
        echo "ID: {$row->part_id}, No: {$row->part_no}, Name: {$row->part_name}\n";
    }
    
    $total = DB::table('part')->count();
    echo "\nTotal parts in DB: {$total}\n";
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}
