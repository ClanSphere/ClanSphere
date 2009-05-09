<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width: 100%">
<tr>
{loop:keys}
  <td class="leftc">{keys:name}</td>
{stop:keys}
</tr>
{loop:more}
<tr>
{loop:values}
  <td class="leftb">{values:name}</td>
{stop:values}
</tr>
{stop:more}
</table>