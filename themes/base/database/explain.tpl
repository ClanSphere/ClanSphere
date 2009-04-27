<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width: 100%">
  <tr>
    <td class="leftb">id</td>
    <td class="leftb">select_type</td>
    <td class="leftb">table</td>
    <td class="leftb">type</td>
    <td class="leftb">possible_keys</td>
    <td class="leftb">key</td>
    <td class="leftb">key_len</td>
    <td class="leftb">ref</td>
    <td class="leftb">rows</td>
    <td class="leftb">Extra</td>
  </tr>
  {loop:more}
  <tr>
    <td class="leftc">{more:id}</td>
    <td class="leftc">{more:select_type}</td>
    <td class="leftc">{more:table}</td>
    <td class="leftc">{more:type}</td>
    <td class="leftc">{more:possible_keys}</td>
    <td class="leftc">{more:key}</td>
    <td class="leftc">{more:key_len}</td>
    <td class="leftc">{more:ref}</td>
    <td class="leftc">{more:rows}</td>
    <td class="leftc">{more:Extra}</td>
  </tr>
  {stop:more}
</table>