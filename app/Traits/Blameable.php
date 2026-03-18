<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait Blameable
{
    protected static function bootBlameable()
    {
        static::creating(function ($model) {

            if (Auth::check() && empty($model->created_by_id)) {
                $model->created_by_id = Auth::id();
            }

        });

        static::updating(function ($model) {

            if (Auth::check()) {
                $model->updated_by_id = Auth::id();
            }

        });
    }
}
