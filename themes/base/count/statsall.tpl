<script type="text/javascript" src="{page:path}mods/count/amline/swfobject.js"></script>
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="3">{lang:visitors} - {lang:alloverview}</td>
  </tr>
</table>
<br />
<div id="flashcontent">
  <table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
    <tr>
      <td class="centerc">{lang:flash}</td>
    </tr>
  </table>
</div>
<script type="text/javascript">
  //<![CDATA[
  var so = new SWFObject("{page:path}mods/count/amline/amline.swf", "amline", "{options:width}%", "{options:height}px", "8", "#{options:background}");
  so.addVariable("path", "{page:path}mods/count/amline/");
  so.addVariable("chart_settings", 
                 "<settings>" +
                   "<text_size>{options:textsize}<\/text_size>" +
                   "<text_color>#{options:textcolor}<\/text_color>" +
                   "<redraw>true<\/redraw>" +
                   "<background>" +
                     "<color>#{options:background}<\/color>" +
                     "<alpha>100<\/alpha>" +
                   "<\/background>" +
                   "<scroller>" +
                     "<enabled>true<\/enabled>" +
                   "<\/scroller>" +
                   "<grid>" +
                     "<x>" +
                       "<enabled>true<\/enabled>" +
                       "<color>#{options:textcolor}<\/color>" +
                       "<dashed>true<\/dashed>" +
                       "<dash_length>3<\/dash_length>" +
                       "<approx_count>12<\/approx_count>" +
                     "<\/x>" +
                     "<y_left>" +
                       "<enabled>true<\/enabled>" +
                       "<color>#{options:textcolor}<\/color>" +
                     "<\/y_left>" +
                     "<y_right>" +
                       "<enabled>true<\/enabled>" +
                       "<color>#{options:textcolor}<\/color>" +
                     "<\/y_right>" +
                   "<\/grid>" +
                   "<axes>" +
                     "<x>" +
                       "<color>#{options:axescolor}<\/color>" +
                     "<\/x>" +
                     "<y_left>" +
                       "<color>#{options:axescolor}<\/color>" +
                       "<tick_length>10<\/tick_length>" +
                     "<\/y_left>" +
                     "<y_right>" +
                       "<color>#{options:axescolor}<\/color>" +
                     "<\/y_right>" +
                   "<\/axes>" +
                   "<indicator>" +
                     "<enabled>true<\/enabled>" +
                     "<color>#{options:indicatorcolor}<\/color>" +
                     "<selection_color>#3972ad<\/selection_color>" +
                     "<y_balloon_on_off>true<\/y_balloon_on_off>" +
                   "<\/indicator>" +
                   "<legend>" +
                     "<y>380<\/y>" +
                     "<text_color_hover>#{options:graphcolor1}<\/text_color_hover>" +
                   "<\/legend>" +
                   "<labels>" +
                     "<label>" +
                       "<align>left<\/align>" +
                       "<text_size>7<\/text_size>" +
                       "<text><\/text>" +
                     "<\/label>" +
                   "<\/labels>" +
                   "<graphs>" +
                     "<graph gid='1'>" +
                       "<axis>left<\/axis>" +
                       "<title>Nominal<\/title>" +
                       "<color>#{options:graphcolor1}<\/color>" +
                       "<color_hover>#{options:graphcolor1}<\/color_hover>" +
                       "<line_width>4<\/line_width>" +
                       "<fill_alpha>30<\/fill_alpha>" +
                       "<fill_color>#{options:graphcolor1}<\/fill_color>" +
                       "<balloon_color>#{options:graphcolor1}<\/balloon_color>" +
                       "<balloon_text_color>#{options:textballoncolor}<\/balloon_text_color>" +
                       "<bullet_color>#{options:graphcolor1}<\/bullet_color>" +
                       "<balloon_text>{value} {lang:visitors}<\/balloon_text>" +
                     "<\/graph>" +
                       "<graph gid='2'>" +
                       "<axis>left<\/axis>" +
                       "<title>Nominal<\/title>" +
                       "<color>#{options:graphcolor2}<\/color>" +
                       "<color_hover>#{options:graphcolor2}<\/color_hover>" +
                       "<line_width>4<\/line_width>" +
                       "<fill_alpha>30<\/fill_alpha>" +
                       "<fill_color>#{options:graphcolor2}<\/fill_color>" +
                       "<balloon_color>#{options:graphcolor2}<\/balloon_color>" +
                       "<balloon_text_color>#{options:textballoncolor}<\/balloon_text_color>" +
                       "<bullet_color>#{options:indicatorcolor}<\/bullet_color>" +
                       "<balloon_text>{lang:average} {value}<\/balloon_text>" +
                     "<\/graph>" +
                   "<\/graphs>" +
                 "<\/settings>");
  so.addVariable("chart_data", 
                 "<chart>" + 
                   "<series>" +
                     {loop:count}"<value xid='{count:id}'>{count:year}<\/value>" + {stop:count}
                   "<\/series>" + 
                   "<graphs>" + 
                     "<graph gid='1' title='{lang:guest}'>" +
                       {loop:countall}"<value xid='{countall:id}'>{countall:value}<\/value>" + {stop:countall}
                     "<\/graph>" +
                   "<\/graphs>" +
                 "<\/chart>");
  so.addVariable("preloader_color", "#FFFFFF");
  so.write("flashcontent");
  //]]>
</script>
