<?php

namespace ChemLab;

use Illuminate\Support\Facades\Auth;

trait UserStampTrait
{
    public static function bootUserStampTrait()
    {
        static::creating(function ($model) {
        	$model->attributes['created_user_id'] = Auth::user()->id;
        	$model->attributes['updated_user_id'] = Auth::user()->id;
        });

        static::updating(function ($model) {
        	$model->attributes['updated_user_id'] = Auth::user()->id;
        });
    }
}