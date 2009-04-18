<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb"> {lang:mod_name} - {lang:edit} </td>
  </tr>
  <tr>
    <td class="leftb"> {head:body}</td>
  </tr>
</table>
<br />
{if:preview}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="newshead">{news:news_headline}</td>
  </tr>
  <tr>
    <td class="bottom"><div style="float:left">{news:news_time} - {news:users_link}</div></td>
  </tr>
  <tr>
  <td class="leftb">{if:catimg}<img src="{page:path}{news:url_catimg}" style="float:right" alt="" />{stop:catimg}{if:readmore}{news:preview_news_readmore}{stop:readmore}{news:preview_news_text}</td>
  </tr>
  {if:show}
 <tr>
  <td class="leftb">{lang:mirror}: {loop:prev_mirror}{prev_mirror:news_mirror}{prev_mirror:dot}{stop:prev_mirror}
  </td>
 </tr>
 {stop:show}
</table>
<br />
{stop:preview}
<form method="post" id="news_edit" action="{url:news_edit}">
  <table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
    <tr>
      <td class="leftc" style="width: 100px;">{icon:kedit} {lang:headline} *</td>
      <td class="leftb" colspan="2"><input type="text" name="news_headline" value="{news:news_headline}" maxlength="200" size="50"  /></td>
    </tr>
    <tr>
      <td class="leftc">{icon:folder_yellow} {lang:category} *</td>
      <td class="leftb" colspan="2">{categories:dropdown}</td>
    </tr>
  {if:fck}
    <tr>
      <td class="leftc" colspan="3"><div id="editor_readmore"{if:no_readmore} style="display:none"{stop:no_readmore}>{icon:kate} {lang:readmore}<br />{fck:editor_readmore}</div></td>
    </tr>
    <tr>
      <td class="leftc" colspan="3">{fck:editor}</td>
    </tr>
	{stop:fck}
	{if:abcode}
	<tr>
      <td class="leftc">{icon:kate} {lang:readmore} <br />
        <br />
        {abcode:smilies_readmore}</td>
      <td class="leftb" colspan="2"><div id="editor_readmore"{if:no_readmore} style="display:none"{stop:no_readmore}>{abcode:features_readmore}
        <textarea name="news_readmore" cols="50" rows="10" id="news_readmore" style="width: 98%;">{news:news_readmore}</textarea></div></td>
    </tr>
    <tr>
      <td class="leftc">{icon:kate} {lang:text} *<br />
        <br />
        {abcode:smilies}</td>
      <td class="leftb" colspan="2">{abcode:features}
        <textarea name="news_text" cols="50" rows="20" id="news_text"  style="width: 98%;">{news:news_text}</textarea></td>
    </tr>
	{stop:abcode}
    {loop:mirror}
    <tr>
      <td class="leftc">{icon:html} {lang:mirror} {mirror:num}</td>
      <td class="leftb">{lang:link}: <input type="text" name="news_mirror_{mirror:num}" value="{mirror:news_mirror}" maxlength="200" size="30"  />
      </td>
      <td class="leftb">{lang:link_name}: <input type="text" name="news_mirror_name_{mirror:num}" value="{mirror:news_mirror_name}" maxlength="50" size="20"  /></td>
    </tr>
    {stop:mirror}
    <tr>
      <td class="leftc">{icon:configure} {lang:more}</td>
      <td class="leftb" colspan="2">
        <input class="form" type="checkbox" value="1" name="news_close" {news:news_close}/>
        {lang:close}
        <br/>
        <input class="form" type="checkbox" value="1" name="news_public" {news:news_public}/>
        {lang:public}
        <br/>
        <input class="form" type="checkbox" value="1" onclick="document.getElementById('editor_readmore').style.display=this.checked?'block':'none'" name="news_readmore_active" {news:news_readmore_active}/>
        {lang:news_readmore_active}
        <br/>
        <input class="form" type="checkbox" value="1" name="news_attached" {news:news_attached}/>
        {lang:attached}
        <br/>
        <input type="checkbox" name="news_newtime" value="1" />
        {lang:new_date}
        <br/>
        <input type="checkbox" name="publish_at" value="1" {news:check_publish}/>
        {lang:publishs_at}: {news:news_publishs_at}</td>
    </tr>
	<tr>
	  <td class="leftc">{icon:configure} {lang:features}</td>
	  <td class="leftb" colspan="2">
	  	{lang:features}: {op:features}<br />
	  	{lang:smileys}: {op:smileys}<br />
	  	{lang:clip}: {op:clip}<br />
	  	{lang:html}: {op:html}<br />
	  	{lang:php}: {op:php}							
	  </td>
	</tr>	
    <tr>
      <td class="leftc">{icon:ksysguard} {lang:options}</td>
      <td class="leftb" colspan="2"><input type="hidden" name="id" value="{news:news_id}" />
	    <input type="hidden" name="users_id" value="{news:users_id}" />
        <input type="submit" name="submit" value="{lang:edit}" />
        <input type="submit" name="preview" value="{lang:preview}" />
        <input type="submit" name="mirror" value="{lang:add_mirror}" />
        <input type="hidden" name="run_loop" value="{news:loop}" />
	  </td>
    </tr>
  </table>
</form>