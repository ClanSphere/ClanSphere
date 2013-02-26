<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
      <td class="headb">{lang:mod_name} - {lang:options}</td>
   </tr>
   <tr>
      <td class="leftb">{lang:options_info}</td>
   </tr>
</table>
<br />

<form method="post" action="{url:joinus_options}">
  <table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
     <tr>
        <td class="leftc">{icon:document} {lang:vorname}</td>
        <td class="leftb">
          <input type="radio" name="vorname" value="1" {op:vorname_yes} />{lang:yes}
          <input type="radio" name="vorname" value="0" {op:vorname_no} />{lang:no}
        </td>
     </tr>  
     <tr>
        <td class="leftc">{icon:document} {lang:surname}</td>
        <td class="leftb">
          <input type="radio" name="surname" value="1" {op:surname_yes} />{lang:yes}
          <input type="radio" name="surname" value="0" {op:surname_no} />{lang:no}
        </td>
     </tr>
     <tr>
        <td class="leftc">{icon:document} {lang:place}</td>
        <td class="leftb">
          <input type="radio" name="place" value="1" {op:place_yes} />{lang:yes}
          <input type="radio" name="place" value="0" {op:place_no} />{lang:no}
        </td>
     </tr>
     <tr>
        <td class="leftc">{icon:document} {lang:country}</td>
        <td class="leftb">
          <input type="radio" name="country" value="1" {op:country_yes} />{lang:yes}
          <input type="radio" name="country" value="0" {op:country_no} />{lang:no}
        </td>
     </tr>     
     <tr>
        <td class="leftc">{icon:document} {lang:icq}</td>
        <td class="leftb">
          <input type="radio" name="icq" value="1" {op:icq_yes} />{lang:yes}
          <input type="radio" name="icq" value="0" {op:icq_no} />{lang:no}
        </td>
     </tr>
     <tr>
        <td class="leftc">{icon:document} {lang:jabber}</td>
        <td class="leftb">
          <input type="radio" name="jabber" value="1" {op:jabber_yes} />{lang:yes}
          <input type="radio" name="jabber" value="0" {op:jabber_no} />{lang:no}
        </td>
     </tr>
     <tr>
        <td class="leftc">{icon:document} {lang:game}</td>
        <td class="leftb">
          <input type="radio" name="game" value="1" {op:game_yes} />{lang:yes}
          <input type="radio" name="game" value="0" {op:game_no} />{lang:no}
        </td>
     </tr>  
     <tr>
        <td class="leftc">{icon:document} {lang:squad}</td>
        <td class="leftb">
          <input type="radio" name="squad" value="1" {op:squad_yes} />{lang:yes}
          <input type="radio" name="squad" value="0" {op:squad_no} />{lang:no}
        </td>
     </tr>
     <tr>
        <td class="leftc">{icon:document} {lang:webcon}</td>
        <td class="leftb">
          <input type="radio" name="webcon" value="1" {op:webcon_yes} />{lang:yes}
          <input type="radio" name="webcon" value="0" {op:webcon_no} />{lang:no}
        </td>
     </tr>
     <tr>
        <td class="leftc">{icon:document} {lang:lanact}</td>
        <td class="leftb">
          <input type="radio" name="lanact" value="1" {op:lanact_yes} />{lang:yes}
          <input type="radio" name="lanact" value="0" {op:lanact_no} />{lang:no}
        </td>
     </tr>
     <tr>
        <td class="leftc">{icon:document} {lang:info}</td>
        <td class="leftb">
          <input type="radio" name="more" value="1" {op:more_yes} />{lang:yes}
          <input type="radio" name="more" value="0" {op:more_no} />{lang:no}
        </td>
     </tr>
     <tr>
        <td class="leftc">{icon:playlist} {lang:max_usershome}</td>
        <td class="leftb"><input type="text" name="max_usershome" value="{op:max_usershome}" maxlength="2" size="2" /></td>
     </tr>      
     <tr>
        <td class="leftc">{icon:ksysguard} {lang:options}</td>
        <td class="leftb"><input type="submit" name="submit" value="{lang:edit}" /></td>
     </tr>
  </table>
</form>