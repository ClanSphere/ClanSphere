<div class="container" style="width:{page:width}">
    <div class="headb">{lang:mod} - {lang:manage}</div>
  <div class="headc clearfix">
    <div class="leftb fl">{icon:editpaste} {lang:create}</div>
    <div class="rightb fr">{pages:list}</div>
  </div>
  <div class="headc clearfix">
    <div class="leftb fl">{lang:function}
      <form method="post" name="abcode_manage" action="{action:form}">
        <select name="where">
          <option value="0">----</option>
          <option value="img">{lang:img}</option>
          <option value="str">{lang:str}</option>
        </select>
        <input type="submit" name="submit" value="{lang:show}" />
      </form></div>
    <div class="rightb fr">{icon:contents} {lang:total}: {lang:count}</div>
  </div>
</div>

<br />

<center>
  {lang:getmsg}
</center>
<table class="forum" cellpadding="0" cellspacing="1" style="width:{page:width}">
  <tr>
    <td class="headb">{sort:function} {lang:function}</td>
    <td class="headb">{sort:pattern} {lang:pattern}</td>
    <td class="headb">{lang:result}</td>
    <td class="headb" colspan="2">{lang:options}</td>
  </tr>
  {loop:abcode}
  <tr>
    <td class="leftc">{abcode:function}</td>
    <td class="leftc">{abcode:pattern}</td>
    <td class="leftc">{abcode:result}</td>
    <td class="leftc">{abcode:edit}</td>
    <td class="leftc">{abcode:remove}</td>
  </tr>
  {stop:abcode}
</table>
