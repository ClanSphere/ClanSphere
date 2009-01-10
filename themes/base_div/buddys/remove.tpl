{if:form}
<div class="container" style="width:{page:width}">
<div class="headb">
{lang:mod} - {lang:head_remove}
</div>
<div class="leftb">
{head:buddy}
</div>
<div class="centerc">
<form method="post" name="buddys_remove" action="{url:buddys_remove}">
<input type="hidden" name="id" value="{head:id}" />
<input type="submit" name="agree" value="{lang:confirm}" />
<input type="submit" name="cancel" value="{lang:cancel}" /></form>
</div>
</div>
{stop:form}

{if:agree}
<div class="container" style="width:{page:width}">
<div class="headb">
{lang:mod} - {lang:head_remove}
</div>
<div class="leftc">
{head:msg}
</div>
<div class="centerb">
<a href="{url:buddys_center}">{lang:continue}</a>
</div>
</div>
{stop:agree}

{if:cancel}
<div class="container" style="width:{page:width}">
<div class="headb">
{lang:mod} - {lang:head_remove}
</div>
<div class="leftc">
{lang:del_false}
</div>
<div class="centerb">
<a href="{url:buddys_center}">{lang:continue}</a>
</div>
</div>
{stop:cancel}