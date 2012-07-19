<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb" colspan="2">{lang:mod_name} - {lang:head_view}</td>
  </tr>
  <tr>
    <td class="leftb">{lang:body_view}</td>
    <td class="rightb"><a href="{url:logs_roots:where=1}">{lang:back}</a>
    </td>
  </tr>
</table>
<br />

<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">{loop:logs}
  <tr>
    <td class="leftc">{logs:time}</td>
    <td class="leftb">{logs:message}</td>
    <td class="leftc"><a href="{url:logs_view:art={var:art}:log={var:log}:id={logs:id}#log_1}">{lang:details}</a></td>
  </tr>{stop:logs}
</table>
<br />

<a href="#log_1" id="log_1"></a>

{if:error}
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="leftc">{icon:1day} {lang:log_date}</td>
    <td class="leftb">{log:date} / {log:time}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:stop} {lang:error}</td>
    <td class="leftb">{log:message}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:folder_yellow} {lang:dname}</td>
    <td class="leftb">{log:file}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:webexport} {lang:error_2}</td>
    <td class="leftb">{log:file2}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:history} {lang:ip}</td>
    <td class="leftb">{log:ip}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:web} {lang:browser}</td>
    <td class="leftb">{log:browser}</td>
  </tr>
</table>
{stop:error}

{if:log}
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="leftc">{icon:1day} {lang:log_date}</td>
    <td class="leftb">{log:date} / {log:time}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:access} {lang:error}</td>
    <td class="leftb">{log:file}</td>
  </tr>
  <tr>
    <td class="leftc" colspan="2">{icon:mail_generic} {lang:name}</td>
  </tr>
  <tr>
    <td class="leftb" colspan="2">{log:message}</td>
  </tr>
</table>
{stop:log}