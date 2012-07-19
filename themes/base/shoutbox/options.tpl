<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb">{lang:mod_name} - {lang:options}</td>
 </tr>
 <tr>
  <td class="leftb">{lang:change_settings}</td>
 </tr>
</table>
<br />

<form method="post" action="{url:shoutbox_options}">
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="leftc">{icon:kedit} {lang:max_text}</td>
  <td class="leftb"><input type="text" name="max_text" value="{op:max_text}" maxlength="4" size="4" /> {lang:figures}</td>
 </tr>
 <tr>
  <td class="leftc">{icon:wizard} {lang:linebreak}</td>
  <td class="leftb">{lang:after} <input type="text" name="linebreak" value="{op:linebreak}" maxlength="4" size="4" /> {lang:figures}</td>
 </tr>
 <tr>
  <td class="leftc">{icon:agt_reload} {lang:order}</td>
  <td class="leftb">
    <select name="order">
     <option value="ASC" {selected:asc}>{lang:newest_bottom}</option>
     <option value="DESC" {selected:desc}>{lang:newest_top}</option>
    </select>
  </td>
 </tr>
 <tr>
  <td class="leftc">{icon:enumList} {lang:display_limit}</td>
  <td class="leftb"><input type="text" name="limit" value="{op:limit}" maxlength="4" size="4" /> {lang:entries}</td>
 </tr>
 <tr>
  <td class="leftc">{icon:ksysguard} {lang:options}</td>
  <td class="leftb">
    <input type="submit" name="submit" value="{lang:save}" />
      </td>
 </tr>
</table>
</form>