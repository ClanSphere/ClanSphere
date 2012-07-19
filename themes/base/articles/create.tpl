  <table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
    <tr>
      <td class="headb">{lang:mod_name} - {lang:create}</td>
    </tr>
    <tr>
      <td class="leftb">{head:body}</td>
    </tr>
  </table>
<br />
{if:preview}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
   <td class="headb">{lang:mod_name} - {lang:preview}</td>
  </tr>
  <tr>
    <td class="leftb">{art:articles_headline}</td>
  </tr>
  <tr>
    <td class="leftc">{if:catimg}
    <img src="{page:path}{cat:url_catimg}" style="float:right" alt="" />{stop:catimg}
    {art:articles_text_preview}</td>
  </tr>
</table>
<br />
{stop:preview}

<form method="post" id="articles_create" action="{url:articles_create}" enctype="multipart/form-data">
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="leftc">{icon:kedit} {lang:headline} *</td>
    <td class="leftb"><input type="text" name="articles_headline" value="{art:articles_headline}" maxlength="200" size="50" /></td>
  </tr>
  <tr>
    <td class="leftc">{icon:folder_yellow} {lang:categories} *</td>
    <td class="leftb">{categories:dropdown}</td>
  </tr>
  {if:no_rte_html}
  <tr>
    <td class="leftb" colspan="2">{abcode:features}
      <input type="button" name="pagebreak" value="{lang:pagebreak}" onclick="javascript:abc_insert('[pagebreak]','','articles_text')" />
      <input type="button" name="sitelink" value="{lang:sitelink}" onclick="javascript:abc_insert('[pb_url=]{lang:sitelink}[/pb_url]','','articles_text')" /><br />
      <textarea name="articles_text" cols="99" rows="35" id="articles_text"  style="width: 98%;">{art:articles_text}</textarea></td>
  </tr>
  {stop:no_rte_html}
  {if:rte_html}
  <tr>
    <td colspan="2" style="padding:0px">{articles:content}</td>
  </tr>
  {stop:rte_html}
  <tr>
    <td class="leftc">{icon:configure} {lang:more}</td>
    <td class="leftb"><input type="checkbox" name="articles_com" value="1" {data:articles_com_checked} />
      {lang:nocom}<br />
      <input type="checkbox" name="articles_navlist" value="1" {data:articles_navlist_checked} />
      {lang:nav}<br />
      <input type="checkbox" name="articles_fornext" value="1" {data:articles_fornext_checked} />
      {lang:fornext}</td>
  </tr>
  {pictures:select}
  <tr>
    <td class="leftc">{icon:ksysguard} {lang:options}</td>
    <td class="leftb">
    <input type="submit" name="submit" value="{lang:create}" />
    <input type="submit" name="preview" value="{lang:preview}" />
       </td>
  </tr>
</table>
</form>
