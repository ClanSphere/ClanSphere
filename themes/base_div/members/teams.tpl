<div class="container" style="width:{page:width}">
    <div class="headb">{lang:mod} - {lang:head_list} </div>
    <div class="leftb">{lang:body}</div>
</div>
{loop:members}
<table class="forum" cellpadding="0" cellspacing="1" style="width:{page:width}">
  <tr>
    <td class="centerb" rowspan="3" style="width:30%">{members:pic}</td>
    <td class="leftc" style="width:20%">{lang:name}</td>
    <td class="leftb">{members:icon} {members:name} </td>
  </tr>
  <tr>
    <td class="leftc"> {lang:game}</td>
    <td class="leftb">{members:game}</td>
  </tr>
  <tr>
    <td class="leftc"> {lang:members}</td>
    <td class="leftb">{loop:squad_members}{squad_members:members}{squad_members:dot}{stop:squad_members}</td>
  </tr>
</table>
<br />
{stop:members}