<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="2"> {head:articles_headline} </td>
  </tr>
  <tr>
    <td class="leftb"> {lang:from} {head:users_link} {lang:at} {head:articles_date}</td>
    <td class="rightb"> {head:pages} </td>
  </tr>
</table>
<br />
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
<tr>
  <td class="leftb">{if:catimg}
    <img src="{page:path}{cat:url_catimg}" style="float:right" alt="" />{stop:catimg}
    {articles:articles_text}
  </td>
 </tr>
</table>