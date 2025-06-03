<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    /** @use HasFactory<\Database\Factories\AccountFactory> */
    use HasFactory;

    protected $fillable = ['name', 'description', 'type', 'color', 'amount'];

    public function users()
    {
        return $this->belongsToMany(
            User::class,
            'account_user',
            'account_id',
            'user_id'
        )->withTimestamps();
    }
}
