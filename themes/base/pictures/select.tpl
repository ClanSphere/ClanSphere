 <tr>
  <td class="leftc">{icon:image} {lang:picture}</td>
  <td class="leftb">{if:already}<img src="{page:path}uploads/pictures/{picture:file}" alt="" /><br />
     <input type="checkbox" name="del_picture" value="{picture:file}" /> {lang:del_picture}<br /><br />
     {stop:already}<input type="file" name="picture" /></td>
 </tr>