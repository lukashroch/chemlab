<?php

namespace ChemLab\Models;

use ChemLab\Export\Exportable;
use ChemLab\Export\ExportableTrait;
use ChemLab\Models\Traits\ActionableTrait;
use ChemLab\Models\Traits\ScopeTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Job extends Model implements Exportable
{
    use ActionableTrait, ExportableTrait, ScopeTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'jobs';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id', 'queue', 'payload', 'attempts', 'reserved_at', 'available_at', 'created_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    /**
     * The list of attributes to cast.
     *
     * @var array
     */
    protected $casts = [
        'payload' => 'json',
    ];

    /**
     * Get actions based on current view
     *
     * @return array
     */
    public static function actions(): array
    {
        return [
            'toolbar' => ['run', 'delete'],
            'table' => ['run', 'delete']
        ];
    }

    /**
     * Get export columns.
     *
     * @return array
     */
    public static function exportColumns(): array
    {
        return [];
    }

    /**
     * Getter for available_at Attribute
     *
     * @param string $value
     * @return Carbon
     */
    public function getAvailableAtAttribute($value): Carbon
    {
        return Carbon::createFromTimestamp($value);
    }
}
