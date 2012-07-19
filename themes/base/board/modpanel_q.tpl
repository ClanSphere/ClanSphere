<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb">{lang:board} - {lang:mod3}</td>
  </tr>
  <tr>
    <td class="leftb">{head:links}</td>
  </tr>
</table>
<br />

<form method="post" id="board_modpanel_q" action="{url:board_modpanel_q:id={threads:id}}">
{if:move}
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="leftb" style="width:20%">{icon:forward} {lang:move}</td>
    <td class="leftc">
      <select name="board_id">
        {board:select}
      </select>
    </td>
  </tr>
  <tr>
    <td class="leftb">{icon:agt_reload} {lang:ghostlink}</td>
    <td class="leftc">
      <input type="radio" name="ghost" value="1" /> {lang:yes}
      <input type="radio" name="ghost" value="0" checked="checked" /> {lang:no}
    </td>
  </tr>
  <tr>
    <td class="leftb">{icon:lockoverlay} {lang:thread_close}</td>
    <td class="leftc">
      <input type="radio" name="thread_closed" value="1" {checked:closed}/> {lang:yes}
      <input type="radio" name="thread_closed" value="0" {checked:notclosed}/> {lang:no}
    </td>
  </tr>
  <tr>
    <td class="leftb">{icon:ksysguard} {lang:options}</td>
    <td class="leftc">
      <input type="submit" name="submit_move" value="{lang:change}" />
    </td>
  </tr>
</table>
{stop:move}
{if:rename}
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="leftb" style="width:20%">{icon:kate} {lang:rename}</td>
    <td class="leftc"><input type="text" name="thread_headline" value="{val:thread_headline}" maxlength="200" size="50" /></td>
  </tr>
  <tr>
    <td class="leftb">{icon:ksysguard} {lang:options}</td>
    <td class="leftc">
      <input type="submit" name="submit_rename" value="{lang:change}" />
    </td>
  </tr>
</table>
{stop:rename}
</form>