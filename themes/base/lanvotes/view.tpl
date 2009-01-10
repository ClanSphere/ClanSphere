<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:mod} - {lang:head_view}</td>
  </tr>
  <tr>
    <td class="leftb">{lang:body_view}</td>
  </tr>
</table>

<br />

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="leftb">{icon:connect_to_network} {lang:lanparty}</td>
    <td class="leftc">{lan:name}</td>
  </tr>
  <tr>
    <td class="leftb">{icon:status_unknown} {lang:status}</td>
    <td class="leftc">{lan:status}</td>
  </tr>
  <tr>
    <td class="leftb">{icon:1day} {lang:start}</td>
    <td class="leftc">{lan:start}</td>
  </tr>
  <tr>
    <td class="leftb">{icon:today} {lang:end}</td>
    <td class="leftc">{lan:end}</td>
  </tr>
</table>

<br />

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="leftc">{lan:question}</td>
  </tr>
</table>

<br />

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:election}</td>
    <td class="headb" style="width:120px">{lang:graphic}</td>
    <td class="headb" style="width:75px">{lang:percent}</td>
    <td class="headb" style="width:75px">{lang:count}</td>
  </tr>
  {loop:election}
  <tr>
  <td class="leftc">{election:question}<div style="float:right;text-align:right;height:13px;width:35px;vertival-align:middle">&nbsp;</div></td>
  <td class="leftc">
   <div style="background-image:url({page:path}symbols/votes/vote03.png); width:100px; height:13px;">
   <div style="background-image:url({page:path}symbols/votes/vote01.png); width:{election:percent}px; text-align:right; padding-left:1px">
   {election:end_img}</div></div>
  </td>
  <td class="rightc">{election:percent}%</td>
  <td class="rightc">{election:count}</td>
 </tr>
  {stop:election}
</table>
