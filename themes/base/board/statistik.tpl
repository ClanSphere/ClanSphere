{if:list}
<table style="width:{page:width}" class="forum" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="centerb" style="vertical-align:middle;"><img src="{page:path}symbols/board/board_read_.png" alt="" width="32" height="32" /></td>
  <td class="leftb" style="vertical-align:middle;">{lang:no_stats_thread}</td>
    <td class="centerb" style="vertical-align:middle;"><img src="{page:path}symbols/board/board_unread_.png" alt="" width="32" height="32" /></td>
  <td class="leftb" style="vertical-align:middle;">{lang:new_stats_thread}</td>
    <td class="centerb" style="vertical-align:middle;"><img src="{page:path}symbols/board/password.png" alt="" width="32" height="32" /></td>
  <td class="leftb" style="vertical-align:middle;">{lang:pw_stats_thread}</td>    
  </tr>
</table>  
{stop:list}

{if:listcat}
<table style="width:{page:width}" class="forum" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="leftc" colspan="6">{lang:threads_normale}</td>
  </tr>
  <tr>
    <td class="centerb" style="vertical-align:middle;"><img src="{page:path}symbols/board/post_.png" alt="" width="32" height="32" /></td>
  <td class="leftb" style="vertical-align:middle;">{lang:no_stats_thread}</td>
    <td class="centerb" style="vertical-align:middle;"><img src="{page:path}symbols/board/post_unread_.png" alt="" width="32" height="32" /></td>
  <td class="leftb" style="vertical-align:middle;">{lang:new_stats_thread}</td>
    <td class="centerb" style="vertical-align:middle;"><img src="{page:path}symbols/board/post_close_.png" alt="" width="32" height="32" /></td>
  <td class="leftb" style="vertical-align:middle;">{lang:thread_closed}</td>    
  </tr>
  <tr>
    <td class="leftc" colspan="6">{lang:threads_important}</td>
  </tr>
  <tr>
    <td class="centerb" style="vertical-align:middle;"><img src="{page:path}symbols/board/post_important_.png" alt="" width="32" height="32" /></td>
  <td class="leftb" style="vertical-align:middle;">{lang:thread_important}</td>
    <td class="centerb" style="vertical-align:middle;"><img src="{page:path}symbols/board/post_unread_important_.png" alt="" width="32" height="32" /></td>
  <td class="leftb" style="vertical-align:middle;">{lang:new_stats_thread}</td>
    <td class="centerb" style="vertical-align:middle;"><img src="{page:path}symbols/board/post_close_important_.png" alt="" width="32" height="32" /></td>
  <td class="leftb" style="vertical-align:middle;">{lang:thread_closed}</td>    
  </tr>  
</table> 
{stop:listcat}
<br />

<table style="width:{page:width}" class="forum" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb" colspan="2">{lang:board_stats}</td>
  </tr>
  <tr>
  <td class="centerb" style="width:10%"><img src="{page:path}symbols/board/agt_forum.png" alt="" width="32" height="32" /></td>
  <td class="leftb"  style="width:90%">
    {stats:online}<br />
      {lang:stats_newest}{user:newest}<br />
    <hr />
    {loop:users}{users:nick}{stop:users}<br />
  </td>
  </tr>
  <tr>
    <td class="centerb" style="width:10%; vertical-align:middle;"><img src="{page:path}symbols/board/stats.png" alt="" width="32" height="32" /></td>
    <td class="leftb"  style="width:90%">
    {lang:all_users}{user:all}<br />
    {lang:threads_and} {stats:threads}<br />
    {lang:replies}: {stats:comments}<br />
  </td>
  </tr>
</table>


