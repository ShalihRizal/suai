<?php

/**
 * Menu Helper
 *
 * Updated 31 Agustus 2021, 09:40
 *
 * @author Digital Robotik Indonesia
 *
 */

namespace App\Helpers;

use Request;
use Illuminate\Support\Facades\Auth;
use Modules\SysMenu\Repositories\SysMenuRepository;

class MenuDashHelper
{

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    // Tambahkan parameter $activeMenu pada fungsi render
    // ...

    public static function render($activeMenu = '')
    {
        $_sysmenuRepository = new SysMenuRepository;

        $getMenus = $_sysmenuRepository->getAllOrderByParams(['menu_is_sub' => 0]);
        $menus = "";

        if (sizeof($getMenus) > 0) {
            foreach ($getMenus as $menu) {
                $getSubs = $_sysmenuRepository->getAllOrderByParams(['menu_parent_id' => $menu->menu_id]);
                $subs = "";
                $subLinks = array();

                // Check Role for the main menu
                $getRole = $_sysmenuRepository->getRole($menu->module_id, Auth::user()->group_id);

                if (!$getRole) {
                    continue;
                }

                // Check if it's the active main menu
                $isActiveMain = self::isActiveMenu($menu->menu_url, $activeMenu);

                $activeMain = $isActiveMain ? 'active' : '';
                $showMain = $isActiveMain ? 'show' : '';

                if (sizeof($getSubs) > 0) {
                    $areSubs = false;

                    foreach ($getSubs as $sub) {
                        // Check Role for the submenu
                        $getRole = $_sysmenuRepository->getRole($sub->module_id, Auth::user()->group_id);

                        if (!$getRole) {
                            continue;
                        }

                        $isActiveSub = self::isActiveMenu($sub->menu_url, $activeMenu);

                        $active = $isActiveSub ? 'active' : '';

                        $subLinks[] = $sub->menu_url;

                        $subs .= "<li class='nav-item" . $active . "'><a class='nav-link pl-3' href='" . url($sub->menu_url) . "'><span class='ml-1 item-text'>" . $sub->menu_name . "</span></a></li>";

                        $areSubs = true;
                    }

                    if (!$areSubs) {
                        continue;
                    }

                    $id_class_replace = str_replace(" ", "", $menu->menu_name);
                    $id_class = substr($id_class_replace, 0, 5);

                    $menus .= "<li class='nav-item dropdown " . $activeMain . "'>
                                    <a href='#" . $id_class . "' data-toggle='collapse' aria-expanded='false' class='dropdown-toggle nav-link'>
                                        <i data-feather='" . $menu->menu_icon . "'></i> <span class='ml-3 item-text'>" . $menu->menu_name . "</span>
                                    </a>
                                    <ul id='" . $id_class . "' class='collapse list-unstyled pl-4 w-100 " . $showMain . "' >
                                        " . $subs . "
                                    </ul>
                                </li>";
                } else {
                    $id_class_replace = str_replace(" ", "", $menu->menu_name);
                    $id_class = substr($id_class_replace, 0, 5);

                    $menus .= "<li class='nav-item w-100 " . $activeMain . "'>
                                    <a class='nav-link' href='" . url($menu->menu_url) . "' aria-expanded='false'>
                                        <i data-feather='" . $menu->menu_icon . "' ></i><span class='ml-3 item-text'>" . $menu->menu_name . "</span>
                                    </a>
                                </li>";
                }
            }
        }

        return $menus;
    }

    public static function isActiveMenu($menuUrl, $activeMenu)
    {
        return $activeMenu == $menuUrl || Request::segment(1) == $menuUrl;
    }
}
