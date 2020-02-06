<?php

namespace ChemLab\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
     * @return BelongsTo
     */
    public function chemical(): BelongsTo
    {
        return $this->belongsTo(Chemical::class);
    }

    /**
     * @return BelongsTo
     */
    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    /**
     * @return BelongsTo
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return string
     */
    public function added(): string
    {
        return $this->created_at->formatLocalized('%d %b %Y (%H:%M)');
        //return iconv('ISO-8859-2', 'UTF-8', $this->created_at->formatLocalized('%d %B %Y (%H:%M)'));
    }
}
