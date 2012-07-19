<a href="{url:users_home}">{lang:home}</a> -
{if:messages}
  <a href="{url:messages_inbox}">{lang:messages}</a> (<span id="cs_messages_navmsgs">{messages:new}</span>) -
{stop:messages}
<a href="{url:users_settings}">{lang:settings}</a> -
{if:more}
  {if:contact}
    <a href="{url:contact_manage}">{lang:contact}</a> (<span id="cs_contact_navmsgs">{contact:new}</span>) -
  {stop:contact}
  {if:admin}
    <a href="{url:clansphere_admin}">{lang:admin}</a> -
  {stop:admin}
  {if:system}
    <a href="{url:clansphere_system}">{lang:system}</a> -
  {stop:system}
  {if:panel}
    <a href="{link:panel}">{lang:panel}</a> -
  {stop:panel}
{stop:more}
<a href="{url:users_logout}">{lang:logout}</a>