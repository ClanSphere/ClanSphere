<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb" colspan="2">{lang:mod_name} - {lang:manage}</td>
 </tr>
 <tr>
  <td class="leftb">{icon:contents} {lang:total}: {count:all}</td>
  <td class="rightb">{pages:list}</td>
 </tr>
 <tr>
  <td class="leftb" colspan="2">
    <form method="post" id="events_manage" action="{url:events_manage}">
      <fieldset style="border: 0; padding: 0">
        {icon:folder_yellow} {lang:category}
        {head:categories}
        <input type="submit" name="submit" value="{lang:show}" />
      </fieldset>
      </form>
  </td>
 </tr>
</table>
<br />

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="centerb">{icon:7days} <a href="{url:events_guestsmulti}">{lang:guests_multi}</a></td>
  <td class="centerb">{icon:kghostview} <a href="{url:events_guestsearch}">{lang:guests_search}</a></td>
  <td class="centerb">{icon:strokedocker} <a href="{url:events_guestslatest}">{lang:guests_latest}</a></td>
 </tr>
</table>
<br />

{head:message}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb">{sort:date} {lang:date}</td>
  <td class="headb">{sort:name} {lang:name}</td>
  <td class="headb" colspan="5">{lang:guests}</td>
  <td class="headb" colspan="4">{lang:options}</td>
 </tr>
 {loop:events}
 <tr>
  <td class="left{events:class}">{events:time} {events:canceled}</td>
  <td class="left{events:class}"><a href="{url:events_view:id={events:events_id}}">{events:events_name}</a></td>
  <td class="right{events:class}"><em>{events:signed}</em></td>
  <td class="center{events:class}">{events:indicator}</td>
  <td class="right{events:class}">{events:guests}</td>
  <td class="right{events:class}"><span style="text-decoration: underline">{events:events_guestsmin}</span></td>
  <td class="right{events:class}"><strong>{events:events_guestsmax}</strong></td>
  <td class="left{events:class}"><a href="{url:events_guests:id={events:events_id}}" title="{lang:guests}">{icon:kdmconfig}</a></td>
  <td class="left{events:class}"><a href="{url:events_picture:id={events:events_id}}" title="{lang:pictures}">{icon:image}</a></td>
  <td class="left{events:class}"><a href="{url:events_edit:id={events:events_id}}" title="{lang:edit}">{icon:edit}</a></td>
  <td class="left{events:class}"><a href="{url:events_remove:id={events:events_id}}" title="{lang:remove}">{icon:editdelete}</a></td>
 </tr>
 {stop:events}
</table>