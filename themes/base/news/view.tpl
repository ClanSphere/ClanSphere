<br />
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
<tr>
<td class="newshead">
{news:news_headline}
</td>
</tr>
<tr>
<td class="bottom">
<div style="float:left">
{news:news_time} - {news:users_link}
</div>
<div style="float:right">
{news:comments_link} ({news:comments_count})
</div>
</td>
</tr>
<tr>
<td class="leftb">{if:catimg}
    <img src="{page:path}{news:url_catimg}" style="float:right" alt="" />{stop:catimg}
{news:news_readmore}{news:news_text}
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