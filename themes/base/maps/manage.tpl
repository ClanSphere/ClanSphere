<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb" colspan="2">{lang:mod_name} - {lang:manage}</td>
 </tr>
 <tr>  
  <td class="leftb">{icon:contents} {lang:total}: {head:count_maps}</td>
  <td class="rightb">{head:pages}</td>
 </tr>
 <tr>
   <td class="leftb"colspan="2">{lang:game}
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