<div class="container" style="width:{page:width}">
    <div class="headb">{lang:mod} - {lang:head_variables}</div>
    <div class="leftb">{lang:body_variables}</div>
</div>
<br />
<div class="container" style="width:{page:width}">
  {loop:com}
  <div class="headc clearfix">
    <div class="leftc fl" style="width:40%">{com:var}</div>
    <div class="leftb fl">{com:value}</div>
  </div>
  {stop:com}
</div>
<br />
<div class="container" style="width:{page:width}">
  {loop:main}
  <div class="headc clearfix">
    <div class="leftc fl" style="width:40%">{main:var}</div>
    <div class="leftb fl">{main:value}</div>
  </div>
  {stop:main}
</div>
<br />
<div class="container" style="width:{page:width}">
  {loop:log}
  <div class="headc clearfix">
    <div class="leftc fl" style="width:40%">{log:var}</div>
    <div class="leftb fl">{log:value}</div>
  </div>
  {stop:log}
</div>
<br />
<div class="container" style="width:{page:width}">
  {loop:account}
  <div class="headc clearfix">
    <div class="leftc fl" style="width:40%">{account:var}</div>
    <div class="leftb fl">{account:value}</div>
  </div>
  {stop:account}
</div>
