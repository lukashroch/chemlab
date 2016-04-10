<?php namespace ChemLab\Helpers;

use Entrust;
use Form;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\HtmlString;

class Html
{
    /**
     * The URL generator instance.
     *
     * @var \Illuminate\Contracts\Routing\UrlGenerator
     */
    protected $url;

    /**
     * The View Factory instance.
     *
     * @var \Illuminate\Contracts\View\Factory
     */
    protected $view;

    /**
     * Create a new Helper builder instance.
     *
     * @param \Illuminate\Contracts\Routing\UrlGenerator $url
     * @param \Illuminate\Contracts\View\Factory $view
     */
    public function __construct(UrlGenerator $url = null, Factory $view)
    {
        $this->url = $url;
        $this->view = $view;
    }

    /**
     * Transform the string to an Html serializable object
     *
     * @param $html
     *
     * @return \Illuminate\Support\HtmlString
     */
    protected function toHtmlString($html)
    {
        return new HtmlString($html);
    }

    public function icon($type, $id = null, $attr = array())
    {
        $ctype = str_replace('.', '-', $type);
        $title = (isset($attr['name']) && !str_contains($type, '.delete')) ? $attr['name'] : trans($type);
        $string = "<span class=\"fa fa-" . $ctype . "\" aria-hidden=\"true\" title=\"" . $title . "\"></span>";

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
            case "department.index":
            case "permission.index":
            case "role.index":
            case "store.index":
            case "user.index":
            case "user.profile":
                $string = "<a href=\"" . route($type) . "\">" . $string . " " . trans($type) . "</a>";
                break;
            case "admin.dbbackup.show":
            case "brand.show":
            case "chemical.show":
            case "compound.show":
            case "department.show":
            case "permission.show":
            case "role.show":
            case "store.show":
            case "user.show":
                $string = "<a href=\"" . route($type, ['id' => $id]) . "\" title=\"" . $title . "\">" . $string . "  " . str_limit($title, 50) . "</a>";
                break;
            case "brand.edit":
            case "chemical.edit":
            case "compound.edit":
            case "department.edit":
            case "permission.edit":
            case "role.edit":
            case "store.edit":
            case "user.edit":
                if (!Entrust::can($ctype))
                    return "";
                $string = "<a role=\"button\" class=\"btn btn-default\" href=\"" . route($type, ['id' => $id]) . "\" title=\"" . $title . "\">" . $string . "</a>";
                break;
            case "brand.delete":
            case "chemical.delete":
            case "compound.delete":
            case "department.delete":
            case "permission.delete":
            case "role.delete":
            case "store.delete":
            case "user.delete":
                if (!Entrust::can($ctype))
                    return "";
            case "admin.dbbackup.delete":
                $string = "<button class=\"btn btn-danger delete\" data-action=\"" . route($type, ['id' => $id]) . "\" data-confirm=\"" . trans('common.action.delete.confirm', ['name' => $attr['name']]) . "\" title=\"" . $title . "\">" . $string . "</button>";
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
                if (empty($id))
                    return "";

                $ids = explode(';', $id);
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
            case "common.save":
            case "common.submit":
                $string = "<button type=\"submit\" class=\"btn btn-primary\" title=\"" . $title . "\">" . $string . " " . trans($type) . "</button>";
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

        return $this->toHtmlString($string);
    }

    public function alert($type, $str)
    {
        return $this->toHtmlString("<div class=\"alert alert-" . $type . " alert-dismissible\">
            <span class=\"fa fa-common-alert-" . $type . "\" aria-hidden=\"true\"></span> " . $str . " " . $this->icon('common.alert.close') . "</div>");
    }

    public function unit($unit, $val)
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
