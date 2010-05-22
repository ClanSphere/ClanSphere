var Clansphere = {
  ajax: {
    hash: '',
    scrollTarget: '',
    base: '',
    index: '',
    mod_rewrite: false,
    forceReload: false,
    options: {
      checkURLInterval: 50,
      loadingImage: '<img src="uploads/ajax/loading.gif" id="ajax_loading" alt="Loading..." />',
      contentSelector: "#content",
      debugSelector: '#debug',
      label_upload_delete: 'Delete',
      label_upload_progress: 'Uploading File...',
      error_upload_progress: 'Upload still in progress! Formular can not be sumited until file is uploaded completly.'
    },
    
    active_upload_count: 0,
    
    initialize: function(mod_rewrite, basepath) {

      window.setInterval(Clansphere.ajax.checkURL, Clansphere.ajax.options.checkURLInterval);
      
      Clansphere.ajax.mod_rewrite = mod_rewrite ? true : false;
      
      Clansphere.ajax.base = basepath;
      Clansphere.ajax.index = basepath.replace(/.*?\/([a-z]*?)\.php/g, "$1");

      Clansphere.ajax.convertLinksToAnchor('body');
      Clansphere.ajax.convertForms('body');
      
    },

    updatePage: function (response) {
      Clansphere.ajax.forceReload = false;
      
      Clansphere.ajax.hash = "#" + response.location;
      if(Clansphere.ajax.scrollTarget) {
        window.location.hash = Clansphere.ajax.hash + '#' + Clansphere.ajax.scrollTarget;
      } else {
        window.location.hash = Clansphere.ajax.hash;
      }
      
      $(Clansphere.ajax.options.contentSelector).html(response.content);
    
      Clansphere.ajax.convertLinksToAnchor(Clansphere.ajax.options.contentSelector);
      Clansphere.ajax.convertForms(Clansphere.ajax.options.contentSelector);
      document.title = response.title;
      if (response.scripts) window.setTimeout(function(){ eval(response.scripts); }, 0);
      for (navlist in response.navlists) $("#"+navlist).html(response.navlists[navlist]);
      if(Clansphere.ajax.scrollTarget) {
        $('html, body').animate({scrollTop: $('#' + Clansphere.ajax.scrollTarget).offset().top}, 1000);
      }
      if(response.debug)
      {
        $(Clansphere.ajax.options.debugSelector).replaceWith(response.debug);
      }
    },

    checkURL: function() {
      var hash = window.location.hash.split('#');
      hash[1] = hash[1] || '';
      if ('#' + hash[1] == Clansphere.ajax.hash && Clansphere.ajax.forceReload!==true) return;
      Clansphere.ajax.forceReload = false;
      if (Clansphere.ajax.hash != '') $(Clansphere.ajax.options.contentSelector).append(Clansphere.ajax.options.loadingImage);
      
      Clansphere.ajax.hash = '#' + hash[1];
      if(hash[2]) {
        Clansphere.ajax.scrollTarget = hash[2];
      } else {
        Clansphere.ajax.scrollTarget = '';
      }
      var prefix = !Clansphere.ajax.mod_rewrite ? "" : "params=/";
      
      //Clansphere.validation.requestRules(mod);
      $.ajax({
            type: 'GET',
            url: Clansphere.ajax.base,
            data: prefix + Clansphere.ajax.hash.substr(1) + "&xhr=1",
            dataType: 'json',
            success: Clansphere.ajax.updatePage,
            error: Clansphere.ajax.errorHandler
      });
    },
    
    convertLinksToAnchor: function (element) {
      element = $(element);
      element.find('a').each(function(i,e){
        if(!$(e).hasClass('noajax')) {
          if (!Clansphere.ajax.mod_rewrite) {
            e.href = e.href.replace(/([a-zA-Z0-9\/\.\-\_\:]*?)\?mod=(\w.+?)/g, "#mod=$2");
          } else {
        	var regexp = new RegExp("^[a-zA-Z0-9\/\.\-\_\:]*?/" + Clansphere.ajax.index + "/(.+?)","g");
        	e.href = e.href.replace(regexp, "#$1");
          }
        }
      }).click(function(e) {
        if(this.href.substr(0,7)=='http://') {
    	    Clansphere.ajax.forceReload = true;
    	  }
    	});
      
      element
      
      return element;
    },
    
    convertForms: function(element) {

      
      element = $(element);
      
      element.find('input[type=file]').change(function() {
        Clansphere.ajax.upload_file(this);
      });
      
      element.find('form').submit(function() {
        if(Clansphere.ajax.active_upload_count > 0) {
          alert(Clansphere.ajax.options.error_upload_progress);
          return false;
        }
                
        var target;
        var action = $(this).attr('action');
        
        if (!Clansphere.ajax.mod_rewrite) {
          target = action.replace(/([a-zA-Z0-9\/\.\-\_\:]*?)\?mod=(\w.+?)/g, "$1?mod=$2");
        } else {
      	  var regexp = new RegExp("^[a-zA-Z0-9\/\.\-\_\:]*?/" + Clansphere.ajax.index + "/(.+?)","g");
      	  target = action.replace(regexp, "?params=/$1");
        }
        
        $.ajax({
              type: 'POST',
              url: target,
              data: $(this).serialize() + ('&' + $(this).data('ajax_submit_button') + '=1&xhr=1'),
              dataType: 'json',
              success: function(response){
                Clansphere.ajax.scrollTarget = 'content';
                Clansphere.ajax.updatePage(response);
                Clansphere.ajax.scrollTarget = '';
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
    
    errorHandler: function(xhr) {
      try { console.log("There was in error in processing the XHRequest. Check out the Request Object:\n", xhr); $('#ajax_loading').fadeOut(); } catch(e) { alert("There was in error in processing the XHRequest."); }
      if($(Clansphere.ajax.options.debugSelector).size() > 0)
      {
      $(Clansphere.ajax.options.debugSelector + ' #errors').prepend('<span>Error in XHRequest!</span>\n<br/>\n<br/>');
      $('html, body').animate({scrollTop: 0 }, 300);
      }
    },
    
    upload_complete: function(upload_name, file_name) {
      document.getElementById('upload_' + upload_name).innerHTML = "<a href=\"javascript:Clansphere.ajax.remove_file('" + upload_name + "');\">" + Clansphere.ajax.options.label_upload_delete  + "</a> | " + file_name;
      Clansphere.ajax.active_upload_count -= 1;
    },

    remove_file: function(upload_name) {
      $.ajax({
            type: 'POST',
            url: 'upload.php',
            data: {'remove': upload_name},
            success: Clansphere.ajax.remove_complete(upload_name)
      });
    },

    remove_complete: function(upload_name) {
      element = document.getElementById('upload_' + upload_name).parentNode;
      new_file_input = document.createElement('input');
      new_file_input.type = 'file';
      new_file_input.name = upload_name;
      new_file_input.onchange = function() { upload_file(this); };
      element.innerHTML = '';
      element.appendChild(new_file_input);
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
      form.action = "upload.php";
      form.setAttribute("enctype","multipart/form-data");

      enctype = form.getAttributeNode("enctype");
      enctype.value = "multipart/form-data";

      element.parentNode.innerHTML = "<div id=\"upload_"+element.name+"\">" + Clansphere.ajax.options.label_upload_progress + "</div>";
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
    			$('#'+field_to).html(response)
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
  initialize: function(mod_rewrite, basepath, reload) {
	
    Clansphere.ajax.initialize(mod_rewrite, basepath);   // Activate this line for ajax
    // Clansphere.validation.initialize();
  }

};

$(function() {
   //Clansphere.initialize();
});