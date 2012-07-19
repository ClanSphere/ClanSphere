<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="3">{lang:users_gallery} - {lang:info}</td>
  </tr>
  {center:head}
  <tr>
    <td class="leftb" colspan="3">{lang:info_body}</td>
  </tr>
</table>
<br />

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="leftb">{icon:image} {lang:info_pics}</td>
    <td class="leftc">{data:count_pics}</td>
  </tr>
  <tr>
    <td class="leftb">{icon:history} {lang:info_pics_activ}</td>
    <td class="leftc">{data:count_active}</td>
  </tr>
  <tr>
    <td class="leftb">{icon:history_clear} {lang:info_pics_inactiv}</td>
    <td class="leftc">{data:count_inactive}</td>
  </tr>
  <tr>
    <td class="leftb">{icon:folder_yellow} {lang:info_folders}</td>
    <td class="leftc">{data:count_cats}</td>
  </tr>
  <tr>
    <td class="leftb">{icon:kdict} {lang:info_views}</td>
    <td class="leftc">{data:count_views}</td>
  </tr>
  <tr>
    <td class="leftb">{icon:volume_manager} {lang:info_votes}</td>
    <td class="leftc">{data:count_votes}</td>
  </tr>
  <tr>
    <td class="leftb">{icon:xpaint} {lang:info_picsize}</td>
    <td class="leftc">{data:count_size}</td>
  </tr>
  <tr>
    <td class="leftb">{icon:web} {lang:info_trafik}</td>
    <td class="leftc">{data:count_trafik}</td>
  </tr>
  <tr>
    <td class="leftb">{icon:nfs_unmount} {lang:info_space}</td>
    <td class="leftc">
      <div style="background-image:url({page:path}symbols/messages/messages03.png); width:100px; height:13px;">
        <div style="background-image:url({img:01}); width:{data:count_space}px; text-align:right; padding-left:1px">
          <img src="{page:path}{img:02}" style="height:13px;width:2px" alt="" />
        </div>
      </div>
      <div style="float:left; clear:both; height:13px; width:35px;">
        {data:count_space}%
      </div>
    </td>
  </tr>
</table>