<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Monolog\Level;

class UserModel extends Authenticatable
{
    use HasFactory;
    protected $table = 'm_user';
    public $timestamps = false;
    protected $primaryKey = 'user_id';
    /*
     *
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'level_id',
        'username',
        'nama',
        'password',
    ];

    public function level(): BelongsTo
    {
        return $this->belongsTo(LevelModel::class, 'level_id', 'level_id');
    }
}
