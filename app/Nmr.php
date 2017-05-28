<?php

namespace ChemLab;
use Illuminate\Support\Facades\Storage;

class Nmr extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'nmrs';

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
    protected $fillable = ['filename', 'content', 'user_id'];

    public static function boot()
    {
        parent::boot();
        static::deleted(function ($model) {
            Storage::delete($model->filename);
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopeOfUser($query, $user)
    {
        if ($user == null)
            return $query;

        if (is_array($user))
            return $query->whereIn('nmrs.user_id', $user);
        else
            return $query->where('nmrs.user_id', $user);
    }

    /**
     * Get name for NMR data
     *
     * @return string
     */
    public function getName()
    {
        return "NMR-data-".$this->created_at->format('Y-m-d');
    }
}
