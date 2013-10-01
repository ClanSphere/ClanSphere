<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:head_create}</td>
  </tr>
  <tr>
    <td class="leftb">{head:body}</td>
  </tr>
</table>
<br />

<form method="post" id="cash_create" action="{url:cash_create}">
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="leftc">{icon:personal} {lang:nick} *</td>
  <td class="leftb">
        <input type="text" name="users_nick" id="users_nick" value="{users:nick}" autocomplete="off" onkeyup="Clansphere.ajax.user_autocomplete('users_nick', 'search_users_result' ,'{page:path}')" maxlength="80" size="40" /><br />
        <div id="search_users_result"></div>
  </td>
  </tr>
  <tr>
    <td class="leftc">{icon:money} {lang:money} *</td>
    <td class="leftb"><input type="text" name="cash_money" value="{cash:cash_money}" maxlength="14" size="10" /> {op:currency}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:folder_yellow} {lang:inout} *</td>
    <td class="leftb">
      {cash:inout_sel}
    </td>
  <tr>
    <td class="leftc">{icon:1day} {lang:date} *</td>
    <td class="leftb">
      {cash:date_sel}
    </td>
  </tr>
  <tr>
    <td class="leftc">{icon:kedit} {lang:for} *</td>
    <td class="leftb"><input type="text" name="cash_text" value="{cash:cash_text}" maxlength="200" size="50" /></td>
  </tr>
  <tr>
    <td class="leftc">{icon:kate} {lang:info}<br />
      <br />
      {cash:abcode_smileys}
    </td>
    <td class="leftb">
      {cash:abcode_features}
      <textarea class="rte_abcode" name="cash_info" cols="50" rows="20" id="cash_info">{cash:cash_info}</textarea>
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