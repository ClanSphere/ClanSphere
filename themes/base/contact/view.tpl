<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:view}</td>
  </tr>
  <tr>
    <td class="leftb">{lang:head_view}</td>
  </tr>
</table>
<br />

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="2">{lang:the_request}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:personal} {lang:from}</td>
  <td class="leftb">{mail:mail_name} &lt;{mail:mail_email}&gt;</td>
  </tr>
  <tr>
    <td class="leftc">{icon:important} {lang:request}</td>
    <td class="leftb">{mail:categories_name}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:kedit} {lang:subject}</td>
  <td class="leftb">{mail:mail_subject}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:licq} {lang:icq}</td>
  <td class="leftb">{mail:mail_icq}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:jabber_protocol} {lang:jabber}</td>
  <td class="leftb">{mail:mail_jabber}</td>
  </tr>  
  <tr>
    <td class="leftc">{icon:kdmconfig} {lang:firm}</td>
  <td class="leftb">{mail:mail_firm}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:clock} {lang:date}</td>
  <td class="leftb">{mail:mail_date}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:network} {lang:ip}</td>
  <td class="leftb">{mail:mail_ip}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:mail_generic} {lang:message}</td>
  <td class="leftb">{mail:mail_message}</td>
  </tr>
  {if:answer}
  <tr>
    <td class="headb" colspan="2">{lang:the_answer}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:personal} {lang:editor}</td>
  <td class="leftb">{mail:user}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:clock} {lang:date}</td>
  <td class="leftb">{mail:mail_answertime}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:mail_generic} {lang:message}</td>
  <td class="leftb">{mail:mail_answer}</td>
  </tr>
  {stop:answer}
  <tr>
    <td class="headb" colspan="2">{lang:options}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:ksysguard} {lang:options}</td>
  <td class="leftb"><a href="{url:contact_manage}">{lang:back}</a>
      {if:noanswer}
      <br />
      <a href="{url:contact_answer:id={mail:mail_id}}">{lang:answer}</a>
      {stop:noanswer}
    </td>
  </tr>
</table>