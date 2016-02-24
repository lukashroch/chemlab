<?php namespace ChemLab;

use Illuminate\Database\Eloquent\Model;

class ChemicalItem extends Model
{
    protected $table = 'chemical_items';

    protected $guarded = ['id'];
    protected $fillable = ['chemical_id', 'store_id', 'amount', 'unit'];

    public function chemical()
    {
        return $this->belongsTo('ChemLab\Chemical');
    }

    public function store()
    {
        return $this->belongsTo('ChemLab\Store');
    }

    public function added()
    {
        return $this->created_at->formatLocalized('%d %B %Y (%H:%M)');
    }
}
