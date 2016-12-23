<?php namespace ChemLab;

use Illuminate\Database\Eloquent\Model;

class ChemicalItem extends Model
{
    use UserStampTrait;

    protected $table = 'chemical_items';

    protected $guarded = ['id'];
    protected $fillable = ['chemical_id', 'store_id', 'amount', 'unit', 'owner_id', 'created_user_id', 'updated_user_id'];

    public function chemical()
    {
        return $this->belongsTo(Chemical::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class);
    }

    public function updator()
    {
        return $this->belongsTo(User::class);
    }

    public function added()
    {
        return $this->created_at->formatLocalized('%d %b %Y (%H:%M)');
        //return iconv('ISO-8859-2', 'UTF-8', $this->created_at->formatLocalized('%d %B %Y (%H:%M)'));
    }
}
