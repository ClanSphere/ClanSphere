{comments:message}

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="bottom" colspan="2"><div style="float:left">{lang:comments}: {comments:sum}</div>
    <div style="float:right">{comments:pages}</div></td>
  </tr>
  {loop:com}
  <tr>
    <td class="{com:class}" style="width:150px">
      {if:guest}{com:guestnick}<br /><br />
      {lang:guest}<br />
      <br /><br />{stop:guest}
      {if:user}{com:flag} {com:user}<br />
      {com:avatar}<br />
      {com:status} {com:laston}<br />
      <br />
      {lang:place}: {com:place}<br />
      {lang:posts}: {com:posts}{stop:user}
    </td>
    <td class="{com:class}"> # {com:current} - {com:comments_time}<a href="#" id="com{com:run}"></a>
      <hr style="width:100%" />
      <br />
      {com:comments_text}
      {com:comments_edit}
      {if:quote_board}<br /><br />
      <div style="float:right">
        <input type="submit" name="fquote" value="{com:id}" style="width:16px;height:16px;background:url({page:path}{fquote:icon});border:none;cursor:pointer;padding:0px;font-size:0px;" />
      </div>{stop:quote_board}
      {if:edit_delete}<br /><br />
      <div style="float:right">
        {com:edit_delete}
      </div>{stop:edit_delete}
    </td>
  </tr>
  {stop:com}
  {if:bottom_pages}
  <tr>
    <td class="bottom" colspan="2"><div style="float:right">{comments:pages}</div></td>
  </tr>
  {stop:bottom_pages}
</table>
{if:form}</form>{stop:form}