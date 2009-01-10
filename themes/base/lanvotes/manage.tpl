<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb" colspan="3">{lang:mod} - {lang:head_manage}</td>
 </tr>
 <tr>
  <td class="leftb">{icon:editpaste} {lang:new}</td>
  <td class="rightb">{icon:contents} {lang:all} {lang:count}</td>
  <td class="rightb">{pages:list}</td>
 </tr>
 <tr>
  <td class="leftb" colspan="3">{lang:select_lan}
    <form method="post" name="lanvotes_manage" action="{url:form}">
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
{head:message}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
 <tr>
  <td class="headb" style="width:33%">{sort:question}{lang:question}</td>
  <td class="headb" style="width:33%">{sort:start}{lang:start}</td>
  <td class="headb" style="width:34%">{sort:end}{lang:end}</td>
  <td class="headb" style="width:34%"colspan="2">{lang:options}</td>
 </tr>
 {loop:lanvotes}
 <tr>
  <td class="leftc">{lanvotes:question}</td>
  <td class="leftc">{lanvotes:start}</td>
  <td class="leftc">{lanvotes:end}</td>
  <td class="leftc">{lanvotes:edit}</td>
  <td class="leftc">{lanvotes:del}</td>
 </tr>
 {stop:lanvotes}
</table>