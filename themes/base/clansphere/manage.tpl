<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="2"> {head:mod} - {head:action} </td>
  </tr>
  <tr>
    <td class="leftb"> {head:topline} </td>
    <td class="leftb"> {lang:total}: {head:total} </td>
  </tr>
</table>
<br />
{head:message}

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="centerc">
      <div style="text-align:center">
        {loop:content}
        <div class="manage">
        {content:img_link1}<br />{content:txt_link1}
        </div>
       {stop:content}
       </div>
    </td>
  </tr>
</table>