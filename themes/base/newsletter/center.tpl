<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width};">
  <tr>
    <td class="headb"> {lang:mod_name} - {lang:users} </td>
  </tr>
  <tr>
    <td class="leftb"> {head:body_text}</td>
  </tr>
  <tr>
    <td class="centerb">{head:back}</td>
  </tr>
</table>
<br />
<form method="post" id="newsletter_subscribe" action="{url:action}">
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width};">
  <tr>
    <td class="leftc" style="width: 100px;"> {icon:mail} {lang:mod_name}</td>
    <td class="leftb"><input type="checkbox" name="newsletter" value="1" {newsletter:checked} /> {lang:subscribe}</td>
  </tr>
  <tr>
    <td class="leftc"> {icon:ksysguard} {lang:options}</td>
    <td class="leftb"><input type="submit" name="submit" value="{lang:edit}" /></td>
  </tr>  
</table>
</form>