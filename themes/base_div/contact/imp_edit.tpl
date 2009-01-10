{if:form}
<div class="container" style="width:{page:width}">
	<div class="headb">{lang:mod_imp} - {lang:head_edit}</div>
    <div class="leftc">{lang:body_edit}</div>
</div>
<br />

<form method="post" name="imprint_edit" action="{url:contact_imp_edit}">
    <table class="forum" cellpadding="0" cellspacing="1" style="width:{page:width}">
        <tr>
            <td class="leftc">{icon:kate} {lang:text} *</td>
            <td class="leftb">{imprint:abcode_features}
            	<textarea name="imprint" cols="55" rows="30" id="imprint" >{imprint:content}</textarea>
            </td>
        </tr>
        <tr>
            <td class="leftc">{icon:ksysguard} {lang:options}</td>
            <td class="leftb">
            	<input type="submit" name="submit" value="{lang:edit}" />
                <input type="reset" name="reset" value="{lang:reset}" />
            </td>
        </tr>
    </table>
</form>
{stop:form}

{if:done}
<div class="container" style="width:{page:width}">
	<div class="headb">{lang:mod_imp} - {lang:head_edit}</div>
    <div class="leftc">{lang:changes_done}</div>
</div>
<br />

<div class="container" style="width:{page:width}">
	<div class="centerb"><a href="{url:contact_manage}">{lang:continue}</a></div>
</div>
<br />
{stop:done}

{if:wizzard}
<div class="container" style="width:{page:width}">
	<div class="leftb">{lang:wizard}: <a href="{url:wizard_roots}">{lang:show}</a> - <a href="{url:wizard_roots,handler=cont&amp;done=1}">{lang:task_done}</a></div>
</div>
<br />
{stop:wizzard}