<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class UserDataScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        if (!Auth::check()) {
            return;
        }

        $user = Auth::user();

        // roles fetch karo
        $roles = $user->roles()->pluck('slug')->toArray();

        if (!in_array('super_admin', $roles) && !in_array('admin', $roles)) {
            if (in_array('created_by_id', $model->getFillable()) ||
                \Schema::hasColumn($model->getTable(), 'created_by_id')) {

                $builder->where($model->getTable().'.created_by_id', $user->id);
            }
        }
    }
}
