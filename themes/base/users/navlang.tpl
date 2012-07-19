<form method="post" id="users_navlang" action="{form:url}">
<fieldset style="border: 0; padding: 0">
<select name="lang">
{loop:langs}
  <option value="{langs:name}" style="background-image:url({langs:img}); background-repeat: no-repeat; padding-left: 30px"{langs:selected}>{langs:name}</option>  
{stop:langs}
</select>
<input type="submit" name="login" value="{lang:show}" />
</fieldset>
</form>