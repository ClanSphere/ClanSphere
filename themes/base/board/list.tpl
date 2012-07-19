<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb" colspan="5">{lang:mod_name} - {lang:head_list}</td>
 </tr>
 <tr>
  <td class="centerb" style="width:20%"><a href="{url:board_new}">{lang:new}</a></td>
  <td class="centerb" style="width:20%"><a href="{url:board_active}">{lang:active}</a></td>
  <td class="centerb" style="width:20%"><a href="{url:board_toplist}">{lang:toplist}</a></td>
  <td class="centerb" style="width:20%"><a href="{url:board_stats}">{lang:stats}</a></td>
  <td class="centerb" style="width:20%"><a href="{url:board_search}">{lang:search}</a></td>
 </tr>
 <tr>
  <td class="leftc" colspan="2"><a href="{url:board_list}">{lang:board}</a>
    {if:category} -&gt; {category:name}{stop:category}</td>
  <td class="rightc" colspan="3"><a href="{url:board_mark}">{lang:mark_all}</a></td>
 </tr>
</table>
<br />
{head:message}

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb" colspan="2">{lang:board}</td>
  <td class="headb">{lang:topics}</td>
  <td class="headb">{lang:replies}</td>
  <td class="headb">{lang:lastpost}</td>
 </tr>
 {loop:categories}
 <tr>
  <td class="leftc" colspan="5">
    {categories:blank}<a href="{categories:list_url}">{categories:categories_name}</a>
    {if:small_subforums}<br />{categories:blank}{lang:subforums}:
    {loop:subboard}
    <a href="{url:board_listcat:id={subboard:board_id}}">{subboard:board_name}</a>{subboard:comma}
    {stop:subboard}
    {stop:small_subforums}
  </td>
 </tr>
   {loop:board}
   <tr>
    <td class="leftb" style="width:{categories:iconwidth}px">{categories:blank}{board:icon}</td>
    <td class="leftb"><strong><a href="{board:listcat_url}">{board:board_name}</a></strong>
      <br />{board:board_text}</td>
    <td class="rightb" style="width:60px">{board:board_threads}</td>
    <td class="rightb" style="width:60px">{board:board_comments}</td>
    <td class="leftb" style="width:180px">
      <a href="{board:last_url}">{board:last_name}</a>
      <br />{board:last_time}
      <br />{board:of} {board:last_usernick}</td>
   </tr>
   {stop:board}
 {stop:categories}
 <tr>
  <td class="rightc" colspan="5"><a href="{url:board_mark}">{lang:mark_all}</a></td>
 </tr>
</table>
<br />
{board:statistik}