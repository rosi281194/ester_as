<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Persona extends Model
{
    protected $table = 'persona';
    public static $tables = 'persona';
    protected $guarded = [];

    public static function getAll()
    {
        $personas = DB::table(self::$tables);
        $personas = $personas->whereNull('deleted_at');
        return $personas->get();
    }
}
