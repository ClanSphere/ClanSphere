<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb"> {head:mod} - {head:action} </td>
  </tr>
  <tr>
    <td class="leftb"> {head:topline} </td>
  </tr>
</table>
<br />
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  {loop:content}
  <tr>
    <td class="leftc">{content:img_link1} {content:txt_link1}</td>
    <td class="leftc">{content:img_link2} {content:txt_link2}</td>
    <td class="leftc">{content:img_link3} {content:txt_link3}</td>
  </tr>
  {stop:content}
</table>
