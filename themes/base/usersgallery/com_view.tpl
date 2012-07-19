{if:error}
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:pic}</td>
  </tr>
  <tr>
    <td class="leftc">
      {data:addons}
    </td>
  </tr>
</table>
<br />

<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="centerb">
      <strong>{lang:error}</strong><br />
      {lang:error1}<br /><br />
      {link:back}
    </td>
  </tr>
</table>
{stop:error}

{if:view}
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb" colspan="2">{head:view}</td>
  </tr>
  <tr>
    <td class="leftc">
      {data:addons}
    </td>
  </tr>
</table>
<br />

<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="centerb" colspan="2">{gallery:titel}</td>
  </tr>
  <tr>
    <td class="centerc" colspan="2">{gallery:img}</td>
  </tr>
  <tr>
    <td class="centerb" style="width:30%">{link:back} {one:of} {link:forward}</td>
    <td class="centerb">{view:bottom}</td>
  </tr>
  {if:details}
  <tr>
    <td class="leftb">{icon:today} {lang:date}</td>
    <td class="leftc">{details:date}</td>
  </tr>
  <tr>
    <td class="leftb">{icon:contents} {lang:gallery_description}</td>
    <td class="leftc">{details:description}</td>
  </tr>
  <tr>
    <td class="leftb">{icon:window_fullscreen} {lang:dissolution}</td>
    <td class="leftc">{details:size}</td>
  </tr>
  <tr>
    <td class="leftb">{icon:fileshare} {lang:filesize}</td>
    <td class="leftc">{details:filesize}</td>
  </tr>
  <tr>
    <td class="leftb">{icon:kdict} {lang:gallery_count}</td>
    <td class="leftc">{details:count}</td>
  </tr>
  {if:vote}
  <tr>
    <td class="leftb">{icon:volume_manager} {lang:gallery_vote}</td>
    <td class="leftc">
      {if:vote_now}
      <form method="post" action="{form:action}" id="com_view">
        <select name="voted_answer">
          {vote:options}
        </select>
        <input type="hidden" name="voted_fid" value="{hidden:id}" />
        <input type="submit" name="submit" value="{lang:ok}" />
      </form>
      {stop:vote_now}
      {if:voted}
      <div style="float:left;clear:both">{result:votes}</div>
      <div style="float:left;clear:both;padding-top:8px">{result:icons}</div>
      {stop:voted}
    </td>
  </tr>
  {stop:vote}
  {stop:details}
</table>
{stop:view}