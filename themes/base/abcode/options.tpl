<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:options}</td>
  </tr>
  <tr>
    <td class="leftb">{lang:body_options}</td>
  </tr>
</table>
<br />
{lang:getmsg}

<form method="post" id="abcode_options" action="{url:abcode_options}">
  <table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
    <tr>
      <td class="leftc">{icon:document} {lang:rte_html}</td>
      <td class="leftb">{lang:html_info}<br />{dropdown:rte_html}</td>
    </tr>
    <tr>
      <td class="leftc">{icon:kword} {lang:rte_more}</td>
      <td class="leftb">{dropdown:rte_more}</td>
    </tr>
    <tr>
      <td class="leftc">{icon:download} {lang:rte_web_info}</td>
      <td class="leftb">{lang:rte_txt_info}<br /><br /><a href="http://mods.clansphere.net" target="_blank">{lang:rte_mod_info}</a></td>
    </tr>
  </table>
  <br />

  <table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
    <tr>
      <td class="leftc">{icon:resizecol} {lang:max_width}</td>
      <td class="leftb"><input type="text" name="max_width" value="{options:max_width}" maxlength="4" size="4" /> {lang:pixel}</td>
    </tr>
    <tr>
      <td class="leftc">{icon:resizerow} {lang:max_height}</td>
      <td class="leftb"><input type="text" name="max_height" value="{options:max_height}" maxlength="4" size="4" /> {lang:pixel}</td>
    </tr>
    <tr>
      <td class="leftc">{icon:fileshare} {lang:max_size}</td>
      <td class="leftb"><input type="text" name="max_size" value="{options:max_size}" maxlength="20" size="8" /> {lang:bytes}</td>
    </tr>
    <tr>
      <td class="leftc">{icon:completion} {lang:def_func}</td>
      <td class="leftb">{dropdown:def_func}</td>
    </tr>
    <tr>
      <td class="leftc">{icon:resizerow} {lang:image_height}</td>
      <td class="leftb"><input type="text" name="image_height" value="{options:image_height}" maxlength="4" size="4" /> {lang:pixel}</td>
    </tr>
    <tr>
      <td class="leftc">{icon:resizecol} {lang:image_width}</td>
      <td class="leftb"><input type="text" name="image_width" value="{options:image_width}" maxlength="4" size="4" /> {lang:pixel}</td>
    </tr>
    <tr>
      <td class="leftc">{icon:editcut} {lang:cut}</td>
      <td class="leftb"><input type="text" name="word_cut" value="{options:word_cut}" maxlength="5" size="4" /> {lang:cut_more}</td>
    </tr>
    <tr>
      <td class="leftc">{icon:kopete} {lang:comments}</td>
      <td class="leftb"><input type="checkbox" name="def_abcode" value="1"{checked:def_abcode}/> {lang:def_abcode}</td>
    </tr>
    <tr>
      <td class="leftc">{icon:ksysguard} {lang:options}</td>
      <td class="leftb">
        <input type="submit" name="submit" value="{lang:edit}" />
        
      </td>
    </tr>
  </table>
</form>