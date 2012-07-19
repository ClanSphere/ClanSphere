<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width};">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:edit}</td>
  </tr>
  <tr>
    <td class="leftb">{head:body_text}</td>
  </tr>
</table>
<br />

<form method="post" action="{form:edit}" enctype="multipart/form-data">
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width};">
  <tr>
    <td class="leftc" style="width: 125px;">{icon:kedit} {lang:name} *</td>
    <td class="leftb"><input type="text" name="partner_name" value="{partner:partner_name}" maxlength="200" size="50" /></td>
  </tr>
  <tr>
    <td class="leftc">{icon:folder_yellow} {lang:category} *</td>
    <td class="leftb">{categories:dropdown}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:gohome} {lang:url} *</td>
    <td class="leftb">http:// <input type="text" name="partner_url" value="{partner:partner_url}" maxlength="200" size="50" /></td>
  </tr>
  <tr>
    <td class="leftc">{icon:documentinfo} {lang:alt} *</td>
    <td class="leftb"><input type="text" name="partner_alt" value="{partner:partner_alt}" maxlength="200" size="50" /></td>
  </tr>
  <tr>
    <td class="leftc">{icon:kate} {lang:description} *<br /><br /> {abcode:smileys}</td>
    <td class="leftb">{abcode:features}<textarea class="rte_abcode" name="partner_text" id="partner_text" cols="5" rows="5"  style="width: 98%;">{partner:partner_text}</textarea></td>
  </tr>
  <tr>
    <td class="leftc">{icon:images} {lang:navimg} </td>
    <td class="leftb"><div style="float: left;"> {partner:partner_nimg}<br /><input type="file" name="partner_nimg" value="" /><br />{clip:nimg}</div>
    <div style="float: right;"> <input type="checkbox" value="1" name="remove_nimg" /> {lang:remove}</div> </td>
  </tr>
  <tr>
    <td class="leftc">{icon:images} {lang:listimg} </td>
    <td class="leftb"><div style="float: left;">
    {partner:partner_limg}<br /><input type="file" name="partner_limg" value="" /><br />{clip:limg}</div>
    <div style="float: right;"> <input type="checkbox" value="1" name="remove_limg" /> {lang:remove}</div> </td>
  </tr>
  <tr>
    <td class="leftc">{icon:images} {lang:rotimg} </td>
    <td class="leftb"><div style="float: left;">
     {partner:partner_rimg}<br /> <input type="file" name="partner_rimg" value="" /><br />{clip:rimg}</div>
     <div style="float: right;"> <input type="checkbox" value="1" name="remove_rimg" /> {lang:remove}</div> </td>
  </tr>
  <tr>
   <td class="leftc">{icon:enumList} {lang:priority}</td>
   <td class="leftb"><input type="text" name="partner_priority" value="{partner:partner_priority}" maxlength="2" size="2" /></td>
 </tr>
 <tr>
   <td class="leftc">{icon:ksysguard} {lang:options}</td>
   <td class="leftb"><input type="submit" name="submit" value="{lang:edit}" />  <input type="hidden" name="id" value="{partner:partner_id}" /></td>
 </tr>
</table>
</form>