<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb">{lang:mod_name}</td>
 </tr>
 <tr>
  <td class="leftb">{count:rules}</td>
 </tr>
</table>
<br />

{loop:rules}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb">{rules:cat} ({rules:count_cat})</td>
 </tr>
 <tr>
  <td class="leftb">{rules:cat_text}</td>
 </tr>
</table>
<br />
{stop:rules}
<br />
