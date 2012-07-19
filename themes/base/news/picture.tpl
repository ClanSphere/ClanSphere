<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb" colspan="2">{lang:mod_name} - {lang:picture}</td>
 </tr>
 <tr>
  <td class="leftb">{head:topline}</td>
  <td class="rightb"><a href="{url:news_manage}">{lang:manage}</a></td>
 </tr>
</table>
<br />

<form method="post" action="{url:news_picture}" enctype="multipart/form-data">
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="leftc" style="width:140px">{icon:download} {lang:upload}</td>
  <td class="leftb"><input type="file" name="picture" value="" /><br /><br />{head:infobox}</td>
 </tr>
 <tr>
  <td class="leftc">{icon:ksysguard} {lang:options}</td>
  <td class="leftb">
   <input type="hidden" name="id" value="{head:news_id}" />
   <input type="submit" name="submit" value="{lang:submit}" />
  </td>
 </tr>
 </table>
</form>
<br />

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="leftc" style="width:140px">{icon:images} {lang:current}</td>
  <td class="leftb">{loop:pictures}
    {pictures:view_link} {pictures:remove_link}
    <br /><br />{stop:pictures}
  </td>
 </tr>
</table>