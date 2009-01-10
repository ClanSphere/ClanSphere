<div class="container" style="width:{page:width}">
    <div class="headb">{lang:mod} - {lang:list}</div>
    <div class="leftb">{icon:contents} {lang:total}: {count:faq}</div>
</div>
<br />
<div class="container" style="width:{page:width}">
  {loop:categories}
    <div class="headb"><a href="{url:faq_view,id={categories:categories_id}}">{categories:categories_name}</a></div>
  {loop:faq}
    <div class="leftc fl">{faq:faq_question}</div>
    <div class="rightb fr">{faq:faq_answer}</div>
  {stop:faq}
  {stop:categories}
</div>
