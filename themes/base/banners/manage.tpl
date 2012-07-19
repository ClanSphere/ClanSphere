<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="2">{lang:mod_name} - {lang:head_manage}</td>
  </tr>
  <tr>    
    <td class="leftb">{icon:contents} {lang:total}: {count:all}</td>
    <td class="rightb">{pages:list}</td>
  </tr>
</table>
<br />
{lang:getmsg}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{sort:name} {lang:name}</td>
    <td class="headb">{sort:order} {lang:order}</td>
    <td class="headb" colspan="2">{lang:options}</td>
  </tr>
  {loop:banners}
  <tr>
    <td class="leftc">{banners:name}</td>
    <td class="leftc">{banners:order}</td>
    <td class="leftc"><a href="{banners:edit}" title="{lang:edit}">{icon:edit}</a></td>
    <td class="leftc"><a href="{banners:remove}" title="{lang:remove}">{icon:editdelete}</a></td>
  </tr>
  {stop:banners}
</table>
