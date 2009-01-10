<div class="container" style="width:{page:width}">
  <div class="headb">{lang:mod} - {lang:head_list}</div>
  <div class="leftb">{lang:body_list}</div>
</div>
<br />
{head:getmsg}
<table class="forum" cellpadding="0" cellspacing="1" style="width:{page:width}">
 <tr>
  <td class="headb" colspan="4">{lang:last10}</td>
 </tr>
 <tr>
  <td class="leftb" colspan="2">{icon:contents} {lang:total}: {head:count}</td>
  <td class="centerb" colspan="2">{head:pages}</td>
 </tr>
 <tr>
  <td class="leftc">{sort:question} {lang:last10_quest}</td>
  <td class="leftc">{lang:last10_com}</td>
  <td class="leftc">{lang:last10_ans}</td>
  <td class="leftc" style="width:170px">{sort:ends_on} {lang:last10_end}</td>
 </tr>
{loop:votes}
 <tr>
  <td class="leftb">{votes:question_link}</td>
  <td class="rightb" style="width:80px">{votes:com_count}</td>
  <td class="rightb" style="width:80px">{votes:elect_count}</td>
  <td class="rightb" style="widht:170px">{votes:ends_on}</td>
 </tr>
 {stop:votes}
</table>
