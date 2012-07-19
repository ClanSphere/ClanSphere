<html>
<head>
<style type="text/css">
<!--
body {background-color: #f2f2f2;}
td {background-color:#fff;}
a{color:#ba1616;}
-->
</style>
</head>
<body>

<table border="0" align="center" cellpadding="12" cellspacing="3">
  <tr>
    <td><img src="{data:src}" alt="" /></td>
    <td rowspan="2" style="vertical-align: top">
      {lang:of} <a href="mailto:{data:sender_mail}">{data:sender_name}</a><br />
      <br />
      {lang:to} <a href="mailto:{data:receiver_mail}">{data:receiver_name}</a><br />
      <br /><br /><br />
      {data:time}
    </td>
  </tr>
  <tr>
    <td><strong>{data:ecard_titel}</strong><br />
      <br />
      {data:ecard_text}
    </td>
  </tr>
</table>
</html>