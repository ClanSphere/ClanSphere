<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="4">{lang:mod_name} - {lang:signature}</td>
  </tr>
  <tr>
    <td class="leftb" style="width:25%"><a href="{link:abos}">{lang:abos}</a> ({count:abos})</td>
    <td class="leftb" style="width:25%"><a href="{link:attachments}">{lang:attachments}</a> ({count:attachments})</td>
    <td class="leftb" style="width:25%"><a href="{link:avatar}">{lang:avatar}</a></td>
    <td class="leftb" style="width:25%">{lang:signature}</td>
  </tr>
</table>
<br />
{head:getmsg}
{if:preview}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:preview}</td>
  </tr>
  <tr>
    <td class="leftb">{signature:preview}</td>
  </tr>
</table>
<br />
{stop:preview}

<form method="post" id="board_create" action="{action:form}">
  <table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
    <tr>
      <td class="leftc">{icon:kate} {lang:signature}<br />
        <br />
        <br />
        {signature:smileys}</td>
      <td class="leftb">{signature:abcode}<br />
        <textarea class="rte_abcode" name="signature" cols="50" rows="20" id="signature">{signature:text}</textarea>
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:ksysguard} {lang:options}</td>
      <td class="leftb"><input type="submit" name="submit" value="{lang:create}" />
        <input type="submit" name="preview" value="{lang:preview}" />
              </td>
    </tr>
  </table>
</form>