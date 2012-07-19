<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:head_list}</td>
  </tr>
  <tr>
    <td class="leftc">{link:gallery} {link:subfolders} - {data:folders_name}</td>
  </tr>
  {tmp:empty_cat}
  <tr>
    <td class="leftc">
      {loop:sub_folders}
        <div style="float:left; width:{options:thumbs}px; height:100px; margin:5px; padding:0px; background-repeat: no-repeat center;">
          {sub_folders:folders_img} <br />
          {sub_folders:folders_name}
         </div>
      {stop:sub_folders}
      {loop:img}
        <div style="float:left; width:{options:thumbs}px; height:{options:thumbs}px; margin:5px; padding:0px; background: url({page:path}mods/gallery/image.php?thumb={img:img}) no-repeat center; border:1px solid #666666">
        {img:link}
         </div>
      {stop:img}
    </td>
  </tr>
  <tr>
    <td class="centerb">{data:pages}</td>
  </tr>
</table>