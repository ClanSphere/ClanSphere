<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
		<td class="leftb">
			{sort:time}
		</td>
		<td class="leftb">
			<div style="float:left">
				{sort:titel} {lang:titel} {sort:name} {lang:category}
			</div>
			<div style="float:right">
				{sort:time} {lang:time}
			</div>
		</td>
		<td class="rightb">
		 {lang:options}
		</td>
	</tr>
	{loop:box}
	{box:box}
	{stop:box}
</table>