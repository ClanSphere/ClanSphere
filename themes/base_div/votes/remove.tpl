<div class="container" style="width:{page:width}">
  <div class="leftb">{lang:del_before}{remove:id}{lang:del_next}</div>
  <div class="centerc">
   <form method="post" name="{remove:mode}_remove" action="{url:votes_remove}">
   <input type="hidden" name="id" value="{remove:id}" />
   <input type="submit" name="agree" value="{lang:confirm}" />
   <input type="submit" name="cancel" value="{lang:cancel}" />
   </form>
  </div>
</div>
