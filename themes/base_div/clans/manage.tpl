<div class="container" style="width:{page:width}">
  <div class="headb">{lang:mod} - {lang:manage}</div>
 <div class="headc clearfix">
  <div class="leftb fl">{icon:editpaste} <a href="{url:clans_create}">{lang:new_clan}</a></div>
  <div class="rightb fr">{pages:list}</div>
 </div>
 <div class="headc clearfix">
  <div class="leftb fl">{icon:package_settings} <a href="{url:clans_options}">{lang:options}</a></div>
  <div class="leftb fr">{icon:contents} {lang:total}: {count:all}</div>
 </div>
</div>
<br />
{head:message}
<table class="forum" cellpadding="0" cellspacing="1" style="width:{page:width}">
 <tr>
  <td class="headb">{sort:name} {lang:name}</td>
  <td class="headb">{sort:short} {lang:short}</td>
  <td class="headb" colspan="2">{lang:options}</td>
 </tr>{loop:clans}
 <tr>
  <td class="leftc">{clans:name}</td>
  <td class="leftc">{clans:short}</td>
  <td class="leftc">{clans:edit}</td>
  <td class="leftc">{clans:remove}</td>
 </tr>{stop:clans}
</table>