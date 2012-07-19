<?PHP
// ClanSphere 2010 - www.clansphere.net
// $Id$

function cs_search($mod) {
  $cs_lang = cs_translate('search');

  $data = array();
  $data['search']['mod'] = $mod;
  
 echo cs_subtemplate(__FILE__,$data,'search','search_function');
}