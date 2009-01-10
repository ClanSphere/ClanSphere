<div class="container" style="width:{page:width}">
    <div class="headb">{lang:mod} - {lang:head1}</div>
  <div class="headc clearfix">
    <div class="leftb">{lang:body}</div>
    <div class="rightb">{pages:list}</div>
  </div>
</div>
<br />
<table class="forum" cellpadding="0" cellspacing="1" style="width:{page:width}">
  <tr>
    <td class="headb">{sort:name} {lang:name}</td>
    <td class="headb">{lang:genre}</td>
    <td class="headb">{sort:usk} {lang:usk}</td>
    <td class="headb" colspan="2">{lang:release}</td>
  </tr>
  {loop:games}
  <tr>
    <td class="leftc">{games:name}</td>
    <td class="leftc">{games:genre}</td>
    <td class="leftc">{games:usk}</td>
    <td class="leftc">{games:release}</td>
  </tr>
  {stop:games}
</table>
