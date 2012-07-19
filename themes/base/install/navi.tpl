<div id="nav_padding">{lang:mod_name}</div>
 
<div class="nav_content"{active:lang}>{arr:lang}1. {lang:language_choose}</div>
<div class="nav_content"{active:compatible}>{arr:compatible}2. {lang:install_check}</div>
<div class="nav_content"{active:license}>{arr:license}3. {lang:license}</div>
<div class="nav_content"{active:settings}>{arr:settings}4. {lang:configuration}</div>
{if:sql_select}<div class="nav_content"{active:sql_select}>{arr:sql_select}4.1 {lang:module_select}</div>{stop:sql_select}
<div class="nav_content"{active:sql}>{arr:sql}5. {lang:database}</div>
<div class="nav_content"{active:admin}>{arr:admin}6. {lang:create_admin_head}</div>
<div class="nav_content"{active:check}>{arr:check}7. {lang:last_check}</div>