<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:list}</td>
  </tr>
  <tr>
    <td class="leftb">{lang:total}: {count:faq}</td>
  </tr>
</table>
<br />
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  {loop:categories}
  <tr>
    <td class="headb" colspan="2"><a href="{url:faq_view:id={categories:categories_id}}">{categories:categories_name}</a></td>
  </tr>
  {loop:faq}
  <tr>
    <td class="leftc">{faq:faq_question}</td>
    <td class="rightb">{faq:faq_answer}</td>
  </tr>
  {stop:faq}
  {stop:categories}
</table>
