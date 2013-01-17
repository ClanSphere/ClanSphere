<form method="post" id="gallery" action="{url:gallery_manage_advanced}" enctype="multipart/form-data">
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb" colspan="5">{lang:mod_name} - {lang:head}</td>
  </tr>
  {manage:head}
</table>
<br />

{if:start}
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="leftc">{icon:configure} {lang:head}</td>
    <td class="leftb">
      <input type="checkbox" name="read" value="1" /> {lang:read}<br />
      <input type="checkbox" name="read_zip" value="1" /> {lang:read_zip}<br />
      <input type="checkbox" name="del" value="1" /> {lang:del}
    </td>
  </tr>
  <tr>
    <td class="leftc">{icon:ksysguard} {lang:options}</td>
    <td class="leftb"><input type="submit" name="submit" value="{lang:continue}" /></td>
  </tr>
</table>
{stop:start}

{if:zipfile}
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb" colspan="2">{lang:read_zip}</td>
  </tr>
  <tr>
    <td class="leftb">{icon:download} {lang:zipfile}</td>
    <td class="leftc"><input type="file" name="zipfile" value="" /></td>
  </tr>
  <tr>
    <td class="leftb">{icon:ksysguard} {lang:options}</td>
    <td class="leftc">
      <input type="hidden" name="submit" value="1" />
      <input type="hidden" name="read_zip" value="1" />
      <input type="submit" name="submit_zipfile" value="{lang:continue}" />
    </td>
  </tr>
</table>
{stop:zipfile}

{if:pictures_found}
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb" colspan="4">{lang:newpic}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:folder_yellow} {lang:folder}</td>
    <td class="leftb" colspan="3">
      {folders:select}
    </td>
  </tr>
  <tr>
    <td class="leftc">{icon:access} {lang:access}</td>
    <td class="leftb" colspan="3">
      <select name="gallery_access">
        {access:options}
      </select>
    </td>
  </tr>
  <tr>
    <td class="leftc">{icon:xpaint} {lang:show}</td>
    <td class="leftb" colspan="3">
      <select name="gallery_status">
        {show:options}
      </select>
    </td>
  </tr>
  <tr>
    <td class="leftc">{icon:xpaint} {lang:watermark}</td>
    <td class="leftb" colspan="3">
      <select name="gallery_watermark" onchange="{watermark:onchange}">
        {watermark:options}
      </select>
      <select name="watermark_pos">
        {watermark:pos_options}
      </select>
      <input type="text" name="gallery_watermark_trans" value="{watermark:trans}" maxlength="3" size="3" />%
      {watermark:img}
    </td>
  </tr>
  {loop:pictures}
  <tr>
    <td class="leftb" rowspan="3">
      <input type="checkbox" name="status_{pictures:run}" value="1" checked="checked" />
      <input type="hidden" name="name_{pictures:run}" value="{pictures:name}" />
    </td>
    <td class="leftb" rowspan="3">{pictures:img}</td>
    <td class="leftc">{lang:name}</td>
    <td class="leftc">{pictures:name}</td>
  </tr>
  <tr>
    <td class="leftb">{lang:size}</td>
    <td class="leftb">{pictures:size}</td>
  </tr>
  <tr>
    <td class="leftc">{lang:filesize}</td>
    <td class="leftc">{pictures:filesize}</td>
  </tr>
  {stop:pictures}
  <tr>
    <td class="leftc">{icon:ksysguard} {lang:options}</td>
    <td class="leftb" colspan="3">
      <input type="submit" name="submit_1" value="{lang:continue}" />
    </td>
  </tr>
</table>
<br />
{stop:pictures_found}

{if:pictures_done}
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  {loop:pics}
  <tr>
    <td class="leftb" rowspan="2">{pics:name}</td>
    <td class="leftc">{lang:name}</td>
    <td class="leftb">twitterbird-trans.png</td>
  </tr>
  <tr>
    <td class="leftc" colspan="2">{lang:thumb_true}</td>
  </tr>
  {stop:pics}
</table>
{stop:pictures_done}

{if:thumb}
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
     <td class="headb" colspan="2">{lang:delthumb}</td>
  </tr>
  {loop:thumbs}
  <tr>
    <td class="leftb">{thumbs:name}</td>
    <td class="leftc">{thumbs:msg}</td>
  </tr>
  {stop:thumbs}
</table>
{stop:thumb}

{if:error_zip}
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb">{lang:read_zip}</td>
  </tr>
  <tr>
    <td class="leftc">{lang:error_zip}</td>
  </tr>
  <tr>
    <td class="leftb">{lang:filetypes} {zip:filetype}</td>
  </tr>
</table>
{stop:error_zip}

{if:nopic}
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="leftc">{lang:nopic}</td>
  </tr>
</table>
{stop:nopic}

{if:no_thumb}
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="leftc">{lang:nothumb}</td>
  </tr>
</table>
{stop:no_thumb}


</form>