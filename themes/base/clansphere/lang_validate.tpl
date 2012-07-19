<div style="width:{page:width}; margin: auto;" class="forum" cellpadding="0" cellspacing="{page:cellspacing}"> {loop:languages}
  <div class="headb" style="margin:1px;"><a href="javascript:cs_display('lang_{languages:name}')">{languages:name}</a></div>
  <div id="lang_{languages:name}" style="display:none"> {loop:modules}
    <div class="leftc" style="margin:1px;"><a href="javascript:cs_validate('{languages:name}','{modules:name}')">{modules:name}</a></div>
    <div style="margin:1px; display:none;" id="mod_{languages:name}_{modules:name}"></div>
    {stop:modules} </div>
  {stop:languages} </div>
