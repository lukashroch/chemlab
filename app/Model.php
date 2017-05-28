<?php

namespace ChemLab;

use Illuminate\Database\Eloquent\Model as BaseModel;
use Yajra\Auditable\AuditableTrait;

class Model extends BaseModel
{
    use AuditableTrait;

    /**
     * The attributes that are nullable
     *
     * @var array
     */
    protected $nullable = [];

    public static function boot()
    {
        parent::boot();
        static::saving(function ($model) {
            $model->beforeSave();
        });
    }

    public function beforeSave()
    {
        if (empty($this->nullable))
            return;
        
        foreach ($this->attributes as $key => &$value) {
            if (in_array($key, $this->nullable)) {
                empty($value) and $value = null;
            }
        }
    }
}