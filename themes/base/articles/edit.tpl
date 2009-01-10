  <table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
    <tr>
      <td class="headb">{lang:mod} - {lang:edit}</td>
    </tr>
    <tr>
      <td class="leftb"> {head:body} {head:error}</td>
    </tr>
  </table>
<br />
{if:preview}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
   <td class="headb">{lang:mod} - {lang:preview}</td>
  </tr>
  <tr>
    <td class="leftb">{data:articles_headline}</td>
  </tr>
  <tr>
    <td class="leftc">{if:catimg}
    <img src="{page:path}{cat:url_catimg}" style="float:right" alt="" />{stop:catimg}
    {art:articles_text_preview}</td>
  </tr>
</table>
<br />
{stop:preview}

<form method="post" name="articles_create" action="{url:articles_edit}">
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="leftc">{icon:kedit} {lang:headline} *</td>
    <td class="leftb"><input type="text" name="articles_headline" value="{data:articles_headline}" maxlength="200" size="50"  /></td>
  </tr>
  <tr>
    <td class="leftc">{icon:folder_yellow} {lang:categories} *</td>
    <td class="leftb">{categories:dropdown}</td>
  </tr>
  {if:nofckeditor}
  <tr>
    <td class="leftc" colspan="2">{abcode:features}{abcode:pagebreak}{abcode:sitelink}<br />
      <textarea name="articles_text" cols="99" rows="35" id="articles_text"  style="width: 98%;">{data:articles_text}</textarea></td>
  </tr>
  {stop:nofckeditor}
  {if:fckeditor}
  <tr>
    <td colspan="2" style="padding:0px">{articles:content}</td>
  </tr>
  {stop:fckeditor}
  <tr>
    <td class="leftc">{icon:configure} {lang:more}</td>
    <td class="leftb"><input type="checkbox" name="articles_com" value="1"  {data:articles_com_checked} />
      {lang:nocom}<br />
      <input type="checkbox" name="articles_navlist" value="1"  {data:articles_navlist_checked} />
      {lang:nav}<br />
      <input type="checkbox" name="articles_fornext" value="1"  {data:articles_fornext_checked} />
      {lang:fornext}<br />
	  <input type="checkbox" name="articles_newtime" value="1" />
      {lang:new_date}</td>
  </tr>
  {pictures:select}
  <tr>
    <td class="leftc">{icon:ksysguard} {lang:options}</td>
    <td class="leftb">
		<input type="hidden" name="id" value="{data:articles_id}" />
		<input type="hidden" name="articles_time" value="{data:articles_time}" />
		<input type="submit" name="submit" value="{lang:edit}" />
	    <input type="submit" name="preview" value="{lang:preview}" />
 		<input type="reset" name="reset" value="{lang:reset}" />
	</td>
  </tr>
</table>
</form>
