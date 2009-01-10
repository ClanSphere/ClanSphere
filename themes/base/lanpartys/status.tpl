<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:96%">
  <tr>
    <td class="leftc">{icon:connect_to_network} {lang:lanparty}</td>
    <td class="leftb">{lanpartys:lanparty}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:kdmconfig} {lang:team}</td>
    <td class="leftb"><form method="post" name="lanpartys_status" action="{url:form}">
        <input type="text" name="languests_team" value="{lanpartys:team}" maxlength="20" size="20"  />
        <input type="hidden" name="id" value="{data:id}" />
        <input type="submit" name="submit" value="{lang:change}" />
      </form>
	  <br />
	  <br />
	  {lanpartys:team_done}
	  </td>
  </tr>
  <tr>
    <td class="leftc">{icon:status_unknown} {lang:status}</td>
    <td class="leftb">{lanpartys:status}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:money} {lang:money}</td>
    <td class="leftb">{lanpartys:money}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:1day} {lang:paytime}</td>
    <td class="leftb">{lanpartys:paytime}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:kwallet2} {lang:bankaccount}</td>
    <td class="leftb">{lanpartys:bankaccount}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:kwallet2} {lang:usage}</td>
    <td class="leftb">{lanpartys:usage}</td>
  </tr>
</table>
