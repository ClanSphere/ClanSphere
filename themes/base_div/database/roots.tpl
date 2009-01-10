<div class="container" style="width:{page:width}">
    <div class="headb">{lang:mod} - {lang:roots}</div>
    <div class="leftc">{lang:body_roots}</div>
</div>
<br />
<div class="container" style="width:{page:width}">
  {if:cs_db}
    <div class="centerb"><a href="{roots:optimize_tables_url}">{lang:optimize_tables}</a> </div>
  {stop:cs_db}
    <div class="centerb"><a href="{roots:import_url}">{lang:import}</a> </div>
    <div class="centerb"><a href="{roots:export_url}">{lang:export}</a> </div>
    <div class="centerb"><a href="{roots:statistic_url}">{lang:statistic}</a> </div>
</div>
