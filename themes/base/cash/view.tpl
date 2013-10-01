<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:head_view}</td>
  </tr>
  <tr>
    <td class="leftb">{lang:head_view}</td>
  </tr>
</table>
<br />

{if:allowed}
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="leftc">{icon:personal} {lang:nick}</td>
    <td class="leftb">{cash:user}</td>
  </tr>
  <tr>
    <td class="leftc" style="width:140px">{icon:money} {lang:money}</td>
    <td class="leftb">{cash:money} {op:currency}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:kate} {lang:for}</td>
    <td class="leftb">{cash:text}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:folder_yellow} {lang:inout}</td>
    <td class="leftb">{cash:inout}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:1day} {lang:date}</td>
    <td class="leftb">{cash:date}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:documentinfo} {lang:info}</td>
    <td class="leftb">
      {cash:info}
    </td>
  </tr>
</table>
{stop:allowed}

{if:not_allowed}
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="centerb">{lang:low_access}</td>
  </tr>
</table>
{stop:not_allowed}