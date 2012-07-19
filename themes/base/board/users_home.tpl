<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb" colspan="3">{lang:last_threads}</td>
 </tr>
 <tr>
  <td class="leftc">{lang:board}</td>
  <td class="leftc">{lang:topic}</td>
  <td class="leftc" style="width:180px">{lang:lastpost}</td>
 </tr>{loop:threads}
 <tr>
  <td class="leftb">
    <a href="{url:board_list:id={threads:categories_id}}">{threads:categories_name}</a><br /> -&gt; 
    <a href="{url:board_listcat:id={threads:board_id}}">{threads:board_name}</a>
  </td>
  <td class="leftb">
    <strong><a href="{url:board_thread:where={threads:threads_id}:start={threads:new_posts}}">{threads:threads_headline}</a></strong>
    {threads:pages}
  </td>
  <td class="leftb">{threads:threads_last_time}{threads:users_nick}</td>
 </tr>{stop:threads}
</table>
<br />