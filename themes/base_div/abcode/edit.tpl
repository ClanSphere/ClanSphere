<div class="container" style="width:{page:width}">
    <div class="headb">{lang:mod} - {lang:edit}</div>
    <div class="leftb">{lang:body}</div>
</div>
<br />

<form method="post" name="abcode_edit" action="{action:form}" enctype="multipart/form-data">
  <table class="forum" cellpadding="0" cellspacing="1" style="width:{page:width}">
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
      <td class="leftc">{icon:ksysguard} {lang:options}</td>
      <td class="leftb"><input type="hidden" name="abcode_file" value="{abcode:file}" />
        <input type="hidden" name="id" value="{abcode:id}" />
        <input type="submit" name="submit" value="{lang:edit}" />
        <input type="reset" name="reset" value="{lang:reset}" />
      </td>
    </tr>
  </table>
</form>
