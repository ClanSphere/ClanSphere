<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td colspan="2" class="headb">{lang:mod_name} - {data:titel}</td>
  </tr>
  <tr>
    <td colspan="2" class="leftb"><a href="{url:gallery_list}">{lang:mod_name}</a> {link:subfolders} {data:folders_name}</td>
  </tr>
  <tr>
    <td colspan="2" class="centerb">{data:picture}</td>
  </tr>
  <tr>
    <td class="leftb" style="width:140px">{link:picture_backward} {link:picture_rotate_left} <!--{link:picture_zoom_smaller} {link:picture_zoom_normally} {link:picture_zoom_bigger}--> {link:picture_rotate_right} {link:picture_forward} </td>
    <td class="leftb">{link:ecard} {link:download_picture} {link:download_zip} {link:print}</td>
  </tr>
  <tr>
    <td class="leftb">{icon:personal} {lang:user}</td>
    <td class="leftb">{data:user}</td>
  </tr>
  <tr>
    <td class="leftb">{icon:today} {lang:date}</td>
    <td class="leftb">{data:date}</td>
  </tr>
  <tr>
    <td class="leftb">{icon:contents} {lang:gallery_description}</td>
    <td class="leftb">{data:description}</td>
  </tr>
  <tr>
    <td class="leftb">{icon:window_fullscreen} {lang:dissolution}</td>
    <td class="leftb">{data:pic_size}</td>
  </tr>
  <tr>
    <td class="leftb">{icon:fileshare} {lang:filesize}</td>
    <td class="leftb">{data:filesize}</td>
  </tr>
  <tr>
    <td class="leftb">{icon:kdict} {lang:gallery_count}</td>
    <td class="leftb">{data:count}</td>
  </tr>
  {if:vote}
  <tr>
    <td class="leftb">{icon:volume_manager} {lang:gallery_vote} </td>
    <td class="leftb">
        {if:vote_allow}
            <form method="post" id="com_view" action="{url:gallery_com_view}">
                <input type="hidden" name="where" value="{hidden:id}" />
                <select name="voted_answer">{vote:options}</select>
                <input type="submit" name="submit" value="{lang:ok}" />
            </form>
        {stop:vote_allow}
        {if:voted}
            {data:vote}
        {stop:voted}
    </td>
  </tr>
  {stop:vote}
</table>