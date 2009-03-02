<form method="post" action="{url:news_recent}">
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb" colspan="3">{lang:mod} - {lang:recent}</td>
 </tr>
 <tr>
  <td class="leftb">{lang:category}
	{head:dropdown}
	<input type="submit" name="submit" value="{lang:show}" />
  </td>
  <td class="leftb"><a href="{url:news_list}">{lang:list}</a></td>
  <td class="rightb">{head:pages}</td>
 </tr>
</table>
</form>

{loop:news}
<br />
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="newshead">
   <div style="float:left">{news:news_headline}</div>
   <div style="float:right">{news:categories_name}</div>
  </td>
 </tr>
 <tr>
  <td class="bottom">
    <div style="float:left">{news:news_time} - {news:users_link}</div>
    <div style="float:right">{news:comments_link} ({news:comments_count})</div>
  </td>
 </tr>
 <tr>
  <td class="leftb">{if:catimg}
    <img src="{page:path}{news:url_catimg}" style="float:right" alt="" />{stop:catimg}
    {news:news_readmore}<a href="{news:news_readmore_link}">{lang:readmore_go}</a>{news:news_text}<br />
{news:pictures}
  </td>
 </tr>
 {if:show}
 <tr>
  <td class="leftb">{lang:mirror}: {loop:mirror}{mirror:news_mirror}{mirror:dot}{stop:mirror}
  </td>
 </tr>
 {stop:show}
</table>
{stop:news}