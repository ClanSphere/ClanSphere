<div class="container" style="width:{page:width}">
 <div class="headb">{lang:mod}</div>
<div class="leftb">{lang:text_list}</div>
</div>

<br />
{loop:history}
<div class="container" style="width:{page:width}">
<div class="bottom">{history:history_time} - {history:user}</div>
   <div class="leftc">{history:history_text}</div>
</div>
<br />
{stop:history}