<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:mod} - {lang:head_create}</td>
  </tr>
  <tr>
    <td class="leftc">{lang:body}</td>
  </tr>
</table>
<br />
<form method="post" name="lanpartys_create" action="{url:form}">
  <table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
    <tr>
      <td class="leftc">{icon:connect_to_network} {lang:name} *</td>
      <td class="leftb"><input type="text" name="lanpartys_name" value="" maxlength="80" size="40"  />
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:gohome} {lang:url}</td>
      <td class="leftb" colspan="2"> http://
        <input type="text" name="lanpartys_url" value="" maxlength="80" size="50"  />
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:1day} {lang:start}</td>
      <td class="leftb">{lanpartys:start}
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:today} {lang:end}</td>
      <td class="leftb">{lanpartys:end}
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:daemons} {lang:maxguests}</td>
      <td class="leftb"><input type="text" name="lanpartys_maxguests" value="" maxlength="8" size="8"  />
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:money} {lang:money}</td>
      <td class="leftb"><input type="text" name="lanpartys_money" value="" maxlength="40" size="20"  />
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:organizer} {lang:needage}</td>
      <td class="leftb"><input type="text" name="lanpartys_needage" value="16" maxlength="40" size="20"  />
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:kfm_home} {lang:location}</td>
      <td class="leftb"><input type="text" name="lanpartys_location" value="" maxlength="80" size="40"  />
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:kdm_home} {lang:adress}</td>
      <td class="leftb"><input type="text" name="lanpartys_adress" value="" maxlength="80" size="40"  />
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:starthere} {lang:postal_place}</td>
      <td class="leftb"><input type="text" name="lanpartys_postalcode" value="" maxlength="8" size="8"  />
        <input type="text" name="lanpartys_place" value="" maxlength="40" size="40"  />
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:kwallet2} {lang:bankaccount}</td>
      <td class="leftb">{lanpartys:abcode_bankaccount}<br />
        <textarea name="lanpartys_bankaccount" cols="50" rows="5" id="lanpartys_bankaccount" ></textarea>
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:network_local} {lang:network}</td>
      <td class="leftb">{lanpartys:abcode_network}<br />
        <textarea name="lanpartys_network" cols="50" rows="5" id="lanpartys_network" ></textarea>
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:joystick} {lang:tournaments}</td>
      <td class="leftb">{lanpartys:abcode_tournaments}<br />
        <textarea name="lanpartys_tournaments" cols="50" rows="5" id="lanpartys_tournaments" ></textarea>
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:whatsnext} {lang:features}</td>
      <td class="leftb">{lanpartys:abcode_features}<br />
        <textarea name="lanpartys_features" cols="50" rows="8" id="lanpartys_features" ></textarea>
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:kate} {lang:more}</td>
      <td class="leftb">{lanpartys:abcode_more}<br />
        <textarea name="lanpartys_more" cols="50" rows="5" id="lanpartys_more" ></textarea>
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:ksysguard} {lang:options}</td>
      <td class="leftb"><input type="submit" name="submit" value="{lang:create}" />
        <input type="reset" name="reset" value="{lang:reset}" />
      </td>
    </tr>
  </table>
</form>