<table class="forum" cellpadding="0" cellspacing="1" style="width:{page:width}">
 <tr>
  <td class="headb" colspan="3">{lang:mod} - {lang:list}</td>
 </tr>
 <tr>
  <td class="leftc">{info:warcount}</td>
  <td class="rightc" colspan="2">{pages:choice}</td>
 </tr>
 <tr>
  <td class="leftc">{lang:squad}
    <form method="post" name="wars_list" action="{url:form}">
      <select name="where" >
        <option value="0">----</option>
        {loop:squads}<option value="{squads:squads_id}">{squads:name}</option>{stop:squads}
      </select>
      <input type="submit" name="submit" value="{lang:show}" />
    </form>
  </td>
  <td class="leftc"><a href="{url:ranks}">{lang:ranks}</a></td>
  <td class="rightc"><a href="{url:stats}">{lang:stats}</a></td>
 </tr>
</table>
<br />

<table class="forum" cellpadding="0" cellspacing="1" style="width:{page:width}">
 <tr>
  <td class="headb">{lang:game}</td>
  <td class="headb">{sort:date}{lang:date}</td>
  <td class="headb">{sort:enemy}{lang:enemy}</td>
  <td class="headb">{sort:category}{lang:category}</td>
  <td class="headb" colspan="2">{lang:score}</td>
 </tr>
 {loop:wars}
 <tr>
  <td class="leftb">{wars:gameicon}</td>
  <td class="leftb">{wars:date}</td>
  <td class="leftb"><a href="{wars:enemyurl}">{wars:enemy}</a></td>
  <td class="leftb"><a href="{wars:caturl}">{wars:category}</a></td>
  <td class="centerb"><a href="{wars:url}">{wars:result}</a></td>
  <td class="centerb">{wars:resulticon}</td>
 </tr>
 {stop:wars}
</table>