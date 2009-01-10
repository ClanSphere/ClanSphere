<div class="forum" style="width:{page:width}">
		<div class="leftb">{sort:time}</div>
		<div class="leftb">
			<div class="fl">{sort:titel} {lang:titel} {sort:name} {lang:category}</div>
			<div class="fr">{sort:time} {lang:time}</div>
		</div>
		<div class="rightb">{lang:options}</div>
	{loop:box}
	{box:box}
	{stop:box}
</div>