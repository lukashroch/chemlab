<?php namespace ChemLab;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use FlushModelCache;

    protected $table = 'brands';

    protected $guarded = ['id'];
    protected $fillable = ['name', 'pattern', 'description'];

    public function chemicals()
    {
        return $this->hasMany(Chemical::class);
    }

    public function scopeSelectList($query)
    {
        return $query->orderBy('name', 'asc')->pluck('name', 'id')->toArray();
    }

    public function scopeSelectPatternList($query)
    {
        return $query->where('name', 'LIKE', "%SA:%")->orderBy('id', 'asc')->pluck('pattern', 'id')->toArray();
    }
}
