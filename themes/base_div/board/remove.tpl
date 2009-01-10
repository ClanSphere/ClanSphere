<div class="container" style="width:{page:width}">
    <div class="headb">{lang:mod} - {lang:remove}</div>
  <form method="post" name="board_remove" action="{action:form}">
      <div class="leftb">{lang:body}
        {if:threads_loop}
        <br />
        <br />
        <input type="checkbox" name="change_threads" value="1" {remove:checked} />
        {lang:change_threads}<br />
        {lang:change_board}
       {remove:dropdown}
        {stop:threads_loop}
      </div>
      <div class="centerc"><input type="hidden" name="id" value="{remove:id}" />
        <input type="submit" name="agree" value="{lang:confirm}" />
        <input type="submit" name="cancel" value="{lang:cancel}" />
  </div>
  </form>
</div>
