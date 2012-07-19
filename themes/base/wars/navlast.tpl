<a href="{url:squads_view:id={war:squads_id}}" title="{war:squads_name}" style="float:left; width: 33%;">
  <img src="{page:path}uploads/squads/{war:squads_picture}" alt="{war:squads_name}" />
 </a>

<div style="float: left; text-align: center; width: 34%; padding-top: 20px">
  <span style="font-weight: bold;">vs.</span><br /><br />
  <a href="{url:wars_view:id={war:wars_id}}">
  {if:draw}<span style="color: #bbb">{war:score1}</span> : <span style="color: #bbb">{war:score2}</span>{stop:draw}
  {unless:draw}
  {if:win}<span style="color: #00ff00">{war:score1}</span> : <span style="color: #ff0000">{war:score2}</span>{stop:win}
  {unless:win}<span style="color: #ff0000">{war:score1}</span> : <span style="color: #00ff00">{war:score2}</span>{stop:win}
  {stop:draw}
  </a>
 </div>

<a href="{url:clans_view:id={war:clans_id}}" title="{war:clans_name}" style="float: right; width: 33%;">
  <img src="{page:path}uploads/clans/{war:clans_picture}" alt="{war:clans_name}" />
 </a>

<br style="clear: both" />