<?php

namespace ChemLab\Helpers;

use Form;
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

    public static function icon($type, array $attr = [], array $htmlAttr = [])
    {
        $attr = array_merge([
            'id' => '',
            'name' => '',
            'response' => '',
            'titleToText' => false,
            'disable' => false
        ], $attr);

        $ctype = str_replace('.', '-', $type);
        //$route = route($type, $attr['id'] ? ['id' => $attr['id']] : []);
        $trans = trans($type);
        $string = "<span class=\"fa fa-{$ctype}\" aria-hidden=\"true\" title=\"{$trans}\"></span>";
        if ($attr['titleToText'] == true)
            $string .= " " . $trans;

        switch ($type) {
            case "admin.index":
            case "brand.index":
            case "chemical.index":
            case "compound.index":
            case "nmr.index":
            case "permission.index":
            case "profile.index":
            case "role.index":
            case "store.index":
            case "user.index":
                $string = "<a href=\"" . route($type) . "\">{$string} {$trans}</a>";
                break;
            case "admin.dbbackup.create":
            case "brand.create":
            case "chemical.create":
            case "compound.create":
            case "nmr.create":
            case "permission.create":
            case "role.create":
            case "store.create":
            case "user.create":
                $string = "<a role=\"button\" class=\"btn btn-primary btn-sm float-right\" href=\"" . route($type) . "\" title=\"{$trans}\">{$string}<span class=\"d-none d-lg-inline\"> {$trans}</span></a>";
                break;
            case "admin.dbbackup.show":
            case "brand.show":
            case "chemical.show":
            case "compound.show":
            case "nmr.show":
            case "permission.show":
            case "role.show":
            case "store.show":
            case "user.show":
            case "admin.dbbackup.download":
            case "nmr.download":
                if (!empty($attr['name']))
                    $string = "<a href=\"" . route($type, ['id' => $attr['id']]) . "\" title=\"" . $attr['name'] . "\">" . str_limit($attr['name'], 50) . "</a>";
                else
                    $string = "<a role=\"button\" class=\"btn btn-sm btn-secondary\" href=\"" . route($type, ['id' => $attr['id']]) . "\" title=\"{$trans}\">{$string}</a>";
                break;
            case "brand.edit":
            case "chemical.edit":
            case "compound.edit":
            case "permission.edit":
            case "role.edit":
            case "store.edit":
            case "user.edit":
                if (!auth()->user()->can($ctype)) {
                    return "";
                }
                if ($attr['disable'] == true)
                    $string = "<button class=\"btn btn-secondary btn-sm disabled\" title=\"{$trans}\">{$string}</button>";
                else
                    $string = "<a role=\"button\" class=\"btn btn-secondary btn-sm\" href=\"" . route($type, ['id' => $attr['id']]) . "\" title=\"{$trans}\">{$string}</a>";
                break;
            case "brand.delete":
            case "chemical.delete":
            case "chemical-item.delete":
            case "compound.delete":
            case "nmr.delete":
            case "permission.delete":
            case "role.delete":
            case "store.delete":
            case "user.delete":
            case "admin.dbbackup.delete":
                if (!auth()->user()->can($ctype) && ($type != "admin.dbbackup.delete" && $type != "chemical-item.delete")) {
                    return "";
                }
                if ($attr['disable'] == true)
                    $string = "<button class=\"btn btn-danger btn-sm disabled\" title=\"{$trans}\">{$string}</button>";
                else
                    $string = "<button class=\"btn btn-danger btn-sm delete\" data-url=\"" . route($type, ['id' => $attr['id']]) . "\" data-confirm=\"" . trans('common.action.delete.confirm', ['name' => $attr['name']]) . "\" data-response=\"{$attr['response']}\" title=\"{$trans}\">{$string}</button>";
                break;
            case "chemical-item.index":
                $string .= " " . $trans;
                break;
            case "chemical-item.create":
            case "chemical.structure.edit":
                $string = Form::button($string . "<span class=\"hidden-sm-down\"> " . $trans, $attr);
                break;
            case "chemical-item.edit":
                $attr['title'] = $trans;
                if ($attr['disable'] == true)
                    $string = "<button class=\"btn btn-secondary btn-sm disabled\" title=\"{$trans}\">{$string}</button>";
                else
                    $string = Form::button($string, $attr);
                break;
            case "chemical.pubchem.link":
            case "chemical.chemspider.link":
                $string = "<a href=\"" . url(trans($type, ['id' => $attr['id']])) . "\" target=\"_blank\" rel=\"noopener\">{$attr['id']} {$string}</span></a>";
                break;
            case "permission.role":
            case "role.permission":
            case "role.store":
            case "role.user":
            case "user.role":
                $string .= " " . $attr['name'];
                break;
            case "common.badge.assigned":
            case "common.badge.not-assigned":
                $class = ($type == "common.badge.assigned") ? " btn-danger" : " btn-success";
                $string = "<button class=\"btn btn-sm float-right " . $class . "\" title=\"{$trans}\">{$string}</button>";
                break;
            case "common.save":
            case "common.submit":
                $string = "<button type=\"submit\" class=\"btn btn-primary\" title=\"{$trans}\">{$string} {$trans}</button>";
                break;
            case "common.search":
                $string = "<button type=\"submit\" class=\"btn btn-secondary\" title=\"{$trans}\">{$string}</button>";
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
            <span class=\"fa fa-common-alert-{$type}\" aria-hidden=\"true\"></span> {$str} " . self::icon('common.alert.close') . "</div>");
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
