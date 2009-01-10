  <div class="container" style="width:{page:width}">
      <div class="headb">{lang:mod} - {lang:create}</div>
      <div class="leftb">{head:body} {head:error}</div>
  </div>
<br />
{if:preview}
<div class="container" style="width:{page:width}">
   <div class="headb">{lang:mod} - {lang:preview}</div>
    <div class="leftb">{art:articles_headline}</div>
    <div class="leftc">{art:articles_text_preview}</div>
</div>
<br />
{stop:preview}

<form method="post" name="articles_create" action="{url:form}">
<table class="forum" cellpadding="0" cellspacing="1" style="width:{page:width}">
  <tr>
    <td class="leftc">{icon:kedit} {lang:headline} *</td>
    <td class="leftb"><input type="text" name="articles_headline" value="{art:articles_headline}" maxlength="200" size="50"  /></td>
  </tr>
  <tr>
    <td class="leftc">{icon:folder_yellow} {lang:categories} *</td>
    <td class="leftb">{categories:dropdown}</td>
  </tr>
  {if:nofckeditor}
  <tr>
    <td class="leftc" colspan="2">{abcode:features}{abcode:pagebreak}{abcode:sitelink}<br />
      <textarea name="articles_text" cols="99" rows="35" id="articles_text"  style="width: 98%;">{art:articles_text}</textarea></td>
  </tr>
  {stop:nofckeditor}
  {if:fckeditor}
  <tr>
    <td colspan="2" style="padding:0px">{articles:content}</td>
  </tr>
  {stop:fckeditor}
  <tr>
    <td class="leftc">{icon:configure} {lang:more}</td>
    <td class="leftb"><input type="checkbox" name="articles_com" value="1" />
      {lang:nocom}<br />
      <input type="checkbox" name="articles_navlist" value="1" />
      {lang:nav}<br />
      <input type="checkbox" name="articles_fornext" value="1" />
      {lang:fornext}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:ksysguard} {lang:options}</td>
    <td class="leftb">
		<input type="submit" name="submit" value="{lang:create}" />
		<input type="submit" name="preview" value="{lang:preview}" />
 		<input type="reset" name="reset" value="{lang:reset}" />
	</td>
  </tr>
</table>
</form>
