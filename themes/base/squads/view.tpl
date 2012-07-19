<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb">{lang:mod_name} - {lang:head_list}</td>
 </tr>
 <tr>
  <td class="leftb">{lang:part_of}</td>
 </tr>
</table>
<br />

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb" colspan="2">{game:icon} {squad:squads_name}</td>
 </tr>
<tr>
  <td class="leftb">{squad:squads_pic}</td>
  <td class="leftb">{squad:squads_text}</td>
</tr>
</table>
<br />

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
   <tr>
    <td class="headb" colspan="5">      
      {lang:members}
    </td>
   </tr>
   <tr>
    <td class="leftc" style="width:40px">{lang:country}</td>
    <td class="leftc">{lang:nick}</td>
    <td class="leftc">{lang:task}</td>
    <td class="leftc" style="width:80px">{lang:since}</td>
    <td class="leftc" style="width:40px">{lang:status}</td>
   </tr>
   {loop:members}
   <tr>
    <td class="leftb"><img src="{page:path}{members:countrypath}" style="height:11px;width:16px" alt="{members:country}" /></td>
    <td class="leftb">{members:users_url}</td>
    <td class="leftb">{members:members_task}</td>
    <td class="leftb">{members:members_since}</td>
    <td class="leftb">{members:page}</td>
   </tr>
   {stop:members}
  </table>
<br />

{if:rank}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="2">{lang:ranks}</td>    
  </tr>
  <tr>
    <td class="leftc">{lang:name}</td>
    <td class="leftc">{lang:image}</td>
  </tr>
  {loop:ranks}
  <tr>
    <td class="leftb">{ranks:name}</td>
    <td class="leftb">{ranks:picture}</td>
  </tr>
  {stop:ranks}
</table>
<br />
{stop:rank}

{if:award}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="3">{lang:awards}</td>    
  </tr>
  <tr>
    <td class="leftc">{lang:date}</td>
    <td class="leftc">{lang:event}</td>
    <td class="leftc">{lang:place}</td>
  </tr>
  {loop:awards}
  <tr>
    <td class="leftb">{awards:awards_time}</td>
    <td class="leftb"><a href="http://{awards:awards_event_url}">{awards:awards_event}</a></td>
    <td class="leftb">{awards:awards_place}</td>
  </tr>
  {stop:awards}
</table>
<br />
{stop:award}

{if:war}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="5">{lang:wars}</td>    
  </tr>
 <tr>
  <td class="leftc">{lang:date}</td>
  <td class="leftc">{lang:enemy}</td>
  <td class="leftc">{lang:category}</td>
  <td class="leftc" colspan="2">{lang:score}</td>
 </tr>
 {loop:wars}
 <tr>
  <td class="leftb">{wars:date}</td>
  <td class="leftb"><a href="{wars:enemyurl}">{wars:enemy}</a></td>
  <td class="leftb"><a href="{wars:caturl}">{wars:category}</a></td>
  <td class="leftb"><a href="{wars:url}">{wars:result}</a></td>
  <td class="leftb">{wars:resulticon}</td>
 </tr>
  {stop:wars}
<tr>
  <td class="leftb" colspan="5"><a href="{url:wars_stats:id={squad:squads_id}}">{lang:stats}</a></td>    
</tr>
</table>
{stop:war}