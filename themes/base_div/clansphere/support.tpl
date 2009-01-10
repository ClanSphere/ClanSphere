<div class="container" style="width:{page:width}">
    <div class="headb"> ClanSphere - {lang:support} </div>
    <div class="leftb"> {lang:body_support} </div>
</div>
{loop:support} <br />
<div class="container" style="width:{page:width}">
    <div class="leftc"><a href="http://{support:url}" target="_blank">{support:name}</a>
      <hr noshade="noshade" style="width:100%" />
      {support:text} </div>
</div>
{stop:support}