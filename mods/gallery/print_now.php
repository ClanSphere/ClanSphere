<?PHP
// ClanSphere 2008 - www.clansphere.net
// $Id$

//$cs_lang = cs_translate('gallery');

?>
<SCRIPT LANGUAGE="JavaScript">
<!--
if (window.print) {
window.print();
setTimeout('self.close()',5000);
}
//-->
</SCRIPT>

<?PHP
if(!empty($_REQUEST['pic'])) 
{
  $pic = $_REQUEST['pic'];
  $size = $_REQUEST['size'];
  
  echo "<img src=\"image.php?pic=$pic&size=$size class=\"mediumimage\" border=\"0\" alt=\"\">";
}
else
{
?>
  <SCRIPT LANGUAGE="JavaScript">
  <!--
  setTimeout('self.close()',2000);
  //-->
  </SCRIPT>
<?PHP
echo 'bye bye';
}
?>