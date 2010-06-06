var Clansphere = {
  ajax: {
    hash: '#',
    scrollTarget: '',
    baseFile: '',
    basePath: '',
    index: '',
    modRewrite: false,
    forceReload: false,
    forceScroll: false,
    navlists: '',
    last_activity: 0,
    userIsActive: true,
    urlChecker: null,
    navlistRefresher: null,
    navlistPaused: false,
    regex: null,
    loadingImage: null,
    hashMarker: '#',
    options: {
      loadEventName: 'csAjaxLoad',
      checkURLInterval: 50,
      refreshNavlistsInterval: 10000,
      loadingImage: $('<img id="ajax_loading" alt="Loading..." />'),
      contentSelector: "#content",
      debugSelector: '#debug',
      debugNavlistRequets: false,
      anchorMarker: '::scrollTo:',
      scrollDuration: 1000,
      activityCheckTime: 60000,
      navlistSelector: '.cs_navlist',
      navlistIdPrefix: 'cs_navlist_',
      uploadScript: 'upload.php',
      labelUploadDelete: 'Delete',
      labelUploadProgress: 'Uploading File...',
      errorUploadProgress: 'Upload still in progress! Formular can not be sumited until file is uploaded completly.',
      uploadFailedMessage: 'Upload failed! Please try again'
    },
    
    active_upload_count: 0,
    
    initialize: function(modRewrite, basepath) {
      
      Clansphere.ajax.urlChecker = window.setInterval(Clansphere.ajax.checkURL, Clansphere.ajax.options.checkURLInterval);
      Clansphere.ajax.switchNavlistRefresher(true);
      
      Clansphere.ajax.modRewrite = modRewrite ? true : false;

      var basePathRegExp = new RegExp("(.*?)\/([a-z]*?)\.php","g");

      Clansphere.ajax.baseFile = basepath;
      Clansphere.ajax.basePath = basepath.replace(basePathRegExp, '$1');
      Clansphere.ajax.index = basepath.replace(basePathRegExp, "$2");
      
      if(!Clansphere.ajax.modRewrite) {
        Clansphere.ajax.regex = new RegExp("^(?:[a-zA-Z0-9\/\.\-\_\:]*)?\?mod=(.+?)$","g");
      } else {
        Clansphere.ajax.regex = new RegExp("^(?:[a-zA-Z0-9\/\.\-\_\:]*)?" + Clansphere.ajax.basePath + '/' + Clansphere.ajax.index + "/?(.+?)$","g")
      }
      
      Clansphere.ajax.checkUrlConsistency();
      
      Clansphere.ajax.options.loadingImage.attr('src', Clansphere.ajax.basePath + '/uploads/ajax/loading.gif' );
      
      Clansphere.ajax.convertLinksToAnchor('body');
      Clansphere.ajax.convertForms('body');
      Clansphere.ajax.navlists = Clansphere.ajax.getNavlists('body');
      
      Clansphere.ajax.trackActivity();
      
    },

    updatePage: function (response) {
      Clansphere.ajax.forceReload = false;
      
      Clansphere.ajax.hash = Clansphere.ajax.hashMarker + response.location;
      if(Clansphere.ajax.scrollTarget) {
        window.location.hash = Clansphere.ajax.hash + Clansphere.ajax.options.anchorMarker + Clansphere.ajax.scrollTarget;
      } else {
        window.location.hash = Clansphere.ajax.hash;
      }
      
      if(!response.reload) {
        $(Clansphere.ajax.options.contentSelector).html(response.content);
        
    
        Clansphere.ajax.convertLinksToAnchor(Clansphere.ajax.options.contentSelector);
        Clansphere.ajax.convertForms(Clansphere.ajax.options.contentSelector);
      
        $(Clansphere.ajax.options.contentSelector).trigger(Clansphere.ajax.options.loadEventName);
      
        document.title = response.title;
      
        Clansphere.ajax.performScroll();
        
        if(response.navlists) {
          Clansphere.ajax.updateNavlists(response.navlists);
        }
      
        Clansphere.ajax.debug(response);
      
        if (response.scripts) eval(response.scripts);
        Clansphere.ajax.switchNavlistRefresher(true);

        
        Clansphere.ajax.toggleSpinner(0);
      }
      
      
      else
      {
        window.location.reload();
      }
    },

    checkURL: function() {
      var hash = window.location.hash.substr(1).split(Clansphere.ajax.options.anchorMarker);
      hash[0] = hash[0] || '';
      
      
      
      if (Clansphere.ajax.hashMarker + hash[0] == Clansphere.ajax.hash && Clansphere.ajax.forceReload!==true)  {
        if(hash[1]!==Clansphere.ajax.scrollTarget || Clansphere.ajax.forceScroll===true) {
          Clansphere.ajax.scrollTarget = hash[1];
          Clansphere.ajax.performScroll();
        }
        return;
      }
      
      Clansphere.ajax.switchNavlistRefresher(false);
      
      if(hash[1]) {
        Clansphere.ajax.scrollTarget = hash[1];
      } else {
        Clansphere.ajax.scrollTarget = '';
      }
      
      Clansphere.ajax.forceReload = false;
      if (Clansphere.ajax.hash != '') Clansphere.ajax.toggleSpinner(1);
      
      Clansphere.ajax.hash = Clansphere.ajax.hashMarker + hash[0];

      var prefix = !Clansphere.ajax.modRewrite ? "" : "params=/";
      
      $.ajax({
            type: 'GET',
            url: Clansphere.ajax.baseFile,
            data: prefix + Clansphere.ajax.hash.substr(1) + "&xhr=1" + Clansphere.ajax.navlists,
            dataType: 'json',
            success: Clansphere.ajax.updatePage,
            error: Clansphere.ajax.errorHandler
      });
    },
    
    checkUrlConsistency: function() {
      var testconsistence = window.location.pathname.replace(Clansphere.ajax.basePath + '/' + Clansphere.ajax.index,'').replace(Clansphere.ajax.basePath, '').replace('/','').replace('.php','');
      
      if(testconsistence.length > 0)
      {
        var newpath = window.location.pathname.replace(Clansphere.ajax.basePath + '/' + Clansphere.ajax.index + '/', Clansphere.ajax.basePath + '/' + Clansphere.ajax.index + Clansphere.ajax.hashMarker);
        window.location = newpath;
        return;
      }
      if(window.location.search) {
        window.location = window.location.pathname + Clansphere.ajax.hashMarker + window.location.search.substr(1);
      }
    },
    
    convertLinksToAnchor: function (element) {
      element = $(element);
      element.find('a:not(.noajax)[href]').each(function(i,e){
        var href = e.href;
        href = href.replace(Clansphere.ajax.hashMarker, Clansphere.ajax.options.anchorMarker);
        if (!Clansphere.ajax.modRewrite) {
          href = href.replace(Clansphere.ajax.regex, "mod=$1"); 
        } else {
      	  href = href.replace(Clansphere.ajax.regex, "$1");
        }
        var hrefsplitter = href.split(Clansphere.ajax.options.anchorMarker);
        if(hrefsplitter[1] && hrefsplitter[0].length===0) {
          href = Clansphere.ajax.hash.substr(1) + Clansphere.ajax.options.anchorMarker + hrefsplitter[1];
          $(e).data('noreload',true);
        }
        e.href = Clansphere.ajax.hashMarker + href;
      }).bind('click', function(e) {
        if(this.href.substr(0,7)=='http://' && !$(this).data('noreload')) {
  	      Clansphere.ajax.forceReload = true;
  	    }
  	    Clansphere.ajax.forceScroll = true;
  	  });
      
      return element;
    },
    
    convertForms: function(element) {

      
      element = $(element);
      
      element.find('input[type=file]').change(function() {
        Clansphere.ajax.upload_file(this);
      });
      
      element.find('form:not(.noajax)').submit(function() {
        
        if(Clansphere.ajax.active_upload_count > 0) {
          alert(Clansphere.ajax.options.errorUploadProgress);
          return false;
        }
                
        var target;
        var action = $(this).attr('action');
        
        if (!Clansphere.ajax.modRewrite) {
          target = action.replace(Clansphere.ajax.regex, Clansphere.ajax.baseFile + "?mod=$1");
        } else {
      	  target = action.replace(Clansphere.ajax.regex, Clansphere.ajax.baseFile + "?params=/$1");
        }
        
        Clansphere.ajax.switchNavlistRefresher(false);
        Clansphere.ajax.toggleSpinner(1);
        $.ajax({
              type: 'POST',
              url: target,
              data: $(this).serialize() + ('&' + $(this).data('ajax_submit_button') + '=1&xhr=1' + Clansphere.ajax.navlists),
              dataType: 'json',
              success: function(response){
                Clansphere.ajax.scrollTarget = 'content';
                Clansphere.ajax.updatePage(response);
              },
              error: Clansphere.ajax.errorHandler
          });

          return false;
      });

      element.find('input').click(function() {
        if($(this).attr('type') == 'submit') {
          $(this.form).data('ajax_submit_button',$(this).attr('name'))
        }
      });
      
      return element;
      
    },
    
    toggleSpinner: function(bin){

      loadingImage = Clansphere.ajax.options.loadingImage.appendTo(Clansphere.ajax.options.contentSelector).hide();
      
      switch(bin) {
        case 1:
          loadingImage.fadeIn(10);
          break;
        case 0:
        default:
          loadingImage.fadeOut(10).remove();
      }
    },
    
    performScroll: function() {
      if(Clansphere.ajax.scrollTarget) {
        $('html, body').animate({scrollTop: $('#' + Clansphere.ajax.scrollTarget).offset().top}, Clansphere.ajax.options.scrollDuration);
      }
      Clansphere.ajax.forceScroll = false;
    },
    
    getNavlists: function(element)
    {
      navlists = [];
      $(element).find(Clansphere.ajax.options.navlistSelector).each(function(index) {
        navlists.push(this.id.substr(Clansphere.ajax.options.navlistIdPrefix.length));
      });
      if(navlists.length)
        return '&xhr_navlists=' + navlists.join(',');
      else return '';
    },
    
    refreshNavlists: function() {   
      if(!Clansphere.ajax.checkActivity() || !Clansphere.ajax.navlists || Clansphere.ajax.navlistPaused) {
        return null;
      }
      
      $.ajax({
        type: 'GET',
        url: '?xhr=1&xhr_nocontent=1' + Clansphere.ajax.navlists,
        dataType: 'json',
        success: function(response){
          Clansphere.ajax.updateNavlists(response.navlists);
          if(Clansphere.ajax.options.debugNavlistRequets===true)
          {
            Clansphere.ajax.debug(response);
          }
        },
        error: Clansphere.ajax.errorHandler
      });
    },
    
    updateNavlists: function(navlists) {
      var nav;
      for(id in navlists) {
        if(nav = $(document.getElementById(Clansphere.ajax.options.navlistIdPrefix + id))) {
          nav.html(navlists[id]);
          nav.trigger(Clansphere.ajax.options.loadEventName);
          Clansphere.ajax.convertLinksToAnchor('#' + Clansphere.ajax.options.navlistIdPrefix + id);
          Clansphere.ajax.convertForms('#' + Clansphere.ajax.options.navlistIdPrefix + id);
        }
      }
    },
    
    switchNavlistRefresher: function(status) {
      switch(status) {
        case true:
          if(!Clansphere.ajax.navlistRefresher) {
            Clansphere.ajax.navlistRefresher = window.setInterval(Clansphere.ajax.refreshNavlists, Clansphere.ajax.options.refreshNavlistsInterval);
          }
          break;
        case false:
        default:
          if(Clansphere.ajax.navlistRefresher) {
            window.clearInterval(Clansphere.ajax.navlistRefresher);
            Clansphere.ajax.navlistRefresher = null;
          }
      }
    },
    
    trackActivity: function() {
      $(window).unbind('mousemove');
      
      Clansphere.ajax.lastActivity = new Date().getMinutes();
      Clansphere.ajax.checkActivity;
      
      window.setTimeout(function() {
        $(window).bind('mousemove', Clansphere.ajax.trackActivity);
      }, Clansphere.ajax.options.activityCheckTime);
    },
    
    checkActivity: function() {
      Clansphere.ajax.userIsActive = ((new Date().getMinutes() - Clansphere.ajax.lastActivity) > 1) ? false : true;
      return Clansphere.ajax.userIsActive;
    },
    
    errorHandler: function(xhr, textStatus, error) {
      Clansphere.ajax.toggleSpinner(0);
      if($(Clansphere.ajax.options.debugSelector).size() > 0)
      {
        more = '';
        if(console) {
          more = ' - Check Firebug for further details.';
          console.error("[Clansphere] Failed to process the XHRequest(Type:" + textStatus + "). Check out the Request Object:\n", xhr);
        }
        $(Clansphere.ajax.options.debugSelector + ' #errors').prepend('<strong>XHRequest Error:</strong> ' + textStatus + ' [HttpStatus: ' + xhr.status + ']' + more + '\n<br/>\n<br/>');
        $('html, body').animate({scrollTop: 0 }, 100);
      } else alert("[Clansphere] Failed to process the XHRequest.");
    },
    
    debug: function(response) {
      if(response.debug)
      {
        $(Clansphere.ajax.options.debugSelector).replaceWith(response.debug);
      }
    },
    
    debugInfo: function() {
      
      var box = $('#cspAjaxDebugInfoBox');
      
      var d = '',
          debugInfos = [
            'Clansphere.ajax.regex',
            'Clansphere.ajax.index',
            'Clansphere.ajax.basePath',
            'Clansphere.ajax.baseFile',
            'Clansphere.ajax.regex'
          ];
            
      d += '<h2>Ajax Debug Information</h2>';
      
      d += '<a href="#" onclick="javascript:$(this).parent().remove();">Close</a>';
      
      for(dbg in debugInfos) {
        d += '<p><b>' + debugInfos[dbg] + ':</b><br/>' + eval(debugInfos[dbg]) + '</p>';
      }
            
      if(box.size()==0)
        $('<div id="cspAjaxDebugInfoBox"/>').css({position:'absolute', left:'5%', top: '5%', width: '86%', background: '#fff', padding: '2%', border:'5px solid #666'}).html(d).appendTo('body');
      else
        box.html(d);
    },
    
    upload_complete: function(upload) {
      if(upload.error) {
        Clansphere.ajax.remove_complete(upload.name);
        alert(Clansphere.ajax.options.uploadFailedMessage);
      } else {
        document.getElementById('upload_' + upload.name).innerHTML = "<a href=\"javascript:Clansphere.ajax.remove_file('" + upload.name + "');\">" + Clansphere.ajax.options.labelUploadDelete  + "</a> | " + upload.original_name + ' (' + upload.size + ')';
      }
      Clansphere.ajax.active_upload_count -= 1;
    },

    remove_file: function(upload_name) {
      $.ajax({
            type: 'POST',
            url: Clansphere.ajax.basePath + '/' + Clansphere.ajax.options.uploadScript,
            data: {'remove': upload_name},
            success: Clansphere.ajax.remove_complete(upload_name)
      });
    },

    remove_complete: function(upload_name) {
      element = document.getElementById('upload_' + upload_name);
      new_file_input = document.createElement('input');
      new_file_input.type = 'file';
      new_file_input.name = upload_name;
      new_file_input.onchange = function() { Clansphere.ajax.upload_file(this); };
      element.innerHTML = '';
      $(element).html(new_file_input);
    },
    
    upload_file: function(element) {

      Clansphere.ajax.active_upload_count += 1;

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
      form.action = Clansphere.ajax.basePath + '/' + Clansphere.ajax.options.uploadScript;
      form.setAttribute("enctype","multipart/form-data");

      enctype = form.getAttributeNode("enctype");
      enctype.value = "multipart/form-data";

      $(element).replaceWith("<div id=\"upload_"+element.name+"\">" + Clansphere.ajax.options.labelUploadProgress + "</div>");
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
    },
    
    user_autocomplete: function(field_from, field_to, path) {
    	$.ajax({
    		url: path + 'mods/ajax/search_users.php',
        data: 'target=' + field_from + '&term=' + $('#'+field_from).val(),
    		success : function(response) {
    			$('#'+field_to).html(response).show().bind('click', function() {
    			  event.stopPropagation();
    			});
    			$(document).bind('click', function() {
    				$('#'+field_to).hide();
    			});    			
    		}
    	});
    }
  },
/*
  validation: {
    mod: {
      name: '',
      rules: {}
    },
    lang: 0,

    options: {
      valideClass: 'valide',
      invalideClass: 'invalide',
      errorMsgClass: 'error'
    },

    initialize: function() {

      $('input, textarea').live( 'keyup', function () {
        input_field = $(this)
        if(Clansphere.validation.mod.rules[ input_field.attr('name')]) {
          field = Clansphere.validation.mod.rules[input_field.attr('name')];
          value = input_field.attr('value');
          if (!value && !field.min){ Clansphere.validation.mark_as_valide(this); }

          if (field.min && value.length < field.min){ Clansphere.validation.mark_as_invalide(this, 'min'); return;}
          if (field.max && value.length > field.max){ Clansphere.validation.mark_as_invalide(this, 'max'); return;}
          if (field.regex) {
              end = field.regex.lastIndexOf($(field).attr('regex').substr(0,1));
              pattern = field.regex.substr(1,end - 1);
              modifiers = field.regex.substr(end + 1);
              
              if (!new RegExp(pattern, modifiers).test(value)){ Clansphere.validation.mark_as_invalide(this, 'regex'); return;}
          }

          Clansphere.validation.mark_as_valide(this);
        }
      });
    },

    requestRules: function(mod) {

      if (Clansphere.validation.mod.name == mod) return false;
      
      Clansphere.validation.mod.name = mod;
      if(Clansphere.validation.lang==0) {
        $.ajax({
            type: 'GET',
            url: 'mods/ajax/validation.php',
            data: mod,
            dataType: 'json',
            success: function (json) { 
              Clansphere.validation.mod.name = mod
              Clansphere.validation.mod.rules = json.data;
              Clansphere.validation.lang = json.translations;
            }
        });
      } else {
        $.ajax({
            type: 'GET',
            url: 'mods/' + mod + '/config.json',
            dataType: 'json',
            success: function (json) { 
              Clansphere.validation.mod.rules = json.data; 
            }
        });
      }
      return true;
    },
       
    mark_as_invalide: function(element, error) {
      options = Clansphere.validation.options;
      element = $(element);
      
      
      if(element.next('.' + options.errorMsgClass).size() == 0) {
        element.after('<div class="' + options.errorMsgClass + '">');
      }
      element.removeClass(options.valideClass)
             .addClass(options.valideClass)
             .next('.' + options.errorMsgClass)
             .text(Clansphere.validation.lang[error]);
             
      return element;
    },
    
    mark_as_valide: function (element) {
      element = $(element);
      options = Clansphere.validation.options;
      element.removeClass(options.invalideClass)
           .addClass(options.valideClass)
           .next('.' + options.errorMsgClass)
           .text('');
           
      return element;
    }


  },
*/
  initialize: function(modRewrite, basepath, reload) {
	
    Clansphere.ajax.initialize(modRewrite, basepath);   // Activate this line for ajax
    // Clansphere.validation.initialize();
  }

};

$(function() {
   //Clansphere.initialize();
});