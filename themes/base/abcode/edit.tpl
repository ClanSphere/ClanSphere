<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:edit}</td>
  </tr>
  <tr>
    <td class="leftb">{lang:body}</td>
  </tr>
</table>
<br />
<form method="post" id="abcode_edit" action="{url:abcode_edit}" enctype="multipart/form-data">
  <table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
    <tr>
      <td class="leftc">{icon:completion} {lang:function} *</td>
      <td class="leftb" colspan="2"><select name="abcode_func">
          <option value="0">----</option>
          <option value="img" {select:img}>{lang:img}</option>
          <option value="str" {select:str}>{lang:str}</option>
        </select>
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:cell_edit} {lang:pattern} *</td>
      <td class="leftb"><input type="text" name="abcode_pattern" value="{abcode:pattern}" {word:cut} size="40" />
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:cell_layout} {lang:result}</td>
      <td class="leftb"><input type="text" name="abcode_result" value="{abcode:result}" {word:cut} size="40" />
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:images} {lang:pic_current}</td>
      <td class="leftb">{abcode:pic}</td>
    </tr>
    <tr>
      <td class="leftc">{icon:download} {lang:pic_up}</td>
      <td class="leftb"><input type="file" name="picture" value="" />
        <br />
        <br />
        {abcode:clip}</td>
    </tr>
    <tr>
      <td class="leftc">{icon:favorites} {lang:order}</td>
      <td class="leftb"><input type="text" name="abcode_order" value="{abcode:order}" size="2" maxlength="2"/></td>
    </tr>
    <tr>
      <td class="leftc">{icon:ksysguard} {lang:options}</td>
      <td class="leftb"><input type="hidden" name="abcode_file" value="{abcode:file}" />
        <input type="hidden" name="id" value="{abcode:id}" />
        <input type="submit" name="submit" value="{lang:edit}" />
              </td>
    </tr>
  </table>
</form>
