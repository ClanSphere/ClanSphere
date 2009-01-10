<div class="container" style="width:{page:width}">
    <div class="headb">{lang:mod} - {lang:head_active}</div>
    <div class="leftb">{lang:body_active}</div>
</div>
<br />
<table class="forum" cellpadding="0" cellspacing="1" style="width:{page:width}">
  <tr>
    <td class="bottom" colspan="5"><div style="float:left;">{lang:threads} {lang:count}</div>
      <div style="float:right;">{pages:list}</div></td>
  </tr>
  <tr>
    <td class="leftc" colspan="2">{lang:thread}</td>
    <td class="leftc">{lang:replies}</td>
    <td class="leftc">{lang:hits}</td>
    <td class="leftc">{lang:lastpost}</td>
  </tr>
  
  {if:not_active}
  <tr>
    <td class="centerc" colspan="5">{lang:no_threads}</td>
  </tr>
  {stop:not_active}
 
  {if:active}
  {loop:threads}
  <tr>
    <td class="leftb" style="width:36px">{threads:icon}</td>
    <td class="leftb"><b>{threads:important} {threads:headline}</b> {threads:pages}</td>
    <td class="centerb" style="width:60px">{threads:comments}</td>
    <td class="centerb" style="width:60px">{threads:view}</td>
    <td class="leftb" style="width:180px">{threads:last} {threads:last_user}</td>
  </tr>
  {stop:threads}
  {stop:active}
  <tr>
    <td class="bottom" colspan="5"><div style="float:left;">{lang:threads} {lang:count}</div>
      <div style="float:right;">{pages:list}</div></td>
  </tr>
</table>