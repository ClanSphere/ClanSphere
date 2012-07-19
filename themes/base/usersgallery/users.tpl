<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">
      {lang:mod_name} - {lang:head_list}    </td>
  </tr>
  <tr>
    <td class="leftb">
      {data:addons}
    </td>
  </tr>
</table>
<br />
{lang:getmsg}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  {loop:cat_list}
  {tmp:empty_cat}
  {loop:cat}
  <tr>
    <td class="leftc">
      <div style="width:15%; float:left">
        {cat:img}
      </div>
      <div style="width:85%">
        <strong>{cat:folders_name}</strong> <br /> 
        <hr style="width:100%" />
        {cat:folders_text}
        <hr style="width:100%" />
        {cat:pic_count} {cat:last_update}
      </div>
    </td>
  </tr>
  {stop:cat}
</table>
<br />

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
      <div style="float: left; width: 100px; height: 100px; margin: 5px; padding: 0px; background-position: center; background-repeat: no-repeat; background-image: url({page:path}mods/gallery/image.php?usersthumb={top_views:img})">
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
      <div style="float: left; width: 100px; height: 100px; margin: 5px; padding: 0px; background-position: center; background-repeat: no-repeat; background-image: url({page:path}mods/gallery/image.php?usersthumb={last_update:img})">
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
      <div style="float: left; width: 100px; height: 100px; margin: 5px; padding: 0px; background-position: center; background-repeat: no-repeat; background-image: url({page:path}mods/gallery/image.php?usersthumb={vote:img})">
        {vote:link}
      </div>
    {stop:vote}
    </td>
  </tr>
</table>
<br />
{stop:vote_1}
  {stop:cat_list}
  
  {loop:cat_list_1}
  <tr>
    <td class="leftc">
      {link:gallery} {link:subfolders} - {data:folders_name}
    </td>
  </tr>
  <tr>
    <td class="leftc">
      {loop:cat_1}
        <div style="float: left; width: 100px; height: 100px; margin: 5px; padding: 0px; background-position: center; background-repeat: no-repeat">
          {cat_1:folders_img} <br /> {cat_1:folders_name}
        </div>
      {stop:cat_1}
      {loop:img}
        <div style="float: left; width: 100px; height: 100px; margin: 5px; padding: 0px; background-position: center; background-repeat: no-repeat; background-image: url({page:path}mods/gallery/image.php?usersthumb={img:img})">
        {img:link}
      </div>
    {stop:img}
    </td>
  </tr>
  <tr>
    <td class="centerb">
      {data:pages}
    </td>
  </tr>
</table>
{stop:cat_list_1}
{tmp:empty_cat}