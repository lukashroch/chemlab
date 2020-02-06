<?php

namespace ChemLab\Models\Traits;

use Illuminate\Support\Carbon;

trait DatesTrait
{
    /**
     * Format specified date to timestamp
     *
     * @param $value
     * @param string $callback
     * @param string $format
     *
     * @return Carbon|null
     */
    public function toTimestamp($value, $callback = 'startOfDay', $format = 'd.m.Y')
    {
        return is_null($value) ? $value : Carbon::createFromFormat($format, $value)->{$callback}()->format($this->getDateFormat());

        //return is_null($value) ? $value : Carbon::parse($value)->{$callback}()->format($this->getDateFormat());
    }

    /**
     * Format timestamp from DB to specified date
     *
     * @param $value
     * @param string $format
     * @return string|null
     */
    public function toDate($value, $format = 'd.m.Y')
    {
        return is_null($value) ? $value : $this->asDateTime($value)->format($format);
    }
}
