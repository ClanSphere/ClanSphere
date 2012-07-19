<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="4">{lang:mod_name} - {lang:head_center}</td>
  </tr>
  <tr>
    <td class="leftb" style="width:25%"><a href="{link:abos}">{lang:abos}</a> ({link:abos_count})</td>
    <td class="leftb" style="width:25%"><a href="{link:attachments}">{lang:attachments}</a> ({link:attachments_count})</td>
    <td class="leftb" style="width:25%">{lang:avatar}</td>
    <td class="leftb" style="width:25%"><a href="{link:signature}">{lang:signature}</a> </td>
  </tr>
</table>
<br />
{lang:getmsg}
{if:error}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="leftb">{avatar:error}</td>
  </tr>
</table>
<br />
{stop:error}
<form method="post" id="users_avatar" action="{action:form}" enctype="multipart/form-data">
  <table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
    <tr>
      <td class="leftc">{icon:images} {lang:current}</td>
      <td class="leftb">{avatar:img}</td>
    </tr>
    <tr>
      <td class="leftc">{icon:download} {lang:upload}</td>
      <td class="leftb"><input type="file" name="picture" value="" />
        <br />
        <br />
        {avatar:clip}</td>
    </tr>
    <tr>
      <td class="leftc">{icon:configure} {lang:more}</td>
      <td class="leftb"><input type="checkbox" name="delete" value="1" />
        {lang:remove}</td>
    </tr>
    <tr>
      <td class="leftc">{icon:ksysguard} {lang:options}</td>
      <td class="leftb"><input type="submit" name="submit" value="{lang:save}" />
      </td>
    </tr>
  </table>
</form>