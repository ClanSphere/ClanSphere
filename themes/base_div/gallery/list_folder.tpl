<div class="container" style="width:{page:width}">
		<div class="headb">
			{lang:mod} - {lang:head_list}		</div>
		<div class="leftc">
			{link:gallery} {link:subfolders} - {data:folders_name}
		</div>
	{tmp:empty_cat}
		<div class="leftc clearfix">
			{loop:sub_folders}
				<div style="float: left; width: 100px; height: 100px; margin: 5px; padding: 0px; background-position: center; background-repeat: no-repeat; ">
					{sub_folders:folders_img} <br />
					 {sub_folders:folders_name}
				</div>
			{stop:sub_folders}
			{loop:img}
				<div style="float: left; width: 100px; height: 100px; margin: 5px; padding: 0px; background-position: center; background-repeat: no-repeat; background-image: url(mods/gallery/image.php?thumb={img:img}); border:1px solid #666666">
				{img:link}
			</div>
		{stop:img}
		</div>
		<div class="centerb">
			{data:pages}
		</div>
</div>