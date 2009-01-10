<form method="post" name="articles_remove" action="{url:quotes_remove}">
<div class="container" style="width:{page:width}">
  <div class="headb">{head:mod} - {head:action}</div>
  <div class="leftb">{head:body}</div>
  <div class="centerc">
	  <input type="hidden" name="id" value="{quotes:id}" />
	  <input type="submit" name="agree" value="{lang:confirm}" />
      <input type="submit" name="cancel" value="{lang:cancel}" />
  </div>
</div>
</form>