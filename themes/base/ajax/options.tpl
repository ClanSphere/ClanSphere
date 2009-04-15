<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:ajax} - {lang:options}</td>
  </tr>
  <tr>
    <td class="leftb">{lang:errors_here}</td>
  </tr>
</table>
<br />

<form method="post" id="ajax_options" action="{url:ajax_options}" enctype="multipart/form-data">
  <table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
    <tr>
      <td class="leftc">{icon:agt_reload} {lang:ajax}</td>
      <td class="leftb"><select name="ajax" onchange="document.getElementById('ajax_reload_div').style.display=this.value==0?'none':'block';document.getElementById('ajax_navlists').style.display=this.value==0?'none':'block'">
          <option value="1"{options:ajax_on}>{lang:on}</option>
          <option value="0"{options:ajax_off}>{lang:off}</option>
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
      <td class="leftc">{icon:playlist} {lang:reloading_navlists}</td>
      <td class="leftb"><div id="ajax_navlists" style="{switch:ajax_on}">{loop:navlists}
      <input type="checkbox" value="{navlists:raw}" name="navlists[]"{navlists:checked} /> {navlists:mod} / {navlists:action}{if:descr} - {navlists:description}{stop:descr}<br />{stop:navlists}
      <br />{lang:additionally}: <input type="text" name="additionals" value="{options:additionals}" size="30" />
      </div></td>
    </tr>
    <tr>
      <td class="leftc">{icon:ksysguard} {lang:options}</td>
      <td class="leftb"><input type="submit" name="submit" value="{lang:edit}" />
        <input type="reset" name="reset" value="{lang:reset}" />
      </td>
    </tr>
  </table>
</form>