<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb" colspan="3">{lang:mod_name} - {lang:list}</td>
 </tr>
 <tr>
  <td class="leftb">{info:warcount}</td>
  <td class="rightb" colspan="2">{pages:choice}</td>
 </tr>
 <tr>
  <td class="leftb">{lang:squad}
    <form method="post" id="wars_list" action="{url:wars_list}">
      <select name="where">
        <option value="0">----</option>
        {loop:squads}<option value="{squads:squads_id}">{squads:name}</option>{stop:squads}
      </select>
      <input type="submit" name="submit" value="{lang:show}" />
    </form>
  </td>
  <td class="leftb"><a href="{url:ranks}">{lang:ranks}</a></td>
  <td class="rightb"><a href="{url:wars_stats}">{lang:stats}</a></td>
 </tr>
</table>
<br />

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb">{lang:game}</td>
  <td class="headb">{sort:date}{lang:date}</td>
  <td class="headb">{sort:enemy}{lang:enemy}</td>
  <td class="headb">{sort:category}{lang:category}</td>
  <td class="headb" colspan="2">{lang:score}</td>
 </tr>
 {loop:wars}
 <tr>
  <td class="leftc">{wars:gameicon}</td>
  <td class="leftc">{wars:date}</td>
  <td class="leftc"><a href="{wars:enemyurl}">{wars:enemy}</a></td>
  <td class="leftc"><a href="{wars:caturl}">{wars:category}</a></td>
  <td class="centerc" 
  {if:upcoming}colspan="2"{stop:upcoming}
  {if:running}colspan="2"{stop:running}
  {if:canceled}colspan="2"{stop:canceled}>
  <a href="{wars:url}">{if:played}{wars:result}{stop:played}</a>
  {if:upcoming}<a href="{wars:url}">{lang:upcoming}</a>{stop:upcoming}
  {if:running}<a href="{wars:url}">{lang:running}</a>{stop:running}
  {if:canceled}<a href="{wars:url}">{lang:canceled}</a>{stop:canceled}
  </td>
  {if:played}
  <td class="centerc"><a href="{wars:url}">{wars:resulticon}</a></td>
  {stop:played}
 </tr>
 {stop:wars}
</table>