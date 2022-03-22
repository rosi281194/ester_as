<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Recaudacion extends Model
{
    protected $table = 'recaudacion';
    public static $tables = 'recaudacion';
    protected $guarded = [];

    public static function getAll()
    {
        $users = DB::table(self::$tables);
        $users = $users->whereNull('deleted_at');
        return $users->get();
    }
}
