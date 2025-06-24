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
          $this->html .= '<li>
            <a class="text-gray-600 tracking-wide leading-[1.5] w-auto block text-sm px-3 py-2 hover:bg-red-300 hover:text-white hover:rounded-lg mb-2' . ($isActive ? ' bg-red-300 text-white font-bold rounded-lg shadow py-3' : '') . '" href="' . url($url) . '">
              <i class="' . $icon . '"></i>
              <span class="menu-text ml-2">' . $title . '</span>
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
          <hr class="mt-3 border border-gray-100 rounded-lg">
          <h6 class="navbar-heading menu-text px-3 py-2 font-bold text-gray-400  tracking-wide text-sm uppercase">
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
