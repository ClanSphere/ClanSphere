function cs_ajax_setcontent (request, id, onfinish, setanch) {
    
  if (request.status != 200) return;

  if (!document.getElementById(id)) { window.setTimeout(function() { cs_ajax_setcontent(request, id, onfinish); },50); return; }
  response = request.responseText;
  response = response.replace(/href=\"#([a-zA-Z0-9-_]*?)\"/g,"href=\"javascript:cs_scrollto_by_name('$1')\"");
  document.getElementById(id).innerHTML = (!mod_rewrite) ? response.replace(/href=\"([a-zA-Z0-9\/\.\-\_]*?)\?mod=(\w.+?)\"/g,"href=\"#mod=$2\"") :
    response.replace(/href=\"\/[a-zA-Z0-9\/\.\-\_]*?(content|navlists)\/(\w.+?)\"/g,"href=\"#$2\"");
		scripts = response.match(/<script(.*)src="(.+?)"(.*)?><\/script>/g); // Soll aus der Antwort die JavaScript-URLs rauslesen und dann an javascript_include uebergeben.
		if(scripts) {
			for (var i = 0; i < scripts.length; ++i)
				include_javascript(scripts[i].match(/src="(.+?)"/)[1]);
		}
  delete response;
  if (document.getElementById('ajax_js') == null && id == 'content') {
    request_cont = 0;
    if (setanch) {
      anch = "#" + document.getElementById('ajax_location').href.replace('&amp;','&');
      anch = anch.substr(anch.lastIndexOf("#"));
      window.location.hash = anch;
    }	
    document.title = document.getElementById('ajax_title').innerHTML;
  }
  if (onfinish) window.setTimeout(onfinish,0);
	window.onDomReady;
}

function include_javascript(path) {
	if(document.getElementById(path)) {
		return;	
	}
	var head = document.getElementsByTagName("head")[0];
  script = document.createElement('script');
  script.id = path;
  script.type = 'text/javascript';
  script.src = path;
  head.appendChild(script);

}

function cs_scrollto_by_name(target) {
  pos = document.getElementsByName(target)[0].offsetTop;
  window.scrollTo(0,pos);
}

function cs_ajax_getcontent(url, objectid, onfinish, params, setanch) {
  cs_ajax_request(url, function(request) { cs_ajax_setcontent(request, objectid, onfinish, setanch); }, (params) ? 'POST' : 'GET', params );
}

function cs_ajax_request (url, callback, method, params, request) {
  
  if (!request) {
    if (url.substr(0,7) == 'content') {
      if (request_cont) request_cont.abort();
      else request_cont = cs_ajax_start();
      cs_ajax_request (url, callback, method, params, request_cont);
    } else
      cs_ajax_request (url, callback, method, params, cs_ajax_start());
    return;
  }
  if (!method) method = 'GET';
  request.open (method, url, true);
    
  request.onreadystatechange = function() {
    if (request.readyState == 4) {
      request.onreadystatechange = function(){};
      callback (request);
    }
  };
  
  if(method == 'POST') {
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded; charset=UTF-8");
    request.setRequestHeader("Content-length", params.length);
    request.send(params);
  } else {
    request.send (url);
  }
}

function cs_ajax_start() {
  if (window.XMLHttpRequest) return new XMLHttpRequest();
  return (window.ActiveXObject) ? new ActiveXObject("Msxml2.XMLHTTP") : false;
}

var anch = "__START__";
var done = 1;
var debug = 0;
var away;
var lastmove;
var mod_rewrite;
var request_cont;
var active_upload_count = 0;
  
function initializeAJAX(modrewrite, navinterval) {
  cont = document.getElementsByTagName('body')[0].innerHTML;
  if (modrewrite) {
    mod_rewrite = 1;
    cont = cont.replace(/href=\"\/[a-zA-Z0-9\/\.\-\_]*?(index|debug|board)\/(\w.+)\"/g,"href=\"#$2\"");
  } else
    cont = cont.replace(/href=\"([a-zA-Z0-9\/\.\-\_]*)\?mod=(\w.+?)\"/g,"href=\"#mod=$2\"");
  document.getElementsByTagName('body')[0].innerHTML = cont;
  delete cont;
  lastmove = GetMins();
  if (window.location.href.indexOf('debug') != -1) debug = 1;
  
  window.setInterval("checkanch()",50);
  
  if (!navinterval) return;
  
  window.setInterval("updatenavs()", navinterval * 1000);
  window.setTimeout('window.onmousemove = Movement;',60000);
  window.setInterval('CheckActivity()',120000);
  window.onunload = function() { if (typeof request != "undefined") request.abort(); };
}

function checkanch() {
  anch_new = window.location.hash;
  if (anch_new == anch || anch_new == "") return;
  subanch = (!mod_rewrite) ? anch_new.substr(1) : "params=/" + anch_new.substr(1);
  if (debug) subanch += '&debug';
  url = anch != "__START__" ? 'content.php?'+ subanch : 'content.php?'+subanch+'&first';
  document.getElementById('content').innerHTML += '<img src="uploads/ajax/loading.gif" id="ajax_loading" alt="Loading.." />';
  
  cs_ajax_getcontent(url,'content', "cloaded('"+anch+"')");
  anch = anch_new;
}

function cloaded(anch) {
  forms_to_ajax();
  if (document.getElementById('ajax_js')) eval(document.getElementById('ajax_js').innerHTML);
  if (anch != "__START__") setnavs(1);
}

function updatenavs() {
  if (!done || away) return;
  if (!document.getElementById('temp_div')) {
    temp = document.createElement("div");
    temp.id = 'temp_div';
    temp.style.display = 'none';
    document.getElementsByTagName('body')[0].appendChild(temp);
  }
  done = 0;
  cs_ajax_getcontent('navlists.php','temp_div','setnavs()');
}

function setnavs(cache) {
  cnttmp = cache == 1 && document.getElementById('contenttemp') ? document.getElementById('contenttemp').innerHTML : '';
  cont = cache != 1 ? document.getElementById('temp_div').innerHTML : cnttmp;
  done = 1;
  parts = cont.split('!33/');
  for (run = 1; run < parts.length; run+=2)
    if (document.getElementById(parts[run])) document.getElementById(parts[run]).innerHTML = parts[run+1];
}

function form_to_string(form) {
  string = "";
  firstsubmit = "";
  var fields = form.elements;
  for(i=0;i<fields.length;i++) {
    switch(fields[i].type) {
      case 'text': case 'password': case 'hidden': case 'textarea':
    	  string += encodeURI(fields[i].name) + "=" + fields[i].value + "&";
        break;
      case 'submit':
        if (!firstsubmit) firstsubmit = fields[i].name; break;
      case 'radio': case 'checkbox':
        if(fields[i].checked)
          string += encodeURI(fields[i].name) + "=" + encodeURI(fields[i].value) + "&";
        break;
      case 'select-one':
        string += encodeURI(fields[i].name) + "=" + encodeURI(fields[i].options[fields[i].selectedIndex].value) + "&";
    }
  }
  clickedbutton = document.getElementById('submitbutton').innerHTML;
  ending = (!clickedbutton) ? firstsubmit + "=1" : clickedbutton + "=1";
  return string + ending;
}

function upload_complete(upload_name, file_name) {
  document.getElementById('upload_' + upload_name).innerHTML = "<a href=\"javascript:remove_file('" + upload_name + "');\">Delete</a> | " + file_name;
  active_upload_count -= 1;
}

function remove_file(upload_name) {
  cs_ajax_request ('upload.php', function(req){ remove_complete(upload_name); }, 'POST', 'remove=' + upload_name);
}

function remove_complete(upload_name) {
  element = document.getElementById('upload_' + upload_name).parentNode;
  new_file_input = document.createElement('input');
  new_file_input.type = 'file';
  new_file_input.name = upload_name;
  new_file_input.onchange = function() { upload_file(this); };
  element.innerHTML = '';
  element.appendChild(new_file_input);
}

function forms_to_ajax() {
  forms = document.getElementsByTagName('form');
  document.getElementById('content').innerHTML += '<div id="submitbutton" style="display:none"></div>';
  for(i = 0; i <forms.length; i++) {
    felements = forms[i].elements;
    for(j = 0; j < felements.length; j++) {
      switch(felements[j].type) {
        case 'submit':
          felements[j].onclick = function() { document.getElementById('submitbutton').innerHTML = this.name; };
          break;
        case 'file':
          felements[j].onchange = function() { upload_file(this); };
          break;
      }
    }
    forms[i].onsubmit = function() {
      if(active_upload_count==0) {
        document.getElementById('content').innerHTML += '<img src="uploads/ajax/loading.gif" id="ajax_loading" alt="Loading.." />';
        form_data = form_to_string(this);
        cs_ajax_getcontent(this.action.replace(/([a-zA-Z0-9\/\.\-\_\:]*)\?mod\=(\w.+)/g,"content.php?mod=$2"),'content',  "cloaded('"+anch+"')" , form_data, 1);
      } else {
        alert('Upload proccess still running');
      }
      return false;
    };
  }
}

function upload_file(element) {
  
  active_upload_count += 1;
  
  if (!document.getElementById('upload_frame_div')) {
    upload_frame_div = document.createElement("div");
    upload_frame_div.setAttribute('id','upload_frame_div');
    upload_frame_div.style.display = 'none';
    document.getElementsByTagName('body')[0].appendChild(upload_frame_div);
  }
  
  upload_frame = false;
  for(i = 0; i < document.getElementById('upload_frame_div').getElementsByTagName('iframe').length; i++) {
    upload_frame = document.getElementById('upload_frame_div').getElementsByTagName('iframe')[0];
    break;
  }
  if(!upload_frame) {
    document.getElementById('upload_frame_div').innerHTML += "<iframe width=\"0\" height=\"0\" frameborder=\"0\" name=\"upload_frame_" + i + "\"></iframe>";
    upload_frame = document.getElementsByName("upload_frame_" + i)[0];
  }
  form = document.createElement('form');
  form.name = "upload_form";
  form.target = upload_frame.name;
  form.method = "post";
  form.action = "upload.php";
  form.setAttribute("enctype","multipart/form-data");
  
  enctype = form.getAttributeNode("enctype");
  enctype.value = "multipart/form-data";
  
  element.parentNode.innerHTML = "<div id=\"upload_"+element.name+"\">Uploading file...</div>";
  document.getElementById('upload_frame_div').appendChild(form);
  upload_name = document.createElement("input");
  upload_name.type = 'hidden';
  upload_name.name = 'upload_name';
  upload_name.value = element.name;
  

  with(form) {
    appendChild(element);
    appendChild(upload_name);
    submit();
  }
}

// User activity
function GetMins() { now = new Date(); return now.getMinutes(); }

function Movement (Event) {
  lastmove = GetMins();
  away = 0;
  window.onmousemove = function() { };
  window.setTimeout('window.onmousemove = Movement;',60000);
}
function CheckActivity() { if ((GetMins() - lastmove) % 60 > 1) away = 1; }