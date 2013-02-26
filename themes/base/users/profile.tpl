<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width};">
  <tr>
    <td class="headb"> {lang:mod_name} - {lang:profile} </td>
  </tr>
  <tr>
    <td class="leftb"> {users:body} </td>
  </tr>
</table>
<br />
<form method="post" id="users_profile" action="{form:action}">
  <table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width};">
    <tr>
      <td class="headb">{lang:column}</td>
      <td class="headb">{lang:value}</td>
      <td class="headb">{lang:hidden}</td>
    </tr>
    <tr>
      <td class="leftc"> {icon:personal} {lang:nick} * </td>
      <td class="leftb" colspan="2"><input type="text" name="users_nick" value="{users:users_nick}" maxlength="40" size="40" />
      </td>
    </tr>
    <tr>
      <td class="leftc"> {icon:personal} {lang:prename}</td>
      <td class="leftb"><input type="text" name="users_name" value="{users:users_name}" maxlength="80" size="50" /></td>
      <td class="centerc"><input type="checkbox" name="hidden[]" value="users_name"  {hidden:users_name} />
      </td>
    </tr>
    <tr>
      <td class="leftc"> {icon:personal} {lang:surname}</td>
      <td class="leftb"><input type="text" name="users_surname" value="{users:users_surname}" maxlength="80" size="50" /></td>
      <td class="centerc"><input type="checkbox" name="hidden[]" value="users_surname"  {hidden:users_surname} />
      </td>
    </tr>
    <tr>
      <td class="leftc"> {icon:groupevent} {lang:sex}</td>
      <td class="leftb" colspan="2"><select name="users_sex">
          <option value="0">----</option>
          <option value="male" {users:male_check}>{lang:male}</option>
          <option value="female" {users:female_check}>{lang:female}</option>
        </select>
      </td>
    </tr>
    <tr>
      <td class="leftc"> {icon:1day} {lang:birthday}</td>
      <td class="leftb">{users:users_age}
      </td>
      <td class="centerc"><input type="checkbox" name="hidden[]" value="users_age"  {hidden:users_age} />
      </td>
    </tr>
    <tr>
      <td class="leftc"> {icon:kivio} {lang:height}</td>
      <td class="leftb"><input type="text" name="users_height" value="{users:users_height}" maxlength="3" size="3" />
        cm</td>
      <td class="centerc"><input type="checkbox" name="hidden[]" value="users_height"  {hidden:users_height} />
      </td>
    </tr>
    <tr>
      <td class="leftc"> {icon:kdm_home} {lang:adress}</td>
      <td class="leftb"><input type="text" name="users_adress" value="{users:users_adress}" maxlength="80" size="50" /></td>
      <td class="centerc"><input type="checkbox" name="hidden[]" value="users_adress"  {hidden:users_adress} />
      </td>
    </tr>
    <tr>
      <td class="leftc"> {icon:starthere} {lang:postal_place}</td>
      <td class="leftb"><input type="text" name="users_postalcode" value="{users:users_postalcode}" maxlength="8" size="8" />
        <input type="text" name="users_place" value="{users:users_place}" maxlength="40" size="40" /></td>
      <td class="centerc"><input type="checkbox" name="hidden[]" value="users_place"  {hidden:users_place} />
      </td>
    </tr>
    <tr>
      <td class="leftc"> {icon:locale} {lang:country}</td>
      <td class="leftb" colspan="2">
      <select name="users_country"  onchange="document.getElementById('country_1').src='{page:path}symbols/countries/' + this.form.users_country.options[this.form.users_country.selectedIndex].value + '.png'">
     {loop:country}
     <option value="{country:short}"{country:selection}>{country:full}</option>{stop:country}
    </select>
    {users:country_url}</td>
    </tr>
    <tr>
      <td class="leftc"> {icon:mail_generic} {lang:email} *</td>
      <td class="leftb"><input type="text" name="users_email" value="{users:users_email}" maxlength="40" size="40" /></td>
      <td class="centerc"><input type="checkbox" name="hidden[]" value="users_email"  {hidden:users_email} />
      </td>
    </tr>
    <tr>
      <td class="leftc"> {icon:gohome} {lang:url}</td>
      <td class="leftb"> http://
        <input type="text" name="users_url" value="{users:users_url}" maxlength="80" size="50" /></td>
      <td class="centerc"><input type="checkbox" name="hidden[]" value="users_url"  {hidden:users_url} />
      </td>
    </tr>
    <tr>
      <td class="leftc"> {icon:licq} {lang:icq}</td>
      <td class="leftb"><input type="text" name="users_icq" value="{users:users_icq}" maxlength="12" size="12" /></td>
      <td class="centerc"><input type="checkbox" name="hidden[]" value="users_icq"  {hidden:users_icq} />
      </td>
    </tr>
    <tr>
      <td class="leftc"> {icon:jabber_protocol} {lang:jabber}</td>
      <td class="leftb">{lang:jabber_info}<br /><input type="text" name="users_jabber" value="{users:users_jabber}" maxlength="40" size="40" /></td>
      <td class="centerc"><input type="checkbox" name="hidden[]" value="users_jabber"  {hidden:users_jabber} />
      </td>
    </tr>
    <tr>
      <td class="leftc"> {icon:skype} {lang:skype}</td>
      <td class="leftb"><input type="text" name="users_skype" value="{users:users_skype}" maxlength="40" size="40" /></td>
      <td class="centerc"><input type="checkbox" name="hidden[]" value="users_skype"  {hidden:users_skype} />
      </td>
    </tr>
    <tr>
      <td class="leftc"> {icon:linphone} {lang:phone}</td>
      <td class="leftb"><input type="text" name="users_phone" value="{users:users_phone}" maxlength="40" size="40" /></td>
      <td class="centerc"><input type="checkbox" name="hidden[]" value="users_phone"  {hidden:users_phone} />
      </td>
    </tr>
    <tr>
      <td class="leftc"> {icon:sms_protocol} {lang:mobile}</td>
      <td class="leftb"><input type="text" name="users_mobile" value="{users:users_mobile}" maxlength="40" size="40" /></td>
      <td class="centerc"><input type="checkbox" name="hidden[]" value="users_mobile"  {hidden:users_mobile} />
      </td>
    </tr>
    <tr>
      <td class="leftc"> {icon:documentinfo} {lang:info}<br /><br />
    {abcode:smileys}
   </td>
      <td class="leftb" colspan="2">{abcode:features}
        <textarea class="rte_abcode" name="users_info" cols="50" rows="12" id="users_info">{users:users_info}</textarea>
      </td>
    </tr>
    <tr>
      <td class="leftc"> {icon:ksysguard} {lang:options}</td>
      <td class="leftb" colspan="2"><input type="submit" name="submit" value="{lang:edit}" />
              </td>
    </tr>
  </table>
</form>
