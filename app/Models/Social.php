<?php

namespace ChemLab\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Social extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_socials';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id', 'user_id'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['provider', 'provider_id'];

    /**
     * The attributes that are visible.
     *
     * @var array
     */
    protected $visible = ['provider', 'provider_id'];

    /**
     * Get user membership
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
