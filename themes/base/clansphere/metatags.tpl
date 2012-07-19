<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">ClanSphere - {lang:metatags}</td>
  </tr>
  <tr>
    <td class="leftb">{lang:generate_metatags}</td>
  </tr>
  {if:done}
  <tr>
    <td class="leftc">{lang:wizard}: {lang:link_2}</td>
  </tr>
  {stop:done}
</table>
<br />
<form method="post" id="metatags" action="{url:clansphere_metatags}">
  <table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
    <tr>
      <td class="leftc">{icon:kate} {lang:description}</td>
      <td class="leftb"><input type="text" name="description" value="{metatags:description}"  maxlength="200" size="50" />
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:lock} {lang:keywords}</td>
      <td class="leftb"><input type="text" name="keywords" value="{metatags:keywords}"  maxlength="200" size="50" />
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:locale} {lang:languages}</td>
      <td class="leftb"><input type="text" name="language" value="{metatags:language}"  size="50" /></td>
    </tr>
    <tr>
      <td class="leftc">{icon:personal} {lang:author}</td>
      <td class="leftb"><input type="text" name="author" value="{metatags:author}"  size="50" /></td>
    </tr>
    <tr>
      <td class="leftc">{icon:webexport} {lang:designer}</td>
      <td class="leftb"><input type="text" name="designer" value="{metatags:designer}"  size="50" /></td>
    </tr>
    <tr>
      <td class="leftc">{icon:kdmconfig} {lang:publisher}</td>
      <td class="leftb"><input type="text" name="publisher" value="{metatags:publisher}"  size="50" /></td>
    </tr>
    <tr>
      <td class="leftc">{icon:search} {lang:robots}</td>
      <td class="leftb"><select name="robots">
          <option value="index,follow" {selected:robots_all}>{lang:yes}</option>
          <option value="noindex,nofollow" {selected:robots_no}>{lang:no}</option>
        </select>
      </td>
    </tr>
    <tr>
      <td class="leftc"> {icon:neotux} {lang:distribution} </td>
      <td class="leftb"><select name="distribution">
          <option value="global" {selected:distribution_global}>{lang:global}</option>
          <option value="IU" {selected:distribution_intern}>{lang:internal}</option>
        </select>
      </td>
    </tr>
    <tr>
      <td class="leftc"> {icon:ksysguard} {lang:options} </td>
      <td class="leftb"><input type="submit" name="submit" value="{lang:submit}" />
              </td>
    </tr>
  </table>
</form>
