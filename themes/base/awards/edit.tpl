<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width};">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:head_edit}</td>
  </tr>
  <tr>
    <td class="leftb">{head:body_create}</td>
  </tr>
</table>
<br />

<form method="post" action="{url:awards_edit}">
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width};">
  <tr>
    <td class="leftc">{icon:kedit} {lang:event} *</td>
    <td class="leftb"><input type="text" name="awards_event" value="{awards:awards_event}" maxlength="200" size="50" /></td>
  </tr>
  <tr>
    <td class="leftc">{icon:kedit} {lang:event_url} *</td>
    <td class="leftb">http://<input type="text" name="awards_event_url" value="{awards:awards_event_url}" maxlength="200" size="43" /></td>
  </tr>
  <tr>
    <td class="leftc">{icon:package_games} {lang:game} *</td>
    <td class="leftb">{select:game} - <a href="{url:games_create}">{lang:create}</a></td>
  </tr>
  <tr>
  <td class="leftc">{icon:yast_group_add} {lang:squad}</td>
  <td class="leftb">
    <select name="squads_id">
     <option value="0">----</option>{loop:squads}
     <option value="{squads:squads_id}"{squads:selection}>{squads:squads_name}</option>{stop:squads}
    </select>
     - <a href="{url:squads_create}">{lang:create}</a>
  </td>
 </tr>
  <tr>
    <td class="leftc">{icon:1day} {lang:date} *</td>
    <td class="leftb">{select:date}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:kedit} {lang:place} *</td>
    <td class="leftb"><input type="text" name="awards_rank" value="{awards:awards_rank}" maxlength="3" size="3" /></td>
  </tr>
  <tr>
    <td class="leftc">{icon:ksysguard} {lang:options}</td>
    <td class="leftb">
      <input type="submit" name="submit" value="{lang:create}" />
       <input type="submit" name="preview" value="{lang:preview}" />
              <input type="hidden" name="id" value="{awards:awards_id}" />
     </td>
   </tr>
</table>
</form>