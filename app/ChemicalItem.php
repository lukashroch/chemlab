<?php namespace ChemLab;

use Illuminate\Database\Eloquent\Model;

class ChemicalItem extends Model
{
    protected $table = 'chemical_items';

    protected $guarded = ['id'];
    protected $fillable = ['chemical_id', 'store_id', 'amount', 'unit'];

    public function chemical()
    {
        return $this->belongsTo(Chemical::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function added()
    {
        return $this->created_at->formatLocalized('%d %b %Y (%H:%M)');
        //return iconv('ISO-8859-2', 'UTF-8', $this->created_at->formatLocalized('%d %B %Y (%H:%M)'));
    }
}
