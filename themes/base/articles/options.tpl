<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
      <td class="headb">{lang:mod_name} - {lang:options}</td>
   </tr>
   <tr>
      <td class="leftb">{lang:options_info}</td>
   </tr>
</table>
<br />

<form method="post" action="{url:articles_options}">
  <table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
     <tr>
        <td class="leftc">{icon:playlist} {lang:max_navlist}</td>
        <td class="leftb"><input type="text" name="max_navlist" value="{op:max_navlist}" maxlength="2" size="2" /></td>
     </tr> 
     <tr>
        <td class="leftc">{icon:playlist} {lang:max_navtop}</td>
        <td class="leftb"><input type="text" name="max_navtop" value="{op:max_navtop}" maxlength="2" size="2" /></td>
     </tr>      
     <tr>
        <td class="leftc">{icon:ksysguard} {lang:options}</td>
        <td class="leftb"><input type="submit" name="submit" value="{lang:edit}" /></td>
     </tr>
  </table>
</form>