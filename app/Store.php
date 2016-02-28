<?php namespace ChemLab;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Store extends Model
{
    protected $table = 'stores';

    protected $guarded = ['id'];
    protected $fillable = ['name', 'department_id', 'description', 'temp_min', 'temp_max'];

    public function department()
    {
        return $this->belongsTo('ChemLab\Department');
    }

    public function items()
    {
        return $this->hasMany('ChemLab\ChemicalItem');
    }

    public function scopeSelectList($query)
    {
        return $query->orderBy('name', 'asc')->lists('name', 'id')->toArray();
    }

    public function scopeSelectDepList($query)
    {
        return $query->join('departments', 'stores.department_id', '=', 'departments.id')
            ->select(DB::raw('CONCAT_WS(" - ", departments.prefix, stores.name) as name'), 'stores.id')
            ->orderBy('name', 'asc')
            ->lists('name', 'stores.id')->toArray();
    }

    public function scopeOfDepartment($query, $department)
    {
        if ($department == null)
            return $query;

        if (is_array($department))
            return $query->whereIn('department_id', $department);
        else
            return $query->where('department_id', $department);
    }

    public function scopeUniqueStore($query, $data)
    {
        return $query->where('id', '!=', $data['id'])->where('name', $data['name'])->where('department_id', $data['department_id']);
    }
}
