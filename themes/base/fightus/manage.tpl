<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="3">{lang:mod_name} - {lang:manage}</td>
  </tr>
  <tr>
    <td class="leftb">{icon:editpaste} <a href="{url:fightus_new}">{lang:new_fight}</a></td>
    <td class="leftb">{icon:contents} {lang:total}: {head:count}</td>
    <td class="rightb">{head:pages}</td>
  </tr>
</table>
<br />

{head:getmsg}

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:game}</td>
    <td class="headb">{sort:clan} {lang:clan}</td>
    <td class="headb">{sort:date} {lang:fight_date}</td>
    <td class="headb" colspan="3">{lang:options}</td>
  </tr>
  {loop:fightus}
  <tr>
    <td class="leftc">{fightus:game}</td>
    <td class="leftc"><a href="{fightus:url_view}">{fightus:clan}</a></td>
    <td class="leftc">{fightus:date}</td>
    <td class="leftc"><a href="{fightus:url_convert_clan}" title="{lang:convert_clan}">{icon:convert_clan}</a></td>
    <td class="leftc"><a href="{fightus:url_convert_war}" title="{lang:convert_war}">{icon:convert_war}</a></td>
    <td class="leftc"><a href="{fightus:url_remove}" title="{lang:remove}">{icon:editdelete}</a></td>
  </tr>
  {stop:fightus}
</table>