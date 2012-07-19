<form method="post" action="{url:users_manage}">
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb" colspan="2">{lang:users} - {lang:manage}</td>
  </tr>
  <tr>    
    <td class="leftb">{icon:contents} {lang:total}: {head:total}</td>
    <td class="rightb">{head:pages} </td>
  </tr>
  <tr>
    <td class="centerb" colspan="2">
      <a href="{url:users_manage:where=a}">A</a> - 
      <a href="{url:users_manage:where=b}">B</a> - 
      <a href="{url:users_manage:where=c}">C</a> - 
      <a href="{url:users_manage:where=d}">D</a> - 
      <a href="{url:users_manage:where=e}">E</a> - 
      <a href="{url:users_manage:where=f}">F</a> - 
      <a href="{url:users_manage:where=g}">G</a> - 
      <a href="{url:users_manage:where=h}">H</a> - 
      <a href="{url:users_manage:where=i}">I</a> - 
      <a href="{url:users_manage:where=j}">J</a> - 
      <a href="{url:users_manage:where=k}">K</a> - 
      <a href="{url:users_manage:where=l}">L</a> - 
      <a href="{url:users_manage:where=m}">M</a> - 
      <a href="{url:users_manage:where=n}">N</a> - 
      <a href="{url:users_manage:where=o}">O</a> - 
      <a href="{url:users_manage:where=p}">P</a> - 
      <a href="{url:users_manage:where=q}">Q</a> - 
      <a href="{url:users_manage:where=r}">R</a> - 
      <a href="{url:users_manage:where=s}">S</a> - 
      <a href="{url:users_manage:where=t}">T</a> - 
      <a href="{url:users_manage:where=u}">U</a> - 
      <a href="{url:users_manage:where=v}">V</a> - 
      <a href="{url:users_manage:where=w}">W</a> - 
      <a href="{url:users_manage:where=x}">X</a> - 
      <a href="{url:users_manage:where=y}">Y</a> - 
      <a href="{url:users_manage:where=z}">Z</a> - 
      <a href="{url:users_manage}">{lang:all}</a>
    </td>
  </tr>
  <tr>
    <td class="leftb">{lang:search}</td>
    <td class="leftb">
      <input type="text" name="search_name" id="search_name" value="{search:name}" autocomplete="off" onkeyup="Clansphere.ajax.user_autocomplete('search_name', 'search_users_result', '{page:path}')" size="50" maxlength="100" />
      <input type="submit" name="{lang:submit}" />
      <div id="search_users_result"></div>
    </td>
  </tr>
</table>
</form>
<br />
{head:message}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" style="width:30px"> {lang:country}</td>
    <td class="headb"> {sort:nick} {lang:nick}</td>
    <td class="headb" style="width:125px"> {sort:laston} {lang:laston}</td>
    <td class="headb" style="width:50px"> {lang:status}</td>
    <td class="headb"> {sort:active} {lang:active}</td>
  <td class="headb"> {sort:access} {lang:access}</td>
    <td class="headb" colspan="3" style="width:50px"> {lang:options} </td>
  </tr>
  {loop:users}
  <tr>
    <td class="centerc"><img src="{page:path}{users:country}" style="height:11px;width:16px" alt="" /></td>
    <td class="leftc">{users:nick}</td>
    <td class="rightc">{users:laston}</td>
    <td class="centerc">{users:page}</td>
    <td class="leftc">{users:active}</td>
  <td class="leftc">{users:access}</td>
    <td class="leftc"><a href="{users:url_picture}" title="{lang:picture_edit}">{icon:camera_unmount}</a></td>
    <td class="leftc"><a href="{users:url_edit}" title="{lang:edit}">{icon:edit}</a></td>
    <td class="leftc"><a href="{users:url_delete}" title="{lang:remove}">{icon:editdelete}</a> </td>
  </tr>
  {stop:users}
</table>