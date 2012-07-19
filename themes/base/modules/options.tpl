<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:options}</td>
   </tr>
   <tr>
      <td class="leftb">{lang:options_info}</td>
   </tr>
</table>
<br />
<form method="post" action="{url:modules_options}">
  <table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
     {loop:mods}
      <tr>
        <td class="headb" colspan="2">{mods:mod}</td>
       </tr>   
       {loop:navlist}
        <tr>
          <td class="leftc" style="width:200px;">{icon:playlist}&nbsp;&nbsp;{navlist:type}</td>
          <td class="leftb"><input type="text" name="{navlist:ivalue}" value="{navlist:value}" size="2" maxlength="3" /></td>
        </tr>
      {stop:navlist}   
     {stop:mods}
     <tr>
       <td class="leftc">{icon:ksysguard} {lang:options}</td>
       <td class="leftb"><input type="submit" value="{lang:save}" name="submit" /></td>
     </tr>
  </table>
</form>