<div class="container" style="width:{page:width}">
    <div class="headb">{lang:mod} - {lang:head_create}</div>
    <div class="leftc">{lang:body}</div>
</div>
<br />
<form method="post" name="access_create" action="{action:form}">
  <table class="forum" cellpadding="0" cellspacing="1" style="width:{page:width}">
    <tr>
      <td class="leftc">{icon:access} {lang:name} *</td>
      <td class="leftb"><input type="text" name="access_name" value="{access2:name}" maxlength="40" size="40" />
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:package_system} {access2:clansphere}</td>
      <td class="leftb"><select name="access_clansphere">
          <option value="0">0 - {lang:clansphere_0}</option>
          <option value="3">3 - {lang:clansphere_3}</option>
          <option value="4">4 - {lang:clansphere_4}</option>
          <option value="5">5 - {lang:clansphere_5}</option>
        </select>
      </td>
    </tr>
    {loop:access}
    <tr>
      <td class="leftc">{access:icon} {access:name}</td>
      <td class="leftb">{access:select}
      </td>
    </tr>
   {stop:access}
    <tr>
      <td class="leftc">{icon:ksysguard} {lang:options}</td>
      <td class="leftb"><input type="submit" name="submit" value="{lang:create}" />
        <input type="reset" name="reset" value="{lang:reset}" />
      </td>
    </tr>
  </table>
</form>
