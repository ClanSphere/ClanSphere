<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:user}</td>
  </tr>
  <tr>
    <td class="leftb">{users:addons}</td>
  </tr>
</table>
<br />

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">{loop:medalsuser}
  <tr>
    <td class="leftb"><a name="{medalsuser:medals_id}"></a>
      <div style="float:left; width:40%; text-align: center; padding: 5px"><img src="{page:path}{medalsuser:img_src}" /></div>
      <div style="float:left; width:55%; padding-left: 10px;">
        <span style="text-decoration: underline">{medalsuser:medals_name}</span> - <em>{lang:since} {medalsuser:medals_date}</em><br />
        {medalsuser:medals_text}
      </div>
      <br style="clear:both" />
    </td>
  </tr>{stop:medalsuser}
</table>