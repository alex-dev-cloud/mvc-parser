<?php


namespace core;


class Paginator
{
    public $total;
    public $perPage;
    public $currentPage;
    public $countPages;
    public $uri;

    public function __construct($page, $perPage, $total)
    {
        $uri = $_SERVER['REQUEST_URI'];
        $this->total = $total;
        $this->perPage = $perPage;
        $this->countPages = $this->getCountPages();
        $this->currentPage = $this->getCurrentPages($page);
    }

    public function getCountPages (){
        return ceil($this->total/$this->perPage) ?: 1;
    }

    public function getCurrentPages ($page){
        if (!$page || $page < 1) return 1;
        if ($page > $this->countPages) $page = $this->countPages;
        return $page;
    }

    public function getStart(){
        return ($this->currentPage - 1) * $this->perPage;
    }

    public function getHTML(){
        $back = null;
        $forward = null;
        $startPage = null;
        $endPage = null;
        $page2left = null;
        $page1left = null;
        $page2right = null;
        $page1right = null;

        if ($this->currentPage > 1){
            $back = "<li><a class='nav-link' href='{$this->uri}?page=" . $this->currentPage - 1 . "'>&lt;</a></li>";
        }
        if ($this->currentPage < $this->countPages){
            $forward = "<li><a class='nav-link' href='{$this->uri}?page=" . $this->currentPage + 1 . "'>&gt;</a></li>";
        }
        if ($this->currentPage > 3){
            $startPage = "<li><a class='nav-link' href='{$this->uri}?page=1'>&laquo;</a></li>";
        }
        if ($this->currentPage > ($this->currentPage - 2)){
            $endPage = "<li><a class='nav-link' href='{$this->uri}?page=". $this->currentPage + 1 . ">&raquo;</a></li>";
        }
        if ($this->currentPage - 2 > 0){
            $page2left = "<li><a class='nav-link' href='{$this->uri}?page=" . $this->currentPage - 2 . "'>$this->currentPage - 2</a></li>";
        }
        if ($this->currentPage - 1 > 0){
            $page1left = "<li><a class='nav-link' href='{$this->uri}?page=" . $this->currentPage - 1 . "'>$this->currentPage - 1</a></li>";
        }
        if ($this->currentPage + 2 > 0){
            $page2right = "<li><a class='nav-link' href='{$this->uri}?page=" . $this->currentPage + 2 . "'>$this->currentPage + 2</a></li>";
        }
        if ($this->currentPage + 1 > 0){
            $page1right = "<li><a class='nav-link' href='{$this->uri}?page=" . $this->currentPage + 1 . "'>$this->currentPage + 1</a></li>";
        }
        return '<ul class="pagination">' . $startPage . $back . $page2left . $page1left . '<li class="active"><a>' . $this->currentPage . '</a></li>' . $page1right . $page2right . $forward . $endPage . '</ul>';

    }

    public function __toString()
    {
        return $this->getHTML();
    }

}