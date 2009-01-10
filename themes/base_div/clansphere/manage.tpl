<div class="container" style="width:{page:width}">
    <div class="headb"> {head:mod} - {head:action} </div>
    <div class="leftb"> {head:topline} </div>
</div>
<br />
<table class="forum" cellpadding="0" cellspacing="1" style="width:{page:width}">
  {loop:content}
  <tr>
    <td class="centerc" style="width:25%">{content:img_link1}<br />
      {content:txt_link1}</td>
    <td class="centerc" style="width:25%">{content:img_link2}<br />
      {content:txt_link2}</td>
    <td class="centerc" style="width:25%">{content:img_link3}<br />
      {content:txt_link3}</td>
    <td class="centerc" style="width:25%">{content:img_link4}<br />
      {content:txt_link4}</td>
  </tr>
  {stop:content}
</table>
