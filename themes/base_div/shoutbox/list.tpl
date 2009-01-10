<div class="forum" style="width:{page:width}">
  <div class="headb">{lang:mod} - {lang:archieve}</div>
  <div class="headc clearfix">
  	<div class="leftb fl">{icon:contents} {lang:total}: {count:all}</div>
  	<div class="leftb fr">{pages:list}</div>
  </div>
</div>
<br />

<table class="forum" cellpadding="0" cellspacing="1" style="width:{page:width}">
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