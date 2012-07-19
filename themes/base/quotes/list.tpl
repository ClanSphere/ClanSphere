<form method="post" action="{url:quotes_list}">
 <table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
   <td class="headb" colspan="2">{lang:mod_name} - {lang:list}</td>
 </tr>
 <tr>
  <td class="leftb">{lang:total}: {head:count}</td>
  <td class="rightb">{head:pages}</td>
 </tr>
 <tr>
  <td class="leftb" colspan="2">{lang:category}
    {head:dropdown}
    <input type="submit" name="submit" value="{lang:show}" />
  </td>
 </tr>
</table>
</form>
<br />

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb" style="width:30%;">{sort:quotes_time} {lang:date}</td>
  <td class="headb">{sort:quotes_headline} {lang:headline}</td>
 </tr>{loop:quotes}
 <tr>
  <td class="leftc">{quotes:quotes_time}</td>
  <td class="leftc">{quotes:quotes_headline}</td>
 </tr>{stop:quotes}
</table>