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
  	<td class="headb" style="width:40px;">{lang:country}</td>
	<td class="headb">{sort:nick}{lang:nick}</td>
	<td class="headb">{sort:place}{lang:place}</td>
	<td class="headb">{sort:laston}{lang:laston}</td>	
  	<td class="headb" style="width:40px;">{lang:page}</td>	
	{if:access}
	<td class="headb"></td>
	{stop:access}
  </tr>
  {loop:results}
  <tr>
	<td class="leftc">{results:img}</td>
	<td class="leftc" style="font-weight:bold;">{results:user}</td>
	<td class="leftc">{results:place}</td>
	<td class="leftc">{results:date}</td>
	<td class="leftc">{results:icon}</td>
	{if:access}
	<td class="leftc">{results:msg}</td>
	{stop:access}
  </tr>
  {stop:results}
 </table>
{stop:result}
{if:noresults}
<div class="container" style="width:{page:width};">
	<div class="leftb">{icon:important}{lang:nohit}</div>
</div>
{stop:noresults}
<br />




