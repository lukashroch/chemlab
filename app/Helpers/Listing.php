<?php namespace ChemLab\Helpers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\HtmlString;

class Listing
{
    private $url;
    private $page;
    private $lastPage;
    private $interval;
    private $count;
    private $items;
    private $allItems;

    public function __construct($data, $url)
    {
        $this->url = $url . "?";
        foreach (Input::All() as $key => $value) {
            if ($key == 'page' || $value == null)
                continue;

            $this->url .= $key . "=" . $value . "&amp;";
        }
        $this->page = Input::get('page', 1);
        $this->interval = Auth::user()->listing;
        $this->lastPage = 0;
        $this->count = 0;

        if ($count = $data->count()) {
            $this->allItems = $data;
            $this->lastPage = ceil($count / $this->interval);
            $this->count = $count;
            $this->items = $data->slice($this->interval * ($this->page - 1), $this->interval);
        }
    }

    public function items()
    {
        return $this->items ? $this->items : array();
    }

    public function count()
    {
        return $this->count;
    }

    private function isEmpty()
    {
        return (!$this->lastPage && !$this->count);
    }

    public function renderSimple()
    {
        if ($this->isEmpty())
            return "";

        $from = ($this->page * $this->interval) - ($this->interval - 1);
        $to = $this->page * $this->interval;

        $forward = "<li><a href=\"" . $this->url . "page=1\" rel=\"first\"><span class=\"fa fa-angle-double-left\" aria-hidden=\"true\"></span></a></li>
          <li><a href=\"" . $this->url . "page=" . ($this->page - 1) . "\" rel=\"prev\"><span class=\"fa fa-angle-left\" aria-hidden=\"true\"></span></a></li>";
        $backward = "<li><a href=\"" . $this->url . "page=" . ($this->page + 1) . "\" rel=\"next\"><span class=\"fa fa-angle-right\" aria-hidden=\"true\"></span></a></li>
          <li><a href=\"" . $this->url . "page=" . $this->lastPage . "\"><span class=\"fa fa-angle-double-right\" aria-hidden=\"true\"></span></a></li>";

        if ($this->page == 1)
            $forward = "";
        if ($this->page == $this->lastPage) {
            $to = $this->count;
            $backward = "";
        }

        return new HtmlString("<ul class=\"pagination\">" . $forward . "<li class=\"active\"><span>" . $from . "-" . $to . "</span></li>" . $backward . "</ul>");
    }

    public function render()
    {
        if ($this->isEmpty())
            return "";

        $startPage = ($this->page - 4 <= 1) ? 1 : $this->page - 4;
        $endPage = ($this->page + 4 >= $this->lastPage) ? $this->lastPage : $this->page + 4;
        $links = "";
        for ($i = $startPage; $i <= $endPage; $i++) {
            if ($i != $this->page)
                $links .= "<li><a href=\"" . $this->url . "page=" . $i . "\"><span>" . $i . "</span></a></li>";
            else
                $links .= "<li class=\"active\"><span>" . $i . "</span></li>";
        }

        $previous = $this->page != 1 ? "<li><a href=\"" . $this->url . "page=1\" rel=\"first\"><span class=\"fa fa-angle-double-left\" aria-hidden=\"true\"></span></a></li>
          <li><a href=\"" . $this->url . "page=" . ($this->page - 1) . "\" rel=\"prev\"><span class=\"fa fa-angle-left\" aria-hidden=\"true\"></span></a></li>" : "";

        $next = $this->page != $this->lastPage ? "<li><a href=\"" . $this->url . "page=" . ($this->page + 1) . "\" rel=\"next\"><span class=\"fa fa-angle-right\" aria-hidden=\"true\"></span></a></li>
          <li><a href=\"" . $this->url . "page=" . $this->lastPage . "\"><span class=\"fa fa-angle-double-right\" aria-hidden=\"true\"></span></li>" : "";

        return new HtmlString("<ul class=\"pagination\">" . $previous . $links . $next . "</ul>");
    }
}
