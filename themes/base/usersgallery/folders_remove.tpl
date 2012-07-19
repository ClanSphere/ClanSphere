<form method="post" id="folders_remove" action="{url:usersgallery_folders_remove}">
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb">{lang:folders} - {lang:remove}</td>
  </tr>
  <tr>
    <td class="leftb">{head:body}</td>
  </tr>
</table>
<br />

{if:error}
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="leftb">{error:msg}</td>
  </tr>
</table>
<br />
{stop:error}

{if:pictures_in_folder}
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="leftc">
      <input type="radio" name="del" value="1" onChange="document.getElementById('move').style.display=this.checked?'none':'none';" /> {lang:fr_opt_1}<br />
      <input type="radio" name="del" value="2" onChange="document.getElementById('move').style.display=this.checked?'none':'none';" /> {lang:fr_opt_2}<br />
      {if:other_folders}
      <input type="radio" name="del" value="3" onChange="document.getElementById('move').style.display=this.checked?'block':'none';" /> {lang:fr_opt_3}<br />
      <div id="move" style="display:none;">
        {folders:dropdown}
      </div>
      {stop:other_folders}
    </td>
  </tr>
</table>
<br />
{stop:pictures_in_folder}

<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="centerc">
      <input type="hidden" name="id" value="{hidden:id}" />
      <input type="submit" name="agree" value="{lang:confirm}" />
      <input type="submit" name="cancel" value="{lang:cancel}" />
    </td>
  </tr>
</table>
</form>