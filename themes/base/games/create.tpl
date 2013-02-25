<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:create}</td>
  </tr>
  <tr>
    <td class="leftb">{lang:body}</td>
  </tr>
</table>
<br />
<form method="post" id="games_create" action="{url:games_create}" enctype="multipart/form-data">
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
      <td class="leftc">{icon:images} {lang:icon}</td>
      <td class="leftb"><input type="file" name="symbol" value="" />
        <br />
        <br />
        {games:clip}</td>
    </tr>
    <tr>
      <td class="leftc">{icon:ksysguard} {lang:options}</td>
      <td class="leftb"><input type="submit" name="submit" value="{lang:create}" />
              </td>
    </tr>
  </table>
</form>