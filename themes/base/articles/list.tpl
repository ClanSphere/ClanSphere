<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:head_list}</td>
  </tr>
  <tr>
    <td class="leftb">{lang:body_list} </td>
  </tr>
</table>
<br />

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
   <td class="headb">{sort:category} {lang:category}</td>
  <td class="headb">{lang:count}</td>
  </tr>{loop:categories}
  <tr>
     <td class="leftb">{categories:space} {categories:categories_name}</td>
    <td class="rightb" style="width: 50px;">{categories:articles_count}</td>
  </tr>
  <tr>
    <td class="leftb" colspan="2">{categories:space} {if:catimg}
      <img src="{page:path}{categories:url_catimg}" style="float:right" alt="" />{stop:catimg}
      {categories:categories_text}
     </td>
  </tr>{stop:categories}
</table>