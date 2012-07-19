<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:ajax} - {lang:options}</td>
  </tr>
  <tr>
    <td class="leftb">{lang:errors_here}</td>
  </tr>
</table>
<br />

<form method="post" id="ajax_options" action="{url:ajax_options}" enctype="multipart/form-data" class="noajax">
  <table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
    <tr>
      <td class="leftc">{icon:agt_reload} {lang:ajax}</td>
      <td class="leftb"><select name="ajax" onchange="document.getElementById('ajax_reload_div').style.display=this.value==0?'none':'block';document.getElementById('ajax_navlists').style.display=this.value==0?'none':'block'">
          <option value="1"{options:ajax_on}>{lang:on}</option>
          <option value="0"{options:ajax_off}>{lang:off}</option>
        </select></td>
    </tr>
    <tr>
      <td class="leftc">{icon:kdmconfig} {lang:activation_for}</td>
      <td class="leftb"><select name="for">
         <option value="1"{options:for_severals}>{lang:severals}</option>
         <option value="2"{options:for_all}>{lang:all}</option>
        </select></td>
    </tr>
    <tr>
      <td class="leftc">{icon:image} {lang:loading_icon}</td>
      <td class="leftb"><img src="{page:path}uploads/ajax/loading.gif" alt="-" /><br />{lang:another}<input type="file" name="loading" /></td>
    </tr>
    <tr>
      <td class="leftc">{icon:playlist} {lang:reload_navlists}</td>
      <td class="leftb"><div id="ajax_reload_div" style="{switch:ajax_on}">
            {lang:every} <input type="text" name="ajax_reload" value="{options:ajax_reload}" size="3" maxlength="3" /> {lang:seconds}
           </div></td>
    </tr>
    <tr>
      <td class="leftc">{icon:ksysguard} {lang:options}</td>
      <td class="leftb"><input type="submit" name="submit" value="{lang:edit}" />
              </td>
    </tr>
  </table>
</form>