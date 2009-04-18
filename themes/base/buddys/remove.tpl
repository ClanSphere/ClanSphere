{if:form}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
<tr><td class="headb">
{lang:mod_name} - {lang:head_remove}
</td></tr>
<tr><td class="leftb">
{head:buddy}
</td></tr>
<tr><td class="centerc">
<form method="post" id="buddys_remove" action="{url:buddys_remove}">
<input type="hidden" name="id" value="{head:id}" />
<input type="submit" name="agree" value="{lang:confirm}" />
<input type="submit" name="cancel" value="{lang:cancel}" /></form>
</td></tr>
</table>
{stop:form}

{if:agree}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
<tr><td class="headb">
{lang:mod_name} - {lang:head_remove}
</td></tr>
<tr><td class="leftc">
{head:msg}
</td></tr>
<tr><td class="centerb">
<a href="{url:buddys_center}">{lang:continue}</a>
</td></tr>
</table>
{stop:agree}

{if:cancel}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
<tr><td class="headb">
{lang:mod_name} - {lang:head_remove}
</td></tr>
<tr><td class="leftc">
{lang:del_false}
</td></tr>
<tr><td class="centerb">
<a href="{url:buddys_center}">{lang:continue}</a>
</td></tr>
</table>
{stop:cancel}