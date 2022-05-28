<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMeta extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'code',
        'telegram',
        'telegram_id',
        'career',
        'invite_id',
        'comment',
        'winner',
        'order_winner',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'participant_telegram',
    ];

    /**
     * user
     *
     * @return User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
