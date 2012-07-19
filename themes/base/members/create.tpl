<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb">{lang:mod_name} - {lang:create}</td>
 </tr>
 <tr>
  <td class="leftc">{head:text}</td>
 </tr>
</table>
<br />

<form method="post" id="members_create" action="{url:members_create}">
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="leftc">{icon:yast_group_add} {lang:squad} *</td>
  <td class="leftb">
    <select name="squads_id">
     <option value="0">----</option>{loop:squads}
     <option value="{squads:squads_id}"{squads:selection}>{squads:squads_name}</option>{stop:squads}
    </select>
   - <a href="{url:squads_create}">{lang:create}</a>
  </td>
 </tr>
 <tr>
  <td class="leftc">{icon:personal} {lang:user} *</td>
  <td class="leftb">
        <input type="text" name="users_nick" id="users_nick" value="{users:nick}" autocomplete="off" onkeyup="Clansphere.ajax.user_autocomplete('users_nick', 'search_users_result' ,'{page:path}')" maxlength="80" size="40" /><br />
        <div id="search_users_result"></div>
  </td>
 </tr>
 <tr>
  <td class="leftc">{icon:todo} {lang:task} *</td>
  <td class="leftb">
    <input type="text" name="members_task" value="{value:task}" maxlength="80" size="40" />
  </td>
 </tr>
 <tr>
  <td class="leftc">{icon:enumList} {lang:order}</td>
  <td class="leftb">
    <input type="text" name="members_order" value="{value:order}" maxlength="4" size="4" />
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
      </td>
 </tr>
</table>
</form>