<form method="post" name="articles_remove" action="{url:articles_remove}">
  <div class="container" style="width:{page:width}">
      <div class="headb"> {lang:mod} - {lang:head_remove} </div>
      <div class="leftb"> {head:body} </div>
      <div class="centerc">
	  <input type="hidden" name="id" value="{articles:id}" />
	  <input type="submit" name="agree" value="{lang:confirm}" />
        <input type="submit" name="cancel" value="{lang:cancel}" /></div>
  </div>
</form>
