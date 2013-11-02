<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Template
{
    private $page_title = '';
    private $head = '';
    private $foot = '';

    public function getHead()
    {
        return $this->head;
    }

    public function setHead($string)
    {
        $this->head = join(PHP_EOL, array($this->head, $string));
    }

    public function clearHead()
    {
        $this->head = '';
    }

    public function getFoot()
    {
        return $this->foot;
    }

    public function setFoot($string)
    {
        $this->foot = join(PHP_EOL, array($this->foot, $string));
    }

    public function clearFoot()
    {
        $this->foot = '';
    }

    public function getPageTitle()
    {
        return $this->page_title;
    }

    public function setPageTitle($string)
    {
        $this->page_title = $string;
    }

}
