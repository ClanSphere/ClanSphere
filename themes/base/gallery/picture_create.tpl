<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
  <td class="headb">{lang:mod_name} - {lang:create_picture}</td>
  </tr>
  <tr>
  <td class="leftb">{body:picture_create} {error:icon} {error:error} {error:message}</td>
  </tr>
</table>
<br />
<form method="post" id="picture_create" action="{url:gallery_picture_create}" enctype="multipart/form-data">
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="leftc" style="width:140px">{icon:download} {lang:upload} *</td>
    <td class="leftb">
      {if:file_up}<input type="hidden" name="file_up" value="1" />
      <input type="hidden" name="gallery_name" value="{hidden:gallery_name}" />
      {show:picture}{stop:file_up}
      {if:no_up}<input type="file" name="picture" value="" />
      {data:info_clip}{stop:no_up}
    </td>
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
      {data:gallery_access}
    </td>
  </tr>
  <tr>
    <td class="leftc">{icon:xpaint} {lang:show}</td>
    <td class="leftb">
      {data:gallery_status}
    </td>
  </tr>
  <tr>
    <td class="leftc">{icon:xpaint} {lang:watermark}</td>
    <td class="leftb">
      {data:w_select}
      {data:w_position}
      {lang:wm_trans}<input type="text" name="gallery_watermark_trans" value="{data:w_trans}" maxlength="3" size="3" />%
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
      <input type="checkbox" name="gray" value="1" {check:gray}/> {lang:gray_show}<br />
    </td>
  </tr>
  <tr>
    <td class="leftc">{icon:ksysguard} {lang:options}</td>
    <td class="leftb">
    <input type="submit" name="submit" value="{lang:create}" />
      </td>
  </tr>
</table>
</form>