<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * Class ServerStatus
 * @package App\Enums
 *
 * @method static ServerStatus Online()
 * @method static ServerStatus Offline()
 */
final class ServerStatus extends Enum
{
    const Online = 'Online';
    const Offline = 'Offline';

    public function color(): string
    {
        switch ($this->value) {
            case self::Offline:
                return 'red';

            case self::Online:
                return 'green';

            default:
                return 'black';
        }
    }
}
