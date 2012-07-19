<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
   <td class="headb">{lang:mod_name} - {lang:cut_comment_as_thread}</td>
 </tr>
 <tr>
   <td class="leftc">{lang:errors_here}</td>
 </tr>
</table>
<br />

<form method="post" id="thread_cut" action="{url:board_thread_cut}">
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
   <td class="leftc" style="width: 130px">{icon:kedit} {lang:headline} *</td>
   <td class="leftb" colspan="2"><input type="text" name="threads_headline" value="" maxlength="200" size="50" /></td>
 </tr>
 <tr>
   <td class="leftc">{icon:tutorials} {lang:board} *</td>
   <td class="leftb" colspan="2">{board:select}</td>
 </tr>
 <tr>
   <td class="leftc">{icon:kate} {lang:text}</td>
   <td class="leftb" colspan="2">{abcode:features}<br /><textarea class="rte_abcode" rows="20" cols="50" name="threads_text" id="threads_text">{comment:comments_text}</textarea></td>
 </tr>
 <tr>
  <td class="leftb" colspan="2">{lang:comments}</td>
  <td class="leftb">{lang:takeover}</td>
 </tr>
 <tr>
  <td class="leftb"><img src="{page:path}symbols/countries/{comment:users_country}.png" alt="" /> {comment:user}</td>
  <td class="leftb">{comment:text}</td>
  <td class="leftb">-</td>
 </tr>{loop:comments}
 <tr>
  <td class="leftc"><img src="{page:path}symbols/countries/{comments:users_country}.png" alt="" /> {comments:user}</td>
  <td class="leftc">{comments:comments_text}</td>
  <td class="leftb"><input type="checkbox" name="comments[]" value="{comments:comments_id}"{comments:checked} /></td>
 </tr>{stop:comments}
 <tr>
   <td class="leftc">{icon:ksysguard} {lang:options}</td>
   <td class="leftb" colspan="2">
     <input type="hidden" name="comments_id" value="{comment:comments_id}" />
     <input type="hidden" name="old_threads_id" value="{comment:comments_fid}" />
     <input type="submit" name="submit" value="{lang:save}" />
    </td>
 </tr>
</table>

</form>