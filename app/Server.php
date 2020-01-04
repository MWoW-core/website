<?php

namespace App;

use App\Concerns\Server\StatusCheck;
use App\Enums\ServerStatus;
use App\Events\ServerCreated;
use App\Events\ServerDeleted;
use App\Events\ServerUpdated;
use App\Scripts\Script;
use BenSampo\Enum\Traits\CastsEnums;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;
use JJG\Ping;
use Throwable;
use function collect;
use function decrypt;
use function dns_get_record;
use function encrypt;
use function filter_var;
use function get_class;
use function implode;
use const DNS_A;
use const FILTER_VALIDATE_IP;
use const PHP_EOL;

/**
 * Class Server
 * @package App
 * @mixin Builder
 * @property int $id
 * @property string $status
 * @property string $realmlist
 * @property string $latency
 * @property string $ssh_user
 * @property string $ssh_key
 * @property string $ssh_address
 * @property string $ssh_port
 *
 * @property-read $ssh_ip_address
 * @property-read Collection $tasks
 * @property-read Collection $realms
 * @property-read Collection $accounts
 */
class Server extends Model
{
    use CastsEnums, StatusCheck, SoftDeletes;

    protected $fillable = [
        'status',
        'realmlist',
        'latency',
        'ssh_user',
        'ssh_key',
        'ssh_address',
        'ssh_port'
    ];

    protected array $dispatchesEvents = [
        'created' => ServerCreated::class,
        'updated' => ServerUpdated::class,
        'deleted' => ServerDeleted::class,
    ];

    public array $enumCasts = [
        'status' => ServerStatus::class
    ];

    public function isLocalhost(): bool
    {
        return $this->ssh_ip_address == '127.0.0.1';
    }

    public function run(Script $script)
    {
        $this->tasks()->create([
            'script' => get_class($script),
            'output' => $script->run($this)
        ]);
    }

    public function SSH()
    {
        return new SecureShell($this);
    }

    public function setSshKeyAttribute(?string $value): void
    {
        $this->attributes['ssh_key'] = $value ? encrypt($value) : null;
    }

    public function getSshKeyAttribute(?string $encryptedValue): ?string
    {
        if (!$encryptedValue) {
            return null;
        }

        return decrypt($encryptedValue);
    }

    public function getSshIpAddressAttribute(): ?string
    {
       return filter_var($this->ssh_address, FILTER_VALIDATE_IP) ?: Arr::get(dns_get_record($this->ssh_address, DNS_A), '0.ip', null);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function realms(): HasMany
    {
        return $this->hasMany(Realm::class);
    }

    public function accounts(): HasMany
    {
        return $this->hasMany(Account::class);
    }
}
