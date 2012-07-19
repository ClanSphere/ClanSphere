{icon:home} <a href="{url:users_home}">{lang:home}</a><br />
{if:messages}
  {icon:inbox} <a href="{url:messages_inbox}">{lang:messages}</a> (<span id="cs_messages_navmsgs">{messages:new}</span>)<br />
{stop:messages}
{icon:looknfeel} <a href="{url:users_settings}">{lang:settings}</a><br />
<br />
{if:more}
  {if:contact}
    {icon:kontact} <a href="{url:contact_manage}">{lang:contact}</a> (<span id="cs_contact_navmsgs">{contact:new}</span>)<br />
  {stop:contact}
  {if:admin}
    {icon:view_text} <a href="{url:clansphere_admin}">{lang:admin}</a><br />
  {stop:admin}
  {if:system}
    {icon:package_system} <a href="{url:clansphere_system}">{lang:system}</a><br />
  {stop:system}
  {if:panel}
    {icon:view_choose} <a href="{link:panel}">{lang:panel}</a><br />
  {stop:panel}
  <br />
{stop:more}
{icon:exit} <a href="{url:users_logout}">{lang:logout}</a>