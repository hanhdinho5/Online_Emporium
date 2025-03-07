<?php


    function has_child($data, $id)
    {
        foreach ($data as $v) {
            if ($v['parent_id'] == $id)
                return true;
        }
        return false;
    }

    function render_menu($data, $menu_id = 'list-item', $menu_class = '', $parent_id = 0, $level = 0)
    {
        if ($level == 0)
            $result = "<ul class='{$menu_id}'>";
        else
            $result = "<ul class='{$menu_class}'>";
        $url = url('');
        foreach ($data as $v) {
            if ($v['parent_id'] == $parent_id) {
                $v['level'] = $level;
                $result .= "<li>";
                if ($parent_id == 0)
                    $result .= "<a href='{$url}/dm-san-pham/{$v['slug']}/{$v['id']}'>{$v['name']}</a>";
                else
                    $result .= "<a href='{$url}/seach-dm/?k={$v['name']}'>{$v['name']}</a>";

                if (has_child($data, $v['id'])) {
                    $result .= render_menu($data, '', $menu_class, $v['id'], $level + 1);
                }
                $result .= "</li>";
            }
        }
        $result .= "</ul>";
        return $result;
    }

    function data_tree($data_src, $parent_id = 0, $level = 0)
    {
        $result = array();
        foreach ($data_src as $item) {
            if ($item['parent_id'] == $parent_id) {
                $item['level'] = $level;
                $result[] = $item;
                $child = data_tree($data_src, $item['id'], $level + 1);
                $result = array_merge($result, $child);
            }
        }
        return $result;
    }
