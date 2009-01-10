<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:mod} - {lang:head_create}</td>
  </tr>
  <tr>
    <td class="leftb">{lang:body}</td>
  </tr>
</table>

<br />

<form method="post" name="lanrooms_create" action="{url:form}">
  <table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
    <tr>
      <td class="leftb">{icon:connect_to_network} {lang:lanparty} *</td>
      <td class="leftc"><select name="lanpartys_id" >
          <option value="0">----</option>
          {loop:lan}
		  <option value="{lan:id}">{lan:name}</option>
		  {stop:lan}
        </select>
      </td>
    </tr>
    <tr>
      <td class="leftb">{icon:kate} {lang:name} *</td>
      <td class="leftc"><input type="text" name="lanrooms_name" value="{lanroom:name}" maxlength="80" size="40"  />
      </td>
    </tr>
    <tr>
      <td class="leftb">{icon:ksysguard} {lang:options}</td>
      <td class="leftc"><input type="submit" name="submit" value="{lang:submit}" />
        <input type="reset" name="reset" value="{lang:reset}" />
      </td>
    </tr>
  </table>
</form>
