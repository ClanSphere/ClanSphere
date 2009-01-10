{loop:cat}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:mod} - {cat:name}</td>
  </tr>
  <tr>
    <td class="leftb">{cat:text}</td>
  </tr>
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