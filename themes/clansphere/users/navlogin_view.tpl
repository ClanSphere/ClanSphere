<ul class="clear">
	<li><a href="{url:users_home}">{lang:home}</a></li>
	{if:messages}
	<li><a href="{url:messages_inbox}">{lang:messages}</a> (<span id="cs_messages_navmsgs">{messages:new}</span>)</li>
	{stop:messages}
	<li><a href="{url:users_settings}">{lang:settings}</a></li>
	{if:more}
		{if:contact}
		<li><a href="{url:contact_manage}">{lang:contact}</a> (<span id="cs_contact_navmsgs">{contact:new}</span>)</li>
		{stop:contact}
  		{if:joinus}
		<li><a href="{url:joinus_manage}">{lang:joinus}</a> ({joinus:joinus_count})</li>
		{stop:joinus}
  		{if:fightus}
		<li><a href="{url:fightus_manage}">{lang:fightus}</a> ({fightus:fightus_count})</li>
		{stop:fightus}
  		{if:admin}
		<li><a href="{url:clansphere_admin}">{lang:admin}</a></li>
		{stop:admin}
  		{if:system}
		<li><a href="{url:clansphere_system}">{lang:system}</a></li>
		{stop:system}
  		{if:panel}
		<li><a href="{link:panel}">{lang:panel}</a></li>
		{stop:panel}
	{stop:more}
	<li><a href="{url:users_logout}">{lang:logout}</a></li>
</ul>