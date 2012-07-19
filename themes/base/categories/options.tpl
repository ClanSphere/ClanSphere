<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:options}</td>
  </tr>
  <tr>
    <td class="leftb">{lang:body_options}</td>
  </tr>
</table>
<br />

{head:getmsg}

<form method="post" id="categories_options" action="{url:categories_options}">
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="leftc">{icon:resizecol} {lang:max_width}</td>
    <td class="leftb"><input type="text" name="max_width" value="{op:max_width}" maxlength="4" size="4" /> {lang:pixel}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:resizerow} {lang:max_height}</td>
    <td class="leftb"><input type="text" name="max_height" value="{op:max_height}" maxlength="4" size="4" /> {lang:pixel}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:fileshare} {lang:max_size}</td>
    <td class="leftb"><input type="text" name="max_size" value="{op:max_size}" maxlength="20" size="8" /> {lang:bytes}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:kcmdf} {lang:def_mod}</td>
    <td class="leftb">
      <select name="def_mod">
        {loop:mod}
        {mod:sel}
        {stop:mod}
      </select>
    </td>
  </tr>
  <tr>
    <td class="leftc">{icon:ksysguard} {lang:options}</td>
    <td class="leftb">
      <input type="submit" name="submit" value="{lang:edit}" />
          </td>
  </tr>
</table>
</form>