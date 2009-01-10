<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:mod} - {lang:head_edit}</td>
  </tr>
  <tr>
    <td class="leftc">{lang:body}</td>
  </tr>
</table>
<br />
<form method="post" name="lanpartys_edit" action="{url:form}">
  <table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
    <tr>
      <td class="leftc">{icon:connect_to_network} {lang:name} *</td>
      <td class="leftb"><input type="text" name="lanpartys_name" value="{lanpartys:name}" maxlength="80" size="40"  />
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:gohome} {lang:url}</td>
      <td class="leftb" colspan="2"> http://
        <input type="text" name="lanpartys_url" value="{lanpartys:url}" maxlength="80" size="50"  />
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
      <td class="leftb"><input type="text" name="lanpartys_maxguests" value="{lanpartys:maxguests}" maxlength="8" size="8"  />
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:money} {lang:money}</td>
      <td class="leftb"><input type="text" name="lanpartys_money" value="{lanpartys:money}" maxlength="40" size="20"  />
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:organizer} {lang:needage}</td>
      <td class="leftb"><input type="text" name="lanpartys_needage" value="{lanpartys:needage}" maxlength="40" size="20"  />
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:kfm_home} {lang:location}</td>
      <td class="leftb"><input type="text" name="lanpartys_location" value="{lanpartys:location}" maxlength="80" size="40"  />
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:kdm_home} {lang:adress}</td>
      <td class="leftb"><input type="text" name="lanpartys_adress" value="{lanpartys:adress}" maxlength="80" size="40"  />
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:starthere} {lang:postal_place}</td>
      <td class="leftb"><input type="text" name="lanpartys_postalcode" value="{lanpartys:postal_postalcode}" maxlength="8" size="8"  />
        <input type="text" name="lanpartys_place" value="{lanpartys:postal_place}" maxlength="40" size="40"  />
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:kwallet2} {lang:bankaccount}</td>
      <td class="leftb">{lanpartys:abcode_bankaccount}<br />
        <textarea name="lanpartys_bankaccount" cols="50" rows="5" id="lanpartys_bankaccount" >{lanpartys:bankaccount}</textarea>
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:network_local} {lang:network}</td>
      <td class="leftb">{lanpartys:abcode_network}<br />
        <textarea name="lanpartys_network" cols="50" rows="5" id="lanpartys_network" >{lanpartys:network}</textarea>
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:joystick} {lang:tournaments}</td>
      <td class="leftb">{lanpartys:abcode_tournaments}<br />
        <textarea name="lanpartys_tournaments" cols="50" rows="5" id="lanpartys_tournaments" >{lanpartys:tournaments}</textarea>
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:whatsnext} {lang:features}</td>
      <td class="leftb">{lanpartys:abcode_features}<br />
        <textarea name="lanpartys_features" cols="50" rows="8" id="lanpartys_features" >{lanpartys:features}</textarea>
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:kate} {lang:more}</td>
      <td class="leftb">{lanpartys:abcode_more}<br />
        <textarea name="lanpartys_more" cols="50" rows="5" id="lanpartys_more" >{lanpartys:more}</textarea>
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