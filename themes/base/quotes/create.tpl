<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:create}</td>
  </tr>
  <tr>
    <td class="leftb">{head:body} {head:error}</td>
  </tr>
</table>
<br />

<form method="post" id="quotes_create" action="{url:action}">
  <table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
    <tr>
      <td class="leftc">{icon:kedit} {lang:headline} *</td>
      <td class="leftb">
        <input type="text" name="quotes_headline" value="{quotes:quotes_headline}" maxlength="200" size="50" />
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:folder_yellow} {lang:categories} *</td>
      <td class="leftb">{categories:dropdown}</td>
    </tr>
    <tr>
      <td class="leftc">{icon:kate} {lang:text} *<br />
        <br />
        {data:smileys}</td>
      <td class="leftb">{abcode:features}<br />
        <textarea class="rte_abcode" name="quotes_text" cols="99" rows="35" id="quotes_text"  style="width: 98%;">{quotes:quotes_text}</textarea>
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:ksysguard} {lang:options}</td>
      <td class="leftb"><input type="submit" name="submit" value="{lang:create}" />
        </td>
    </tr>
  </table>
</form>
