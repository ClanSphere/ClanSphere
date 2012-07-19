<form method="post" id="ecard" action="{url:gallery_ecard}">
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:ecard_head_list}</td>
  </tr>
  <tr>
    <td class="leftb">{head:body}</td>
  </tr>
</table>
<br />

{if:preview}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="centerb">{prev:img}</td>
    <td class="leftc" rowspan="2">
      {lang:of} {prev:mailfrom}<br />
      <br />
      {lang:to} {prev:mailto}<br />
      <br /><br /><br />
      {prev:time}
    </td>
  </tr>
  <tr>
    <td class="leftb"><strong>{prev:titel}</strong><br />
      <br />
      {prev:text}
    </td>
  </tr>
</table>
<br />
{stop:preview}

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="leftb" style="width:140px">{icon:image} {lang:pic}</td>
    <td class="centerc">{ecard:picture}</td>
  </tr>
  <tr>
    <td class="headb" colspan="2">{lang:sender}</td>
  </tr>
  <tr>
    <td class="leftb">{lang:name} *</td>
    <td class="leftc">{data:sender_name}</td>
  </tr>
  <tr>
    <td class="leftb">{lang:mail} *</td>
    <td class="leftc">{data:sender_mail}</td>
  </tr>
  <tr>
    <td class="headb" colspan="2">{lang:receiver}</td>
  </tr>
  <tr>
    <td class="leftb">{lang:name} *</td>
    <td class="leftc"><input type="text" name="receiver_name" value="{data:receiver_name}" maxlength="80" size="40" /></td>
  </tr>
  <tr>
    <td class="leftb">{lang:mail} *</td>
    <td class="leftc"><input type="text" name="receiver_mail" value="{data:receiver_mail}" maxlength="80" size="40" /></td>
  </tr>
  <tr>
    <td class="leftb">{lang:titel} *</td>
    <td class="leftc"><input type="text" name="ecard_titel" value="{data:ecard_titel}" maxlength="80" size="40" /></td>
  </tr>
  <tr>
    <td class="leftb">{icon:kate} {lang:text} *</td>
    <td class="leftc">
      {abcode:features}
      <textarea class="rte_abcode" name="ecard_text" cols="50" rows="15" id="ecard_text">{data:ecard_text}</textarea>
    </td>
  </tr>
  <tr>
    <td class="leftb">{icon:ksysguard} {lang:options}</td>
    <td class="leftc">
      <input type="hidden" name="id" value="{hidden:id}" />
      <input type="submit" name="preview" value="{lang:preview}" />
      <input type="submit" name="submit" value="{lang:send}" />
    </td>
  </tr>
</table>
</form>