<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:mod} - {lang:create}</td>
  </tr>
  <tr>
    <td class="leftb">{lang:body}</td>
  </tr>
</table>
<br />

<form method="post" id="events_guestsnew" action="{url:form}">
  <table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
    <tr>
      <td class="leftc">{icon:cal} {lang:event} *</td>
      <td class="leftb"><select name="events_id" >
          <option value="0">----</option>
		  {loop:events}
		  <option value="{events:id}">{events:time} - {events:name}</option>
		  {stop:events}
        </select>
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:personal} {lang:user} *</td>
      <td class="leftb" colspan="2"><select name="users_id" >
          <option value="0">----</option>
		  {loop:user}
          <option value="{user:id}">{user:name}</option>
		  {stop:user}
        </select>
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