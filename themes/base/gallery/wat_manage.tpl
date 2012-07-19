<table class="forum" cellpadding="0" cellspacing="{page:cellspacig}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="5">{lang:mod_name} - {lang:watermark}</td>
  </tr>
  {manage:head}
  <tr>
    <td class="leftb" colspan="2">{icon:editpaste} <a href="{url:gallery_wat_create}">{lang:new_watermark}</a></td>
    <td class="leftb" colspan="2">{icon:contents} {lang:total}: {head:count}</td>
    <td class="rightb" colspan="1">{head:pages}</td>
  </tr>
</table>
<br />

{head:getmsg}

<table class="forum" cellpadding="0" cellspacing="{page:cellspacig}" style="width:{page:width}">
  <tr>
    <td class="headb">{sort:id} {lang:watermark}</td>
    <td class="headb">{sort:name} {lang:name}</td>
    <td class="headb">{lang:options}</td>
  </tr>
  {loop:watermarks}
  <tr>
    <td class="leftc" style="width:110px">{watermarks:img}</td>
    <td class="leftc">{watermarks:name}</td>
    <td class="leftc" style="width:40px">
      <a href="{url:gallery_wat_edit:id={watermarks:id}}" title="{lang:edit}">{icon:edit}</a>
      <a href="{url:gallery_wat_remove:id={watermarks:id}}" title="{lang:remove}">{icon:editdelete}</a>
    </td>
  </tr>
  {stop:watermarks}
</table>