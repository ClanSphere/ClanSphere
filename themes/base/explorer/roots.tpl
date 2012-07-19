<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb" colspan="4">{lang:explorer} - {lang:manage}</td>
 </tr>
 <tr>
  <td class="leftb">{icon:editpaste} {link:new_file}</td>
  <td class="leftb">{icon:folder_yellow} {link:new_dir}</td>
  <td class="leftb">{icon:download} {link:upload_file}</td>
  <td class="leftb">{pages:show}</td>
 </tr>
</table>
<br />
{lang:getmsg}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
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