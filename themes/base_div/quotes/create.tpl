<div class="container" style="width:{page:width}">
    <div class="headb">{lang:mod} - {lang:create}</div>
    <div class="leftb">{head:body} {head:error}</div>
</div>
<br />

<form method="post" name="quotes_create" action="{url:action}">
  <table class="forum" cellpadding="0" cellspacing="1" style="width:{page:width}">
    <tr>
      <td class="leftc">{icon:kedit} {lang:headline} *</td>
      <td class="leftb">
        <input type="text" name="quotes_headline" value="{quotes:quotes_headline}" maxlength="200" size="50"  />
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:folder_yellow} {lang:categories} *</td>
      <td class="leftb">{categories:dropdown}</td>
    </tr>
    <tr>
      <td class="leftc">{icon:kate} {lang:text} *<br />
        <br />
        {data:smilies}</td>
      <td class="leftb">{abcode:features}<br />
        <textarea name="quotes_text" cols="99" rows="35" id="quotes_text"  style="width: 98%;">{quotes:quotes_text}</textarea>
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:ksysguard} {lang:options}</td>
      <td class="leftb"><input type="submit" name="submit" value="{lang:create}" />
        <input type="reset" name="reset" value="{lang:reset}" /></td>
    </tr>
  </table>
</form>
