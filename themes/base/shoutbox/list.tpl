<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb" colspan="2">{lang:mod_name} - {lang:archieve}</td>
 </tr>
 <tr>
  <td class="leftb">{icon:contents} {lang:total}: {count:all}</td>
  <td class="leftb">{pages:list}</td>
 </tr>
</table>
<br />

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb">{sort:nick} {lang:nick}</td>
  <td class="headb">{sort:msg} {lang:message}</td>
  <td class="headb">{sort:date} {lang:date}</td>
 </tr>{loop:shoutbox}
 <tr>
  <td class="leftc">{shoutbox:shoutbox_name}</td>
  <td class="leftc">{shoutbox:shoutbox_text}</td>
  <td class="leftc">{shoutbox:date}</td>
 </tr>{stop:shoutbox}
</table>