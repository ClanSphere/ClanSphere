<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb" colspan="2">{lang:mod} - {lang:archieve}</td>
 </tr>
 <tr>
  <td class="leftc">{icon:contents} {lang:total}: {count:all}</td>
  <td class="leftc">{pages:list}</td>
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
  <td class="leftb">{shoutbox:shoutbox_name}</td>
  <td class="leftb">{shoutbox:shoutbox_text}</td>
  <td class="leftb">{shoutbox:date}</td>
 </tr>{stop:shoutbox}
</table>