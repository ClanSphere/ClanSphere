<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="2">{lang:mod} - {lang:center}</td>
  </tr>
  <tr>
    <td class="leftc">{lang:take_part_in_cups}</td>
    <td class="rightc"><a href="{url:cups_list}">{lang:list}</a></td>
  </tr>
</table>
<br />

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:game}</td>
    <td class="headb">{lang:name}</td>
    <td class="headb">{lang:next_match}</td>
  </tr>{loop:cups}
  <tr>
    <td class="leftb">{if:gameicon_exists}<img src="{page:path}uploads/games/{cups:games_id}.gif" alt="" />{stop:gameicon_exists}</td>
    <td class="leftb"><a href="{url:cups_view:id={cups:cups_id}}">{cups:cups_name}</a></td>
    <td class="leftb">{cups:nextmatch}</td>
  </tr>{stop:cups}
</table>
