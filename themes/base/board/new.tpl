<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:head_new}</td>
  </tr>
  <tr>
    <td class="leftb">{lang:body_new}</td>
  </tr>
</table>
<br />

<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="bottom" colspan="6">
      <div style="float:left">{lang:threads} {count:threads}</div>
      <div style="float:right">{head:pages}</div>
    </td>
  </tr>
  <tr>
    <td class="leftc" colspan="2">{lang:thread}</td>
    <td class="leftc">{lang:replies}</td>
    <td class="leftc">{lang:hits}</td>
    <td class="leftc">{lang:lastpost}</td>
  </tr>
  {if:no_threads}
  <tr>
    <td class="centerb" colspan="6">{lang:no_threads}</td>
  </tr>
  {stop:no_threads}
  {loop:threads}
  <tr>
    <td class="leftb">{threads:icon}</td>
    <td class="leftb">
      <strong>{threads:name}</strong>
      {threads:pages}
    </td>
    <td class="rightb" style="width:60px">{threads:comments}</td>
    <td class="rightb" style="width:60px">{threads:view}</td>
    <td class="leftb" style="width:180px">{threads:last_time}<br/>{lang:from} {threads:last_user}</td>
  </tr>
  {stop:threads}
  <tr>
    <td class="bottom" colspan="6">
      <div style="float:left">{lang:threads} {count:threads}</div>
      <div style="float:right">{head:pages}</div>
    </td>
  </tr>
</table>