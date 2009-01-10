<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb"> {lang:mod} - {lang:options} </td>
  </tr>
  <tr>
    <td class="leftb"> {lang:body}</td>
  </tr>
</table>
<br />
<form method="post" name="memberoption" action="{url:form}">
  <table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
    <tr>
      <td class="leftc">{icon:kdmconfig} {lang:label}</td>
      <td class="leftb"><select name="label" >
          <option value="members" {select:members_select}>{lang:members}</option>
          <option value="employees" {select:employees_select}>{lang:employees}</option>
          <option value="teammates" {select:teammates_select}>{lang:teammates}</option>
          <option value="classmates" {select:classmates_select}>{lang:classmates}</option>
        </select>
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:ksysguard} {lang:options}</td>
      <td class="leftb"><input type="submit" name="submit" value="{lang:edit}" />
        <input type="reset" name="reset" value="{lang:reset}" />
      </td>
    </tr>
  </table>
</form>
