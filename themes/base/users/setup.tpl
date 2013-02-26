<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:users} - {head:action} </td>
  </tr>
  <tr>
    <td class="leftb"> {head:body_text} </td>
  </tr>
{if:done}
  <tr>
    <td class="leftc" colspan="3"> {lang:wizard}: {link:wizard}</td>
  </tr>
{stop:done}
</table>
<br />

<form method="post" id="users_setup" action="{url:users_setup}">
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
      <td class="leftc">{icon:locale} {lang:lang}</td>
      <td class="leftb">
      <select name="users_lang">
        {setup:languages}        
      </select>
      </td>
   </tr>
   <tr>
      <td class="leftc">{icon:ktimer} {lang:timezone}</td>
      <td class="leftb">
      <select name="users_timezone">
        {setup:timezone} 
      </select>
      </td>
   </tr>
   <tr>
      <td class="leftc">{icon:kweather} {lang:dstime}</td>
      <td class="leftb">
         <select name="users_dstime">
          {setup:option_automatic}
          {setup:option_on}
          {setup:option_off}
         </select>
      </td>
   </tr>
   <tr>
      <td class="leftc">{icon:view_text} {lang:datasheet_per_page}</td>
      <td class="leftb" colspan="2"><input type="text" name="users_limit" value="{data:users_limit}" maxlength="2" size="4" /></td>
   </tr>
   <tr>
      <td class="leftc">{icon:view_text} {lang:readtime}</td>
      <td class="leftb" colspan="2"><input type="text" name="users_readtime" value="{data:users_readtime}" maxlength="4" size="4" /> {lang:days}</td>
   </tr>
   <tr>
      <td class="leftc">{icon:view_text} {lang:homelimit}</td>
      <td class="leftb" colspan="2"><input type="text" name="users_homelimit" value="{data:users_homelimit}" maxlength="4" size="4" /></td>
   </tr>
   <tr>
      <td class="leftc">{icon:view_choose} {lang:view}</td>
      <td class="leftb" colspan="2">{setup:view_type}</td>
   </tr>
   <tr>
      <td class="leftc">{icon:goto} {lang:invisible}</td>
      <td class="leftb" colspan="2">{setup:users_invisible}</td>
   </tr>
   <tr>
      <td class="leftc">{icon:mail_generic} {lang:abomail}</td>
      <td class="leftb" colspan="2">{setup:users_abomail}</td>
   </tr>
   {if:ajax_allowed}
   <tr>
      <td class="leftc">{icon:agt_reload} {lang:ajax}</td>
      <td class="leftb" colspan="2">{setup:users_ajax}</td>
   </tr>
   {stop:ajax_allowed}
   <tr>
      <td class="leftc">{icon:ksysguard} {lang:options}</td>
      <td class="leftb">
         <input type="submit" name="submit" value="{lang:save}" />
               </td>
   </tr>
</table>
</form>