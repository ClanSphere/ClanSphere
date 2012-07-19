<table class="forum" style="width: 100%" cellpadding="0" cellspacing="{page:cellspacing}">
{if:row1}
  <tr>
    <td class="centerb">
      <a href="javascript:abc_insert('{var:pattern1}','','{var:textarea}')">{var:img1}</a>
    </td>
    <td class="centerb">
      <a href="javascript:abc_insert('{var:pattern2}','','{var:textarea}')">{var:img2}</a>
    </td>
    <td class="centerb">
      <a href="javascript:abc_insert('{var:pattern3}','','{var:textarea}')">{var:img3}</a>
    </td>
  </tr>
{stop:row1}
{if:row2}
  <tr>
    <td class="centerb">
      <a href="javascript:abc_insert('{var:pattern4}','','{var:textarea}')">{var:img4}</a>
    </td>
    <td class="centerb">
      <a href="javascript:abc_insert('{var:pattern5}','','{var:textarea}')">{var:img5}</a>
    </td>
    <td class="centerb">
      <a href="javascript:abc_insert('{var:pattern6}','','{var:textarea}')">{var:img6}</a>
    </td>
  </tr>
{stop:row2}
{if:row3}
  <tr>
    <td class="centerb">
      <a href="javascript:abc_insert('{var:pattern7}','','{var:textarea}')">{var:img7}</a>
    </td>
    <td class="centerb">
      <a href="javascript:abc_insert('{var:pattern8}','','{var:textarea}')">{var:img8}</a>
    </td>
    <td class="centerb">
      <a href="javascript:abc_insert('{var:pattern9}','','{var:textarea}')">{var:img9}</a>
    </td>
  </tr>
{stop:row3}
{if:features}
  <tr>
    <td class="centerc" colspan="3">
      <a href="#" id="list_{var:textarea}" onclick="window.open('{page:path}features.php?name={var:textarea}', '{lang:list}', 'width=450,height=600,scrollbars=yes'); return false">{lang:list}</a>
    </td>
  </tr>
{stop:features}
</table>