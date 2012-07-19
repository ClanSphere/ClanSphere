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
    <td class="headb">
      {lang:modul}
    </td>
    <td class="headb" style="width:20%">
      {lang:create}
    </td>
    <td class="headb" style="width:20%">
      {lang:manage}
    </td>
    <td class="headb" style="width:20%">
      {lang:options}
    </td>
  </tr>
  {loop:content}
  <tr>
    <td class="leftc">
      {content:img_1} &nbsp; {content:txt_1}
    </td>
    <td class="centerb">
      {content:create_1}
    </td>
    <td class="centerb">
      {content:manage_1}
    </td>
    <td class="centerb">
      {content:options_1}
    </td>
  </tr>
  {stop:content}
</table>