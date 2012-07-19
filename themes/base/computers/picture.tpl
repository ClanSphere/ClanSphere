<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb" colspan="2">{lang:mod_name} - {lang:head_picture}</td>
  </tr>
  <tr>
    <td class="leftb">{head:body}</td>
    <td class="rightb">
      {if:own}<a href="{url:computers_center}">{lang:center}</a>{stop:own}
      {unless:own}<a href="{url:computers_manage}">{lang:manage}</a>{stop:own}
    </td>
  </tr>
</table>
<br />

{head:getmsg}

<form method="post" id="computers_picture" action="{url:computers_picture}" enctype="multipart/form-data">
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="leftc" style="width:140px">{icon:download} {lang:upload}</td>
    <td class="leftb"><input type="file" name="picture" value="" /><br />
      <br />
      {com:abcode_clip}
    </td>
  </tr>
  <tr>
    <td class="leftc">{icon:ksysguard} {lang:options}</td>
    <td class="leftb">
      <input type="hidden" name="id" value="{com:id}" />
      <input type="submit" name="submit" value="{lang:save}" />
    </td>
  </tr>
</table>
</form>
<br />

<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="leftc" style="width:140px">{icon:images} {lang:current}</td>
    <td class="leftb">
      {loop:pictures}
      {pictures:thumb} {pictures:url_remove}<br /><br />
      {stop:pictures}
    </td>
  </tr>
</table>