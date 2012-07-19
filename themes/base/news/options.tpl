<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb">{lang:mod_name} - {lang:options}</td>
 </tr>
 <tr>
  <td class="leftb">{lang:options_info}</td>
 </tr>
</table>
<br />

<form method="post" action="{url:news_options}">
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
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
  <td class="leftc">{icon:document} {lang:def_public}</td>
  <td class="leftb">
    <input type="radio" name="def_public" value="1"{op:public_yes} />
    {lang:yes}
    <input type="radio" name="def_public" value="0"{op:public_no} />
    {lang:no}
  </td>
 </tr>
 <tr>
  <td class="leftc">{icon:playlist} {lang:max_navlist}</td>
  <td class="leftb"><input type="text" name="max_navlist" value="{op:max_navlist}" maxlength="2" size="2" /></td>
 </tr>
 <tr>
  <td class="leftc">{icon:playlist} {lang:max_headline}</td>
  <td class="leftb"><input type="text" name="max_headline" value="{op:max_headline}" maxlength="2" size="2" /></td>
 </tr> 
 <tr>
  <td class="leftc">{icon:playlist} {lang:max_recent}</td>
  <td class="leftb"><input type="text" name="max_recent" value="{op:max_recent}" maxlength="2" size="2" /></td>
 </tr>
 <tr>
  <td class="leftc">{icon:folder_red} {lang:rss_title}</td>
  <td class="leftb"><input type="text" name="rss_title" value="{op:rss_title}" maxlength="80" size="30" /></td>
 </tr>
 <tr>
  <td class="leftc">{icon:kate} {lang:rss_description}</td>
  <td class="leftb"><input type="text" name="rss_description" value="{op:rss_description}" maxlength="160" size="40" /></td>
 </tr>
 <tr>
  <td class="leftc">{icon:kate} {lang:abcode}</td>
  <td class="leftb">
    <input type="checkbox" name="features" value="1" {op:features} />{lang:features}<br />
    <input type="checkbox" name="smileys" value="1" {op:smileys} />{lang:smileys}<br />
    <input type="checkbox" name="clip" value="1"  {op:clip} />{lang:clip}<br />
    <input type="checkbox" name="html" value="1" {op:html} />{lang:html}<br />    
  <input type="checkbox" name="php" value="1"  {op:php} />{lang:php}<br />
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