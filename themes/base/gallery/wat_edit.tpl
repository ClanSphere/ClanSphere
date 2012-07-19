<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:head_create}</td>
  </tr>
  <tr>
    <td class="leftc">{head:body}</td>
  </tr>
</table>
<br />

<form method="post" id="watermark_edit" action="{url:gallery_wat_edit}" enctype="multipart/form-data">
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="leftc">{icon:xpaint} {lang:name} *</td>
    <td class="leftb"><input type="text" name="categories_name" value="{data:categories_name}" maxlength="80" size="40" /></td>
  </tr>
  <tr>
    <td class="leftc">{icon:images} {lang:current}</td>
    <td class="leftb">{wm:current}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:download} {lang:pic_up} *</td>
    <td class="leftb"><input type="file" name="picture" value="" /><br />
      <br />
      {picup:clip}
    </td>
  </tr>
  <tr>
    <td class="leftc">{icon:ksysguard} {lang:options}</td>
    <td class="leftb">
      <input type="hidden" name="id" value="{wm:id}" />
      <input type="submit" name="submit" value="{lang:edit}" />
          </td>
  </tr>
</table>
</form>