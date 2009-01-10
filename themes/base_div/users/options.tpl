<div class="container" style="width:{page:width}">
  <div class="headb">{lang:mod_name} - {lang:options}</div>
  <div class="leftb">{lang:manage_options}</div>
</div>
<br />

<form method="post" name="users_options" action="{url:users_options}">
<table class="forum" cellpadding="0" cellspacing="1" style="width:{page:width}">
 <tr>
  <td class="leftc">{icon:resizecol} {lang:max_width}</td>
  <td class="leftb"><input type="text" name="max_width" value="{options:max_width}" maxlength="4" size="4"  /> {lang:pixel}</td>
 </tr>
 <tr>
  <td class="leftc">{icon:resizerow} {lang:max_height}</td>
  <td class="leftb"><input type="text" name="max_height" value="{options:max_height}" maxlength="4" size="4"  /> {lang:pixel}</td>
 </tr>
 <tr>
  <td class="leftc">{icon:fileshare} {lang:max_size}</td>
  <td class="leftb"><input type="text" name="max_size" value="{options:max_size}" maxlength="20" size="8"  /> {lang:bytes}</td>
 </tr>
 <tr>
  <td class="leftc">{icon:cell_edit} {lang:min_letters}</td>
  <td class="leftb"><input type="text" name="min_letters" value="{options:min_letters}" maxlength="10" size="4"  /> {lang:letters}</td>
 </tr>
 <tr>
  <td class="leftc">{icon:completion} {lang:def_register}</td>
  <td class="leftb">{dropdown:def_register}</td>
 </tr>
 <tr>
  <td class="leftc">{icon:personal} {lang:register}</td>
  <td class="leftb">
  <select name="register" >
  {options:register_off}
  {options:register_on}
  </select>
  </td>
 </tr>
 <tr>
 <td class="leftc">{icon:ksysguard} {lang:options}</td>
  <td class="leftb">
    <input type="submit" name="submit" value="{lang:edit}" />
    <input type="reset" name="reset" value="{lang:reset}" />
   </td>
 </tr>
</table>
</form>