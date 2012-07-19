function check_all() {
  for(i=0;i<document.forms[0].elements.length;i++) {
      if(document.forms[0].elements[i].type=="checkbox")       {
             document.forms[0].elements[i].checked=true;
      }
   }
}
function decheck_all() {
    for(i=0;i<document.forms[0].elements.length;i++)
     {
        if(document.forms[0].elements[i].type=="checkbox")       {
             document.forms[0].elements[i].checked=false;
      }
   }
}