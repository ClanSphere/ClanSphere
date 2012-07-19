<form method="post" id="board_remove" action="{action:form}">
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb">{lang:mod_name} - {lang:remove}</td>
 </tr>
 <tr>
  <td class="leftb">{lang:body}
    <br/>"{remove:name}"
    {if:threads_loop}
    <br /><br />
    <input type="checkbox" name="change_threads" value="1" {remove:checked} />
    {lang:change_threads}<br />
    {lang:change_board} {remove:dropdown}
    {stop:threads_loop}
  </td>
 </tr>
 <tr>
  <td class="centerc"><input type="hidden" name="id" value="{remove:id}" />
     <input type="submit" name="agree" value="{lang:confirm}" />
     <input type="submit" name="cancel" value="{lang:cancel}" />
  </td>
 </tr>
</table>
</form>