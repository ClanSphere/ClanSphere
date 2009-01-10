<div class="container" style="width:{page:width}">
  <div class="headb">{lang:mod} - {lang:manage}</div>
  <div class="headc clearfix">
  	<div class="leftb fl">{icon:contents} {lang:total}: {head:total}</div>
  	<div class="rightb fr">{head:pages}</div>
  </div>
</div>
<br />
<div class="container" style="width:{page:width}">
    <div class="headb"> {sort:title} {lang:title}</div>
  {loop:static}
    <div class="leftc"><a href="{static:url_view}" title="{lang:show}">{static:static_title}</div>
  {stop:static}
</div>
