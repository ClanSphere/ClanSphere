
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="leftc">{votes:question}</td>
 </tr>
</table>
<br />

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb">{sort:answer} {lang:answer}</td>
  <td class="headb" style="width:120px">{sort:bar} {lang:bar}</td>
  <td class="headb" style="width:85px">{sort:percent} {lang:percent}</td>
  <td class="headb" style="width:85px">{sort:elections} {lang:elections}</td>
 </tr>
{loop:answers}
 <tr>
  <td class="leftb">{answers:answer}<div style="float:right;text-align:right;height:13px;width:35px;vertical-align:middle">&nbsp;</div></td>
  <td class="leftb" style="width:120px">
   <div style="background-image:url({page:path}symbols/votes/vote03.png); width:100px; height:13px;">
   <div style="background-image:url({page:path}symbols/votes/vote01.png); width:{answers:percent}px; text-align:right; padding-left:1px">
   {answers:end_img}</div></div>
  </td>
  <td class="rightb">{answers:percent}%</td>
  <td class="rightb">{answers:count}</td>
 </tr>
{stop:answers}
 <tr>
  <td class="rightc" colspan="3">{lang:total}</td>
  <td class="rightc">{votes:answers_count}</td>
 </tr>
</table>
