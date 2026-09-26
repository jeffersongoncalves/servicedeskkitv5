<?php

namespace App\Models;

use JeffersonGoncalves\Filament\User\Models\User as BaseUser;
use JeffersonGoncalves\ServiceDesk\Concerns\HasTickets;

/**
 * Columns, casts, factory, observer, Filament panel access and avatar come from
 * jeffersongoncalves/laravel-user + jeffersongoncalves/filament-user.
 */
class User extends BaseUser
{
    use HasTickets;
}
