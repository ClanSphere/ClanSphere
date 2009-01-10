<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb" colspan="3">{lang:mod} - {lang:head_list}</td>
 </tr>
 <tr>
  <td class="leftb">{lang:all}</td>
  <td class="rightb" colspan="2">{pages:list}</td>
 </tr>
 <tr>
  <td class="leftb" colspan="2">{lang:select}
    <form method="post" name="lanvotes_list" action="{url:form}">
      <select name="lanpartys_id" >
        <option value="0">----</option>
        {loop:lanpartys}
		<option value="{lanpartys:id}">{lanpartys:name}</option>
		{stop:lanpartys}
      </select>
      <input type="submit" name="submit" value="{lang:show}" />
    </form>
  </td>
 </tr>
</table>
<br />

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb" style="width:33%">{sort:question}{lang:question}</td>
  <td class="headb" style="width:33%">{sort:start}{lang:start}</td>
  <td class="headb" style="width:34%">{sort:end}{lang:end}</td>
 </tr>
 {loop:lanvotes}
 <tr>
  <td class="leftc">{lanvotes:question}</td>
  <td class="leftc">{lanvotes:start}</td>
  <td class="leftc">{lanvotes:end}</td>
 </tr>
 {stop:lanvotes}
</table>