{loop:cat}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:mod_name} - {cat:name}</td>
  </tr>
  {if:cat_text}
  <tr>
    <td class="leftb">{cat:text}</td>
  </tr>
  {stop:cat_text}
</table>
{stop:cat} <br />
{loop:faq}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb"> # {faq:num} {faq:question}</td>
  </tr>
  <tr>
    <td class="leftb">{faq:answer}</td>
  </tr>
</table>
<br />
{stop:faq} 