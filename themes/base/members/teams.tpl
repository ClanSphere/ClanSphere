<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:head_list} </td>
  </tr>
  <tr>
    <td class="leftb">{lang:body}</td>
  </tr>
</table>
<br />
{loop:members}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="centerb" rowspan="3" style="width:30%">{members:pic}</td>
    <td class="leftc" style="width:20%">{lang:name}</td>
    <td class="leftb">{members:icon} {members:name} </td>
  </tr>
  {if:game}
  <tr>
    <td class="leftc">{lang:game}</td>
    <td class="leftb">{members:game}</td>
  </tr>
  {stop:game}
  <tr>
    <td class="leftc"> {lang:members}</td>
    <td class="leftb">{loop:squad_members}{squad_members:members}{squad_members:dot}{stop:squad_members}</td>
  </tr>
</table>
<br />
{stop:members}