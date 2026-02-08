<?php

namespace App\Observers;

use App\Models\Operator;
use Illuminate\Support\Facades\Cache;
use Psr\SimpleCache\InvalidArgumentException;

class OperatorObserver
{
    /**
     * Handle the Operator "created" event.
     */
    public function created(Operator $operator): void
    {
        try {
            Cache::delete('operators_count');
        } catch (InvalidArgumentException) {
        }
    }

    /**
     * Handle the Operator "updated" event.
     */
    public function updated(Operator $operator): void
    {
        //
    }

    /**
     * Handle the Operator "deleted" event.
     */
    public function deleted(Operator $operator): void
    {
        try {
            Cache::delete('operators_count');
        } catch (InvalidArgumentException) {
        }
    }

    /**
     * Handle the Operator "restored" event.
     */
    public function restored(Operator $operator): void
    {
        //
    }

    /**
     * Handle the Operator "force deleted" event.
     */
    public function forceDeleted(Operator $operator): void
    {
        //
    }
}
