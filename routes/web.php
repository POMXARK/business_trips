<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;


Route::get('/test_db', function () {
    try {
        $dbconnect = DB::connection()->getPDO();
        $dbname = DB::connection()->getDatabaseName();
        try {
            $tables = array_map('reset', DB::select('SHOW TABLES'));
            dump($tables);
        } catch (Exception $e) {

        }

        return "Connected successfully to the database. Database name is :".$dbname ;
    } catch(Exception $e) {
        return "Error in connecting to the database";
    }
});
