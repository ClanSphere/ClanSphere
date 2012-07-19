<form method="post" id="logs_roots" action="{url:logs_roots}">
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb" colspan="3">{lang:mod_name} - {lang:head_roots}</td>
  </tr>
  <tr>
    <td class="leftb">
      {head:dropdown}
      <input type="submit" name="submit" value="{lang:ok}" />
    </td>
    <td class="leftb">{icon:contents} {lang:total}: {head:count}</td>
    <td class="rightb">{head:pages}</td>
  </tr>    
  {if:wizard}
  <tr>
    <td class="leftc" colspan="3">{lang:wizard} : {wizard:show} - {wizard:task_done}</td>
  </tr>
  {stop:wizard}
</table>
</form>
<br />

<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb">{sort:name} {lang:dname}</td>
    <td class="headb">{lang:errors}</td>
    <td class="headb" colspan="2" style="width:25%">{lang:options}</td>
  </tr>
  {loop:log}
  <tr>
    <td class="leftc">{log:name}</td>
    <td class="rightc">{log:handle}</td>
    <td class="leftc" style="width:25%">
      {log:details} -
      {log:download} -
      {log:delete}
    </td>
  </tr>
  {stop:log}
</table>