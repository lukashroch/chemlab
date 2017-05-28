<?php

namespace ChemLab;

class ChemicalItem extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'chemical_items';

    /**
     * The attributes that are guarded.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['chemical_id', 'store_id', 'amount', 'unit', 'owner_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function chemical()
    {
        return $this->belongsTo(Chemical::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return string
     */
    public function added()
    {
        return $this->created_at->formatLocalized('%d %b %Y (%H:%M)');
        //return iconv('ISO-8859-2', 'UTF-8', $this->created_at->formatLocalized('%d %B %Y (%H:%M)'));
    }
}
