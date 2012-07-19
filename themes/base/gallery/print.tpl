<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:print}</td>
  </tr>
  <tr>
    <td class="leftb">{head:body}</td>
  </tr>
</table>
<br />

{if:preview}
<form method="post" id="print_now" action="{url:gallery_print_now}">
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="centerb">{print:img}</td>
  </tr>
  {if:extension}
  <tr>
    <td class="centerb"><a href="{print:url}">{lang:print}</a></td>
  </tr>
  {stop:extension}
</table>
</form>
<br />
{stop:preview}

<form method="post" id="print" action="{url:gallery_print}">
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="leftc" style="width:140px">{icon:configure} {lang:print_format}</td>
    <td class="leftb" colspan="2">
      <input type="radio" name="print" value="1" /> {lang:print_ff1}<br />
      <input type="radio" name="print" value="2" /> {lang:print_ff2}<br />
      <input type="radio" name="print" value="3" /> {lang:print_ff3}
    </td>
  </tr>
  <tr>
    <td class="leftc" style="width:150">{icon:configure} {lang:print_p_format}</td>
    <td class="leftb" colspan="2">
      <input type="radio" name="print" value="4" /> {lang:print_pf1}<br />
      <input type="radio" name="print" value="5" /> {lang:print_pf2}<br />
      <input type="radio" name="print" value="6" /> {lang:print_pf3}
    </td>
  </tr>
  <tr>
    <td class="leftc" style="width:150">{icon:configure} {lang:print_v_format}</td>
    <td class="leftb" colspan="2">
      <input type="radio" name="print" value="7" /> {lang:print_vf1}<br /><br />
      <input type="text" name="print_width" value="1024" maxlength="4" size="4" /> X 
      <input type="text" name="print_height" value="768" maxlength="4" size="4" /> Pixel
    </td>
  </tr>
  <tr>
    <td class="leftc">{icon:ksysguard} {lang:options}</td>
    <td class="leftb">
      <input type="hidden" name="id" value="{picture:id}" />
      <input type="submit" name="preview" value="{lang:preview}" />
          </td>
  </tr>
</table>
</form>