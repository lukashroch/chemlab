<?php

namespace ChemLab\Helpers;

class Helper
{
    // TODO: unit stuff should be reworked at some point
    public static function unit($unit, $val)
    {
        if (empty($val))
            return "";

        $aUnit = explode(',', $unit);
        $aUnit = array_values(array_diff($aUnit, array(0)));
        if (!count($aUnit))
            return $val . __('chemicals.unit');

        $aUnitDef = array(
            [1000, 'mG', 'µL', 'unit'],
            [1, 'G', 'mL', 'unit'],
            [0.001, 'kG', 'L', 'unit']);

        $mp = $val >= 1 ? ceil($val / 1000) : 0;
        $mp = $mp > 2 ? 2 : $mp;
        $val = $val * $aUnitDef[$mp][0];

        $sUnit = "";
        foreach ($aUnit as $key => $value) {
            $sUnit != "" && $sUnit .= "/";
            $sUnit .= $aUnitDef[$mp][$value];
        }

        return round($val, 2) . $sUnit;
    }
}
