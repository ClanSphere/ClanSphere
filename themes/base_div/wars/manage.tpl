<div class="container" style="width:{page:width}">
  <div class="headb">{lang:mod} - {lang:manage}</div>
  <div class="headc clearfix">
  	<div class="leftb fl">{icon:editpaste} <a href="{url:wars_create}">{lang:new_war}</a></div>
  	<div class="leftb fr">{icon:contents} {lang:total}: {count:all}</div>
  </div>
  <div class="headc clearfix">
  	<div class="rightb fr">{pages:list}</div>
  	<div class="leftb fl">
    {lang:status}
      <form method="post" name="wars_manage" action="{url:wars_manage}">
      <select name="where" >
        <option value="0">----</option>
        <option value="upcoming"{selection:upcoming}>{lang:upcoming}</option>
        <option value="running"{selection:running}>{lang:running}</option>
        <option value="canceled"{selection:canceled}>{lang:canceled}</option>
        <option value="played"{selection:played}>{lang:played}</option>
      </select>
      <input type="submit" name="submit" value="{lang:show}" />
      </form>
  </div>
  </div>
</div>
<br />
{head:message}
<table class="forum" cellpadding="0" cellspacing="1" style="width:{page:width}">
 <tr>
  <td class="headb">{sort:date} {lang:date}</td>
  <td class="headb">{sort:squad} {lang:squad}</td>
  <td class="headb">{sort:enemy} {lang:enemy}</td>
  <td class="headb" colspan="4">{lang:options}</td>
 </tr>{loop:wars}
 <tr>
  <td class="leftb"><a href="{url:wars_view,id={wars:wars_id}}" title="{lang:details}">{wars:date}</a></td>
  <td class="leftb"><a href="{url:squads_view,id={wars:squads_id}}">{wars:squads_name}</a></td>
  <td class="leftb"><a href="{url:clans_view,id={wars:clans_id}}">{wars:clans_name}</a></td>
  <td class="leftb"><a href="{url:wars_rounds,id={wars:wars_id}}" title="{lang:rounds}">{icon:agt_reload}</a></td>
  <td class="leftb"><a href="{url:wars_picture,id={wars:wars_id}}" title="{lang:pictures}">{icon:image}</a></td>
  <td class="leftb"><a href="{url:wars_edit,id={wars:wars_id}}" title="{lang:edit}">{icon:edit}</a></td>
  <td class="leftb"><a href="{url:wars_remove,id={wars:wars_id}}" title="{lang:remove}">{icon:editdelete}</a></td>
 </tr>{stop:wars}
</table>