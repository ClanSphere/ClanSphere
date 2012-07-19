<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
<tr>
 <td class="headb">{lang:mod_name}</td>
</tr>
 <tr>
<td class="leftb">{lang:text_list}</td>
 </tr>
</table>

<br />
{loop:history}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
<td class="bottom">{history:history_time} - {history:user}</td>
</tr>
 <tr>
   <td class="leftc">{history:history_text}</td>
 </tr>
</table>
<br />
{stop:history}