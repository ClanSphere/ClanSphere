<a href="javascript:abc_insert('[left]','[/left]','{var:textarea}','')" title="{lang:left}"><img src="{page:path}symbols/{var:imgpath}/openoffice/lc_alignleft.{var:ext}" alt="{lang:left}" /></a>
<a href="javascript:abc_insert('[center]','[/center]','{var:textarea}','')" title="{lang:center}"><img src="{page:path}symbols/{var:imgpath}/openoffice/lc_alignhorizontalcenter.{var:ext}" alt="{lang:center}" /></a>
<a href="javascript:abc_insert('[right]','[/right]','{var:textarea}','')" title="{lang:right}"><img src="{page:path}symbols/{var:imgpath}/openoffice/lc_alignright.{var:ext}" alt="{lang:right}" /></a>
<a href="javascript:abc_insert('[justify]','[/justify]','{var:textarea}','')" title="{lang:justify}"><img src="{page:path}symbols/{var:imgpath}/openoffice/lc_alignblock.{var:ext}" alt="{lang:justify}" /></a>
<a href="javascript:abc_insert('[b]','[/b]','{var:textarea}','')" title="{lang:bold}"><img src="{page:path}symbols/{var:imgpath}/openoffice/lc_bold2.{var:ext}" alt="{lang:bold}" /></a>
<a href="javascript:abc_insert('[i]','[/i]','{var:textarea}','')" title="{lang:italic}"><img src="{page:path}symbols/{var:imgpath}/openoffice/lc_italic2.{var:ext}" alt="{lang:italic}" /></a>
<a href="javascript:abc_insert('[u]','[/u]','{var:textarea}','')" title="{lang:underline}"><img src="{page:path}symbols/{var:imgpath}/openoffice/lc_underline2.{var:ext}" alt="{lang:underline}" /></a>
<a href="javascript:abc_insert('[s]','[/s]','{var:textarea}','')" title="{lang:strike}"><img src="{page:path}symbols/{var:imgpath}/openoffice/lc_strike.{var:ext}" alt="{lang:strike}" /></a>
<a href="javascript:abc_insert('[hr]','','{var:textarea}','')" title="{lang:horizontal_rule}"><img src="{page:path}symbols/{var:imgpath}/openoffice/lc_hr2.{var:ext}" alt="{lang:horizontal_rule}" /></a>
<a href="javascript:abc_insert('[h=1]','[/h]','{var:textarea}','')" title="{lang:headline}"><img src="{page:path}symbols/{var:imgpath}/openoffice/lc_headline.{var:ext}" alt="{lang:headline}" /></a>
<a href="javascript:abc_insert('[indent=15]','[/indent]','{var:textarea}','')" title="{lang:indent}"><img src="{page:path}symbols/{var:imgpath}/openoffice/lc_incrementindent.{var:ext}" alt="{lang:indent}" /></a>
<a href="javascript:abc_insert('[quote]','[/quote]','{var:textarea}','')" title="{lang:quote}"><img src="{page:path}symbols/{var:imgpath}/openoffice/lc_quote.{var:ext}" alt="{lang:quote}" /></a>
<a href="javascript:abc_insert('[php]','[/php]','{var:textarea}','')" title="{lang:php}"><img src="{page:path}symbols/{var:imgpath}/openoffice/lc_sourcecode.{var:ext}" alt="{lang:php}" /></a>
<a href="javascript:abc_insert('[list][*]','[/list]','{var:textarea}','')" title="{lang:list}"><img src="{page:path}symbols/{var:imgpath}/openoffice/lc_list.{var:ext}" alt="{lang:list}" /></a>
<a href="javascript:abc_insert('[img]','[/img]','{var:textarea}','')" title="{lang:image}"><img src="{page:path}symbols/{var:imgpath}/openoffice/lc_grafmode.{var:ext}" alt="{lang:image}" /></a>
<a href="javascript:abc_insert('[url]','[/url]','{var:textarea}','')" title="{lang:link}"><img src="{page:path}symbols/{var:imgpath}/openoffice/lc_openurl.{var:ext}" alt="{lang:link}" /></a>
<a href="javascript:abc_insert('[mail]','[/mail]','{var:textarea}','')" title="{lang:mail}"><img src="{page:path}symbols/{var:imgpath}/openoffice/lc_sendmail.{var:ext}" alt="{lang:mail}" /></a>
<a href="javascript:abc_insert('[clip={lang:more}]','[/clip]','{var:textarea}','')" title="{lang:clip}"><img src="{page:path}symbols/{var:imgpath}/openoffice/lc_datainrows.{var:ext}" alt="{lang:clip}" /></a>
<a href="javascript:abc_insert('[threadid=X]','[/threadid]','{var:textarea}','')" title="{lang:thread}"><img src="{page:path}symbols/{var:imgpath}/openoffice/lc_inserthyperlink.{var:ext}" alt="{lang:thread}" /></a>
{if:html}<a href="javascript:abc_insert('[html]','[/html]','{var:textarea}','')" title="{lang:html}"><img src="{page:path}symbols/{var:imgpath}/openoffice/lc_editdoc.{var:ext}" alt="{lang:html}" /></a>{stop:html}
<br />

<select name="size_{var:textarea}"
  onchange="javascript:abc_insert('[size=' + this.form.size_{var:textarea}.options[this.form.size_{var:textarea}.selectedIndex].value + ']','[/size]','{var:textarea}');this.selectedIndex=0">
  <option value="">{lang:font_size}</option>
  <option value="8">{lang:tiny}</option>
  <option value="10">{lang:small}</option>
  <option value="12">{lang:medium}</option>
  <option value="18">{lang:large}</option>
  <option value="24">{lang:giant}</option>
</select>

<select name="color_{var:textarea}"
  onchange="javascript:abc_insert('[color=' + this.form.color_{var:textarea}.options[this.form.color_{var:textarea}.selectedIndex].value + ']','[/color]','{var:textarea}');this.selectedIndex=0">
  <option value="">{lang:font_color}</option>
  <option value="aqua" style="color: aqua">{lang:aqua}</option>
  <option value="black" style="color: black">{lang:black}</option>
  <option value="blue" style="color: blue">{lang:blue}</option>
  <option value="fuchsia" style="color: fuchsia">{lang:fuchsia}</option>
  <option value="gray" style="color: gray">{lang:gray}</option>
  <option value="green" style="color: green">{lang:green}</option>
  <option value="lime" style="color: lime">{lang:lime}</option>
  <option value="maroon" style="color: maroon">{lang:maroon}</option>
  <option value="navy" style="color: navy">{lang:navy}</option>
  <option value="olive" style="color: olive">{lang:olive}</option>
  <option value="orange" style="color: orange">{lang:orange}</option>
  <option value="purple" style="color: purple">{lang:purple}</option>
  <option value="red" style="color: red">{lang:red}</option>
  <option value="silver" style="color: silver">{lang:silver}</option>
  <option value="teal" style="color: teal">{lang:teal}</option>
  <option value="white" style="color: white">{lang:white}</option>
  <option value="yellow" style="color: yellow">{lang:yellow}</option>
</select>
<br />