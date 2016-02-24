<?php namespace ChemLab;

use Illuminate\Database\Eloquent\Model;

class ChemicalStructure extends Model
{
    protected $table = 'chemical_structures';

    protected $primaryKey = 'chemical_id';

    protected $guarded = ['chemical_id'];
    protected $fillable = ['inchikey', 'inchi', 'smiles', 'sdf'];

    public function chemical()
    {
        return $this->belongsTo('ChemLab\Chemical');
    }

}
