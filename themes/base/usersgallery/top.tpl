<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">
      {lang:mod_name} - {lang:top_list}    </td>
  </tr>
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

{if:com_1}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="leftb">
      {lang:com}
    </td>
  </tr>
  <tr>
    <td class="leftc">
    {loop:com}
      <div style="float: left; width: 100px; height: 100px; margin: 5px; padding: 0px; background-position: center; background-repeat: no-repeat; background-image: url({page:path}mods/gallery/image.php?usersthumb={com:img})">
        {com:link}
      </div>  
    {stop:com}
    </td>
  </tr>
</table>
<br />
{stop:com_1}