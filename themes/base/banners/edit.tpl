<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:head_edit}</td>
  </tr>
  <tr>
    <td class="leftc">{lang:body}</td>
  </tr>
</table>
<br />
<form method="post" id="banners_create" action="{action:form}" enctype="multipart/form-data">
  <table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
    <tr>
      <td class="leftc">{icon:kblackbox} {lang:name} *</td>
      <td class="leftb"><input type="text" name="banners_name" value="{banners:name}" maxlength="80" size="40" />
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:folder_yellow} {lang:category} *</td>
      <td class="leftb">{banners:category} </td>
    </tr>
    <tr>
      <td class="leftc">{icon:gohome} {lang:url} *</td>
      <td class="leftb"> http://
        <input type="text" name="banners_url" value="{banners:url}" maxlength="80" size="50" />
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:images} {lang:pic_current}</td>
      <td class="leftb">{banners:pic_current}</td>
    </tr>
    <tr>
      <td class="leftc">{icon:download} {lang:pic_up} *</td>
      <td class="leftb"><input type="file" name="picture" value="" />
        <br />
        <br />
        {banners:clip} <br />
        {lang:or_img_url}<br />
        <input type="text" name="banners_picture" value="{banners:or_img_url}" maxlength="80" size="50" />
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:documentinfo} {lang:alt}</td>
      <td class="leftb"><input type="text" name="banners_alt" value="{banners:alt}" maxlength="80" size="40" />
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:enumList} {lang:order}</td>
      <td class="leftb"><input type="text" name="banners_order" value="{banners:order}" maxlength="4" size="4" />
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:ksysguard} {lang:options}</td>
      <td class="leftb"><input type="hidden" name="id" value="{data:id}" />
        <input type="submit" name="submit" value="{lang:edit}" />
              </td>
    </tr>
  </table>
</form>
