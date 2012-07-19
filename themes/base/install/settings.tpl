<table class="forum" style="width: 100%" cellpadding="0" cellspacing="1">
 <tr>
  <td class="headb">{lang:mod_name} - {lang:head_settings}</td>
 </tr>
 <tr>
  <td class="leftc">{head:message}</td>
 </tr>
</table>
<br />

{if:setup}
<table class="forum" style="width: 100%" cellpadding="0" cellspacing="1">
 <tr>
  <td class="centerb">
    <a href="{url_install:install_sql:lang={data:lang}}">{lang:full_install}</a><br /><br />
    <a href="{url_install:install_sql_select:lang={data:lang}}">{lang:module_select}</a>
  </td>
 </tr>
</table>
{stop:setup}

{if:display_setup}
<table class="forum" style="width: 100%" cellpadding="0" cellspacing="1">
 <tr>
  <td class="headb">setup.php</td>
 </tr>
 <tr>
  <td class="leftc">
    <form method="post" id="setup_file" action="">
    <textarea cols="50" rows="15">{data:setup}</textarea>
    </form>  
  </td>
 </tr>
 <tr>
  <td class="leftb">{lang:save_file}</td>
 </tr>
</table>
{stop:display_setup}

{if:display_form}
<form method="post" id="install_settings" action="{url_install:install_settings}">
<table class="forum" style="width: 100%" cellpadding="0" cellspacing="1">
 <tr>
  <td class="leftc">{lang:hash} *</td>
  <td class="leftb">
    <select name="hash">
      <option value="0">----</option>
      <option value="md5"{selected:md5}>Md5 = Message-Digest Algorithm</option>
      <option value="sha1"{selected:sha1}>Sha1 = Secure Hash Algorithm 1</option>
     </select><br />
    {lang:hash_info}
   </td>
 </tr>
 <tr>
  <td class="leftc">{lang:type} *</td>
  <td class="leftb">
    <select name="type">
      <option value="0">----</option>
      {data:types}
     </select><br />
    {lang:type_info}
   </td>
 </tr>
 <tr>
  <td class="leftc">{lang:subtype}</td>
  <td class="leftb">
    <input type="text" name="subtype" value="{value:subtype}" maxlength="200" size="50" /><br />
    {lang:subtype_info}
   </td>
 </tr>
 <tr>
  <td class="leftc">{lang:place}</td>
  <td class="leftb">
    <input type="text" name="place" value="{value:place}" maxlength="200" size="50" /><br />
    {lang:place_info}
   </td>
 </tr>
 <tr>
  <td class="leftc">{lang:db_name} *</td>
  <td class="leftb">
    <input type="text" name="name" value="{value:name}" maxlength="80" size="40" /><br />
    {lang:sqlite_info}
   </td>
 </tr>
 <tr>
   <td class="leftc">{lang:prefix} *</td>
   <td class="leftb"><input type="text" name="prefix" value="{value:prefix}" maxlength="8" size="8" /></td>
 </tr>
 <tr>
   <td class="leftc">{lang:user}</td>
   <td class="leftb"><input type="text" name="user" value="{value:user}" maxlength="50" size="25" /></td>
 </tr>
 <tr>
   <td class="leftc">{lang:pwd}</td>
   <td class="leftb"><input type="password" name="pwd" value="{value:pwd}" maxlength="50" size="25" autocomplete="off" /></td>
 </tr>
 <tr>
   <td class="leftc">{lang:charset}</td>
   <td class="leftb">{value:charset}</td>
 </tr>
 <tr>
   <td class="leftc">{lang:more}</td>
   <td class="leftb">
     <input type="checkbox" name="save_actions" value="1"{checked:save_actions} /> {lang:save_actions}<br />
     <input type="checkbox" name="save_errors" value="1"{checked:save_errors} /> {lang:save_errors}
    </td>
 </tr>
 <tr>
  <td class="leftc">{lang:options}</td>
  <td class="leftb">
    <input type="hidden" name="lang" value="{data:lang}" />
    <input type="submit" name="create" value="{lang:create}" />
    <input type="submit" name="view" value="{lang:show}" />
    
   </td>
 </tr>
</table>
</form>

{stop:display_form}