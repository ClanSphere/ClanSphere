<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb" colspan="3">{lang:mod} - {lang:manage}</td>
 </tr>
 <tr>
  <td class="leftc">{icon:editpaste} <a href="{url:maps_create}">{lang:new_map}</a></td>
  <td class="leftc">{icon:contents} {lang:total}: {head:count_maps}</td>
  <td class="rightc">{head:pages}</td>
 </tr>
 <tr>
 	<td class="leftc"colspan="3">{lang:game}
 		<form method="post" id="maps_manage" action="{url:maps_manage}">
 			{head:dropdown}
 			<input type="submit" name="submit" value="{lang:show}" /> 		
 		</form>
 	</td>
 </tr>
</table>
<br />

{head:getmsg}

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb">{sort:name} {lang:name}</td>
  <td class="headb" colspan="2" style="width:20%">{lang:options}</td>
 </tr>{loop:maps}
 <tr>
  <td class="leftc"><a href="{url:maps_view:id={maps:id}}">{maps:name}</a></td>
  <td class="leftc"><a href="{url:maps_edit:id={maps:id}}">{icon:edit}</a></td>
  <td class="leftc"><a href="{url:maps_remove:id={maps:id}}">{icon:editdelete}</a></td>
 </tr>{stop:maps}
</table>	