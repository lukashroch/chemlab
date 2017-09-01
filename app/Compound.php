<?php

namespace ChemLab;

class Compound extends Model
{
    use FlushableTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'compounds';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['internal_id', 'owner_id', 'name', 'mw', 'amount', 'description', 'inchikey', 'inchi', 'smiles', 'sdf'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeOfOwner($query, $owner)
    {
        // If owner input data null, scope 'all data'
        if ($owner == null)
            return $query;

        $query->where(function ($query) use ($owner) {
            $query->whereIn('compounds.owner_id', array_values($owner));
            // If owner not defined, pass null to DB query
            if (array_search('nd', $owner) !== false)
                $query->orWhere('compounds.owner_id', '=', null);
        });

        return $query;
    }
}
