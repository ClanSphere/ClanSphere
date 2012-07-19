{votes:question}<br /><br />
{loop:results}
   <div style="padding:1px;">{results:answer}</div>
   <div style="float:right;text-align:right;height:13px;width:35px;vertical-align:middle;">{results:percent}%</div>
   <div style="padding:1px;"><div style="background-image:url({page:path}symbols/votes/vote03.png); width:100px; height:13px;"><div style="background-image:url({page:path}symbols/votes/vote01.png); width:{results:percent}%; padding-left:1px;">
   {results:end_img}</div></div></div>
{stop:results}
<br />
<div style="text-align:center;"><a href="{url:votes_view:where={votes:id}}">{lang:current_vote}</a></div>
