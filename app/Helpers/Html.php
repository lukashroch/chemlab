<?php namespace ChemLab\Helpers;

use Entrust;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\HtmlString;
use Form;

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
        $string = "<span class=\"fa fa-" . $ctype . "\" aria-hidden=\"true\" title=\"" . $title . "\" alt=\"" . $title . "\"></span>";

        switch ($type) {
            case "admin.index":
            case "admin.overview":
            case "admin.dbbackup":
            case "admin.cache":
            case "brand.index":
            case "chemical.index":
            case "chemical.recent":
            case "chemical.search":
            case "chemical.search.structure":
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
                $string = "<a href=\"" . route($type, ['id' => $id]) . "\" title=\"" . $title . "\" alt=\"" . $title . "\">" . $string . "  " . str_limit($title, 50) . "</a>";
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
                $string = "<a href=\"" . route($type, ['id' => $id]) . "\" title=\"" . $title . "\" alt=\"" . $title . "\">" . $string . "</a>&nbsp;";
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
                $string = "<a href=\"#\" class=\"remove\" data-action=\"" . route($type, ['id' => $id]) . "\" data-confirm=\"" . trans('common.action.delete.confirm', ['name' => $attr['name']]) . "\" title=\"" . $title . "\" alt=\"" . $title . "\">" . $string . " </a>";
                break;
            case "chemical.item.add":
            case "chemical.item.edit":
            case "chemical.item.delete":
                $string = Form::button($string, $attr);
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
                $string = "<a class=\"close pull-right " . $ctype . "\" href=\"#\">" . $string . "</a>";
                break;
            default:
                break;
        }

        return $this->toHtmlString($string);
    }

    public
    function alert($msg, $type, $js = false)
    {
        $string = "<div class=\"alert alert-" . $type . " alert-dismissible";
        if ($js)
            $string .= " alert-hidden";
        $string .= "\"><span class=\"fa fa-common-alert-" . $type . "\" aria-hidden=\"true\"></span> " . $msg . " " . $this->icon('common.alert.close') . "</div>";

        return $js ? $string : $this->toHtmlString($string);
    }

    public
    function menu($module, $action, $param = null)
    {
        $string = ($action == 'recent' || $action == 'search') ? $this->icon($module . "." . $action) : $this->icon($module . ".index");

        if (isset($param['name']))
            $string .= "<small>&nbsp;&raquo;&nbsp;" . $param['name'] . "</small>";
        if (Input::get('search') != null)
            $string .= "<small>&nbsp;&raquo;&nbsp;" . Input::get('search') . "</small>";

        $id = isset($param['id']) ? $param['id'] : null;

        $string .= "<div class=\"btn-group pull-right\">
            <button type=\"button\" class=\"btn btn-primary dropdown-toggle pull-right\" data-toggle=\"dropdown\" aria-expanded=\"false\">
            <span class=\"fa fa-nav-options\" aria-hidden=\"true\"></span> " . trans('common.options') . " <span class=\"caret\"></span></button>
            <ul class=\"dropdown-menu dropdown-menu-right\" role=\"menu\">";

        if (Entrust::can($module . '-edit'))
            $string .= "<li><a href=\"" . route($module . '.create') . "\"><span class=\"fa fa-fw fa-" . $module . "-create\" aria-hidden=\"true\"></span> " . trans($module . '.create') . "</a></li>
            <li role=\"presentation\" class=\"divider\"></li>";

        $addDiv = false;

        switch ($action) {
            case "index":
            case "recent":
            case "search":
                if ($module == "chemical")
                    $string .= "<li><a href=\"" . route($module . '.export', ['type' => $action]) . "?" . $_SERVER['QUERY_STRING'] . "\" target=\"_blank\"><span class=\"fa fa-fw fa-" . $module . "-export\" aria-hidden=\"true\"></span> " . trans($module . '.export') . "</a></li>
                    <li role=\"presentation\" class=\"divider\"></li>";
                break;
            case "edit":
                if (Entrust::can($module . '-show')) {
                    $string .= "<li><a href=\"" . route($module . '.show', ['id' => $id]) . "/\"><span class=\"fa fa-fw fa-" . $module . "-show\" aria-hidden=\"true\"></span> " . trans($module . '.show') . "</a></li>";
                    $addDiv = true;
                }
                if (Entrust::can($module . '-delete')) {
                    $string .= "<li><a href=\"#\" class=\"remove\" data-action=\"" . route($module . '.delete', ['id' => $id]) . "\" data-confirm=\"" . trans('common.action.delete.confirm', ['name' => $param['name']]) . "\"><span class=\"fa fa-fw fa-" . $module . "-delete\" aria-hidden=\"true\"></span> " . trans($module . '.delete') . "</a>";
                    $addDiv = true;
                }

                break;
            case "show":
                if (Entrust::can($module . '-edit')) {
                    $string .= "<li><a href=\"" . route($module . '.edit', ['id' => $id]) . "/\"><span class=\"fa fa-fw fa-" . $module . "-edit\" aria-hidden=\"true\"></span> " . trans($module . '.edit') . "</a></li>";
                    $addDiv = true;
                }
                if (Entrust::can($module . '-delete')) {
                    $string .= "<li><a href=\"#\" class=\"remove\" data-action=\"" . route($module . '.delete', ['id' => $id]) . "\" data-confirm=\"" . trans('common.action.delete.confirm', ['name' => $param['name']]) . "\"><span class=\"fa fa-fw fa-" . $module . "-delete\" aria-hidden=\"true\"></span> " . trans($module . '.delete') . "</a>";
                    $addDiv = true;
                }
                break;
        }

        if ($addDiv)
            $string .= "<li role=\"presentation\" class=\"divider\"></li>";

        $prevUrl = Session::get('_previous') ? url(Session::get('_previous')['url']) : "#";
        $string .= "<li><a href=\"" . $prevUrl . "\"><span class=\"fa fa-fw fa-common-back\" aria-hidden=\"true\"></span> " . trans('common.back') . "</a></li></ul></div>";

        return $this->toHtmlString($string);
    }

    public
    function unit($type, $val = -1)
    {
        if ($val == -1)
            return $type ? 'mL' : 'G';
        else {
            $type = ($type != '0' && $type != '1') ? '2' : $type;

            $aUnits = array(
                ['mG', '&#181;L', 'mG/&#181;L', 1000],
                ['G', 'mL', 'G/mL', 1],
                ['kG', 'L', 'kG/L', 0.001]);

            $mp = $val >= 1 ? ceil($val / 1000) : 0;
            $mp = $mp > 2 ? 2 : $mp;
            $unit = $aUnits[$mp][$type];
            $val = $val * $aUnits[$mp][3];

            return round($val, 2) . $unit;
        }
    }
}
