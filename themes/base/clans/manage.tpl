<form method="post" action="{url:clans_manage}">
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
      <td class="headb" colspan="3">{lang:mod_name} - {lang:manage}</td>
   </tr>
   <tr>      
      <td class="leftb">{icon:contents} {lang:total}: {count:search}{count:all}</td>      
      <td class="rightb">{pages:list}</td>
   </tr>
  <tr>    
    <td class="leftb" colspan="2">
      {lang:search}: <input type="text" name="search_name" id="search_name" value="{search:name}" size="50" maxlength="100" />
      <input type="submit" name="{lang:submit}" />
    </td>    
  </tr>
  {if:done}
  <tr>
      <td class="leftc" colspan="4"> {lang:wizard}: {link:wizard}</td>
    </tr>
  {stop:done}
</table>
</form>
<br />
{head:message}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
      <td class="headb">{sort:name} {lang:name}</td>
      <td class="headb">{sort:short} {lang:short}</td>
      <td class="headb" colspan="2">{lang:options}</td>
   </tr>
   {loop:clans}
   <tr>
      <td class="leftc">{clans:name}</td>
      <td class="leftc">{clans:short}</td>
      <td class="leftc">{clans:edit}</td>
      <td class="leftc">{clans:remove}</td>
   </tr>
   {stop:clans}
</table>