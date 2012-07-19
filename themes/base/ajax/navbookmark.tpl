{if:share}
{icon:bookmark} <a href="#" onclick="cs_bookmark('{bookmark:uri}', '{bookmark:title}')" class="noajax">{lang:bookmark_add}</a><br />
{icon:cell_edit} <a href="{bookmark:uri}" title="{bookmark:uri}" class="noajax">{lang:bookmark_view}</a>
{stop:share}
{unless:share}
{icon:bookmark} {lang:bookmark_not}
{stop:share}