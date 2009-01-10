<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:mod} - {lang:head_picture}</td>
  </tr>
  <tr>
    <td class="leftb">{lang:body}</td>
  </tr>
</table>
<br />
<form method="post" name="lanpartys_picture" action="{url:form}" enctype="multipart/form-data">
  <table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
    <tr>
      <td class="leftc" style="width:140px">{icon:download} {lang:upload}</td>
      <td class="leftb"><input type="file" name="picture" value=""  />
        <br />
        <br />
        {lanpartys:clip}
    </tr>
    <tr>
      <td class="leftc">{icon:ksysguard} {lang:options}</td>
      <td class="leftb"><input type="hidden" name="where" value="{data:id}" />
        <input type="submit" name="submit" value="{lang:save}" />
      </td>
    </tr>
  </table>
</form>
<br />
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
		<td class="leftc" style="width:140px">{icon:images} {lang:current}</td>
    <td class="leftb">{lanpartys:img}</td>
  </tr>
</table>
