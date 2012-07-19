{if:buddys}
<table cellpadding="0" cellspacing="0" style="width:95%">{loop:users}
 <tr>
  <td>{users:countryicon} {users:url}</td>
  <td style="text-align:right;"><a href="{users:messageurl}">{icon:mail_send}</a></td>
 </tr>{stop:users}
</table>
{stop:buddys}

{if:empty}
{lang:no_buddys}
{stop:empty}