{if:result}
<div class="container" style="width:{page:width};">
  	<div class="headb">{lang:result}</div>
    <div class="headc clearfix">
  		<div class="leftb fl">{icon:contents}{lang:hit}: {result:count}</div>
		<div class="rightb fr">{result:pages}</div>
    </div>
</div>
<br />
<table class="forum" cellpadding="0" cellspacing="1" style="width:{page:width};">
  <tr>
  	<td class="headb">{sort:name}{lang:name}</td>
	<td class="headb">{sort:cat}{lang:cat}</td>
	<td class="headb">{sort:time}{lang:time}</td>
	<td class="headb">{lang:creator}</td>
  </tr>
  {loop:results}
  <tr>
   	<td class="leftc" style="font-weight:bold;">{results:name}</td>
	<td class="leftc">{results:cat}</td>
	<td class="leftc">{results:date}</td>
	<td class="leftc">{results:user}</td>
  </tr>
  {stop:results}
</table>
{stop:result}
{if:noresults}
<div class="container" style="width:{page:width};">
	<div class="leftb">{icon:important}{lang:nohit}</div>
</div>
{stop:noresults}

