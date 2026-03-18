<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class OwnedByUserScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        if (!Auth::check()) {
            return;
        }

        $user = Auth::user();

        if ($user->hasRole('super-admin') || $user->hasRole('Admin')) {
            return;
        }

        $builder->where($model->getTable().'.created_by_id', $user->id);
    }
}
