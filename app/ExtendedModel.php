<?php

namespace ChemLab;

use Illuminate\Database\Eloquent\Model;

class ExtendedModel extends Model
{
    protected $nullable = [];

    public static function boot()
    {
        parent::boot();
        static::saving(function ($model) {
            $model->beforeSave();
        });
    }

    /**
     * Set empty nullable fields to null
     */
    public function beforeSave()
    {
        foreach ($this->attributes as $key => &$value) {
            if (in_array($key, $this->nullable)) {
                empty($value) and $value = null;
            }
        }
    }
}