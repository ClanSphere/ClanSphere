{if:form}
<div class="container" style="width:{page:width}">
	<div class="headb">{lang:mod} - {lang:head_remove}</div>
    <div class="leftb">{remove:confirm}</div>
    <div class="centerc">
        <form method="post" name="mail_delete" action="{url:contact_delete}">
        <input type="hidden" name="id" value="{remove:id}" />
        <input type="submit" name="agree" value="{lang:confirm}" />
        <input type="submit" name="cancel" value="{lang:cancel}" /></form>
    </div>
</div>
{stop:form}

{if:cancel}
<div class="container" style="width:{page:width}">
	<div class="headb">{lang:mod} - {lang:head_remove}</div>
    <div class="leftc">{lang:del_false}</div>
    <div class="centerb"><a href="{url:contact_manage}">{lang:continue}</a></div>
</div>
{stop:cancel}

{if:agree}
<div class="container" style="width:{page:width}">
    <div class="headb">{lang:mod} - {lang:head_remove}</div>
    <div class="leftc">{lang:del_true}</div>
    <div class="centerb"><a href="{url:contact_manage}">{lang:continue}</a></div>
</div>
{stop:agree}