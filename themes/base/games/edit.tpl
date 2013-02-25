<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:edit}</td>
  </tr>
  <tr>
    <td class="leftb">{lang:body}</td>
  </tr>
</table>
<br />
<form method="post" id="games_edit" action="{url:games_edit}" enctype="multipart/form-data">
  <table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
    <tr>
      <td class="leftc">{icon:package_games} {lang:name} *</td>
      <td class="leftb"><input type="text" name="games_name" value="{games:name}" maxlength="200" size="50" />
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:agt_update-product} {lang:version}</td>
      <td class="leftb"><input type="text" name="games_version" value="{games:version}" maxlength="200" size="50" />
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:folder_yellow} {lang:genre} *</td>
      <td class="leftb">{games:genre}
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:1day} {lang:release}</td>
      <td class="leftb">{games:release} 
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:kedit} {lang:creator}</td>
      <td class="leftb"><input type="text" name="games_creator" value="{games:creator}" maxlength="200" size="50" />
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:gohome} {lang:homepage}</td>
      <td class="leftb"><input type="text" name="games_url" value="{games:homepage}" maxlength="200" size="50" />
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:kedit} {lang:usk}</td>
      <td class="leftb">{games:usk}
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:images} {lang:iconakt}</td>
      <td class="leftb" colspan="2">{games:icon}</td>
    </tr>
    <tr>
      <td class="leftc">{icon:images} {lang:iconedit}</td>
      <td class="leftb"><input type="file" name="symbol" value="" />
        <br />
        <br />
        {games:clip}</td>
    </tr>
    <tr>
      <td class="leftc">{icon:configure} {lang:more}</td>
      <td class="leftb"><input type="checkbox" name="delete" value="1" />
        {lang:icon_remove}</td>
    </tr>
    <tr>
      <td class="leftc">{icon:ksysguard} {lang:options}</td>
      <td class="leftb"><input type="hidden" name="id" value="{data:id}" />
        <input type="submit" name="submit" value="{lang:edit}" />
              </td>
    </tr>
  </table>
</form>