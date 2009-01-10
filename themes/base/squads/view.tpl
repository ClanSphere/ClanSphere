<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb">{lang:mod} - {lang:head_list}</td>
 </tr>
 <tr>
  <td class="leftb">{lang:part_of}</td>
 </tr>
</table>
<br />

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb" colspan="5">
    <div style="float:left">{game:icon} {squad:squads_name}</div>
    <div style="float:right">{squad:members} {lang:members}</div>
  </td>
 </tr>
 <tr>
  <td class="leftc" style="width:40px">{lang:country}</td>
  <td class="leftc">{lang:nick}</td>
  <td class="leftc">{lang:task}</td>
  <td class="leftc" style="width:80px">{lang:since}</td>
  <td class="leftc" style="width:40px">{lang:page}</td>
 </tr>
 {loop:members}
 <tr>
  <td class="leftb"><img src="{page:path}{members:countrypath}" style="height:11px;width:16px" alt="{members:country}" /></td>
  <td class="leftb"><a href="{url:users_view:id={members:users_id}}">{members:users_nick_tag}</a></td>
  <td class="leftb">{members:members_task}</td>
  <td class="leftb">{members:members_since}</td>
  <td class="leftb"><img src="{page:path}{members:page}" alt="" /></td>
 </tr>
 {stop:members}
</table>