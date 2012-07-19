<div id="search_users" style="padding: 0; margin: 0; position: absolute">
<table class="forum" cellpadding="0" cellspacing="0" style="padding: 0; margin: 0; width: 100%">
{loop:result}
  <tr>
    <td class="leftb">
      <a onclick="document.getElementById('search_users').style.visibility = 'hidden'" href="javascript:abc_set('{data:old}{result:users_nick}', '{data:target}')">{result:users_nick}</a>
    </td>
  </tr>
{stop:result}
</table>
</div>