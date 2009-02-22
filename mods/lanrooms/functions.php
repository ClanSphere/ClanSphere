<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

function cs_lanroom($mod,$action,$lanrooms_id,$lanroomd_id = 0,$free = 0) {

  $data = array();
  $cs_lang = cs_translate('lanrooms');
  settype($lanrooms_id,'integer');

  $from = "lanroomd lrd LEFT JOIN {pre}_languests lgs ON lrd.lanroomd_id = lgs.lanroomd_id LEFT JOIN {pre}_users usr ON lgs.users_id = usr.users_id";
  $select = "lrd.lanroomd_col AS lanroomd_col, lrd.lanroomd_row AS lanroomd_row, lrd.lanroomd_number AS lanroomd_number, usr.users_nick AS users_nick, usr.users_id AS users_id, lrd.lanroomd_id AS lanroomd_id";
  $order = 'lrd.lanroomd_row ASC, lrd.lanroomd_col ASC';
  $lanroomd = cs_sql_select(__FILE__,$from,$select,"lrd.lanrooms_id = '" . $lanrooms_id . "'",$order,0,0);
  $lanroomd_loop = count($lanroomd);

  if(empty($lanroomd_loop)) {
    return $cs_lang['room_empty'];
  }
  else {
    $where = "lanrooms_id = '" . $lanrooms_id . "'";
    $get_max_row = cs_sql_select(__FILE__,'lanroomd',"MAX(lanroomd_row)",$where);
    $get_max_col = cs_sql_select(__FILE__,'lanroomd',"MAX(lanroomd_col)",$where);
    $max_row = array_values($get_max_row);
    $max_col = array_values($get_max_col);
    $row = 0;
    $col = $max_col[0];
    $run = 0;
    $gow = 'A';
    
    for($go = 0; $go <= $max_col[0] - 1; $go++) {
      $data['figures'][$go]['abc'] = $gow++;
    }
    
    $data['max']['col'] = $max_col[0] +2;
    $data['img']['empty'] = cs_html_img('symbols/clansphere/empty.gif',12,12);
	  
	  $i = 0;
	  $max_run = $max_col[0] * $max_row[0];
    for($run = 0;$run < $max_run;$run++) {
    	
    	$data['numbers'][$run]['if']['max_col'] = FALSE;
      if($col == $max_col[0]) {
        $data['numbers'][$run]['if']['max_col'] = TRUE;
      	$data['numbers'][$run]['123'] = ++$row;
      	$data['numbers'][$run]['empty'] = cs_html_img('symbols/clansphere/empty.gif',12,12);;
        $col = 0;
      }
      $col++;
      
      $data['numbers'][$run]['output'] = '';
      if(($lanroomd[$i]['lanroomd_row'] == $row) AND $lanroomd[$i]['lanroomd_col'] == $col) {
         $content = $lanroomd[$i]['lanroomd_number'] . ' - ';
         if($lanroomd[$i]['lanroomd_id'] == $lanroomd_id) {
           $content .= empty($free) ? $cs_lang['search'] : $cs_lang['self'];
           $img = cs_html_img('symbols/clansphere/green.gif',0,0,'title="' . $content . '"');
           $data['numbers'][$run]['output'] = cs_link($img,'users','view','id=' . $lanroomd[$i]['users_id']);
         }
         elseif(empty($lanroomd[$i]['users_id'])) {
           $content .= $cs_lang['free'];
           $img = cs_html_img('symbols/clansphere/grey.gif',0,0,'title="' . $content . '"');
           $get = cs_link($img,$mod,$action,$free . '=' . $lanroomd[$i]['lanroomd_id']);
           $data['numbers'][$run]['output'] = empty($free) ? $img : $get;
         }
         else {
           $content .= sprintf($cs_lang['used'], $lanroomd[$i]['users_nick']);
           $img = cs_html_img('symbols/clansphere/red.gif',0,0,'title="' . $content . '"');
           $data['numbers'][$run]['output'] = cs_link($img,'users','view','id=' . $lanroomd[$i]['users_id']);
         }
         $i++;
       }
    }
  }
  return cs_subtemplate(__FILE__,$data,'lanrooms','functions');
}
?>
