<?php
// ClanSphere 2008 - www.clansphere.net
// $Id$

function cs_lanroom($mod,$action,$lanrooms_id,$lanroomd_id = 0,$free = 0) {
  $cs_lang = cs_translate('lanrooms');

  $from = "lanroomd lrd LEFT JOIN {pre}_languests lgs ON lrd.lanroomd_id = lgs.lanroomd_id LEFT JOIN {pre}_users usr ON lgs.users_id = usr.users_id";
  $select = "lrd.lanroomd_col AS lanroomd_col, lrd.lanroomd_row AS lanroomd_row, lrd.lanroomd_number AS lanroomd_number, usr.users_nick AS users_nick, usr.users_id AS users_id, lrd.lanroomd_id AS lanroomd_id";
  $order = 'lrd.lanroomd_row ASC, lrd.lanroomd_col ASC';
  settype($lanrooms_id,'integer');
  $lanroomd = cs_sql_select(__FILE__,$from,$select,"lrd.lanrooms_id = '" . $lanrooms_id . "'",$order,0,0);
  $lanroomd_loop = count($lanroomd);

  if(empty($lanroomd_loop)) {
    $var = $cs_lang['room_empty'];
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

    $var = cs_html_table(2,0,2);
    $var .= cs_html_roco(1,'center');
    $var .= cs_html_roco(2,'center');
    $gow = 'A';
    
	for($go = 1; $go <= $max_col[0]; $go++) {
      $var .= cs_html_roco(2,'center',0,0,'15px');
      $var .= $gow++;
    }
    $var .= cs_html_roco(1,'left',0,$max_col[0] + 2);
    $var .= cs_html_img('symbols/clansphere/empty.gif',12,12);

    while($run < $lanroomd_loop) {
      if($col == $max_col[0]) {
        $var .= cs_html_roco(0);
		$var .= cs_html_roco(1,'right');
		$var .= ++$row;
		$var .= cs_html_roco(2,'center');
		$var .= cs_html_img('symbols/clansphere/empty.gif',12,12);
		$col = 0;
      }
      $col++;
      $var .= cs_html_roco(2,'center',0,0,'15px');
      $content = $lanroomd[$run]['lanroomd_number'] . ' - ';
      
	  if($lanroomd[$run]['lanroomd_row'] == $row AND $lanroomd[$run]['lanroomd_col'] == $col) {
        if($lanroomd[$run]['lanroomd_id'] == $lanroomd_id) {
          $content .= empty($free) ? $cs_lang['search'] : $cs_lang['self'];
          $img = cs_html_img('symbols/clansphere/green.gif',0,0,'title="' . $content . '"');
		  $var .= cs_link($img,'users','view','id=' . $lanroomd[$run]['users_id']);
        }
        elseif(empty($lanroomd[$run]['users_id'])) {
          $content .= $cs_lang['free'];
          $img = cs_html_img('symbols/clansphere/grey.gif',0,0,'title="' . $content . '"');
          $get = cs_link($img,$mod,$action,$free . '=' . $lanroomd[$run]['lanroomd_id']);
          $var .= empty($free) ? $img : $get;
        }
        else {
          $content .= sprintf($cs_lang['used'], $lanroomd[$run]['users_nick']);
          $img = cs_html_img('symbols/clansphere/red.gif',0,0,'title="' . $content . '"');
          $var .= cs_link($img,'users','view','id=' . $lanroomd[$run]['users_id']);
        }
        $run++;
      }
    }
    $var .= cs_html_roco(0);
    $var .= cs_html_table(0);
  }
  return $var;
}
?>
