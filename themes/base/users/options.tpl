<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
      <td class="headb">{lang:mod_name} - {lang:options}</td>
   </tr>
   <tr>
      <td class="leftb">{lang:manage_options}</td>
   </tr>
</table>
<br />

<form method="post" id="users_options" action="{url:users_options}" enctype="multipart/form-data">
  <table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
     <tr>
        <td class="leftc">{icon:resizecol} {lang:max_width}</td>
        <td class="leftb"><input type="text" name="max_width" value="{options:max_width}" maxlength="4" size="4" /> {lang:pixel}</td>
     </tr>
     <tr>
        <td class="leftc">{icon:resizerow} {lang:max_height}</td>
        <td class="leftb"><input type="text" name="max_height" value="{options:max_height}" maxlength="4" size="4" /> {lang:pixel}</td>
     </tr>
     <tr>
        <td class="leftc">{icon:fileshare} {lang:max_size}</td>
        <td class="leftb"><input type="text" name="max_size" value="{options:max_size}" maxlength="20" size="8" /> {lang:bytes}</td>
     </tr>
     <tr>
        <td class="leftc">{icon:cell_edit} {lang:min_letters}</td>
        <td class="leftb"><input type="text" name="min_letters" value="{options:min_letters}" maxlength="10" size="4" /> {lang:letters}</td>
     </tr>
     <tr>
        <td class="leftc">{icon:groupevent} {lang:navbirth_max_users}</td>
        <td class="leftb"><input type="text" name="navbirth_max_users" value="{options:navbirth_max_users}" maxlength="10" size="4" /></td>
     </tr>
     <tr>
        <td class="leftc">{icon:groupevent} {lang:nextbirth_max_users}</td>
        <td class="leftb"><input type="text" name="nextbirth_max_users" value="{options:nextbirth_max_users}" maxlength="10" size="4" /></td>
     </tr>
     <tr>
        <td class="leftc">{icon:ktimer} {lang:nextbirth_time_interval}</td>
        <td class="leftb">{dropdown:nextbirth_time_interval} {lang:days}</td>
     </tr>
     <tr>
        <td class="leftc">{icon:completion} {lang:def_register}</td>
        <td class="leftb">{dropdown:def_register}</td>
     </tr>
     <tr>
        <td class="leftc">{icon:personal} {lang:register}</td>
        <td class="leftb">
          <select name="register">
            {options:register_off}
            {options:register_on}
          </select>
        </td>
     </tr>
     <tr>
       <td class="leftc">{icon:personal} {lang:login}</td>
       <td class="leftb">
         <select name="login">
           <option value="nick" {login:nick}>{lang:nick}</option>
           <option value="email" {login:email}>{lang:email}</option>
         </select>
       </td>
     </tr>
     <tr>
        <td class="leftc">{icon:camera_unmount} {lang:default_picture}</td>
        <td class="leftb"><input type="checkbox" name="def_picture_on" value="1" {selected:def_picture}/> {lang:active}<br /><br />
          <img src="{page:path}uploads/users/nopicture.jpg" alt="" /><br /><br />
          {lang:other_one}: <input type="file" name="def_picture" />
         </td>
     </tr>
     <tr>
       <td class="leftc">{icon:ksysguard} {lang:options}</td>
        <td class="leftb"><input type="submit" name="submit" value="{lang:edit}" /></td>
     </tr>
  </table>
</form>