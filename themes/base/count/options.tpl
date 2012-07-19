<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:options}</td>
  </tr>
</table>
<br />

<form method="post" id="count_options" action="{url:count_options}">
  <table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
    <tr>
      <td class="leftc"  style="width:30%">{icon:kdvi} {lang:view}</td>
      <td class="leftb"><select name="view">
    <option value="stats" {count:stats}>{lang:stats}</option>
          <option value="amstats" {count:amstats}>{lang:amstats}</option>
        </select>
      </td>
    </tr>
</table>
<br />

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
    <tr>
  <td class="headb" colspan="2">{lang:amstats} - {lang:options}</td>
    </tr>
    <tr>
      <td class="leftc"  style="width:30%">{icon:resizecol} {lang:width}</td>
      <td class="leftb"><input type="text" name="width" value="{count:width}" maxlength="3" size="3" />
        {lang:proz}</td>
    </tr>
    <tr>
      <td class="leftc">{icon:resizerow} {lang:height}</td>
      <td class="leftb"><input type="text" name="height" value="{count:height}" maxlength="3" size="3" />
        {lang:pixel}</td>
    </tr>
     <tr>
      <td class="leftc">{icon:resizerow} {lang:textsize}</td>
      <td class="leftb"><input type="text" name="textsize" value="{count:textsize}" maxlength="2" size="2" />
        {lang:pixel}</td>
    </tr>
    <tr>
      <td class="leftc">{icon:xpaint} {lang:textcolor}</td>
      <td class="leftb"> #<input type="text" name="textcolor" value="{count:textcolor}" maxlength="6" size="6" />
        {lang:hex}</td>
    </tr>
    <tr>
      <td class="leftc">{icon:xpaint} {lang:background}</td>
      <td class="leftb"> #<input type="text" name="background" value="{count:background}" maxlength="6" size="6" />
        {lang:hex}</td>
    </tr>
    <tr>
      <td class="leftc">{icon:xpaint} {lang:textballoncolor}</td>
      <td class="leftb"> #<input type="text" name="textballoncolor" value="{count:textballoncolor}" maxlength="6" size="6" />
        {lang:hex}</td>
    </tr>
    <tr>
      <td class="leftc">{icon:xpaint} {lang:axescolor}</td>
      <td class="leftb"> #<input type="text" name="axescolor" value="{count:axescolor}" maxlength="6" size="6" />
        {lang:hex}</td>
    </tr>
    <tr>
      <td class="leftc">{icon:xpaint} {lang:indicatorcolor}</td>
      <td class="leftb"> #<input type="text" name="indicatorcolor" value="{count:indicatorcolor}" maxlength="6" size="6" />
        {lang:hex}</td>
    </tr>
    <tr>
      <td class="leftc">{icon:xpaint} {lang:graphcolor1}</td>
      <td class="leftb"> #<input type="text" name="graphcolor1" value="{count:graphcolor1}" maxlength="6" size="6" />
        {lang:hex}</td>
    </tr>
    <tr>
      <td class="leftc">{icon:xpaint} {lang:graphcolor2}</td>
      <td class="leftb"> #<input type="text" name="graphcolor2" value="{count:graphcolor2}" maxlength="6" size="6" />
        {lang:hex}</td>
    </tr>
    <tr>
      <td class="leftc">{icon:ksysguard} {lang:options}</td>
      <td class="leftb"><input type="submit" name="submit" value="{lang:edit}" />
              </td>
    </tr>
  </table>
</form>
