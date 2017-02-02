<?php namespace ChemLab\Helpers;

use Entrust;
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

    public static function icon($type, array $attr = [])
    {
        $attr = array_merge([
            'id' => '',
            'name' => '',
            'titleToText' => false,
            'disable' => false
        ], $attr);

        $ctype = str_replace('.', '-', $type);
        $title = trans($type);
        $string = "<span class=\"fa fa-" . $ctype . "\" aria-hidden=\"true\" title=\"" . $title . "\"></span>";
        if ($attr['titleToText'] == true)
            $string .= " " . $title;

        switch ($type) {
            case "admin.index":
            case "admin.overview":
            case "admin.dbbackup":
            case "admin.cache":
            case "brand.index":
            case "chemical.index":
            case "chemical.recent":
            case "chemical.search":
            case "compound.index":
            case "permission.index":
            case "role.index":
            case "store.index":
            case "user.index":
            case "user.profile":
                $string = "<a href=\"" . route($type) . "\">" . $string . " " . trans($type) . "</a>";
                break;
            case "admin.dbbackup.create":
            case "brand.create":
            case "chemical.create":
            case "compound.create":
            case "permission.create":
            case "role.create":
            case "store.create":
            case "user.create":
                $string = "<a role=\"button\" class=\"btn btn-sm btn-primary pull-right\" href=\"" . route($type) . "\" title=\"" . $title . "\">" . $string . "</a>";
                break;
            case "admin.dbbackup.show":
            case "brand.show":
            case "chemical.show":
            case "compound.show":
            case "permission.show":
            case "role.show":
            case "store.show":
            case "user.show":
                if (!empty($attr['name']))
                    $string = "<a href=\"" . route($type, ['id' => $attr['id']]) . "\" title=\"" . $attr['name'] . "\">" . str_limit($attr['name'], 50) . "</a>";
                else
                    $string = "<a role=\"button\" class=\"btn btn-sm btn-default\" href=\"" . route($type, ['id' => $attr['id']]) . "\" title=\"" . $title . "\">" . $string . "</a>";
                break;
            case "brand.edit":
            case "chemical.edit":
            case "compound.edit":
            case "permission.edit":
            case "role.edit":
            case "store.edit":
            case "user.edit":
                $class = "";
                if (!Entrust::can($ctype)) {
                    if ($attr['disable'] == true)
                        $class = "disable";
                    else
                        return "";
                }
                $string = "<a role=\"button\" class=\"btn btn-sm btn-default " . $class . "\" href=\"" . route($type, ['id' => $attr['id']]) . "\" title=\"" . $title . "\">" . $string . "</a>";
                break;
            case "brand.delete":
            case "chemical.delete":
            case "compound.delete":
            case "permission.delete":
            case "role.delete":
            case "store.delete":
            case "user.delete":
            case "admin.dbbackup.delete":
                $class = "";
                if (!Entrust::can($ctype) && $type != "admin.dbbackup.delete") {
                    if ($attr['disable'] == true)
                        $class = "disable";
                    else
                        return "";
                }
                $string = "<button class=\"btn btn-sm btn-danger delete " . $class . "\" data-url=\"" . route($type, ['id' => $attr['id']]) . "\" data-confirm=\"" . trans('common.action.delete.confirm', ['name' => $attr['name']]) . "\" title=\"" . $title . "\">" . $string . "</button>";
                break;
            case "chemical.items":
                $string .= " " . trans($type);
                break;
            case "chemical.item.create":
            case "chemical.item.save":
            case "chemical.structure.edit":
                $string = Form::button($string . " " . $title, $attr);
                break;
            case "chemical.item.delete":
            case "chemical.item.edit":
                $string = Form::button($string, $attr + ['title' => $title]);
                break;
            case "chemical.pubchem.link":
            case "chemical.chemspider.link":
                if (empty($attr['id']))
                    return "";

                $ids = explode(';', $attr['id']);
                $html = "";
                foreach ($ids as $i)
                    $html .= "<a href=\"" . url(trans($type, ['id' => $i])) . "\" target=\"_blank\">" . $i . " " . $string . "</span></a> ";

                $string = $html;
                break;
            case "permission.role":
            case "role.permission":
            case "role.user":
            case "user.role":
                $string .= " " . $attr['name'];
                break;
            case "badge.assigned":
            case "badge.not-assigned":
                $class = ($type == "badge.assigned") ? " btn-danger" : " btn-success";
                $string = "<button class=\"btn btn-sm pull-right " . $class . "\" title=\"" . $title . "\">" . $string . "</button>";
                break;
            case "common.save":
            case "common.submit":
                $string = "<button type=\"submit\" class=\"btn btn-primary\" title=\"" . $title . "\">" . $string . " " . $title . "</button>";
                break;
            case "common.search":
                $string = "<button type=\"submit\" class=\"btn btn-default\" title=\"" . $title . "\">" . $string . "</button>";
                break;
            case "common.alert.close":
                $string = "<a class=\"close pull-right " . $ctype . "\">" . $string . "</a>";
                break;
            default:
                break;
        }

        return self::toHtmlString($string);
    }

    public static function alert($type, $str)
    {
        return self::toHtmlString("<div class=\"alert alert-" . $type . " alert-dismissible\">
            <span class=\"fa fa-common-alert-" . $type . "\" aria-hidden=\"true\"></span> " . $str . " " . self::icon('common.alert.close') . "</div>");
    }

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
