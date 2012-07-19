<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:head_create}</td>
  </tr>
  <tr>
    <td class="leftc">{head:body}</td>
  </tr>
</table>
<br />

<form method="post" id="events_create" action="{url:events_create}">
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="leftc" style="width:130px">{icon:cal} {lang:name} *</td>
    <td class="leftb"><input type="text" name="events_name" value="{data:events_name}" maxlength="40" size="40" /></td>
  </tr>
  <tr>
    <td class="leftc">{icon:folder_yellow} {lang:category} *</td>
    <td class="leftb">
      {categories:dropdown}
    </td>
  </tr>
  <tr>
    <td class="leftc">{icon:1day} {lang:date} *</td>
    <td class="leftb">
      {select:time}
    </td>
  </tr>
  <tr>
    <td class="leftc">{icon:starthere} {lang:venue}</td>
    <td class="leftb"><input type="text" name="events_venue" value="{data:events_venue}" maxlength="40" size="40" /></td>
  </tr>
  <tr>
    <td class="leftc">{icon:kdmconfig} {lang:guests}</td>
    <td class="leftb">
      {lang:min}: <input type="text" name="events_guestsmin" value="{data:events_guestsmin}" maxlength="8" size="5" /><br />
      {lang:max}: <input type="text" name="events_guestsmax" value="{data:events_guestsmax}" maxlength="8" size="5" /><br />
      {lang:needage}: <input type="text" name="events_needage" value="{data:events_needage}" maxlength="2" size="2" />
    </td>
  </tr>
  <tr>
    <td class="leftc">{icon:gohome} {lang:url}</td>
    <td class="leftb" colspan="2">http://<input type="text" name="events_url" value="{data:events_url}" maxlength="80" size="50" /></td>
  </tr>
  {if:abcode}
  <tr>
    <td class="leftc">{icon:kate} {lang:more}<br />
      <br />
      {abcode:smileys}
    </td>
    <td class="leftb">
      {abcode:features}
      <textarea name="events_more" cols="50" rows="8" id="events_more">{data:events_more}</textarea>
    </td>
  </tr>
  {stop:abcode}
  {if:rte_html}
  <tr>
    <td class="leftc" colspan="2">{icon:kate} {lang:more}</td>
  </tr>
  <tr>
    <td class="leftc" colspan="2" style="padding:0px;">{rte:html}</td>
  </tr>
  {stop:rte_html}
  <tr>
    <td class="leftc">{icon:5days} {lang:multi}</td>
    <td class="leftb">
      <select name="events_multi">
        <option value="no" {check:multi_no}>{lang:no}</option>
        <option value="yes" {check:multi_yes}>{lang:yes}</option>
      </select>
      {lang:multi_info}<br /><br />
      {lang:multix} * 
      <input type="text" name="events_multix" value="{data:events_multix}" maxlength="2" size="3" />
    </td>
  </tr>
  <tr>
    <td class="leftc">{icon:configure} {lang:more}</td>
    <td class="leftb">
      <input type="checkbox" name="events_close" value="1" {check:close} /> {lang:close}<br />
      <input type="checkbox" name="events_cancel" value="1" {check:cancel} /> {lang:canceled}
    </td>
  </tr>
  <tr>
    <td class="leftc">{icon:ksysguard} {lang:options}</td>
    <td class="leftb">
      <input type="submit" name="submit" value="{lang:create}" />
          </td>
  </tr>
</table>
</form>