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
        <div class="manage" style="float:left; width:110px; height:90px">
        {content:img_link1}<br style="margin-bottom:4px" />{content:txt_link1}
        </div>
       {stop:content}
       </div>
    </td>
  </tr>
</table>