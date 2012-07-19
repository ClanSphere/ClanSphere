<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb" colspan="2">{lang:head}</td>
 </tr>
 <tr>
  <td class="leftb">{lang:text1} <b>{online:online}</b> {lang:text2}</td>
  <td class="rightb">{head:pages}</td>
 </tr>
</table>
<br />

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb">{lang:last}</td>
  <td class="headb">{lang:now}</td>
 </tr>{loop:count}
 <tr>
  <td class="leftc">{count:count_time}</td>
  <td class="leftc">{count:count_location}</td>
 </tr>{stop:count}
</table>