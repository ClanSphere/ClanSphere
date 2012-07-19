<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="2"> {head:mod}  -  {head:action} </td>
  </tr>
  <tr>
    <td class="leftb"> {lang:total}: {head:total}</td>
    <td class="rightb"> {head:pages} </td>
  </tr>
  <tr>
    <td class="centerb" colspan="2"> 
      <a href="{url:users_list:where=a}">A</a> - 
      <a href="{url:users_list:where=b}">B</a> - 
      <a href="{url:users_list:where=c}">C</a> - 
      <a href="{url:users_list:where=d}">D</a> - 
      <a href="{url:users_list:where=e}">E</a> - 
      <a href="{url:users_list:where=f}">F</a> - 
      <a href="{url:users_list:where=g}">G</a> - 
      <a href="{url:users_list:where=h}">H</a> - 
      <a href="{url:users_list:where=i}">I</a> - 
      <a href="{url:users_list:where=j}">J</a> - 
      <a href="{url:users_list:where=k}">K</a> - 
      <a href="{url:users_list:where=l}">L</a> - 
      <a href="{url:users_list:where=m}">M</a> - 
      <a href="{url:users_list:where=n}">N</a> - 
      <a href="{url:users_list:where=o}">O</a> - 
      <a href="{url:users_list:where=p}">P</a> - 
      <a href="{url:users_list:where=q}">Q</a> - 
      <a href="{url:users_list:where=r}">R</a> - 
      <a href="{url:users_list:where=s}">S</a> - 
      <a href="{url:users_list:where=t}">T</a> - 
      <a href="{url:users_list:where=u}">U</a> - 
      <a href="{url:users_list:where=v}">V</a> - 
      <a href="{url:users_list:where=w}">W</a> - 
      <a href="{url:users_list:where=x}">X</a> - 
      <a href="{url:users_list:where=y}">Y</a> - 
      <a href="{url:users_list:where=z}">Z</a> - 
      <a href="{url:users_list}">{lang:all}</a>
    </td>
  </tr>
</table><br />
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" style="width:40px"> {lang:country}</td>
    <td class="headb">{sort:nick} {lang:nick}</td>
    <td class="headb">{sort:place} {lang:place}</td>
    <td class="headb">{sort:laston} {lang:laston}</td>
    <td class="headb" style="width:40px"> {lang:status} </td>
  </tr>
  {loop:users}
  <tr>
    <td class="leftc">{users:country}</td>
    <td class="leftc">{users:nick}</td>
    <td class="leftc"> {users:place}</td>
    <td class="leftc"> {users:laston}</td>
    <td class="centerc"> {users:page} </td>
  </tr>
  {stop:users}
</table>
