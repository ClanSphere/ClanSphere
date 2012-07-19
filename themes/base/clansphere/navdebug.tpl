<form method="post" id="clansphere_navdebug" action="{form:url}">
<fieldset style="border: 0; padding: 0">
  <select name="debug_navfile">
    {loop:navfiles}
    <option value="{navfiles:num}">{navfiles:value}</option>
    {stop:navfiles}
  </select>
  <input type="submit" name="submit" value="{lang:show}" />
</fieldset>
</form>