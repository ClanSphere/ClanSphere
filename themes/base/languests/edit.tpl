<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:mod} - {lang:edit}</td>
  </tr>
  <tr>
    <td class="leftb">{lang:body}</td>
  </tr>
</table>
<br />
<form method="post" name="languests_edit" action="{url:form}">
  <table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
    <tr>
      <td class="leftc">{icon:connect_to_network} {lang:lanparty} *</td>
      <td class="leftb"><select name="lanpartys_id" >
          <option value="0">----</option>
		  {loop:lanpartys}
		  <option value="{lanpartys:id}" {lanpartys:select}>{lanpartys:name}</option>
		  {stop:lanpartys}
        </select>
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:personal} {lang:user} *</td>
      <td class="leftb" colspan="2"><select name="users_id" >
          <option value="0">----</option>
		  {loop:user}
          <option value="{user:id}" {user:select}>{user:name}</option>
		  {stop:user}
        </select>
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:kdmconfig} {lang:team}</td>
      <td class="leftb"><input type="text" name="languests_team" value="{languests:team}" maxlength="20" size="20"  />
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:status_unknown} {lang:status} *</td>
      <td class="leftb"><select name="languests_status" >
          <option value="1">{lang:status_1}</option>
          <option value="3" {select:3}>{lang:status_3}</option>
          <option value="4" {select:4}>{lang:status_4}</option>
          <option value="5" {select:5}>{lang:status_5}</option>
        </select>
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:money} {lang:money}</td>
      <td class="leftb"><input type="text" name="languests_money" value="{languests:money}" maxlength="20" size="8"  />
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:1day} {lang:paytime}</td>
      <td class="leftb">{languests:paytime}
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:knotes} {lang:notice}</td>
      <td class="leftb"><input type="text" name="languests_notice" value="{languests:notice}" maxlength="80" size="40"  />
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:ksysguard} {lang:options}</td>
      <td class="leftb"><input type="hidden" name="id" value="{data:id}" />
        <input type="submit" name="submit" value="{lang:edit}" />
        <input type="reset" name="reset" value="{lang:reset}" />
      </td>
    </tr>
  </table>
</form>
