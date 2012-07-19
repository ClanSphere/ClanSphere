<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
      <td class="headb">{lang:mod_name} - {lang:options}</td>
   </tr>
   <tr>
      <td class="leftb">{lang:options_info}</td>
   </tr>
</table>
<br />

<form method="post" action="{url:files_options}">
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
        <td class="leftc">{icon:playlist} {lang:max_headline}</td>
        <td class="leftb"><input type="text" name="max_headline" value="{op:max_headline}" maxlength="2" size="2" /></td>
     </tr>
     <tr>
        <td class="leftc">{icon:playlist} {lang:max_navtop}</td>
        <td class="leftb"><input type="text" name="max_navtop" value="{op:max_navtop}" maxlength="2" size="2" /></td>
     </tr>
     <tr>
        <td class="leftc">{icon:playlist} {lang:max_headline_navtop}</td>
        <td class="leftb"><input type="text" name="max_headline_navtop" value="{op:max_headline_navtop}" maxlength="2" size="2" /></td>
     </tr>      
      
     <tr>
        <td class="leftc">{icon:ksysguard} {lang:options}</td>
        <td class="leftb"><input type="submit" name="submit" value="{lang:edit}" /></td>
     </tr>
  </table>
</form>