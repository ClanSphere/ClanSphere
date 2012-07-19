<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:head_create}</td>
  </tr>
  <tr>
    <td class="leftb">{head:body}</td>
  </tr>
</table>
<br />

<form method="post" id="buddys_create" action="{url:buddys_create}">
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="leftb">{icon:personal} {lang:user} *</td>
    <td class="leftc">
      {if:empty_users_id}
      <input type="text" name="buddys_nick" value="{buddys:nick}" maxlength="200" size="50" {input:more} /><br />
      <span id="output"></span>
      {stop:empty_users_id}
      {if:users_id}
      <input type="hidden" name="buddys_nick" value="{buddys:nick}" />{buddys:nick_sec}
      {stop:users_id}
    </td>
  </tr>
  <tr>
    <td class="leftb">{icon:kate} {lang:notice}<br />
      <br />
      {abcode:smileys}
    </td>
    <td class="leftc">
      {abcode:features}
      <textarea class="rte_abcode" name="buddys_notice" cols="50" rows="15" id="buddys_notice">{create:buddys_notice}</textarea>
    </td>
  </tr>
  <tr>
    <td class="leftb">{icon:ksysguard} {lang:options}</td>
    <td class="leftc">
      <input type="submit" name="submit" value="{lang:create}" />
          </td>
  </tr>
</table>
</form>