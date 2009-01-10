<div class="container" style="width:{page:width}">
		<div class="headb">{lang:mod} - {lang:head_list}</div>
	{tmp:no_cat}
	{loop:cat}
		<div class="leftc">
			<div style="width:22% ;margin-right:5px; float:left">
				{cat:img}
			</div>
			<div style="width:100%">
				<strong>{cat:folders_name}</strong> <br /> 
				<hr style="width:78%" noshade="noshade" />
				{cat:folders_text}
				<hr style="width:78%" noshade="noshade" />
				{cat:pic_count} {cat:last_update}
			</div>
		</div>
	{stop:cat}
</div>
<br />
{lang:getmsg}
{loop:top_views_1}
<div class="container" style="width:{page:width}">
		<div class="leftb">{lang:top}</div>
		<div class="leftc clearfix">
		{loop:top_views}
			<div style="float: left; width: 100px; height: 100px; margin: 5px; padding: 0px; background-position: center; background-repeat: no-repeat; background-image: url(/mods/gallery/image.php?thumb={top_views:img}); border:1px solid #666666">{top_views:link}</div>
		{stop:top_views}
		</div>
</div>
<br />
{stop:top_views_1}
{loop:last_update_1}
<div class="container" style="width:{page:width}">
		<div class="leftb">{lang:last_update}</div>
		<div class="leftc clearfix">
		{loop:last_update}
			<div style="float: left; width: 100px; height: 100px; margin: 5px; padding: 0px; background-position: center; background-repeat: no-repeat; background-image: url(/mods/gallery/image.php?thumb={last_update:img}); border:1px solid #666666">{last_update:link}</div>
		{stop:last_update}
		</div>
</div>
<br />
{stop:last_update_1}
{loop:vote_1}
<div class="container" style="width:{page:width}">
		<div class="leftb">{lang:vote}</div>
		<div class="leftc clearfix">
		{loop:vote}
			<div style="float: left; width: 100px; height: 100px; margin: 5px; padding: 0px; background-position: center; background-repeat: no-repeat; background-image: url(/mods/gallery/image.php?thumb={vote:img}); border:1px solid #666666;">{vote:link}</div>
		{stop:vote}
		</div>
</div>
<br />
{stop:vote_1}