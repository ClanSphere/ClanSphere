<table cellpadding="0" cellspacing="{page:cellspacing}" style="width:100%">
{loop:cups}
 <tr>
  <td><a href="{cups:view_url}">{cups:cups_name}</a></td>
  <td style="text-align:right">{cups:cups_start}</td>
 </tr>{stop:cups}
</table>