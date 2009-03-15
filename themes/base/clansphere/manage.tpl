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
    <td class="centerc" style="text-align: center">
        {loop:content}
        <div style="display: inline-block; margin: 0; padding: 0">
          <div class="manage" style="height: 90px; overflow: auto; width: 110px">
          {content:img_link1}<br style="margin-bottom:4px" />{content:txt_link1}
          </div>
        </div>
       {stop:content}
    </td>
  </tr>
</table>