<div class="container" style="width:{page:width}">
  <div class="headb">{lang:mod} - {lang:picture}</div>
 <div class="headc clearfix">
  <div class="leftb fl">{head:topline}</div>
  <div class="rightb fr"><a href="{url:news_manage}">{lang:manage}</a></div>
 </div>
</div>
<br />

<form method="post" action="{url:news_picture}" enctype="multipart/form-data">
<table class="forum" cellpadding="0" cellspacing="1" style="width:{page:width}">
 <tr>
  <td class="leftc" style="width:140px">{icon:download} {lang:upload}</td>
  <td class="leftb"><input type="file" name="picture" value=""  /><br /><br />{head:infobox}</td>
 </tr>
 <tr>
  <td class="leftc">{icon:ksysguard} {lang:options}</td>
  <td class="leftb">
   <input type="hidden" name="id" value="{head:news_id}"  />
   <input type="submit" name="submit" value="{lang:submit}"  />
  </td>
 </tr>
 </table>
</form>
<br />

<table class="forum" cellpadding="0" cellspacing="1" style="width:{page:width}">
 <tr>
  <td class="leftc" style="width:140px">{icon:images} {lang:current}</td>
  <td class="leftb">{loop:pictures}
    {pictures:view_link} {pictures:remove_link}
    <br /><br />{stop:pictures}
  </td>
 </tr>
</table>