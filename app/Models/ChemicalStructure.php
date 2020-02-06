<?php

namespace ChemLab\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChemicalStructure extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'chemical_structures';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'chemical_id';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['chemical_id'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['inchikey', 'inchi', 'smiles', 'sdf'];

    /**
     * @return BelongsTo
     */
    public function chemical(): BelongsTo
    {
        return $this->belongsTo(Chemical::class);
    }

}
