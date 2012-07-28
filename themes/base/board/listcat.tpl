<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="2">{lang:mod_name} - {lang:head_listcat}</td>
  </tr>
  <tr>
    <td class="leftb" style="width:50%"><a href="{link:board}">{lang:board}</a> -&gt; <a href="{link:name}">{categories:name}</a> -&gt; {board:name}</td>
    <td class="rightb" style="width:50%">{if:newthread}<a href="{link:newthread}">{lang:newthread}</a>{stop:newthread} </td>
  </tr>
  <tr>
    <td class="rightc" colspan="2"><a href="{link:mark_board}">{lang:mark_board}</a> </td>
  </tr>
</table>
<br />
{head:message}

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="bottom" colspan="6"><div style="float:left">{lang:topics}: {count:topics}</div>
      <div style="float:right">{pages:list}</div></td>
  </tr>
  <tr>
    <td class="leftc" colspan="2">{lang:thread}</td>
    <td class="leftc">{lang:replies}</td>
    <td class="leftc">{lang:hits}</td>
    <td class="leftc">{lang:lastpost}</td>
  </tr>
  {loop:threads}
  <tr>
    <td class="leftb" style="width:36px">{threads:icon}</td>
    <td class="leftb"><b>{threads:important}{threads:headline} {threads:attach} {threads:report}</b><br />
      {lang:from} {threads:user} {threads:page} {threads:ghost_thread} {threads:ghost_board}</td>
    <td class="centerb" style="width:60px">{threads:comments}</td>
    <td class="centerb" style="width:60px">{threads:view}</td>
    <td class="leftb" style="width:180px">{threads:date}<br />
      {threads:from} {threads:user_name} </td>
  </tr>
  {stop:threads}

  <tr>
    <td class="bottom" colspan="6"><div style="float:left">{lang:topics}: {count:topics}</div>
      <div style="float:right">{pages:list}</div></td>
  </tr>
  <tr>
    <td class="rightc" colspan="5"><a href="{link:mark_board}">{lang:mark_board}</a>  </td>
  </tr>
</table>
<br />
{board:statistik}