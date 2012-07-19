<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb">{lang:mod_name} - {lang:options}</td>
 </tr>
 <tr>
  <td class="leftb">{lang:errors_here}</td>
 </tr>
</table>
<br />
{lang:getmsg}
<form method="post" action="{url:events_options}">
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="leftc">{icon:resizecol} {lang:max_width}</td>
  <td class="leftb"><input type="text" name="max_width" value="{op:max_width}" maxlength="4" size="4" /> {lang:pixel}</td>
 </tr>
 <tr>
  <td class="leftc">{icon:resizerow} {lang:max_height}</td>
  <td class="leftb"> <input type="text" name="max_height" value="{op:max_height}" maxlength="4" size="4" /> {lang:pixel}</td>
 </tr>
 <tr>
  <td class="leftc">{icon:fileshare} {lang:max_size}</td>
  <td class="leftb"><input type="text" name="max_size" value="{op:max_size}" maxlength="20" size="8" /> {lang:bytes}</td>
 </tr>
 <tr>
  <td class="leftc">{icon:kdict} {lang:require}</td>
  <td class="leftb">
    <input type="checkbox" name="req_fullname" value="1" {checked:req_fullname} /> {lang:req_fullname}<br />
    <input type="checkbox" name="req_fulladress" value="1" {checked:req_fulladress} /> {lang:req_fulladress}<br />
    <input type="checkbox" name="req_mobile" value="1" {checked:req_mobile} /> {lang:req_mobile}<br />
    <input type="checkbox" name="req_phone" value="1" {checked:req_phone} /> {lang:req_phone}
  </td>
 </tr>
 <tr>
  <td class="leftc">{icon:configure} {lang:extended}</td>
  <td class="leftb">
    <input type="checkbox" name="show_wars" value="1" {checked:show_wars} /> {lang:show_wars}
  </td>
 </tr>
 <tr>
  <td class="leftc">{icon:playlist} {lang:max_navbirthday}</td>
  <td class="leftb"><input type="text" name="max_navbirthday" value="{op:max_navbirthday}" maxlength="2" size="2" /></td>
 </tr>
 <tr>
  <td class="leftc">{icon:playlist} {lang:max_navnext}</td>
  <td class="leftb"><input type="text" name="max_navnext" value="{op:max_navnext}" maxlength="2" size="2" /></td>
 </tr>
 <tr>
  <td class="leftc">{icon:ksysguard} {lang:options}</td>
  <td class="leftb">
    <input type="submit" name="submit" value="{lang:save}" />
      </td>
 </tr>
</table>
</form>