<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="2"> {lang:mod_name} - {lang:head_manage}</td>
  </tr>
  <tr>    
    <td class="leftb">{icon:contents} {lang:total}: {lang:count}</td>
    <td class="rightb">{pages:list}</td>
  </tr>
</table>
<br />
{lang:getmsg}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{sort:question} {lang:frage}</td>
    <td class="headb">{lang:user}</td>
    <td class="headb">{sort:category} {lang:cat}</td>
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
