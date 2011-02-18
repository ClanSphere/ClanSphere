<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:options}</td>
  </tr>
  <tr>
    <td class="leftb">{lang:body_options}</td>
  </tr>
  {if:done}
  <tr>
    <td class="leftc"> {lang:wizard}: {lang:link_2}</td>
  </tr>
  {stop:done}
</table>
<br />

<form method="post" id="clansphere_options" action="{url:clansphere_options}" class="noajax">
  <table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
    <tr>
      <td class="leftc">{icon:fileshare} {lang:url_rewrite}</td>
      {if:mod_rewrite}
        <td class="leftb">
          {lang:info_htaccess}<br />
          <select name="mod_rewrite">
            <option value="1"{options:mod_rewrite_on}>{lang:on}</option>
            <option value="0"{options:mod_rewrite_off}>{lang:off}</option>
          </select>
        </td>
      {stop:mod_rewrite}
      {unless:mod_rewrite}
        <td class="leftb">{lang:missing_htaccess}<input type="hidden" name="mod_rewrite" value="0" /></td>
      {stop:mod_rewrite}
    </tr>
    <tr>
      <td class="leftc">{icon:window_fullscreen} {lang:def_width}</td>
      <td class="leftb"><input type="text" name="def_width" value="{options:def_width}" maxlength="20" size="20" />
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:view_text} {lang:cellspacing}</td>
      <td class="leftb"><input type="text" name="cellspacing" value="{options:cellspacing}" maxlength="3" size="3" />
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:bookmark} {lang:def_title}</td>
      <td class="leftb"><input type="text" name="def_title" value="{options:def_title}" maxlength="80" size="50" />
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:folder_home2} {lang:def_show}</td>
      <td class="leftb"> {lang:modul}:
        <select name="def_mod">
          {loop:sel}
          {sel:options}
          {stop:sel}
        </select>
        <br />
        {lang:action}: <input type="text" name="def_action" value="{options:def_action}" maxlength="80" size="20" />
        <br />
        {lang:parameters}: <input type="text" name="def_parameters" value="{options:def_parameters}" maxlength="80" size="18" />
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:server} {lang:def_path}</td>
      <td class="leftb"><select name="def_path_mode">
          <option value="automatic" {options:automatic}>{lang:automatic}</option>
          <option value="manual" {options:manual}>{lang:manual}</option>
        </select>
        <br />
        <input type="text" name="def_path" value="{options:def_path}" maxlength="80" size="50" />
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:multirow} {lang:developer}</td>
      <td class="leftb">
        {lang:developer_info}<br />
        <select name="developer">
          <option value="1"{options:developer_on}>{lang:on}</option>
          <option value="0"{options:developer_off}>{lang:off}</option>
        </select>
        <br />
        {lang:notfound_info}<br />
        <select name="notfound_info">
          <option value="1"{options:notfound_on}>{lang:on}</option>
          <option value="0"{options:notfound_off}>{lang:off}</option>
        </select>
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:agt_update-product} {lang:sec_remote}</td>
      <td class="leftb"><input type="radio" name="sec_remote" value="1" {options:sec_remote_1} />
        {lang:yes}
        <input type="radio" name="sec_remote" value="0" {options:sec_remote_2} />
        {lang:no} </td>
    </tr>
    <tr>
      <td class="leftc">{icon:folder_public} {lang:page_mode}</td>
      <td class="leftb"><input type="radio" name="public" value="1" {options:public_1} />
        {lang:active}
        <input type="radio" name="public" value="0" {options:public_2} />
        {lang:maintenance} </td>
    </tr>
    <tr>
      <td class="leftc">{icon:folder_public} {lang:maintenance_access}</td>
      <td class="leftb">
        <select name="maintenance_access">
          <option value="3" {options:main_acc3_checked}>{lang:level} 3</option>
          <option value="4" {options:main_acc4_checked}>{lang:level} 4</option>
          <option value="5" {options:main_acc5_checked}>{lang:level} 5</option>
        </select>
      </td>
    </tr>    
    <tr>
      <td class="leftc">{icon:kcmdf} {lang:def_admin}</td>
      <td class="leftb"><input type="radio" name="def_admin" value="integrated" {options:admin_1} />
        {lang:integrated}
        <input type="radio" name="def_admin" value="separated" {options:admin_2} />
        {lang:separated} </td>
    </tr>
    <tr>
      <td class="leftc">{icon:ktimer} {lang:def_timezone}</td>
      <td class="leftb">{options:timezone_select} </td>
    </tr>
    <tr>
      <td class="leftc">{icon:kweather} {lang:def_dstime}</td>
      <td class="leftb"><select name="def_dstime">
          <option value="0" {options:time_auto}>{lang:automatic}</option>
          <option value="on" {options:time_1}>{lang:on}</option>
          <option value="off" {options:time_0}>{lang:off}</option>
        </select>
        <br />
        <input type="checkbox" name="dstime_all" value="1" />
        {lang:change_dstime_for_all}</td>
    </tr>
    <tr>
      <td class="leftc">{icon:strokedocker} {lang:def_flood}</td>
      <td class="leftb"><input type="text" name="def_flood" value="{options:def_flood}" maxlength="5" size="5" />
        {lang:seconds}</td>
    </tr>
    <tr>
      <td class="leftc">{icon:view_text} {lang:data_limit}</td>
      <td class="leftb"><input type="text" name="data_limit" value="{options:data_limit}" maxlength="2" size="4" /><br />
        <input type="checkbox" name="data_limit_all" value="1" />
        {lang:change_data_limit_all}</td>
    </tr>
    <tr>
      <td class="leftc">{icon:image} {lang:img_path}</td>
      <td class="leftb"><input type="text" name="img_path" value="{options:img_path}" maxlength="80" size="40" />
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:image} {lang:img_ext}</td>
      <td class="leftb"><input type="text" name="img_ext" value="{options:img_ext}" maxlength="8" size="4" />
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:ksysguard} {lang:options}</td>
      <td class="leftb"><input type="submit" name="submit" value="{lang:edit}" />
              </td>
    </tr>
  </table>
</form>