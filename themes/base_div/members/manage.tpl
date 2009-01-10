<div class="container" style="width:{page:width}">
    <div class="headb">{lang:mod} - {lang:manage}</div>
    <div class="headc clearfix">
    	<div class="leftb fl">{icon:editpaste} {lang:link}</div>
        <div class="leftb fr">{icon:contents} {lang:total}: {lang:all}</div>
    </div>
    <div class="headc clearfix">
    	<div class="leftb fl">{icon:package_settings} {member:options}</div>
    	<div class="rightb fr">{pages:list}</div>
    </div>
</div>
<br />
<center>{lang:getmsg}</center>
<table class="forum" cellpadding="0" cellspacing="1" style="width:{page:width}">
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