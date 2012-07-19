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
        {loop:content}
        <div class="manage" style="float: left; height: 90px; overflow: hidden; width: 110px">
        <a href="{content:link_1}" style="display: block; text-decoration: none">
        {content:img_1}<br style="margin-bottom:4px" />{content:txt_1}</a>
        </div>
       {stop:content}
    </td>
  </tr>
</table>