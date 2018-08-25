<?php

namespace ChemLab\Helpers;

use Illuminate\Support\HtmlString;

class Html
{
    /**
     * Transform the string to an Html serializable object
     *
     * @param $html
     *
     * @return \Illuminate\Support\HtmlString
     */
    protected static function toHtmlString($html)
    {
        return new HtmlString($html);
    }

    public static function icon($type, array $attr = [])
    {
        $attr = array_merge([
            'id' => '',
            'name' => '',
            'titleToText' => false
        ], $attr);

        $ctype = str_replace('.', '-', $type);
        $trans = trans($type);
        $string = "<span class=\"fas fa-{$ctype}\" aria-hidden=\"true\" title=\"{$trans}\"></span>";
        if ($attr['titleToText'] == true)
            $string .= " " . $trans;

        switch ($type) {
            /*case "chemical-item.delete":
                if (!auth()->user()->hasPermission($ctype) && ($type != "admin.dbbackup.delete" && $type != "chemical-item.delete")) {
                    return "";
                }
                if ($attr['disable'] == true)
                    $string = "<button class=\"btn btn-danger btn-sm disabled\" title=\"{$trans}\">{$string}</button>";
                else
                    $string = "<button class=\"btn btn-danger btn-sm delete\" data-url=\"" . route($type, ['id' => $attr['id']]) . "\" data-confirm=\"" . trans('common.action.delete.confirm', ['name' => $attr['name']]) . "\" data-response=\"{$attr['response']}\" title=\"{$trans}\">{$string}</button>";
                break;*/
            case "chemical.pubchem.link":
            case "chemical.chemspider.link":
                $string = "<a href=\"" . url(trans($type, ['id' => $attr['id']])) . "\" target=\"_blank\" rel=\"noopener\">{$attr['id']} {$string}</span></a>";
                break;
            case "common.submit":
                $string = "<button type=\"submit\" class=\"btn btn-primary\" title=\"{$trans}\">{$string} {$trans}</button>";
                break;
            case "common.search":
                $string = "<button type=\"submit\" class=\"btn btn-primary\" title=\"{$trans}\">{$string}</button>";
                break;
            case "common.alert.close":
                $string = "<a class=\"close float-right {$ctype}\">{$string}</a>";
                break;
            default:
                break;
        }

        return self::toHtmlString($string);
    }

    public static function alert($type, $str)
    {
        return self::toHtmlString("<div class=\"alert alert-{$type} alert-dismissible\">
            <span class=\"fas fa-common-alert-{$type}\" aria-hidden=\"true\"></span> {$str} " . self::icon('common.alert.close') . "</div>");
    }

    // TODO: unit stuff should be reworked at some point
    public static function unit($unit, $val)
    {
        if (empty($val))
            return "";

        $aUnit = explode(',', $unit);
        $aUnit = array_values(array_diff($aUnit, array(0)));
        if (!count($aUnit))
            return $val . trans('chemical.unit');

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
