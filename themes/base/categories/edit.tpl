<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:edit}</td>
  </tr>
  <tr>
    <td class="leftc">{head:body}</td>
  </tr>
</table>
<br />

<form method="post" id="categories_edit" action="{url:categories_edit}" enctype="multipart/form-data">
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="leftc">{icon:folder_yellow} {lang:name} *</td>
    <td class="leftb"><input type="text" name="categories_name" value="{cat:categories_name}" maxlength="80" size="40" /></td>
  </tr>
  <tr>
    <td class="leftc">{icon:add_sub_task} {lang:subcat_of}</td>
    <td class="leftb">
      <div id="cat_dropdown">
        {cat:subcat_of}
      </div>
    </td>
  </tr>
  <tr>
    <td class="leftc">{icon:kcmdf} {lang:modul} *</td>
    <td class="leftb">{cat:mod_name}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:access} {lang:needed_access}</td>
    <td class="leftb" colspan="2">
      <select name="categories_access">
        {loop:access}
        {access:sel}
        {stop:access}
      </select>
    </td>
  </tr>
  <tr>
    <td class="leftc">{icon:gohome} {lang:url}</td>
    <td class="leftb" colspan="2">http:// <input type="text" name="categories_url" value="{cat:categories_url}" maxlength="80" size="50" /></td>
  </tr>
  <tr>
    <td class="leftc">{icon:kate} {lang:text}<br />
      <br />
      {cat:abcode_smileys}
    </td>
    <td class="leftb">
      {cat:abcode_features}
      <textarea class="rte_abcode" name="categories_text" cols="50" rows="8" id="categories_text">{cat:categories_text}</textarea>
    </td>
  </tr>
  <tr>
    <td class="leftc">{icon:enumList} {lang:priority}</td>
    <td class="leftb"><input type="text" name="categories_order" value="{cat:categories_order}" maxlength="2" size="2" /></td>
  </tr>
  <tr>
    <td class="leftc">{icon:images} {lang:pic_current}</td>
    <td class="leftb">{cat:current_pic}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:download} {lang:pic_up}</td>
    <td class="leftb">
      <input type="file" name="picture" value="" /><br />
      <br />
      {cat:picup_clip}
    </td>
  </tr>
  {if:more}
  <tr>
    <td class="leftc">{icon:configure} {lang:more}</td>
    <td class="leftb"><input type="checkbox" name="delete" value="1" />{lang:pic_remove}</td>
  </tr>
  {stop:more}
  <tr>
    <td class="leftc">{icon:ksysguard} {lang:options}</td>
    <td class="leftb">
      <input type="hidden" name="id" value="{cat:id}" />
      <input type="hidden" name="cat_mod" value="{cat:cat_mod}" />
      <input type="hidden" name="categories_picture" value="{cat:categories_picture}" />
      <input type="submit" name="submit" value="{lang:edit}" />
          </td>
  </tr>
</table>
</form>