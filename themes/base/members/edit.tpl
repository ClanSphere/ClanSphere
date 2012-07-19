<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb">{head:mod} - {lang:edit}</td>
 </tr>
 <tr>
  <td class="leftc">{head:body}</td>
 </tr>
</table>
<br />

<form method="post" id="members_edit" action="{url:members_edit}">
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="leftc">{icon:yast_group_add} {members:label} *</td>
  <td class="leftb">
  {members:squad_sel}
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
    <input type="text" name="members_task" value="{members:task}" maxlength="80" size="40" />
  </td>
 </tr>
 <tr>
  <td class="leftc">{icon:enumList} {lang:order}</td>
  <td class="leftb">
    <input type="text" name="members_order" value="{members:order}" maxlength="4" size="4" />
  </td>
 </tr>
 <tr>
  <td class="leftc">{icon:today} {lang:since}</td>
  <td class="leftb">{members:since}</td>
 </tr>
 <tr>
  <td class="leftc">{icon:configure} {lang:more}</td>
  <td class="leftb">
    <input type="checkbox" name="members_admin" value="1" {members:admin} />
    {lang:manage}
  </td>
 </tr>
 <tr>
  <td class="leftc">{icon:ksysguard} {lang:options}</td>
  <td class="leftb">
  <input type="hidden" name="id" value="{members:id}" />
    <input type="submit" name="submit" value="{lang:edit}" />
      </td>
 </tr>
</table>
</form>