<div class="container" style="width:{page:width}">
    <div class="headb"> {lang:mod} - {lang:options} </div>
    <div class="leftb"> {lang:body}</div>
</div>
<br />
<form method="post" name="memberoption" action="{url:form}">
  <table class="forum" cellpadding="0" cellspacing="1" style="width:{page:width}">
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
