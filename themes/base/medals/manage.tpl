<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="2">{lang:mod_name} - {lang:manage}</td>
  </tr>
  <tr>    
    <td class="leftb">{icon:contents} {lang:total}: {count:medals}</td>
  <td class="rightb">{pages:list}</td>
  </tr>
</table>
<br />
{message:medals}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{sort:name} {lang:name}</td>
    <td class="headb">{lang:user}</td>
    <td class="headb" colspan="3">{lang:options}</td>
  </tr>{loop:medals}
  <tr>
    <td class="leftc">{medals:medals_name}</td>
    <td class="leftc">{medals:count_user} {lang:awarded}</td>
    <td class="leftc"><a href="{medals:view_user}">{icon:kdmconfig}</a></td>
    <td class="leftc"><a href="{medals:edit_url}">{icon:edit}</a></td>
    <td class="leftc"><a href="{medals:remove_url}">{icon:editdelete}</a></td>
  </tr>{stop:medals}
</table>