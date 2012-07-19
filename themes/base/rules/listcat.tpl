<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb">{lang:mod_name} - {cat_data:name}</td>
 </tr>
 <tr>
  <td class="leftb">{cat_data:text}</td>
 </tr>
</table>
<br />

{loop:rules}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb">&sect; {rules:order} {rules:title}</td>
 </tr>
 <tr>
  <td class="leftb">{rules:rule}</td>
 </tr>
</table>
<br />
{stop:rules}
