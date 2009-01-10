<div class="container" style="width:{page:width}">
    <div class="headb">{lang:mod} - {lang:create}</div>
    <div class="leftc">{lang:body}</div>
</div>

<br />

<form method="post" name="abcode_create" action="{action:form}" enctype="multipart/form-data">
  <table class="forum" cellpadding="0" cellspacing="1" style="width:{page:width}">
    <tr>
      <td class="leftc">{icon:completion} {lang:function} *</td>
      <td class="leftb" colspan="2"><select name="abcode_func">
          <option value="0">----</option>
          <option value="img">{lang:img}</option>
          <option value="str">{lang:str}</option>
        </select>
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:cell_edit} {lang:pattern} *</td>
      <td class="leftb"><input type="text" name="abcode_pattern" value="" {word:cut} size="40" />
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:cell_layout} {lang:result}</td>
      <td class="leftb"><input type="text" name="abcode_result" value="" {word:cut} size="40" />
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:download} {lang:pic_up}</td>
      <td class="leftb"><input type="file" name="picture" value="" />
        <br />
        <br />
        {lang:clip}</td>
    </tr>
    <tr>
      <td class="leftc">{icon:ksysguard} {lang:options}</td>
      <td class="leftb"><input type="submit" name="submit" value="{lang:create}"/>
        <input type="reset" name="reset" value="{lang:reset}"/>
      </td>
    </tr>
  </table>
</form>
