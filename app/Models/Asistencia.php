<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Asistencia extends Model
{
    protected $table = 'asistencia';
    public static $tables = 'asistencia';
    protected $guarded = [];

    public static function getAll()
    {
        $personas = DB::table(self::$tables);
        return $personas->get();
    }
}
