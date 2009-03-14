<div id="debug" style="height: 100px" ondblclick="javascript:cs_debugmode()">
  <span id="errors">
    {data:php_errors}{data:csp_errors}
  </span>
  <span id="sql">
    {loop:sql}
    <strong>{sql:file}</strong><br />{sql:queries}
    {stop:sql}
  </span>
</div>