<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb">{lang:mod_name} - {lang:notifications}</td>
 </tr>
 <tr>
  <td class="leftb">{lang:manage_notifications}</td>
 </tr>
</table>
<br />

<form method="post" id="users_notifications" action="{url:users_notifications}">
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 {loop:notifications}
 <tr>
  <td class="leftc">{icon:resizecol} {notifications:lang}</td>
  <td class="leftb">
    {notifications:notify_methods}
  </td>
 </tr>
 {stop:notifications}
 <tr>
 <td class="leftc">{icon:ksysguard} {lang:options}</td>
  <td class="leftb">
    <input type="submit" name="submit" value="{lang:edit}" />
       </td>
 </tr>
</table>
</form>