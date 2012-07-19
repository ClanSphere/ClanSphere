<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('partner');
$data['categories'] = array();
$op_partner = cs_sql_option(__FILE__,'partner');
$data['partner']['list_width'] = ($op_partner['def_width_listimg'] + 20);

$categories_select = 'categories_name, categories_id, categories_order';
$categories_order = 'categories_order DESC';
$categories_data = cs_sql_select(__FILE__,'categories',$categories_select,"categories_mod = 'partner'",$categories_order,0,0);
$categories_loop = count($categories_data);

for($run=0; $run<$categories_loop; $run++) {

    $data['categories'][$run]['categories_name'] = $categories_data[$run]['categories_name'];
    $categories_id = $categories_data[$run]['categories_id'];
    
  $data['categories'][$run]['partner'] = array();

    $select = 'partner_id, partner_name, partner_url, partner_text, partner_alt, partner_limg';
    $order = 'partner_priority ASC';
    $where = "categories_id = '".$categories_id."'";
    $cs_partner = cs_sql_select(__FILE__,'partner',$select,$where,$order,0,0);
    $partner_loop = count($cs_partner);

    for($run2=0; $run2<$partner_loop; $run2++) {
    
        $data['categories'][$run]['partner'][$run2]['partner_name'] = cs_html_link('http://'.$cs_partner[$run2]['partner_url'],cs_secure($cs_partner[$run2]['partner_name']));
        $data['categories'][$run]['partner'][$run2]['partner_text'] = cs_secure($cs_partner[$run2]['partner_text'],1);
        $data['categories'][$run]['partner'][$run2]['partner_alt'] = cs_secure($cs_partner[$run2]['partner_alt']);
        $place ="uploads/partner/";
        $data['categories'][$run]['partner'][$run2]['partner_limg'] = cs_html_link('http://'.$cs_partner[$run2]['partner_url'],cs_html_img($place.$cs_partner[$run2]['partner_limg'],0,0,0,$cs_partner[$run2]['partner_alt']));
    }

}
echo cs_subtemplate(__FILE__,$data,'partner','list');