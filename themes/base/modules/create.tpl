<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb">{lang:mod_name} - {lang:create}</td>
 </tr>
 <tr>
  <td class="leftb">{message:lang}</td>
 </tr>
</table>
<br />

<form method="post" id="modules_create" action="{form:url}">
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="leftc" style="width:20%">{icon:kedit} {lang:name} *</td>
  <td class="leftb" style="width:80%"><input type="text" value="{value:modname}" name="modname" maxlength="60" size="40" /></td>
 </tr>
 <tr>
  <td class="leftc">{icon:folder_yellow} {lang:directory} *</td>
  <td class="leftb"><input type="text" value="{value:moddir}" name="moddir" maxlength="60" size="40" /></td>
 </tr>
 <tr>
  <td class="leftc">{icon:kedit} {lang:version} *</td>
  <td class="leftb"><input type="text" value="{value:modversion}" name="modversion" maxlength="60" size="25" /></td>
 </tr>
 <tr>
  <td class="leftc">{icon:1day} {lang:release} *</td>
  <td class="leftb">{input:dateselect}</td>
 </tr>
 <tr>
  <td class="leftc">{icon:personal} {lang:creator} *</td>
  <td class="leftb"><input type="text" value="{value:creator}" name="creator" maxlength="60" size="30" /></td>
 </tr>
 <tr>
  <td class="leftc">{icon:kdmconfig} {lang:team} *</td>
  <td class="leftb"><input type="text" value="{value:team}" name="team" maxlength="60" size="30" /></td>
 </tr>
 <tr>
  <td class="leftc">{icon:gohome} {lang:homepage} *</td>
  <td class="leftb"><input type="text" value="{value:homepage}" name="homepage" maxlength="80" size="50" /></td>
 </tr>
 <tr>
  <td class="leftc">{icon:kedit} {lang:description} *</td>
  <td class="leftb"><textarea class="rte_abcode" name="description" cols="50" rows="5">{value:description}</textarea></td>
 </tr>
 <tr>
  <td class="leftc">{icon:images} {lang:icon} *</td>
  <td class="leftb"><input type="text" value="{value:icon}" name="icon" maxlength="60" size="20" /></td>
 </tr>
 <tr>
  <td class="leftc">{icon:image} {lang:show}</td>
  <td class="leftb">
    {loop:show}
    <input type="text" value="{show:value}" name="show_{show:run}" maxlength="80" size="30" /> =&gt; 
    <input type="text" value="{show:axx_value}"name="showaccess_{show:run}" maxlength="3" size="5" /><br />
    {stop:show}
    {help:clip}
  </td>
 </tr>
 <tr>
  <td class="leftc">{icon:folder_yellow} {lang:categories}</td>
  <td class="leftb">
   <select name="categories">
    <option value="0" {selected:categories_no}>{lang:no}</option>
    <option value="1" {selected:categories_yes}>{lang:yes}</option>
   </select>
  </td>
 </tr>
 <tr>
  <td class="leftc">{icon:lock} {lang:protected}</td>
  <td class="leftb">
   <select name="protected">
    <option value="0" {selected:protected_no}>{lang:no}</option>
    <option value="1" {selected:protected_yes}>{lang:yes}</option>
   </select>
  </td>
 </tr>
 <tr>
  <td class="leftc">{icon:db_status} {lang:db_tables}</td>
  <td class="leftb">
    {loop:tables}
    <input type="text" name="table_{tables:run}" value="{tables:value}" maxlength="80" size="30" /><br />
    {stop:tables}
    </td>
 </tr>
 <tr>
  <td class="leftc">{icon:ksysguard} {lang:options}</td>
  <td class="leftb">
   <input type="hidden" name="tablescount" value="{value:tablescount}" />
   <input type="hidden" name="showcount" value="{value:showcount}" />
   <input type="submit" name="submit" value="{lang:create}" />
   <input type="submit" name="addshow" value="{lang:add_show}" />
   <input type="submit" name="addtable" value="{lang:add_table}" />
  </td>
 </tr>
</table>
</form>