<div style="text-align: center; width: 100%">
  <span style="font-weight: bold">{users:country_icon} {users:link}</span><br />
  <div style="padding: 4px">{users:pic}</div>
</div>

<a href="{url:users_home}">{lang:home}</a><br />
{if:messages}
  <a href="{url:messages_inbox}">{lang:messages}</a> (<span id="cs_messages_navmsgs">{messages:new}</span>)<br />
{stop:messages}
<a href="{url:users_settings}">{lang:settings}</a><br />
<br />
{if:more}
  {if:contact}
    <a href="{url:contact_manage}">{lang:contact}</a> (<span id="cs_contact_navmsgs">{contact:new}</span>)<br />
  {stop:contact}
  {if:admin}
    <a href="{url:clansphere_admin}">{lang:admin}</a><br />
  {stop:admin}
  {if:system}
    <a href="{url:clansphere_system}">{lang:system}</a><br />
  {stop:system}
  {if:panel}
    <a href="{link:panel}">{lang:panel}</a><br />
  {stop:panel}
  <br />
{stop:more}
<a href="{url:users_logout}">{lang:logout}</a>