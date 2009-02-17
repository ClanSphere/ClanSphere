<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

$cs_lang = cs_translate('links');

$links_count = cs_sql_count(__FILE__,'links'); 
        
        echo cs_html_table(1,'forum',1);
        echo cs_html_roco(1,'headb');
        echo $cs_lang['mod'] .' - '. $cs_lang['head'];
        echo cs_html_roco(0);
        echo cs_html_roco(1,'leftb');
        echo sprintf($cs_lang['body_list'], $links_count);
        echo cs_html_roco(0);
        echo cs_html_table(0);
        echo cs_html_br(1);


$categories_data = cs_sql_select(__FILE__,'categories','*',"categories_mod = 'links'",'categories_name',0,0);
$categories_loop = count($categories_data);

for($run=0; $run<$categories_loop; $run++) {
        
        
  echo cs_html_table(1,'forum',1);
  echo cs_html_roco(1,'headb');
  echo cs_link(cs_secure($categories_data[$run]['categories_name']),'links','listcat','id=' . $categories_data[$run]['categories_id']);
  $content = cs_sql_count(__FILE__,'links','categories_id = ' .$categories_data[$run]['categories_id']);
  echo ' ('. $content .')';
  echo cs_html_roco(0);
  
  
  echo cs_html_roco(1,'leftb');
  echo cs_secure($categories_data[$run]['categories_text'],1,1);
  echo cs_html_roco(0);
  echo cs_html_table(0);
  echo cs_html_br(2);
} 


?>
