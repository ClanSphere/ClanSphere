<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">
      {lang:mod_name} - {lang:head_list}    </td>
  </tr>
  {tmp:no_cat}
  {loop:cat}
  <tr>
    <td class="leftc">
      <div style="width:22% ;margin-right:5px; float:left">
        {cat:img}
      </div>
      <div style="width:100%">
        <strong>{cat:folders_name}</strong> <br /> 
        <hr style="width:78%" />
        {cat:folders_text}
        <hr style="width:78%" />
        {cat:pic_count} {cat:last_update}
      </div>
    </td>
  </tr>
  {stop:cat}
</table>
<br />
{lang:getmsg}
{loop:top_views_1}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="leftb">
      {lang:top}
    </td>
  </tr>
  <tr>
    <td class="leftc">
    {loop:top_views}
      <div style="float:left; width:{options:thumbs}px; height:{options:thumbs}px; margin:5px; padding:0px; background: url({page:path}mods/gallery/image.php?thumb={top_views:img}) no-repeat center; border:1px solid #666666">
        {top_views:link}
      </div>
    {stop:top_views}
    </td>
  </tr>
</table>
<br />
{stop:top_views_1}
{loop:last_update_1}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="leftb">
      {lang:last_update}
    </td>
  </tr>
  <tr>
    <td class="leftc">
    {loop:last_update}
      <div style="float:left; width:{options:thumbs}px; height:{options:thumbs}px; margin:5px; padding:0px; background: url({page:path}mods/gallery/image.php?thumb={last_update:img}) no-repeat center; border:1px solid #666666">
        {last_update:link}
      </div>
    {stop:last_update}
    </td>
  </tr>
</table>
<br />
{stop:last_update_1}
{loop:vote_1}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="leftb">
      {lang:vote}
    </td>
  </tr>
  <tr>
    <td class="leftc">
    {loop:vote}
      <div style="float:left; width:{options:thumbs}px; height:100px; margin:5px; padding:0px; background: url({page:path}mods/gallery/image.php?thumb={vote:img}) no-repeat center; border:1px solid #666666;">
        {vote:link}
      </div>
    {stop:vote}
    </td>
  </tr>
</table>
<br />
{stop:vote_1}