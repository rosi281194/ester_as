<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Kutia\Larafirebase\Facades\Larafirebase;

class User extends Model implements AuthenticatableContract
{
    use Authenticatable;

    protected $table = 'users';
    public static $tables = 'users';
    protected $guarded = [];

    public function getNameAttribute()
    {
        return $this->username;
    }

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::needsRehash($password) ? Hash::make($password) : $password;
    }

    public static function getAll()
    {
        $users = DB::table(self::$tables);
        $users = $users->whereNull('deleted_at');
        return $users->get();
    }

    public static function getRole($int = null)
    {
        $roles = array(
            '0' => 'admin',
            '1' => 'user',
        );
        if (empty($int)) {
            return array(
                ['value' => '0', 'text' => 'admin'],
                ['value' => '1', 'text' => 'user'],
            );
        }
        return $roles[$int];
    }
}
