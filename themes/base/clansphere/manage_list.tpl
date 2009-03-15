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
    <td class="leftc">
      {content:img_1} &nbsp; <a href="{content:link_1}">{content:txt_1}</a>
    </td>
    <td class="leftc">
      {content:img_2} &nbsp; <a href="{content:link_2}">{content:txt_2}</a>
    </td>
    <td class="leftc">
      {content:img_3} &nbsp; <a href="{content:link_3}">{content:txt_3}</a>
    </td>
  </tr>
  {stop:content}
</table>