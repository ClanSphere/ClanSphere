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
          <div class="manage" style="height: 60px; overflow: hidden; width: 110px">
          <a href="{content:link_1}" style="display: block; text-decoration: none">
          {content:img_1}<br style="margin-bottom:4px" />{content:txt_1}</a>
          </div>
        </div>
       {stop:content}
    </td>
  </tr>
</table>