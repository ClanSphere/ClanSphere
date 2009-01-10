<div class="container" style="width:{page:width}">
    <div class="headb">{lang:mod} - {lang:head_lang_view}</div>
  <div class="headc clearfix">
    <div class="leftb">{lang:body}</div>
    <div class="centerb">{icon:ark} <a href="{link:cache}">{lang:cache}</a> </div>
  </div>
</div>
<br />
<table class="forum" cellpadding="0" cellspacing="1" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:name}</td>
    <td class="headb">{lang:active}</td>
  </tr>
  {loop:themes_list}
  <tr>
    <td class="leftb">{themes_list:name}</td>
    <td class="leftb">{themes_list:active}</td>
  </tr>
  {stop:themes_list}
</table>
