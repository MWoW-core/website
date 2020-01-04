<?php

namespace App;

use App\Enums\RealmExpansion;
use App\Scripts\Script;
use BenSampo\Enum\Traits\CastsEnums;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use function decrypt;
use function encrypt;

/**
 * Class Realm
 * @package App
 * @mixin Builder
 * @property int $id
 * @property int $server_id
 * @property-read Server $server
 * @property string $admin_name
 * @property string $admin_password
 * @property string $expansion
 * @property string $console_address
 * @property integer $console_port
 */
class Realm extends Model
{
    use CastsEnums;

    protected $fillable = [
        'server_id',
        'admin_name',
        'admin_password',
        'expansion',
        'console_address',
        'console_port',
    ];

    public $enumCasts = [
        'expansion' => RealmExpansion::class
    ];

    public function runScript(Script $script): Telnet
    {
        return Telnet::send(
            $script->contents(),
            $this
        );
    }

    public function server(): BelongsTo
    {
        return $this->belongsTo(Server::class);
    }

    public function setAdminNameAttribute(string $name)
    {
        $this->attributes['admin_name'] = encrypt($name);
    }

    public function getAdminNameAttribute(string $encryptedValue): string
    {
        return decrypt($encryptedValue);
    }

    public function setAdminPasswordAttribute(string $value)
    {
        $this->attributes['admin_password'] = encrypt($value);
    }

    public function getAdminPasswordAttribute(string $encryptedValue): string
    {
        return decrypt($encryptedValue);
    }
}
