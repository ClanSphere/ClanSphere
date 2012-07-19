<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb">{lang:mod_name} - {lang:access}</td>
 </tr>
 <tr>
  <td class="leftb">{lang:edit_access}</td>
 </tr>
</table>
<br />

<form method="post" action="{form:url}">
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 {loop:access}
 <tr>
  <td class="leftc">{icon:access}{access:access_name}</td>
  <td class="leftb">
    <select name="access_{access:access_id}">
      <option value="0" {access:sel0}>0 - {lang:lev_0}</option>
      <option value="1" {access:sel1}>1 - {lang:lev_1}</option>
      <option value="2" {access:sel2}>2 - {lang:lev_2}</option>
      <option value="3" {access:sel3}>3 - {lang:lev_3}</option>
      <option value="4" {access:sel4}>4 - {lang:lev_4}</option>
      <option value="5" {access:sel5}>5 - {lang:lev_5}</option>
    </select>
  </td>
 </tr>
 {stop:access}
 <tr>
  <td class="leftc">{icon:ksysguard}{lang:options}</td>
  <td class="leftb">
    <input type="hidden" name="dir" value="{value:dir}" />
    <input type="submit" name="submit" value="{lang:edit}" />
      </td>
</table>
</form>