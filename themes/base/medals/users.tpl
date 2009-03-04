<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="1">
  <tr>
    <td class="headb">{lang:mod} - {lang:user}</td>
  </tr>
  <tr>
    <td class="leftc">{users:addons}</td>
  </tr>
</table>
<br />

<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="1">{loop:medalsuser}
  <tr>
    <td class="leftb"><a name="{medalsuser:medals_id}"></a>
      <div style="float:left; width:40%; text-align: center; padding: 5px"><img src="{medalsuser:img_src}" /></div>
      <div style="float:left; width:55%; padding-left: 10px;">
        <u>{medalsuser:medals_name}</u> - <em>{lang:since} {medalsuser:medals_date}</em><br />
        {medalsuser:medals_text}
      </div>
      <br style="clear:both" />
    </td>
  </tr>{stop:medalsuser}
</table>