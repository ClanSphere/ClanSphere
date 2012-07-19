<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb">{lang:mod_name} - {lang:head_create}</td>
  </tr>
  <tr>
    <td class="leftb">{head:body}</td>
  </tr>
</table>
<br />

<form method="post" id="computers_create" action="{url:computers_create}">
<table class="forum" style="width:{page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="leftc">{icon:mycomputer} {lang:name} *</td>
    <td class="leftb"><input type="text" name="computers_name" value="{com:computers_name}" maxlength="40" size="20" /></td>
  </tr>
  <tr>
    <td class="leftc">{icon:samba} {lang:software} *</td>
    <td class="leftb"><input type="text" name="computers_software" value="{com:computers_software}" maxlength="40" size="40" /></td>
  </tr>
  <tr>
    <td class="leftc">{icon:kcmmemory} {lang:mainboard} *</td>
    <td class="leftb"><input type="text" name="computers_mainboard" value="{com:computers_mainboard}" maxlength="80" size="40" /></td>
  </tr>
  <tr>
    <td class="leftc">{icon:memory} {lang:memory}</td>
    <td class="leftb"><textarea class="rte_abcode" name="computers_memory" cols="50" rows="3" id="computers_memory">{com:computers_memory}</textarea></td>
  </tr>
  <tr>
    <td class="leftc">{icon:kcmprocessor} {lang:processors}</td>
    <td class="leftb"><textarea class="rte_abcode" name="computers_processors" cols="50" rows="3" id="computers_processors">{com:computers_processors}</textarea></td>
  </tr>
  <tr>
    <td class="leftc">{icon:package_graphics} {lang:graphics}</td>
    <td class="leftb"><textarea class="rte_abcode" name="computers_graphics" cols="50" rows="3" id="computers_graphics">{com:computers_graphics}</textarea></td>
  </tr>
  <tr>
    <td class="leftc">{icon:package_multimedia} {lang:sounds}</td>
    <td class="leftb"><textarea class="rte_abcode" name="computers_sounds" cols="50" rows="3" id="computers_sounds">{com:computers_sounds}</textarea></td>
  </tr>
  <tr>
    <td class="leftc">{icon:hdd_unmount} {lang:harddisks}</td>
    <td class="leftb"><textarea class="rte_abcode" name="computers_harddisks" cols="50" rows="3" id="computers_harddisks">{com:computers_harddisks}</textarea></td>
  </tr>
  <tr>
    <td class="leftc">{icon:cd_unmount} {lang:drives}</td>
    <td class="leftb"><textarea class="rte_abcode" name="computers_drives" cols="50" rows="3" id="computers_drives">{com:computers_drives}</textarea></td>
  </tr>
  <tr>
    <td class="leftc">{icon:multiple_monitors} {lang:screens}</td>
    <td class="leftb"><textarea class="rte_abcode" name="computers_screens" cols="50" rows="3" id="computers_screens">{com:computers_screens}</textarea></td>
  </tr>
  <tr>
    <td class="leftc">{icon:mouse} {lang:interfaces}</td>
    <td class="leftb"><textarea class="rte_abcode" name="computers_interfaces" cols="50" rows="3" id="computers_interfaces">{com:computers_interfaces}</textarea></td>
  </tr>
  <tr>
    <td class="leftc">{icon:network} {lang:networks}</td>
    <td class="leftb"><textarea class="rte_abcode" name="computers_networks" cols="50" rows="3" id="computers_networks">{com:computers_networks}</textarea></td>
  </tr>
  <tr>
    <td class="leftc">{icon:hardware} {lang:more}</td>
    <td class="leftb"><textarea class="rte_abcode" name="computers_more" cols="50" rows="6" id="computers_more">{com:computers_more}</textarea></td>
  </tr>
  <tr>
    <td class="leftc">{icon:ksysguard} {lang:options}</td>
    <td class="leftb">
      <input type="hidden" name="referer" value="{com:referer}" />
      <input type="submit" name="submit" value="{lang:create}" />
          </td>
  </tr>
</table>
</form>
