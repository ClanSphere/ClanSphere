<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="3">{lang:def_admin}</td>
  </tr>
  <tr>
    {if:manage}<td class="centerb">{icon:kfm}{menu:manage}</td>{stop:manage}
	{if:create}<td class="centerb">{icon:editpaste}{menu:create}</td>{stop:create}
	{if:options}<td class="centerb">{icon:package_settings}{menu:options}</td>{stop:options}
  </tr>
</table>
<br />