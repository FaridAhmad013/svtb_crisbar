<?php

namespace App\Helpers;

use App\Helpers\AuthCommon;


class Menu
{
    public $html = '';
    public $permission = [];




    public function init()
    {
        $this->html = '<div class="" id="sidenav-collapse-main">';
        return $this;
    }

    public function item($title, $icon, $url, $isActive, $assign)
    {
        if (is_array($assign) && in_array(AuthCommon::user()->role->role, $assign)) {
            $this->html .= '<li class="w-full">
                <a class="w-full text-gray-700 w-full block p-3 text-xs' . ($isActive ? ' bg-red-300 text-white font-bold rounded-lg shadow' : '') . '" href="' . url($url) . '">
                    <i class="' . $icon . '"></i>
                    <span class="ml-2">' . $title . '</span>
                </a>
            </li>';
        }

        return $this;
    }

    public function divinder($title, $assign)
    {
        if (is_array($assign)) {
            if (in_array(AuthCommon::user()->role->role, $assign)) {
                $this->html .= '
                <h6 class="navbar-heading p-0 font-bold text-gray-400 my-3 tracking-wide text-xs uppercase">
                  <span class="docs-normal">' . $title . '</span>
                </h6>';
            }

        }
        return $this;

    }

    public function start_group()
    {
        $this->html .= '<ul class="navbar-nav">';
        return $this;
    }

    public function end_group()
    {
        $this->html .= '</ul>';
        return $this;
    }

    public function to_html()
    {
        $this->html .= '</div>';
        return $this->html;
    }
}
