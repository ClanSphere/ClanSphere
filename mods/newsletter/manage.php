<? 

$cs_lang = cs_translate('newsletter');

empty($_REQUEST['start']) ? $start = 0 : $start = $_REQUEST['start'];
$cs_sort[1] = 'newsletter_time DESC';
$cs_sort[2] = 'newsletter_time ASC'; 
$cs_sort[3] = 'users_nick DESC';
$cs_sort[4] = 'users_nick ASC';
empty($_REQUEST['sort']) ? $sort = 1 : $sort = $_REQUEST['sort'];
$order = $cs_sort[$sort];
$newsletter_count = cs_sql_count(__FILE__,'newsletter');


echo cs_html_table(1,'forum',1);
echo cs_html_roco(1,'headb',0,3);
echo $cs_lang['head_manage'];
echo cs_html_roco(0);
echo cs_html_roco(1,'leftb');
echo cs_icon('editpaste') . cs_link($cs_lang['new_manage'],'newsletter','create');
echo cs_html_roco(2,'leftb');
echo cs_icon('contents') . $cs_lang['total'] . ': ' . $newsletter_count;
echo cs_html_roco(2,'rightb');
echo cs_pages('newsletter','manage',$newsletter_count,$start,0,$sort);
echo cs_html_roco(0);


//Tabele
echo cs_html_roco(0);
echo cs_html_table(0);
echo cs_html_br(1);

echo cs_getmsg();

echo cs_html_table(1,'forum',1);
//echo cs_html_roco(1,'headb');
//echo $cs_lang['to'];
echo cs_html_roco(1,'headb');
echo cs_sort('newsletter','manage',$start,0,3,$sort);
echo $cs_lang['from'];
echo cs_html_roco(2,'headb');
echo $cs_lang['subject'];
echo cs_html_roco(3,'headb');
echo cs_sort('newsletter','manage',$start,0,1,$sort);
echo $cs_lang['date'];
echo cs_html_roco(4,'headb',1,2);
echo $cs_lang['options'];
echo cs_html_roco(0);

//sql
$from = 'newsletter nwl INNER JOIN {pre}_users usr ON nwl.users_id = usr.users_id ';
$select = 'nwl.newsletter_id AS newsletter_id, nwl.newsletter_subject AS newsletter_subject, nwl.newsletter_time AS newsletter_time, nwl.newsletter_text AS newsletter_text, nwl.newsletter_to AS newsletter_to, nwl.users_id AS users_id, usr.users_nick AS users_nick';
$cs_newsletter = cs_sql_select(__FILE__,$from,$select,0,$order,$start,$account['users_limit']);

$newsletter_loop = count($cs_newsletter);
for($run=0; $run<$newsletter_loop; $run++) 

{
	//echo cs_html_roco(1,'leftc');
	//echo $cs_newsletter[$run]['newsletter_to'];
	echo cs_html_roco(1,'leftc');
	echo $cs_newsletter[$run]['users_nick'];
	echo cs_html_roco(2,'leftc');
	echo $cs_newsletter[$run]['newsletter_subject'];
	echo cs_html_roco(3,'leftc');
	echo cs_date('unix',$cs_newsletter[$run]['newsletter_time'],1);
	echo cs_html_roco(4,'centerc');
	$newsletter_id = $cs_newsletter[$run]['newsletter_id'];
	echo cs_link(cs_icon('info'),'newsletter','view','id='.$newsletter_id); 
	echo cs_html_roco(4,'centerc'); 
	echo cs_link(cs_icon('cancel'),'newsletter','remove','id=' .$newsletter_id);
	echo cs_html_roco(0);
}

echo cs_html_table(0);
?>