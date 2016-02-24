<?php namespace ChemLab;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table = 'departments';

    protected $guarded = ['id'];
    protected $fillable = ['name', 'prefix', 'description'];

    public function stores()
    {
        return $this->hasMany('ChemLab\Store');
    }

    public function scopeSelectList($query)
    {
        return $query->orderBy('name', 'asc')->lists('name', 'id')->toArray();
    }
}
