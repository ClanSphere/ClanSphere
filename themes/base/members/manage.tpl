<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="4">{lang:mod_name} - {lang:manage}</td>
  </tr>
  <tr>    
    <td class="leftb">{icon:contents} {lang:total}: {member:all}</td>    
    <td class="rightb">{pages:list}</td>
  </tr>
  <tr>
    <td class="centerb" colspan="3"> 
      <a href="{url:members_manage:where=a}">A</a> - 
      <a href="{url:members_manage:where=b}">B</a> - 
      <a href="{url:members_manage:where=c}">C</a> - 
      <a href="{url:members_manage:where=d}">D</a> - 
      <a href="{url:members_manage:where=e}">E</a> - 
      <a href="{url:members_manage:where=f}">F</a> - 
      <a href="{url:members_manage:where=g}">G</a> - 
      <a href="{url:members_manage:where=h}">H</a> - 
      <a href="{url:members_manage:where=i}">I</a> - 
      <a href="{url:members_manage:where=j}">J</a> - 
      <a href="{url:members_manage:where=k}">K</a> - 
      <a href="{url:members_manage:where=l}">L</a> - 
      <a href="{url:members_manage:where=m}">M</a> - 
      <a href="{url:members_manage:where=n}">N</a> - 
      <a href="{url:members_manage:where=o}">O</a> - 
      <a href="{url:members_manage:where=p}">P</a> - 
      <a href="{url:members_manage:where=q}">Q</a> - 
      <a href="{url:members_manage:where=r}">R</a> - 
      <a href="{url:members_manage:where=s}">S</a> - 
      <a href="{url:members_manage:where=t}">T</a> - 
      <a href="{url:members_manage:where=u}">U</a> - 
      <a href="{url:members_manage:where=v}">V</a> - 
      <a href="{url:members_manage:where=w}">W</a> - 
      <a href="{url:members_manage:where=x}">X</a> - 
      <a href="{url:members_manage:where=y}">Y</a> - 
      <a href="{url:members_manage:where=z}">Z</a> - 
      <a href="{url:members_manage}">{lang:all}</a>
    </td>
  </tr>  
</table>
<br />
{lang:getmsg}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{sort:user} {lang:user}</td>
    <td class="headb">{sort:team} {lang:team}</td>
    <td class="headb" style="width:60px"> {lang:order}</td>
    <td class="headb" colspan="2"> {lang:options}</td>
  </tr>
  
  
  {loop:members}
  <tr>
    <td class="leftc">{members:user}</td>
    <td class="leftc">{members:team}</td>
    <td class="leftc">{members:order}</td>
    <td class="leftc">{members:edit}</td>
    <td class="leftc">{members:remove}</td>
  </tr>
  {stop:members}
</table>