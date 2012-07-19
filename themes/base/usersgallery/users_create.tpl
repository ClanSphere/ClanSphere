<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
  <td class="headb">{lang:mod_name} - {lang:pic}</td>
  </tr>
  <tr>
  <td class="leftb">{head:body}</td>
  </tr>
</table>
<br />

<form method="post" id="users_create" action="{url:usersgallery_users_create}" enctype="multipart/form-data">
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="leftc">{icon:download} {lang:upload} *</td>
    <td class="leftb"><input type="file" name="picture" value="" /> <br /> {data:infobox}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:kedit} {lang:titel} *</td>
    <td class="leftb"><input type="text" name="gallery_titel" value="{data:usersgallery_titel}" maxlength="200" size="50" /></td>
  </tr>
  <tr>
    <td class="leftc">{icon:folder_yellow} {lang:folders} *</td>
    <td class="leftb">{data:folders}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:access} {lang:access}</td>
    <td class="leftb">
      <select name="gallery_access">
        {access:options}
      </select>
    </td>
  </tr>
  <tr>
    <td class="leftc">{icon:xpaint} {lang:show}</td>
    <td class="leftb">
      <select name="gallery_status">
        {status:options}
      </select>
    </td>
  </tr>
  <tr>
    <td class="leftc">{icon:kate} {lang:comment}<br />
      <br />
      {abcode:smileys}
    </td>
    <td class="leftb">
      {abcode:features} 
      <textarea class="rte_abcode" name="description" cols="50" rows="15" id="description" style="width:98%;">{data:usersgallery_description}</textarea>
    </td>
  </tr>
  <tr>
    <td class="leftc">{icon:configure} {lang:head}</td>
    <td class="leftb">
      <input type="checkbox" name="gray" value="1" {check:gray}/> {lang:gray_show}
    </td>
  </tr>
  <tr>
    <td class="leftc">{icon:ksysguard} {lang:options}</td>
    <td class="leftb">
      <input type="submit" name="submit" value="{lang:submit}" />
    </td>
  </tr>
</table>
</form>