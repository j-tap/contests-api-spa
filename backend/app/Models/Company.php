<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Contests
     *
     * @return Contest
     */
    public function contests()
    {
        return $this->hasMany(Contest::class);
    }

    /**
     * Users
     *
     * @return void
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * Settings
     *
     * @return void
     */
    public function settings()
    {
        return $this->hasMany(Setting::class);
    }

}
