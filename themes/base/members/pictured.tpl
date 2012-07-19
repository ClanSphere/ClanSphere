<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb" colspan="2">{head:mod} - {lang:head_pictured}</td>
  </tr>
  <tr>
    <td class="leftb">{head:body}</td>
    <td class="rightb"><a href="{url:members_list}">{lang:list}</a></td>
  </tr>
</table>
<br />

{loop:squads}
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb" colspan="4">
      <div style="float:left">{squads:games_img} {squads:squad_name}</div>
      <div style="float:right">{squads:count_members} {lang:members}</div>
    </td>
  </tr>
  <tr>
  {loop:members}
    <td class="centerb" style="width:25%">
      <br />
      {members:picture}
    </td>
    <td class="leftc" style="width:25%">      
      {members:country} {members:nick}<br />
      <br />
      {members:surname}<br />
      <br />
      {lang:task}: {members:task}<br />
      <br />
      {lang:since}: {members:since}      
    </td>
    {if:td}
    <td class="centerb" style="width:25%"></td>
    <td class="leftc" style="width:25%"></td>
    {stop:td}
  {if:end_row}
  </tr>
  <tr>
  {stop:end_row}
  {stop:members}
  </tr>
</table>
<br />
{stop:squads}
