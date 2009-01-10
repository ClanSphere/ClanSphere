<div class="container" style="width:{page:width}">
    <div class="headb"> {head:mod} - {head:action} </div>
    <div class="leftb"> {head:topline} </div>
</div>
<br />
<table class="forum" cellpadding="0" cellspacing="1" style="width:{page:width}">
  {loop:content}
  <tr>
    <td class="leftc">{content:img_link1} {content:txt_link1}</td>
    <td class="leftc">{content:img_link2} {content:txt_link2}</td>
    <td class="leftc">{content:img_link3} {content:txt_link3}</td>
  </tr>
  {stop:content}
</table>
