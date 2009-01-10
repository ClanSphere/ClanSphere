{loop:cat}
<div class="container" style="width:{page:width}">
    <div class="headb">{lang:mod} - {cat:name}</div>
    <div class="leftb">{cat:text}</div>
</div>
{stop:cat} <br />
{loop:faq}
<div class="container" style="width:{page:width}">
    <div class="headb"> # {faq:num} {faq:question}</div>
    <div class="leftb">{faq:answer}</div>
</div>
<br />
{stop:faq} 