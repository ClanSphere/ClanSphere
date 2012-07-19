<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:options}</td>
  </tr>
  <tr>
    <td class="leftb">{lang:body_opt}</td>
  </tr>
</table>
<br />

<form method="post" id="gallery_edit" action="{url:gallery_options}">
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="2">{lang:mod_name}</td>
  </tr>
  <tr>
    <td class="leftc" style="width:200px;">{icon:insert_table_row} {lang:opt_row}</td>
    <td class="leftb"><input type="text" name="cols" value="{op:cols}" maxlength="1" size="4" /></td>
  </tr>
  <tr>
    <td class="leftc">{icon:insert_table_col} {lang:opt_col}</td>
    <td class="leftb"><input type="text" name="rows" value="{op:rows}" maxlength="1" size="4" /></td>
  </tr>
  <tr>
    <td class="leftc">{icon:xpaint} {lang:opt_max_wight}</td>
    <td class="leftb"><input type="text" name="max_width" value="{op:max_width}" maxlength="4" size="4" />{lang:pixel}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:thumbnail} {lang:opt_tb}</td>
    <td class="leftb"><input type="text" name="thumbs" value="{op:thumbs}" maxlength="3" size="4" />{lang:pixel}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:thumbnail} {lang:opt_tq}</td>
    <td class="leftb"><input type="text" name="quality" value="{op:quality}" maxlength="3" size="4" />%</td>
  </tr>
  <tr>
    <td class="leftc">{icon:resizecol} {lang:opt_pic_mb}</td>
    <td class="leftb"><input type="text" name="width" value="{op:width}" maxlength="4" size="5" />{lang:pixel}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:resizerow} {lang:opt_pic_mh}</td>
    <td class="leftb"><input type="text" name="height" value="{op:height}" maxlength="4" size="5" />{lang:pixel}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:fileshare} {lang:opt_pic_ms}</td>
    <td class="leftb"><input type="text" name="size" value="{op:size}" maxlength="5" size="5" />KiB</td>
  </tr>
  <tr>
    <td class="leftc">{icon:volume_manager} {lang:top_votes}</td>
    <td class="leftb">
      <input type="radio" name="top_5_votes" value="0" {check:top_5_votes_0} /> {lang:show_0}
      <input type="radio" name="top_5_votes" value="1" {check:top_5_votes_1} /> {lang:show_1}
    </td>
  </tr>
  <tr>
    <td class="leftc">{icon:image} {lang:top_views}</td>
    <td class="leftb">
      <input type="radio" name="top_5_views" value="0" {check:top_5_views_0} /> {lang:show_0}
      <input type="radio" name="top_5_views" value="1" {check:top_5_views_1} /> {lang:show_1}
    </td>
  </tr>
  <tr>
    <td class="leftc">{icon:xchat} {lang:newest_pics}</td>
    <td class="leftb">
      <input type="radio" name="newest_5" value="0" {check:newest_5_0} /> {lang:show_0}
      <input type="radio" name="newest_5" value="1" {check:newest_5_1} /> {lang:show_1}
    </td>
  </tr>
  <tr>
    <td class="leftc">{icon:playlist} {lang:list_sort}</td>
    <td class="leftb">
      <select name="list_sort">
        {sort:options}
      </select>
    </td>  
  </tr>
  <tr>
    <td class="leftc">{icon:thumbnail} {lang:lightbox}</td>
    <td class="leftb">
      <select name="lightbox">
        {lightbox:options}
      </select>
    </td>
  </tr>
  <tr>
    <td class="headb" colspan="2">{lang:usergallery}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:fileshare} {lang:opt_pic_ms}</td>
    <td class="leftb"><input type="text" name="size2" value="{op:size2}" maxlength="5" size="5" />KiB</td>
  </tr>
  <tr>
    <td class="leftc">{icon:xpaint} {lang:opt_max_files}</td>
    <td class="leftb"><input type="text" name="max_files" value="{op:max_files}" maxlength="4" size="4" /></td>
  </tr>
  <tr>
    <td class="leftc">{icon:folder_yellow} {lang:max_cats}</td>
    <td class="leftb"><input type="text" name="max_folders" value="{op:max_folders}" maxlength="4" size="4" /></td>
  </tr>
  <tr>
    <td class="leftc">{icon:playlist} {lang:max_navlist}</td>
    <td class="leftb"><input type="text" name="max_navlist" value="{op:max_navlist}" maxlength="2" size="2" /></td>
  </tr>  
  <tr>
    <td class="leftc">{icon:ksysguard} {lang:options}</td>
    <td class="leftb">
      <input type="submit" name="submit" value="{lang:edit}" />
    </td>
  </tr>
</table>
</form>