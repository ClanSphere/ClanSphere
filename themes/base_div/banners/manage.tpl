<div class="container" style="width:{page:width}">
  <div class="headb">{lang:mod} - {lang:head_manage}</div>
  <div class="headc clearfix">
    <div class="leftb fl">{icon:editpaste} <a href="{link:new}" >{lang:new_banner}</a></div>
    <div class="rightb fr">{pages:list}</div>
  </div>
  <div class="headc clearfix">
    <div class="leftb fr">{icon:contents} {lang:total}: 1</div>
  </div>
</div>
<br />
{lang:getmsg}
<table class="forum" cellpadding="0" cellspacing="1" style="width:{page:width}">
  <tr>
    <td class="headb">{sort:name} {lang:name}</td>
    <td class="headb">{sort:order} {lang:order}</td>
    <td class="headb" colspan="2">{lang:options}</td>
  </tr>
  {loop:banners}
  <tr>
    <td class="leftc">{banners:name}</td>
    <td class="leftc">{banners:order}</td>
    <td class="leftc"><a href="{banners:edit}" title="{lang:edit}" ><img src="symbols/crystal_project/16/edit.png" style="height:16px;width:16px" alt="{lang:edit}" /> </a></td>
    <td class="leftc"><a href="{banners:remove}" title="{lang:remove}" ><img src="symbols/crystal_project/16/editdelete.png" style="height:16px;width:16px" alt="{lang:remove}" /> </a> </td>
  </tr>
  {stop:banners}
</table>
