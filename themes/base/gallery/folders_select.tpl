<select name="{select:name}">
  <option value="0">----</option>
  {folders:options}
</select>
{if:create}
- <input type="text" name="folders_name" value="" maxlength="80" size="20" />
{stop:create}