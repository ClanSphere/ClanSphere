<table class="forum" cellpadding="0" cellspacing="1" style="width:{page:width}">
	<tr>
		<td class="headb" colspan="3">
			{head:mod} - {head:action}
		</td>
	</tr>
	<tr>
		<td class="leftb" width="33%">
			{icon:picture} {link:picture}
		</td>
		<td class="leftb" width="33%">
			{icon:folder_yellow} {link:folder}
		</td>
		<td class="rightb" width="33%">
			{icon:info} {link:info}
		</td>
	</tr>
</table>
<br />
<table class="forum" cellpadding="0" cellspacing="1" style="width:{page:width}">
  <tr>
		<td class="leftb" colspan="2">
			{lang:info_body}
		</td>
	</tr>
	<tr>
		<td class="leftc">
			{icon:image} {lang:info_pics}
		</td>
		<td class="rightb">
			{data:count_pics}
		</td>
	</tr>
	<tr>
		<td class="leftc">
			{icon:history} {lang:info_pics_activ}
		</td>
		<td class="rightb">
			{data:count_active}
		</td>
	</tr>
	<tr>
		<td class="leftc">
			{icon:history_clear} {lang:info_pics_inactiv}
		</td>
		<td class="rightb">
			{data:count_inactive}
		</td>
	</tr>
	<tr>
		<td class="leftc">
			{icon:folder_yellow} {lang:info_folders}
		</td>
		<td class="rightb">
			{data:count_cats}
		</td>
	</tr>
	<tr>
		<td class="leftc">
			{icon:kdict} {lang:info_views}
		</td>
		<td class="rightb">
			{data:count_views}
		</td>
	</tr>
	<tr>
		<td class="leftc">
			{icon:Volume Manager} {lang:info_votes}
		</td>
		<td class="rightb">
			{data:count_votes}
		</td>
	</tr>
	<tr>
		<td class="leftc">
			{icon:xpaint} {lang:info_picsize}
		</td>
		<td class="rightb">
			{data:count_size}
		</td>
	</tr>
	<tr>
		<td class="leftc">
			{icon:web} {lang:info_trafik}
		</td>
		<td class="rightb">
			{data:count_trafik}
		</td>
	</tr>
	<tr>
		<td class="leftc">
			{icon:nfs_unmount} {lang:info_space}
		</td>
		<td class="leftb">
			<div style="float:right; text-align:right; height:13px; width:35px; vertical-align:middle">
			{data:count_space}%
			</div>
			<div style="background-image:url({page:path}symbols/messages/messages03.png); width:100px; height:13px;">
				<div style="background-image:url({img:01}); width:{data:count_space}px; text-align:right; padding-left:1px">
					<img src="{page:path}{img:02}" style="height:13px;width:2px" alt=""/>
				</div>
			</div>
		</td>
	</tr>
</table>