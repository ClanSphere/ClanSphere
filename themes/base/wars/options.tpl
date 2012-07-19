<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb">{lang:mod_name} - {lang:options}</td>
 </tr>
 <tr>
  <td class="leftb">{lang:body_options}</td>
 </tr>
</table>
<br />
{head:message}

<form method="post" id="wars_options" action="{url:wars_options}">

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
  <td class="leftc">{icon:playlist} {lang:max_navlist}</td>
  <td class="leftb"><input type="text" name="max_navlist" value="{op:max_navlist}" maxlength="2" size="2" /></td>
 </tr>
 <tr>
  <td class="leftc">{icon:playlist} {lang:max_navlist2}</td>
  <td class="leftb"><input type="text" name="max_navlist2" value="{op:max_navlist2}" maxlength="2" size="2" /></td>
 </tr> 
 <tr>
  <td class="leftc">{icon:playlist} {lang:max_navnext}</td>
  <td class="leftb"><input type="text" name="max_navnext" value="{op:max_navnext}" maxlength="2" size="2" /></td>
 </tr> 
 <tr>
  <td class="leftc">{icon:knode} {lang:news_text}<br /><br />
    {lang:placeholders}:<br /><br />
    {loop:pholders}{pholders:holder} &raquo; {pholders:meaning}<br />
    {stop:pholders}</td>
  <td class="leftb"><textarea class="rte_abcode" name="news_text" cols="60" rows="20">{news:text}</textarea></td>
 </tr>
 <tr>
  <td class="leftc">{icon:ksysguard} {lang:options}</td>
  <td class="leftb">
    <input type="submit" name="submit" value="{lang:edit}" />
   </td>
 </tr>
</table>
</form>