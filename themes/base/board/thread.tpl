<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="2"> {lang:board} - {lang:head_thread} </td>
  </tr>
  <tr>
    <td class="leftb" style="width:50%">{thread:prev}{thread:prev_empty}{thread:next}</td>
    <td class="rightb">{thread:abo}</td>
  </tr>
  <tr>
    <td class="leftc" colspan="2"><a href="#" id="threadanch"></a><a href="{url:board_list}">{lang:board}</a> -&gt; {thread:categories_link} -&gt; {thread:board_link} -&gt;  {thread:thread_link} </td>
  </tr>
</table>
<br />
{thread:getmessage}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  {if:vote}
  <tr>
    <td class="centerb" colspan="2"><div align="center">
        <div style="width: 320px;" align="left">
          <div style="padding: 3px;">
            <div style="margin-bottom: 10px;">{thread:vote_question}</div>
            <form method="post" id="thread_vote" action="{url:board_thread:where={thread:threads_id}}">
              {loop:votes}
              <div><input type="{if:vote_several}checkbox{stop:vote_several}{unless:vote_several}radio{stop:vote_several}" name="voted_election{if:vote_several}[]{stop:vote_several}" value="{votes:run}" /> {votes:vote_election_text}</div>
              {stop:votes}
              <div style="margin-top: 10px;">
                <input type="hidden" name="threads_votes_id" value="{thread:threads_id}" />
                <input type="submit" name="submit_v" value="{lang:vote}" />
              </div>
            </form>
          </div>
        </div>
      </div></td>
  </tr>
  {stop:vote}
  {if:vote_result}
  <tr>
    <td class="leftb" colspan="2"> {thread:vote_question} </td>
  </tr>
  {loop:votes_r}
  <tr>
    <td class="leftc"> {votes_r:answer}</td>
    <td class="leftc"><div align="center">
        <div style="width: 200px;padding: 3px;" align="left">
          <div style="float:right;text-align:right;height:13px;width:40px;vertical-align:middle">{votes_r:answer_percent}%</div>
          <div style="float:right;text-align:right;height:13px;width:40px;vertical-align:middle;margin-right: 4px;">{votes_r:answer_count}</div>
          <div style="background-image:url({votes_r:dirname}symbols/votes/vote03.png); width:100px; height:13px;">
            <div style="background-image:url({votes_r:dirname}symbols/votes/vote01.png); width:{votes_r:answer_percent}px; text-align:right; padding-left:1px"> {votes_r:no_vote_percent} </div>
          </div>
        </div>
      </div></td>
  </tr>
  {stop:votes_r}
  <tr>
    <td class="bottom" colspan="2"><div style="float:right">{lang:elections_vote} {votes:all_count}</div></td>
  </tr>
  {stop:vote_result}
  <tr>
    <td class="bottom" colspan="2"><div style="float:left">{lang:answers}: {thread:sum}</div>
      <div style="float:right">{thread:pages}</div></td>
  </tr>
  {if:asc}
  <tr>
    <td class="leftc" style="width:150px"><img src="{page:path}symbols/countries/{thread_asc:country}.png" style="height:11px;width:16px" alt="" /> {thread_asc:users_link}<br />
      <br />
      {if:moderator}<img src="{page:path}mods/board/rankimg.php?width=100" alt="{thread_asc:boardmod}" /><br />
      {thread_asc:boardmod} <br />
      {stop:moderator}
      
      {if:no_moderator}
      {thread_asc:users_rank} <br />
      {thread_asc:users_title} <br />
      <br />
      {stop:no_moderator}
      
      {thread_asc:avatar} <br />
      <br />
      {thread_asc:place}<br />
      {lang:posts}: {thread_asc:posts}<br />    </td>
    <td class="leftc"> # {lang:theme} - {thread_asc:date}
      <hr style="width:100%" />
      {if:thread_report}
      <div class="quote">{report:thread_clip}</div>
      {stop:thread_report}
      {thread_asc:text}
      {if:thread_asc_files}
      <div style="margin-top: 10px;" class="quote"><strong>{lang:files}</strong> {loop:files}
        <div style="vertical-align:bottom; clear: left; margin-right: 5px; margin-top: 5px; padding: 3px;">{files:file}</div>
        {stop:files} </div>
      {stop:thread_asc_files}
      <div style="clear: left"></div>
      {thread_asc:signature}
      
      {if:thread_asc_edited} <br />
      <br />
      <div style="vertical-align:bottom">{thread_asc:checkedit}</div>
      {stop:thread_asc_edited}</td>
  </tr>
  <tr>
    <td class="leftc"><div style="padding-top:4px; padding-bottom:4px;">{thread_asc:laston}</div></td>
    <td class="leftc"><div style="float:left">{thread_asc:usericons}</div>
      <div style="float:right">{thread_asc:report} {thread_asc:quote} {thread_asc:edit} {thread_asc:remove}</div></td>
  </tr>
  {stop:asc}
  {if:comments}
  {loop:comment}
  <tr>
    <td class="bottom" colspan="2"></td>
  </tr>
  <tr {if:thread_author} class="thread_author_comment"{stop:thread_author}>
    <td class="leftc" style="width:150px"><img src="{page:path}symbols/countries/{comment:country}.png" style="height:11px;width:16px" alt="" /> {comment:users_link}<br />
      {if:thread_author}
      <span class="uthreadstarter">{lang:thread_author}</span> <br />
      {stop:thread_author}
      <br />
      {if:com_moderator}<img src="{page:path}mods/board/rankimg.php?width=100" alt="{comment:boardmod}" /><br />
      {comment:boardmod} <br />
      {stop:com_moderator}
      
      {if:no_com_moderator}
      {comment:users_rank} <br />
      {comment:users_title} <br />
      <br />
      {stop:no_com_moderator}
      
      {comment:avatar} <br />
      <br />
      {comment:place}<br />
      {lang:posts}: {comment:posts}<br />    </td>
    <td class="leftc"> # {lang:answer}: {comment:current} - {comment:date}{comment:current_anchor}
      <hr style="width:100%" />
      {if:com_report}
      <div class="quote">{comment:com_clip}</div>
      {stop:com_report}
      {comment:text}
      {if:c_files}
      <div style="margin-top: 10px;" class="quote"><strong>{lang:files}</strong> {loop:com_files}
        <div style="vertical-align:bottom; clear: left; margin-right: 5px; margin-top: 5px; padding: 3px;">{com_files:file}</div>
        {stop:com_files} </div>
      {stop:c_files}
      <div style="clear: left"></div>
      {comment:signature}
      
      <br /><br />{comment:checkedit}</td>
  </tr>
  <tr {if:thread_author} class="thread_author_comment"{stop:thread_author}>
    <td class="leftc"><div style="padding-top:4px; padding-bottom:4px;">{comment:laston}</div></td>
    <td class="leftc"><div style="float:left">{comment:usericons}</div>
      <div style="float:right">{if:com_user}{comment:report} {comment:quote}{stop:com_user} {if:com_admin}{comment:cut}{comment:edit} {comment:remove}{stop:com_admin}{comment:anch}</div></td>
  </tr>
  {stop:comment}
  {stop:comments}
  {if:sort_desc}
  <tr>
    <td class="leftc" style="width:150px"><img src="{page:path}symbols/countries/{thread_desc:country}.png" style="height:11px;width:16px" alt="" /> {thread_desc:users_link}<br />
      <br />
      {if:moderator}<img src="{page:path}mods/board/rankimg.php?width=100" alt="{thread_desc:boardmod}" /><br />
      {thread_desc:boardmod} <br />
      {stop:moderator}
      
      {if:no_moderator}
      {thread_desc:users_rank} <br />
      {thread_desc:users_title} <br />
      <br />
      {stop:no_moderator}
      
      {thread_desc:avatar} <br />
      <br />
      {thread_desc:place}<br />
      {lang:posts}: {thread_desc:posts}<br />    </td>
    <td class="leftc"> # {lang:theme} - {thread_desc:date}
      <hr style="width:100%" />
      {thread_desc:text}
      {if:thread_desc_files}
      <div style="margin-top: 10px;" class="quote"><strong>{lang:files}</strong> {loop:files}
        <div style="vertical-align:bottom; clear: left; margin-right: 5px; margin-top: 5px; padding: 3px;">{files:file}</div>
        {stop:files} </div>
      {stop:thread_desc_files}
      <div style="clear: left"></div>
      {thread_desc:signature}
      
      <br />
      <br />
      <div style="vertical-align:bottom">{thread_desc:checkedit}</div>
      </td>
  </tr>
  <tr>
    <td class="leftc"><div style="padding-top:4px; padding-bottom:4px;">{thread_desc:laston}</div></td>
    <td class="leftc"><div style="float:left">{thread_desc:users_icons}</div>
      <div style="float:right">{thread_desc:report} {thread_desc:quote} {thread_desc:edit} {thread_desc:remove}</div></td>
  </tr>
  {stop:sort_desc}
  {if:closed}
  <tr>
    <td class="centerb" colspan="2">{thread:closed_img} <br />
      {thread:closed}<br />
      <br />    </td>
  </tr>
  {stop:closed}
  <tr>
    <td class="bottom" colspan="2"><div style="float:left">{lang:answers}: {thread:sum}</div>
      <div style="float:right">{thread:pages}</div></td>
  </tr>
</table>
<br />
{if:modpanel}
<form method="post" id="boardmodpanel_q" action="{url:board_modpanel_q:id={thread:threads_id}}">
  <table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
    <tr>
      <td class="centerb"> {if:modp_close}
        <input type="submit" name="close" value="{lang:thread_close}" />
        {stop:modp_close}
        {if:modp_open}
        <input type="submit" name="open" value="{lang:thread_open}" />
        {stop:modp_open}
        {if:modp_delpin}
        <input type="submit" name="delpin" value="{lang:thread_delpin}" />
        {stop:modp_delpin}
        {if:modp_addpin}
        <input type="submit" name="addpin" value="{lang:thread_addpin}" />
        {stop:modp_addpin}
        <input type="submit" name="move" value="{lang:thread_move}" />
        <input type="submit" name="rename" value="{lang:thread_rename}" />
        <input type="hidden" name="id" value="{thread:threads_id}" />
      </td>
    </tr>
  </table>
</form>
{stop:modpanel} <br />
{if:no_user}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="centerb">{lang:need_user}</td>
  </tr>
</table>
{stop:no_user}

{if:last_own}
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="centerb">{lang:last_own} {thread:doublepost}</td>
  </tr>
</table>
{stop:last_own}

{if:write_comment}
<form method="post" id="board_com_create" action="{url:board_com_create}">
  <table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
    <tr>
      <td class="leftc" colspan="2"><input type="submit" name="advanced" value="{lang:adv_com}" />
      </td>
    </tr>
    <tr>
      <td class="leftc">{icon:kopete} {lang:comment} *<br />
        <br />
        {wcomment:smileys} </td>
      <td class="leftb">{wcomment:abcode}
        <textarea class="rte_abcode" name="comments_text" cols="50" rows="8" id="comments_text"></textarea>
      </td>
    </tr>
    {if:allow_close}
    <tr>
      <td class="leftc">{icon:configure} {lang:more}</td>
      <td class="leftb"><input type="checkbox" name="close_now" value="1" /> {lang:thread_close}</td>
    </tr>
    {stop:allow_close}
    <tr>
      <td class="leftc">{icon:ksysguard} {lang:options}</td>
      <td class="leftb"><input type="hidden" name="id" value="{thread:threads_id}" />
        <input type="submit" name="submit" value="{lang:submit}" />
        <input type="submit" name="preview" value="{lang:preview}" />
              </td>
    </tr>
  </table>
</form>
{stop:write_comment}