<?php


namespace core;


class Paginator
{
    private $totalPages;
    private $pageCurrent;
    private $url;

    private function setCurrentPage(){
        $pageCurrent = (isset($_GET['page']) && !empty(intval($_GET['page']))) ? intval($_GET['page']) : 1;
        if ($pageCurrent > $this->totalPages) $pageCurrent = $this->totalPages;
        if ($pageCurrent < 1) $pageCurrent = 1;
        return $pageCurrent;
    }

    public function __construct($total, $perPage, $url)
    {
        $this->totalPages = ceil($total/$perPage);
        $this->pageCurrent = $this->setCurrentPage();
        $this->url = $url;
    }

    public function getCurrentPage(){
        return $this->pageCurrent;
    }

    public function getHTML(){
        $cur = $this->pageCurrent;
        $tot = $this->totalPages;
        $url = $this->url.'&page=';

        $first = $cur > 1 ? '<li><a href="'.$url.'1'.'">First</a>' : NULL;
        $prev = $cur > 1 ? '<li><a href="'.$url.($cur - 1).'">&laquo; Prev</a>' : NULL;
        $twoBack = $cur > 2 ? '<li><a href="'.$url.($cur - 2).'">'.($cur - 2).'</a>' : NULL;
        $oneBack = $cur > 1 ? '<li><a href="'.$url.($cur - 1).'">'.($cur - 1).'</a>' : NULL;
        $current = $tot > 1 ? '<li><span class="cur-page">'.$cur.'</span></li>' : NULL;
        $oneForward = $cur < $tot ? '<li><a href="'.$url.($cur + 1).'">'.($cur + 1).'</a>' : NULL;
        $twoForward = $cur + 1 < $tot ? '<li><a href="'.$url.($cur + 2).'">'.($cur + 2).'</a>' : NULL;
        $next = $cur < $tot ? '<li><a href="'.$url.($cur + 1).'">Next &raquo;</a>' : NULL;
        $last = $cur < $tot ? '<li><a href="'.$url.$tot.'">Last</a>' : NULL;

        return '<ul class="paginator">'.$first.$prev.$twoBack.$oneBack.$current.$oneForward.$twoForward.$next.$last.'</ul>';
    }

    public function __toString()
    {
        return $this->getHTML();
    }
}