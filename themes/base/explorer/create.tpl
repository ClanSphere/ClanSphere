<table class="forum" style="width: {page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb">{lang:explorer} - {lang:create}</td>
  </tr>
  <tr>
    <td class="leftb">{lang:data_create}</td>
  </tr>
</table>
<br />

<form method="post" id="explorer_create" action="{url:explorer_create}">
<table class="forum" style="width: {page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="leftc">{icon:folder_yellow} {lang:directory}</td>
    <td class="leftb"><input type="text" name="data_folder" value="{var:dir}" maxlength="60" size="40" /></td>
  </tr>
  <tr>
    <td class="leftc">{icon:kate} {lang:f_name}</td>
    <td class="leftb"><input type="text" name="data_name" value="" maxlength="50" size="30" />
     <select name="data_type">
      <option value="" selected="selected"></option>
      <option value=".php">.php</option>
      <option value=".sql">.sql</option>
      <option value=".html">.html</option>
      <option value=".htm">.htm</option>
      <option value=".tpl">.tpl</option>
      <option value=".txt">.txt</option>
     </select>
    </td>
  </tr>
  <tr>
    <td class="leftc" style="width: 20%">
      <div style="display: none;" id="break"><br /></div>
      <div style="display: none;" id="parameters"></div>
      {icon:kate} {lang:content}</td>
    <td class="leftb" style="width: 80%">
      <input type="button" name="tab" value="TAB" accesskey="t" onclick="javascript:abc_insert('\t','','data_content','')" />
    {abcode:tools}
    {abcode:html1} <br />
    {abcode:sql}
    {abcode:html2} <br />
    <textarea name="data_content" cols="50" rows="35" id="data_content"></textarea></td>
  </tr>
  <tr>
    <td class="leftc">{icon:ksysguard} {lang:options}</td>
    <td class="leftb">
      <input type="submit" name="submit" value="{lang:create}" />
      </td>
  </tr>
</table>
</form>