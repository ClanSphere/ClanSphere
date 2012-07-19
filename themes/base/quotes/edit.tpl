
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb"> {head:mod} - {head:action} </td>
  </tr>
  <tr>
    <td class="leftb"> {head:body} {head:error}</td>
  </tr>
</table>
<br />
<form method="post" id="quotes_create" action="{url:quotes_edit}">
  <table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
    <tr>
      <td class="leftc" style="width: 100px;">{icon:kedit} {lang:headline} *</td>
      <td class="leftb"><input type="text" name="quotes_headline" value="{data:quotes_headline}" maxlength="200" size="50" /></td>
    </tr>
    <tr>
      <td class="leftc">{icon:folder_yellow} {lang:categories} *</td>
      <td class="leftb">{categories:dropdown}</td>
    </tr>
    <tr>
      <td class="leftc">{icon:kate} {lang:text} *<br />
        <br />
        {data:smileys}</td>
      <td class="leftc">{abcode:features}
        <textarea class="rte_abcode" name="quotes_text" cols="99" rows="35" id="quotes_text"  style="width: 98%;">{data:quotes_text}</textarea></td>
    </tr>
    <tr>
      <td class="leftc">{icon:configure} {lang:more}</td>
      <td class="leftb"><input type="checkbox" name="quotes_newtime" value="1" />
        {lang:new_date}</td>
    </tr>
    <tr>
      <td class="leftc">{icon:ksysguard} {lang:options}</td>
      <td class="leftb"><input type="hidden" name="id" value="{data:quotes_id}" />
        <input type="hidden" name="quotes_time" value="{data:quotes_time}" />
        <input type="submit" name="submit" value="{lang:edit}" />
        </td>
    </tr>
  </table>
</form>
