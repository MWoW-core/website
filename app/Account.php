<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Account
 * @package App
 * @mixin Builder
 * @property integer $user_id
 * @property integer $server_id
 * @property-read User $user
 * @property-read Server $server
 */
class Account extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'server_id'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function server(): BelongsTo
    {
        return $this->belongsTo(Server::class);
    }
}
