<?php namespace ChemLab;

class Compound extends ExtendedModel
{
    protected $table = 'compounds';

    protected $guarded = ['id'];
    protected $fillable = ['internal_id', 'owner_id', 'name', 'mw', 'amount', 'description', 'inchikey', 'inchi', 'smiles', 'sdf'];
    protected $nullable = ['owner_id'];

    public function owner()
    {
        return $this->belongsTo('ChemLab\User');
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
