<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:head_search}</td>
  </tr>
  <tr>
    <td class="leftb">{lang:body_search}</td>
  </tr>
</table>
<br />

<form method="post" id="board_search" action="{url:board_search}">
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="leftb">{icon:cell_edit} {lang:keywords}</td>
    <td class="leftc"><input type="text" name="keywords" value="{data:keywords}" maxlength="200" size="50" /></td>
  </tr>
  <tr>
    <td class="leftb">{icon:completion} {lang:searchmode}</td>
    <td class="leftc">
      <input type="radio" name="searchmode" value="1" {check:exact}/> {lang:match_exact}<br />
      <input type="radio" name="searchmode" value="2" {check:keywords}/> {lang:match_keywords}
    </td>
  </tr>
  <tr>
    <td class="leftb">{icon:kcmdf} {lang:searcharea}</td>
    <td class="leftc">
      <input type="radio" name="searcharea" value="threads" {check:threads}/> {lang:titles_and_text}<br />
      <input type="radio" name="searcharea" value="comments" {check:comments}/> {lang:comments}
    </td>
  </tr>
  <tr>
    <td class="leftb">{icon:tutorials} {lang:board}</td>
    <td class="leftc">
      <select name="board_id">
        <option value="0">----</option>
        {board:options}
      </select>
    </td>
  </tr>
  <tr>
    <td class="leftb">{icon:ksysguard} {lang:options}</td>
    <td class="leftc">
      <input type="submit" name="search" value="{lang:search}" />
    </td>
  </tr>
</table>
</form>

{if:bottom}
<br />
{if:too_short}
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="leftc">{lang:too_short}</td>
  </tr>
</table>
{stop:too_short}

{if:not_found}
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="leftc">{lang:not_found}</td>
  </tr>
</table>
{stop:not_found}

{if:results}
<form method="post" id="board_search2" action="{url:board_search}">
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="leftb">
      <input type="hidden" name="keywords" value="{hidden:keywords}" />
      <input type="hidden" name="searchmode" value="{hidden:searchmode}" />
      <input type="hidden" name="searcharea" value="{hidden:searcharea}" />
      <input type="hidden" name="board_id" value="{hidden:board_id}" />
      <input type="hidden" name="page" value="{hidden:page}" />
      <input type="hidden" name="max_page" value="{hidden:max_page}" />
      {page:of}
    </td>
    <td class="centerb">
      <input type="submit" name="first" value="&lt;&lt;" />
      <input type="submit" name="back" value="&lt;" />
      <input type="submit" name="next" value="&gt;" />
      <input type="submit" name="last" value="&gt;&gt;" />
    </td>
    <td class="rightb">{count:results}</td>
  </tr>
</table>
</form>
<br />

<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb">{lang:board}</td>
    <td class="headb">{lang:topic}</td>
    <td class="headb" style="width:180px">{lang:lastpost}</td>
  </tr>
  {loop:res}
  <tr>
    <td class="leftb">
      {res:category}<br />
      -&gt; {res:board}
    </td>
    <td class="leftb">
      <strong>{res:thread}</strong>
      {res:target}
    </td>
    <td class="leftb">
      {res:date}
      {res:user}
    </td>
  </tr>
  {stop:res}
</table>
{stop:results}

{stop:bottom}