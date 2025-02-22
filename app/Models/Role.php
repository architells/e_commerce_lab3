<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $primaryKey = 'role_id';
    protected $fillable = ['role_name'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_id');
    }
}
