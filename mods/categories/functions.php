<?php

function cs_categories_create($mod, $categories_name) {

    $return = 0;

    if (empty($categories_name)) return 0;

    $get = "categories_mod='" . $mod . "' AND categories_name = '" . cs_sql_escape($categories_name) . "'";
    $get_data = cs_sql_select(__FILE__,'categories','categories_id',$get,'categories_name');
    if(empty($get_data['categories_id'])) {
        $columns = array('categories_mod','categories_name');
        $values = array($mod, $categories_name);
        cs_sql_insert(__FILE__,'categories',$columns,$values);

        $find = "categories_mod='" . $mod . "' AND categories_name = '" . cs_sql_escape($categories_name) . "'";
        $find_data = cs_sql_select(__FILE__,'categories','categories_id',$find,'categories_name');
        $return = $find_data['categories_id'];
    }
    else {
        $return = $get_data['categories_id'];
    }
    return $return;
}

function cs_categories_dropdown($mod, $categories_id) {

    global $account;
    $where = "categories_mod='" . $mod . "'";
    $list_data = cs_sql_select(__FILE__,'categories','categories_id, categories_name',$where,'categories_order ASC, categories_name',0,0);

    $data = array();
    $data['categories']['dropdown'] = cs_dropdown('categories_id','categories_name',$list_data,$categories_id);
    $data['if']['cat_access'] = ($account['access_categories'] >= 3) ? true : false;

    return cs_subtemplate(__FILE__,$data,'categories','cat_dropdown');
}

function cs_categories_dropdown2($mod, $categories_id = 0, $new = 1, $name = 'categories_id') {

    global $account;
    $data = array();
    $cells = 'categories_id, categories_name, categories_subid';
    $categories = cs_sql_select(__FILE__,'categories',$cells,"categories_mod = '".$mod. "' AND categories_access <= '" . $account['access_news'] . "'",'categories_subid ASC, categories_name',0,0);
    $categories = cs_catsort($categories);

    $data['categories']['options'] = '';
    if (!empty($categories)) {
        foreach ($categories AS $cat) {
            $blank = '';
            if (!empty($cat['layer'])) {
                for ($i = 0; $i < $cat['layer']; $i++) { $blank .= '&nbsp;&nbsp;'; }
                $blank .= '&raquo;';
            }
            $data['categories']['options'] .= cs_html_option($blank . $cat['categories_name'],$cat['categories_id'], $cat['categories_id'] == $categories_id);
        }
    }

    $data['if']['new'] = !empty($new) ? TRUE : FALSE;
    $data['dropdown']['name'] = $name;
    return cs_subtemplate(__FILE__,$data,'categories','cat_dropdown2');
}

function cs_catsort ($array, $id = 0) {

    if (empty($array)) return 0;

    $count = count($array);
    $result = array();
    $alrdy_looped = array();
    $subid = 0;
    $order = 1;

    for ($i = 0; $i < $count; $i++) {
        if (empty($array[$i]['categories_subid'])) {
            $array[$i]['layer'] = 0;
            $result[] = $array[$i];
        } else {
            if ($array[$i]['categories_subid'] != $subid) {
                $order = 1;
                $subid = $array[$i]['categories_subid'];
            }
            $pos = multiarray_search($result, 'categories_id', $array[$i]['categories_subid']);
            if ($pos === false) {
                if (in_array($array[$i], $alrdy_looped)) {
                    $array[$i]['layer'] = 0;
                    $result[] = $array[$i];
                    continue;
                }
                $count++;
                $array[] = $array[$i];
                $alrdy_looped[] = $array[$i];
                continue;
            }
            $array[$i]['layer'] = $result[$pos]['layer'] + 1;
            $result = array_merge(array_slice($result, 0, $pos + $order), array($array[$i]), array_slice($result, $pos + $order));
            $order++;
        }
    }

    $start = 0;
    if (!empty($id)) { // Get right (sub)categories
        $count = count($result);
        for ($i = 0; $i < $count; $i++) {
            if ($id == $result[$i]['categories_id']) {
                $layer = $result[$i]['layer'];
                $name = $result[$i]['categories_name'];
                $start = $i;
            } elseif (isset($layer) && $result[$i]['layer'] <= $layer) {
                $end = $i;
                break;
            }
        }
        $end = !empty($end) ? $end - $start : $count;
        $result = array_slice($result,$start,$end);
    }

    return $result;
}

function cs_catspaces ($count = 0, $letter = '&nbsp;&nbsp;') {

    if (empty($count)) return '';
    $string = '';
    for ($i = 0; $i < $count; $i++) {
        $string .= $letter;
    }
    return $string;
}

function multiarray_search ($array, $innerkey, $value) {

    foreach ($array AS $outerkey => $innerarray) {
        if ($innerarray[$innerkey] == $value)
        return $outerkey;
    }
    return FALSE;
}