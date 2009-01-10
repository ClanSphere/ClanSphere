<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('files');

echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb');
echo $cs_lang['mod'];
echo cs_html_roco(0);
echo cs_html_roco(1,'leftb');
echo $cs_lang['mod_list'];
echo cs_html_roco(0);
echo cs_html_table(0);
echo cs_html_br(1);

$where = "categories_mod = 'files' AND categories_access <= '" . $account['access_files'] . "' AND categories_subid = '0'";
$categories_data = cs_sql_select(__FILE__,'categories','*',$where,'categories_name',0,0);
$categories_loop = count($categories_data);

for($run=0; $run<$categories_loop; $run++) {

  echo cs_html_table(1,'forum',1);
  echo cs_html_roco(1,'headb');
  echo cs_link(cs_secure($categories_data[$run]['categories_name']),'files','listcat','where=' . 		 $categories_data[$run]['categories_id']);
  $content = cs_sql_count(__FILE__,'files',"categories_id = '" . $categories_data[$run]['categories_id'] . "'");
  echo ' ('. $content .')';
  echo cs_html_roco(0);

  if(!empty($categories_data[$run]['categories_text'])) {
    echo cs_html_roco(1,'leftb');
	echo cs_secure($categories_data[$run]['categories_text'],1);
	echo cs_html_roco(0);
  }
  
  $sub_where = "categories_mod = 'files' AND categories_access <= '" . $account['access_files'] . "'";
  $sub_where .= " AND categories_subid = '" . $categories_data[$run]['categories_id'] . "'";
  $sub_data = cs_sql_select(__FILE__,'categories','*',$sub_where,'categories_name',0,0);
  $sub_loop = count($sub_data);
  if(!empty($sub_loop)) {
    echo cs_html_roco(1,'leftc');
    echo 'Unterkategorien: ';
    for($runb=0; $runb < $sub_loop; $runb++) {
      echo cs_link(cs_secure($sub_data[$runb]['categories_name']),'files','listcat','where=' . $sub_data[$runb]['categories_id']);
	  $sub_content = cs_sql_count(__FILE__,'files',"categories_id = '" . $sub_data[$runb]['categories_id'] . "'");
	  echo ' (' . $sub_content . ')';
	  if($runb == $sub_loop -1) { } else { echo ', '; }
    }
    echo cs_html_roco(0);
  }
  echo cs_html_table(0);
  echo cs_html_br(1);
}
?>