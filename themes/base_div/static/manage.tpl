<div class="container" style="width:{page:width}">
  <div class="headb">{lang:mod} - {lang:manage}</div>
  <div class="headc clearfix">
    <div class="leftb fl">{icon:editpaste} <a href="{url:new_staticpage}">{lang:new_staticpage}</a></div>
    <div class="rightb fr">{head:pages} </div>
  </div>
  <div class="headc clearfix">
    <div class="leftb fr">{icon:contents} {lang:total}: {head:total}</div>
    <div class="leftb fl"> {lang:access}:
      <form method="post" name="static_manage" action="{url:form}">
        {head:dropdown}
        <input type="submit" name="submit" value="{lang:show}" />
      </form></div>
  </div>
</div>
<br />
{head:message}
<table class="forum" cellpadding="0" cellspacing="1" style="width:{page:width}">
  <tr>
    <td class="headb" style="width:30px">{sort:id}  {lang:id}</td>
    <td class="headb" style="width:125px"> {sort:title} {lang:title}</td>
    <td class="headb" style="width:50px"> {lang:access}</td>
    <td class="headb" colspan="2" style="width:50px"> {lang:options} </td>
  </tr>
  {loop:static}
  <tr>
    <td class="rightc">{static:static_id}</a></td>
    <td class="leftc"><a href="{static:url_view}" title="{lang:show}">{static:static_title}</td>
    <td class="leftc">{static:static_access}</td>
    <td class="leftc" style="width:25px"><a href="{static:url_edit}" title="{lang:edit}">{icon:edit}</a></td>
    <td class="leftc" style="width:25px"><a href="{static:url_delete}" title="{lang:remove}">{icon:editdelete}</a> </td>
  </tr>
  {stop:static}
</table>
