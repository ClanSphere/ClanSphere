var Clansphere = {
  ajax: {
    hash: '#',
    scrollTarget: '',
    baseFile: '',
    basePath: '',
    index: '',
    documentTitle: '',
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
      contentSelector: '#csp_content',
      spinnerTargetSelector: 'body',
      loadingSpinnerPath: '/uploads/ajax/loading.gif',
      debugSelector: '#debug',
      debugNavlistRequets: false,
      alertErrors: false,
      anchorMarker: '::scrollTo:',
      scrollDuration: 1000,
      activityCheckTime: 60000,
      navlistSelector: '.cs_navlist',
      navlistIdPrefix: 'cs_navlist_',
      noAjaxClass: 'noajax',
      uploadScript: 'upload.php',
      labelUploadDelete: 'Delete',
      labelUploadProgress: 'Uploading File...',
      errorUploadProgress: 'Upload still in progress! Formular can not be submitted until the file is uploaded completly.',
      uploadFailedMessage: 'Upload failed! Please try again'
    },
    
    active_upload_count: 0,
    
    initialize: function(modRewrite, basepath, reloadInterval) {
      
      Clansphere.ajax.documentTitle = document.title;
      
      Clansphere.ajax.options.refreshNavlistsInterval = reloadInterval;
      Clansphere.ajax.urlChecker = window.setInterval(Clansphere.ajax.checkURL, Clansphere.ajax.options.checkURLInterval);
      Clansphere.ajax.switchNavlistRefresher(true);
      
      Clansphere.ajax.modRewrite = modRewrite ? true : false;

      var basePathRegExp = new RegExp("(.*?)\/([a-z]*?)\.php","g");

      Clansphere.ajax.baseFile = basepath;
      Clansphere.ajax.basePath = basepath.replace(basePathRegExp, '$1');
      Clansphere.ajax.index = basepath.replace(basePathRegExp, "$2");
      
      if(!Clansphere.ajax.modRewrite) {
        Clansphere.ajax.regex = new RegExp("^(?:.*?)??" + Clansphere.ajax.baseFile + "\\??(.+?)$","g");
      } else {
        Clansphere.ajax.regex = new RegExp("^(?:.*?)??" + Clansphere.ajax.basePath + '/' + Clansphere.ajax.index + "/?(.+?)$","g");
      }
      
      Clansphere.ajax.checkUrlConsistency();
      
      Clansphere.ajax.options.loadingImage.attr('src', Clansphere.ajax.basePath + Clansphere.ajax.options.loadingSpinnerPath );
      
      Clansphere.ajax.convertLinksToAnchor('body');
      Clansphere.ajax.convertForms('body');
      Clansphere.ajax.navlists = Clansphere.ajax.getNavlists('body');
      
      Clansphere.ajax.trackActivity();
      
      $(Clansphere.ajax.options.debugSelector).before('<p><a href="#" onclick="Clansphere.ajax.debugInfo();return false;">Ajax Debugger</a></p>');
      
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
        Clansphere.ajax.active_upload_count = 0;
    
        Clansphere.ajax.convertLinksToAnchor(Clansphere.ajax.options.contentSelector);
        Clansphere.ajax.convertForms(Clansphere.ajax.options.contentSelector);
      
        $(document).trigger(Clansphere.ajax.options.loadEventName, $(Clansphere.ajax.options.contentSelector)[0]);
      
        Clansphere.ajax.performScroll();
        
        Clansphere.ajax.documentTitle = response.title;
        
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
    
    resetTitle: function() {
      document.title = Clansphere.ajax.documentTitle;
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
      var newpath,
          ext = Clansphere.ajax.modRewrite ? '.php' : '',
          path = window.location.pathname+window.location.search,
          testconsistence = path.replace(Clansphere.ajax.basePath + '/' + Clansphere.ajax.index,'').replace('.php',ext).replace(/\/{2,}/i,'');
      
      if(testconsistence.length > 0)
      {
        if(Clansphere.ajax.modRewrite)
        {
          newpath = path
          .replace('.php','')
          .replace(Clansphere.ajax.basePath + '/' + Clansphere.ajax.index + '/', Clansphere.ajax.basePath + '/')
          .replace(Clansphere.ajax.basePath + '/' + Clansphere.ajax.index + '(.*)', Clansphere.ajax.basePath + '/$1')
          .replace(Clansphere.ajax.basePath + '/', Clansphere.ajax.basePath + '/' + Clansphere.ajax.index + Clansphere.ajax.hashMarker)
          + (window.location.hash.substr(1).length > 0 ? Clansphere.ajax.options.anchorMarker : '') + window.location.hash.substr(1);
        } else {
          newpath = Clansphere.ajax.baseFile + Clansphere.ajax.hashMarker + window.location.search.substr(1) + (window.location.hash.substr(1).length > 0 ? Clansphere.ajax.options.anchorMarker : '') + window.location.hash.substr(1);
        }
        window.location = newpath;
      }
    },
    
    convertLinksToAnchor: function (element) {
      element = $(element);
      element.find('a:not(.' + Clansphere.ajax.options.noAjaxClass + ')[href]').each(function(i,e){
        var href = e.href;
        href = href.replace(Clansphere.ajax.regex, "$1");
        var hrefsplitter = href.split(Clansphere.ajax.options.anchorMarker);
        if(hrefsplitter[0].length===0) {
          href = Clansphere.ajax.hash.substr(1) + (hrefsplitter[1] ? Clansphere.ajax.options.anchorMarker + hrefsplitter[1] : '');
          $(e).data('noreload',true);
        }
        if(e.href!==href) {
          href = href.replace(Clansphere.ajax.hashMarker, Clansphere.ajax.options.anchorMarker);
          e.href = Clansphere.ajax.hashMarker + href;
          
          $(e).bind('click', function(e) {
            if((window.location+'').indexOf(this.href)>-1 && !$(this).data('noreload')) {
              Clansphere.ajax.forceReload = true;
            }
            Clansphere.ajax.forceScroll = true;
          });
        }
      });
      
      return element;
    },
    
    convertForms: function(element) {

      
      element = $(element);
      
      element.find('form:not(.' + Clansphere.ajax.options.noAjaxClass + ') input[type=file]').change(function() {
        Clansphere.ajax.upload_file(this);
      });
      
      element.find('form:not(.' + Clansphere.ajax.options.noAjaxClass + ')').submit(function() {
        
        if(Clansphere.ajax.active_upload_count > 0) {
          alert(Clansphere.ajax.options.errorUploadProgress);
          return false;
        }
                
        var target;
        var action = $(this).attr('action');
        
        if (!Clansphere.ajax.modRewrite) {
          target = action.replace(Clansphere.ajax.regex, Clansphere.ajax.baseFile + "?$1");
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
                Clansphere.ajax.scrollTarget = 'csp_content';
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

      var loadingImage = Clansphere.ajax.options.loadingImage.hide().appendTo(Clansphere.ajax.options.spinnerTargetSelector);
      
      switch(bin) {
        case 1:
          if(Clansphere.ajax.options.spinnerTargetSelector==Clansphere.ajax.options.contentSelector) {
            loadingImage.show();
          } else {
            loadingImage.hide().fadeIn(100);
          }
          break;
        default:
          if(Clansphere.ajax.options.spinnerTargetSelector==Clansphere.ajax.options.contentSelector) {
            loadingImage.detach();
          } else {
            loadingImage.show().fadeOut(100, function() {$(this).detach();});
          }
          
      }
    },
    
    performScroll: function() {
      if(Clansphere.ajax.scrollTarget && (target = document.getElementById(Clansphere.ajax.scrollTarget))) {
        $('html, body').animate({scrollTop: $(target).offset().top}, Clansphere.ajax.options.scrollDuration);
      }
      Clansphere.ajax.forceScroll = false;
    },
    
    getNavlists: function(element) {
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
          $(document).trigger(Clansphere.ajax.options.loadEventName, nav[0]);
          Clansphere.ajax.convertLinksToAnchor('#' + Clansphere.ajax.options.navlistIdPrefix + id);
          Clansphere.ajax.convertForms('#' + Clansphere.ajax.options.navlistIdPrefix + id);
        }
      }
      Clansphere.ajax.resetTitle();
    },
    
    switchNavlistRefresher: function(status) {
      switch(status) {
        case true:
          if(Clansphere.ajax.options.refreshNavlistsInterval>0) {
            if(!Clansphere.ajax.navlistRefresher) {
              Clansphere.ajax.navlistRefresher = window.setInterval(Clansphere.ajax.refreshNavlists, Clansphere.ajax.options.refreshNavlistsInterval);
            }
            break;
          }
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
      Clansphere.ajax.checkActivity();
      
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
      } else if(Clansphere.ajax.options.alertErrors===true) alert("[Clansphere] Failed to process the XHRequest.");
    },
    
    debug: function(response) {
      if(response.debug)
      {
        $(Clansphere.ajax.options.debugSelector).html($(response.debug).html());
      }
    },
    
    debugInfo: function() {
      
      var box = $('#cspAjaxDebugInfoBox');
      
      var d = '',
          debugInfos = [
            'Clansphere.ajax.regex',
            'Clansphere.ajax.index',
            'Clansphere.ajax.basePath',
            'Clansphere.ajax.baseFile'
          ];
        
      d += '<a href="#" onclick="$(this).parent().remove();return false;">Close</a>';  
            
      d += '<h2>Ajax Debug Information</h2>';
      
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
      
      var upload_frame_div, upload_frames;
      
      if (!(upload_frame_div = document.getElementById('upload_frame_div'))) {
        upload_frame_div = $('<div/>');
        upload_frame_div.attr('id','upload_frame_div');
        upload_frame_div.css('display', 'none');
        upload_frame_div.appendTo('body');
      } else {
        upload_frame_div = $(upload_frame_div);
      }
      
      upload_frame = false;
      upload_frames = $('#upload_frame_div').find('iframe');
      for(var i = 0; i < upload_frames.size(); i++) {
        upload_frame = upload_frames.eq(i);
        break;
      }
      if(!upload_frame) {
        upload_frame = '<iframe width="0" height="0" frameborder="0" name="upload_frame_' + i + '"></iframe>';
        upload_frame_div.append(upload_frame);
        upload_frame = $('iframe[name=upload_frame_' + i + ']');
      }
      
      form = $('<form>');
      form.attr('name', 'upload_form');
      form.attr('target', upload_frame.attr('name'));
      form.attr('method', 'post');
      form.attr('action', Clansphere.ajax.basePath + '/' + Clansphere.ajax.options.uploadScript);
      form.attr("enctype","multipart/form-data");
      form.attr( "encoding", "multipart/form-data" );
      form.addClass(Clansphere.ajax.options.noAjaxClass);
      
      
      $(element).replaceWith("<div id=\"upload_"+element.name+"\">" + Clansphere.ajax.options.labelUploadProgress + "</div>");
      upload_frame_div.append(form);
      upload_name = $('<input>');
      upload_name.attr('type', 'hidden');
      upload_name.attr('name', 'upload_name');
      upload_name.attr('value', element.name);

      form.append(element);
      form.append(upload_name);
      form.submit();
    },
    
    user_autocomplete: function(field_from, field_to, path) {
      $.ajax({
        url: path + 'mods/ajax/search_users.php',
        data: 'target=' + field_from + '&term=' + $('#'+field_from).val(),
        success : function(response) {
          $('#'+field_to).html(response).show().bind('click', function(event) {
            event.stopPropagation();
          });
          $(document).bind('click', function() {
            $('#'+field_to).hide();
          });          
        }
      });
    }
  },
  
  initialize: function(modRewrite, basepath, reload) {
  
    Clansphere.ajax.initialize(modRewrite, basepath, reload);   // Activate this line for ajax
    // Clansphere.validation.initialize();
  }

};