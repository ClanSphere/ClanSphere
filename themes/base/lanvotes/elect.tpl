<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:mod} - {lang:head_elect}</td>
  </tr>
  <tr>
    <td class="leftb">{lang:body}</td>
  </tr>
</table>

<br />

<form method="post" name="lanvotes_elect" action="{url:form}">
  <table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
    <tr>
      <td class="leftb" style="width:140px">{icon:kate} {lang:question}</td>
      <td class="leftc">{votes:question}
      </td>
    </tr>
    <tr>
      <td class="leftb">{icon:kate} {lang:answer} *</td>
      <td class="leftc">{loop:lan}{lan:answer}<br />{stop:lan}
      </td>
    </tr>
    <tr>
      <td class="leftb">{icon:ksysguard} {lang:options}</td>
      <td class="leftc"> <input type="hidden" name="id" value="{data:id}" />
	  <input type="submit" name="submit" value="{lang:submit}" />
      </td>
    </tr>
  </table>
</form>
