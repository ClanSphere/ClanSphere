<form method="post" id="install_admin" action="{url_install:install_admin}">

<table class="forum" style="width: 100%" cellpadding="0" cellspacing="1">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:admin}</td>
  </tr>
  <tr>
    <td class="leftc">{lang:create_admin}</td>
  </tr>
</table>
<br />

<table class="forum" style="width: 100%" cellpadding="0" cellspacing="1">
  <tr>
    <td class="leftb" colspan="2">{lang:admin}</td>
  </tr>
  <tr>
    <td class="leftc">{lang:lang} *</td>
    <td class="leftb">
     <select name="lang">{loop:langs}
      <option value="{langs:name}"{langs:selected}>{langs:name}</option>{stop:langs}
    </select></td>
  </tr>
  <tr>
    <td class="leftc">{lang:nick} *</td>
    <td class="leftb"><input type="text" name="nick" value="{value:users_nick}" maxlength="40" size="40" /></td>
  </tr>
  <tr>
    <td class="leftc">{lang:email} *</td>
    <td class="leftb"><input type="text" name="email" value="{value:users_email}" maxlength="40" size="40" /></td>
  </tr>
  <tr>
    <td class="leftc">{lang:password} *</td>
    <td class="leftb"><input type="password" name="password" value="{value:users_password}" maxlength="30" size="30" autocomplete="off" /></td>
  </tr>
  <tr>
    <td class="leftb" colspan="2">{lang:show}</td>
  </tr>
  <tr>
    <td class="leftc">{lang:show_groups_as}</td>
    <td class="leftb">
     <select name="clanlabel">
      <option value="clan" selected="selected">{lang:clan}</option>
      <option value="association">{lang:association}</option>
      <option value="club">{lang:club}</option>
      <option value="guild">{lang:guild}</option>
      <option value="enterprise">{lang:enterprise}</option>
      <option value="school">{lang:school}</option>
    </select></td>
  </tr>
  <tr>
    <td class="leftc">{lang:show_subgroups_as}</td>
    <td class="leftb">
     <select name="squadlabel">
      <option value="squad" selected="selected">{lang:squads}</option>
      <option value="group">{lang:groups}</option>
      <option value="section">{lang:sections}</option>
      <option value="team">{lang:teams}</option>
      <option value="class">{lang:class}</option>
    </select></td>
  </tr>
  <tr>
    <td class="leftc">{lang:show_members_as}</td>
    <td class="leftb">
     <select name="memberlabel">
      <option value="members" selected="selected">{lang:members}</option>
      <option value="employees">{lang:employees}</option>
      <option value="teammates">{lang:teammates}</option>
      <option value="classmates">{lang:classmates}</option>
    </select></td>
  </tr>
  <tr>
    <td class="leftc">{lang:options}</td>
    <td class="leftb">
     <input type="submit" name="submit" value="{lang:create}" />
     
    </td>
  </tr>
</table>
</form>