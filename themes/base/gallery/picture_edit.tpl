<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
  <td class="headb">{lang:mod_name} - {lang:picture} {lang:edit}</td>
  </tr>
  <tr>
  <td class="leftb">{body:picture_create} {error:icon} {error:error} {error:message}</td>
  </tr>
</table>
<br />
<form method="post" id="picture_edit" action="{url:gallery_picture_edit}" enctype="multipart/form-data">
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="leftc" style="width:150px">{icon:download} {lang:upload} *</td>
    <td class="leftb">
      {data:picture}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:kedit} {lang:titel} *</td>
    <td class="leftb">
      <input name="gallery_titel" type="text" value="{data:gallery_titel}" size="50" maxlength="80" />
    </td>
  </tr>
  <tr>
    <td class="leftc">{icon:folder_yellow} {lang:folders} *</td>
    <td class="leftb">
      {data:folders_select}
    </td>
  </tr>
  <tr>
    <td class="leftc">{icon:access} {lang:needed_access}</td>
    <td class="leftb">
      <select name="gallery_access">
        {data:gallery_access}
      </select>
    </td>
  </tr>
  <tr>
    <td class="leftc">{icon:xpaint} {lang:show}</td>
    <td class="leftb">
        <select name="gallery_status">
          <option value="0" {check:show1}>{lang:show_0}</option>
          <option value="1" {check:show2}>{lang:show_1}</option>
        </select>
    </td>
  </tr>
  <tr>
    <td class="leftc">{icon:xpaint} {lang:watermark}</td>
    <td class="leftb">
      {data:w_select}
      {data:w_position}
      {lang:wm_trans}<input type="text" name="watermark_trans" value="{data:w_trans}" maxlength="3" size="3" />%
      {data:w_img}
    </td>
  </tr>
  <tr>
    <td class="leftc">{icon:kate} {lang:text} <br /> <br />
     {abcode:smileys}</td>
    <td class="leftb">{abcode:features} <br />
      <textarea class="rte_abcode" name="gallery_description" cols="50" rows="5" id="gallery_description" style="width:98%;">{data:gallery_description}</textarea> 
    </td>
  </tr>
  <tr>
    <td class="leftc">{icon:configure} {lang:more}</td>
    <td class="leftb">
      <input type="checkbox" name="new_time" value="1" {check:time}/> {lang:new_date}<br />
      <input type="checkbox" name="reset_counter" value="1" {check:counter}/> {lang:gallery_count_reset}<br />
    </td>
  </tr>
  <tr>
    <td class="leftc">{icon:ksysguard} {lang:options}</td>
    <td class="leftb">
      <input type="hidden" name="gallery_name" value="{hidden:name}" />
      <input type="hidden" name="id" value="{hidden:id}" />
      <input type="submit" name="submit" value="{lang:edit}" />
        </td>
  </tr>
</table>
</form>