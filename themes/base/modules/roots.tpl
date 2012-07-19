<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb" colspan="4">{lang:mod_name} - {lang:manage}</td>
  </tr>
  <tr>
    <td class="leftb">{icon:editpaste} <a href="{url:modules_create}">{lang:new_module}</a></td>
    <td class="centerb">{icon:contents} {lang:total}: {head:count}</td>
    <td class="centerb">{icon:ark} <a href="{url:clansphere_cache}">{lang:cache}</a></td>
    <td class="rightb"><a href="http://mods.clansphere.net" target="_blank">{lang:more_modules}</a></td>
  </tr>
{if:wizard}
    <tr>
        <td class="leftc" colspan="4">{lang:wizard}: {wizard:roots} - {wizard:task_done}</td>
    </tr>
{stop:wizard}
</table>
<br />

{head:getmsg}

<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb">{lang:mod_name}</td>
    <td class="headb">{lang:version}</td>
    <td class="headb">{lang:date}</td>
    <td class="headb" colspan="2">{lang:options}</td>
  </tr>
  {loop:mod}
  <tr>
    <td class="leftc">{mod:icon} {mod:name_url}</td>
    <td class="leftb">{mod:version}</td>
    <td class="leftb">{mod:released}</td>
    <td class="leftb">{mod:protected}</td>
    <td class="leftb">{mod:access}</td>
  </tr>
  {stop:mod}
</table>
