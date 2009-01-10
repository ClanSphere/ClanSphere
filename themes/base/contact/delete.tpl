{if:form}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
<tr><td class="headb">
{lang:mod} - {lang:head_remove}
</td></tr>
<tr><td class="leftb">
{remove:confirm}
</td></tr>
<tr><td class="centerc">
<form method="post" name="mail_delete" action="{url:contact_delete}">
<input type="hidden" name="id" value="{remove:id}" />
<input type="submit" name="agree" value="{lang:confirm}" />
<input type="submit" name="cancel" value="{lang:cancel}" /></form>
</td></tr>
</table>
{stop:form}

{if:cancel}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
<tr><td class="headb">
{lang:mod} - {lang:head_remove}
</td></tr><tr><td class="leftc">
{lang:del_false}
</td></tr>
<tr><td class="centerb">
<a href="{url:contact_manage}">{lang:continue}</a>
</td></tr>
</table>
{stop:cancel}

{if:agree}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
<tr><td class="headb">
{lang:mod} - {lang:head_remove}
</td></tr><tr><td class="leftc">
{lang:del_true}
</td></tr>
<tr><td class="centerb">
<a href="{url:contact_manage}">{lang:continue}</a>
</td></tr>
</table>
{stop:agree}