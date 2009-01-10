<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb">{lang:mod} - {lang:create}</td>
 </tr>
 <tr>
  <td class="leftc">{head:text}</td>
 </tr>
</table>
<br />

<form method="post" name="members_create" action="{url:members_create}">
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="leftc">{icon:yast_group_add} {lang:squad} *</td>
  <td class="leftb">
    <select name="squads_id" >
     <option value="0">----</option>{loop:squads}
     <option value="{squads:squads_id}"{squads:selection}>{squads:squads_name}</option>{stop:squads}
    </select>
  </td>
 </tr>
 <tr>
  <td class="leftc">{icon:personal} {lang:user} *</td>
  <td class="leftb" colspan="2">
    <select name="users_id" >
     <option value="0">----</option>{loop:users}
     <option value="{users:users_id}"{users:selection}>{users:users_nick}</option>{stop:users}
    </select>
  </td>
 </tr>
 <tr>
  <td class="leftc">{icon:todo} {lang:task} *</td>
  <td class="leftb">
    <input type="text" name="members_task" value="{value:task}" maxlength="80" size="40"  />
  </td>
 </tr>
 <tr>
  <td class="leftc">{icon:enumList} {lang:order}</td>
  <td class="leftb">
    <input type="text" name="members_order" value="{value:order}" maxlength="4" size="4"  />
  </td>
 </tr>
 <tr>
  <td class="leftc">{icon:today} {lang:since}</td>
  <td class="leftb">{dropdown:since_year}</td>
 </tr>
 <tr>
  <td class="leftc">{icon:configure} {lang:more}</td>
  <td class="leftb">
    <input type="checkbox" name="members_admin" value="1" {value:admin_sel}/>
    {lang:manage}
  </td>
 </tr>
 <tr>
  <td class="leftc">{icon:ksysguard} {lang:options}</td>
  <td class="leftb">
    <input type="submit" name="submit" value="{lang:create}" />
    <input type="reset" name="reset" value="{lang:reset}" />
  </td>
 </tr>
</table>
</form>