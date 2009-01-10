{if:buddys}
<div style="width:95%">{loop:users}
 <div class="headc">
  <div class="fl">{users:countryicon} <a href="{users:url}">{users:nick}</a></div>
  <div class="fr" style="text-align:right;"><a href="{users:messageurl}">{icon:mail_send}</a></div>
 </div>{stop:users}
</div>
{stop:buddys}

{if:empty}
{lang:no_buddys}
{stop:empty}