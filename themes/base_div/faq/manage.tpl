<div class="container" style="width:{page:width}">
  <div class="headb"> {lang:mod} - {lang:head_manage}</div>
  <div class="headc clearfix">
    <div class="leftb fl">{icon:editpaste} {lang:create}</div>
    <div class="rightb fr">{pages:list}</div>
    <div class="centerb">{icon:contents} {lang:total}: {lang:count}</div>
  </div>
</div>
<br />
<center>
  {lang:getmsg}
</center>
<table class="forum" cellpadding="0" cellspacing="1" style="width:{page:width}">
  <tr>
    <td class="headb">{sort:question} {lang:frage}</td>
    <td class="headb">{lang:user}</td>
    <td class="headb">{sort:categorie} {lang:cat}</td>
    <td class="headb" colspan="2">{lang:options}</td>
  </tr>
  {loop:faq}
  <tr>
    <td class="leftc">{faq:question}</td>
    <td class="leftc">{faq:user}</td>
    <td class="leftc">{faq:cat}</td>
    <td class="leftc">{faq:edit}</td>
    <td class="leftc">{faq:remove}</td>
  </tr>
  {stop:faq}
</table>
