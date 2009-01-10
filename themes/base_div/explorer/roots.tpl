<div class="container" style="width:{page:width}">
  <div class="headb">{lang:explorer} - {lang:manage}</div>
 <div class="headc clearfix">
  <div class="leftc fl">{icon:editpaste} {link:new_file}</div>
  <div class="leftc fl">{icon:folder_yellow} {link:new_dir}</div>
  <div class="leftc fl">{icon:download} {link:upload_file}</div>
  <div class="rightc fr">{pages:show}</div>
 </div>
</div>
<br />
{lang:getmsg}
<table class="forum" cellpadding="0" cellspacing="1" style="width:{page:width}">
 <tr>
  <td class="headb">{lang:type}</td>
  <td class="headb">{lang:name}</td>
  <td class="headb">{lang:chmod}</td>
  <td class="headb" colspan="4">{lang:options}</td>
 </tr>
 <tr>
  <td class="leftc" colspan="7">{icon:fileopen} {path:show}</td>
 </tr>
{loop:files}
 <tr>
  <td class="leftb">{files:symbol}</td>
  <td class="leftb">{files:name}</td>
  <td class="leftb">{files:chmod}</td>
  <td class="leftb">{files:edit}</td>
  <td class="leftb">{files:remove}</td>
  <td class="leftb">{files:access}</td>
  <td class="leftb">{files:info}</td>
 </tr>
{stop:files}
</table>