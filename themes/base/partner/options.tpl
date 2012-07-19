<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width};">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:options}</td>
  </tr>
  <tr>
    <td class="leftb">{head:body_text}</td>
  </tr>
</table>
<br />

<form method="post" action="{url:partner_options}">
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width};">
  <tr>
    <td class="headb" colspan="2">{icon:images} {lang:navimg}</td>
   </tr>
  <tr>
    <td class="leftc" style="width: 175px;">{icon:resizecol} {lang:max_height} *</td>
    <td class="leftb"><input type="text" name="def_height_navimg" value="{partner:def_height_navimg}" maxlength="4" size="4" /> px</td>
  </tr>
  <tr>
    <td class="leftc">{icon:resizerow} {lang:max_width} *</td>
    <td class="leftb"><input type="text" name="def_width_navimg" value="{partner:def_width_navimg}" maxlength="4" size="4" /> px</td>
  </tr>
  <tr>
    <td class="leftc">{icon:fileshare} {lang:max_size}</td>
    <td class="leftb"><input type="text" name="max_size_navimg" value="{partner:max_size_navimg}" maxlength="10" size="10" /> Bytes</td>
  </tr>
  <tr>
    <td class="headb" colspan="2">{icon:images} {lang:listimg}</td>
   </tr>
  <tr>
    <td class="leftc" style="width: 125px;">{icon:resizecol} {lang:max_height} *</td>
    <td class="leftb"><input type="text" name="def_height_listimg" value="{partner:def_height_listimg}" maxlength="4" size="4" /> px</td>
  </tr>
  <tr>
    <td class="leftc">{icon:resizerow} {lang:max_width} *</td>
    <td class="leftb"><input type="text" name="def_width_listimg" value="{partner:def_width_listimg}" maxlength="4" size="4" /> px</td>
  </tr>
  <tr>
    <td class="leftc">{icon:fileshare} {lang:max_size}</td>
    <td class="leftb"><input type="text" name="max_size_listimg" value="{partner:max_size_listimg}" maxlength="10" size="10" /> Bytes</td>
  </tr>
  <tr>
    <td class="headb" colspan="2">{icon:images} {lang:rotimg}</td>
   </tr>
  <tr>
    <td class="leftc" style="width: 125px;">{icon:resizecol} {lang:max_height} *</td>
    <td class="leftb"><input type="text" name="def_height_rotimg" value="{partner:def_height_rotimg}" maxlength="4" size="4" /> px</td>
  </tr>
  <tr>
    <td class="leftc">{icon:resizerow} {lang:max_width} *</td>
    <td class="leftb"><input type="text" name="def_width_rotimg" value="{partner:def_width_rotimg}" maxlength="4" size="4" /> px</td>
  </tr>
  <tr>
    <td class="leftc">{icon:fileshare} {lang:max_size}</td>
    <td class="leftb"><input type="text" name="max_size_rotimg" value="{partner:max_size_rotimg}" maxlength="10" size="10" /> Bytes</td>
  </tr>
  <tr>
    <td class="leftc">{icon:agt_reload} {lang:rotation}</td>
    <td class="leftb">
    <select name="method">
    <option value="random" {sel:random}>{lang:random}</option>
    <option value="rotation" {sel:rotation}>{lang:change}</option>
    </select>
    </td>
  </tr>
     <tr>
        <td class="leftc">{icon:playlist} {lang:max_navlist}</td>
        <td class="leftb"><input type="text" name="max_navlist" value="{partner:max_navlist}" maxlength="2" size="2" /></td>
     </tr>  
 <tr>
   <td class="leftc">{icon:ksysguard} {lang:options}</td>
   <td class="leftb"><input type="submit" name="submit" value="{lang:edit}" /> </td>
 </tr>
</table>
</form>