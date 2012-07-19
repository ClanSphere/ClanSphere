<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb" colspan="2">{lang:mod_name} - {lang:head_manage}</td>
 </tr>
 <tr>  
  <td class="leftb">{icon:contents} {lang:total}: {count:rules}</td>
  <td class="rightb">{head:pages}</td>
 </tr>
</table>
<br />

{head:message}

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb" style="width:20%">{sort:order} {lang:order}</td>
  <td class="headb">{sort:title} {lang:title}</td>
  <td class="headb">{sort:cat} {lang:cat}</td>
  <td class="headb" colspan="2">{lang:options}</td>
 </tr>
{loop:rules}
 <tr>
  <td class="leftc">{rules:order}</td>
  <td class="leftc">{rules:title}</td>
  <td class="leftc">{rules:cat}</td>
  <td class="leftc"><a href="{rules:url_edit}" title="{lang:edit}">{icon:edit}</a></td>
  <td class="leftc"><a href="{rules:url_remove}" title="{lang:remove}">{icon:editdelete}</a></td>
 </tr>
{stop:rules}
</table>
