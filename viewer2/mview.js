
// load jQuery if not loaded yet
if (typeof (jQuery) == 'undefined') {
  var fileref = document.createElement('script');
  fileref.setAttribute("type", "text/javascript");
  fileref.setAttribute("src", 'http://code.jquery.com/jquery-1.4.4.min.js');
  document.getElementsByTagName('body')[0].appendChild(fileref);

  (ready = function() {
    if ( typeof (jQuery) == 'undefined' || !jQuery) {
      return setTimeout( ready, 1 );
    } else {
      // jQuery loaded and ready
      jQuery.noConflict();
    }
  })();
}

// classes
var MView = function(settings) {
  MView.instance = this;
  this.settings = settings;
  //code for injecting CSS style
  jQuery('head').append('<link rel="stylesheet" type="text/css" href="' + settings.resurl + 'mview.css"/>');
  
  this.parse = function() {
    var html = jQuery(settings.target);
    jQuery.getJSON(settings.source, function(data) {
      if (data.error) {
        html.append('ERROR: ' + data.error + '<br/>source-url was: ' + settings.source);
      } else {
        html.html(MView.getServerHTMLCodeFor(data));
        MView.postLoad(html);
      }
    });
  };
  this.load = function() {
    this.parse();
    if (settings.refreshinterval > 0) {
      setTimeout('MView.instance.load();', settings.refreshinterval*1000);
    }
  };
};
// static methods
MView.postLoad = function(el) {
  jQuery(el).find('.mv-u.muted').append('<img class="mv-icon mv-icon-muted" src="' + settings.resurl + 'img/muted_self_12.png" alt=[m]"/>');
};

MView.stringComparer = Intl.Collator !== undefined ? new Intl.Collator : undefined;
MView.sortcompareObjName = function(a, b) {
  return MView.stringComparer !== undefined ? MView.stringComparer.compare(a.name, b.name) : a.name.localeCompare(b.name);
}
MView.sortcompareChannels = function(a, b) {
  var res = a.position - b.position;
  return res !== 0 ? res : MView.sortcompareObjName(a, b);
}

MView.getServerHTMLCodeFor = function(json) {
  var html = jQuery('<div id="mv-s' + json.id + '" class="mv-s"/>');
  html.append('<div class="mv-s-name">' + json.name + '</div>');
  html.append(MView.getChanHTMLCodeFor(json.root));
  return html;
};
MView.getChansHTMLCodeFor = function(json) {
  var html;
  if (json.length > 0) {
    html = jQuery('<ul/>').addClass('mv-chans');
    for (i in json.sort(MView.sortcompareChannels)) {
      html.append(MView.getChanHTMLCodeFor(json[i]));
    }
  }
  return html;
};
MView.getChanHTMLCodeFor = function(json) {
  var html = jQuery('<li/>').addClass("mv-c");
  html.append(jQuery('<div class="mv-c-name"/>').append(
      (json.x_connecturl == undefined ? json.name : jQuery('<a/>').attr('href', json.x_connecturl).append(json.name))));
  html.append(MView.getChansHTMLCodeFor(json.channels));
  html.append(MView.getUsersHTMLCodeFor(json.users));
  return html;
};
MView.getUsersHTMLCodeFor = function(json) {
  var html = jQuery('<ul/>').attr('class', 'mv-users');
  for (i in json.sort(MView.sortcompareObjName)) {
    html.append(MView.getUserHTMLCodeFor(json[i]));
  }
  return html;
};
MView.getUserHTMLCodeFor = function(json) {
  var el = jQuery('<li/>');
  el.addClass('mv-u');
  if (json.selfMute || json.selfDeaf || json.mute || json.deaf || json.suppress) {
    el.addClass('muted');
  }
  el.append(json.name);
  return el;
  // return '<li class="mv-u">' + json.name + '</div>';
};

// classes for data; not used atm
var Server = function(json) {
  // mandatory fields
  this.id = json.id;
  this.name = json.name;
  this.root = json.root;
  // optional fields
  this.x_connecturl = json.x_connecturl;
  this.x_uptime = json.x_uptime;
};
var Chan = function() {
  // mandatory fields
  this.id = null;
  this.parent = null;
  this.temporary = null;
  this.position = null;
  this.name = null;
  this.description = null;
  this.channels = null;
  this.users = null;
  this.links = null; // A list of IDs that name linked channels
  // optional fields
  this.x_connecturl = null;
};
var User = function() {
  // mandatory fields
  this.name = null;
  this.session = null;
  this.userid = null;
  this.channel = null;
  this.selfMute = null;
  this.selfDeaf = null;
  this.mute = null;
  this.deaf = null;
  this.suppress = null;
  // optional fields
  this.comment = null;
  this.x_texture = null;
  this.version = null;
  this.release = null;
  this.identity = null;
  this.onlinesecs = null;
  this.idlesecs = null;
  this.address = null;
  this.x_addrstring = null;
  this.recording = null;
  this.bytespersec = null;
  this.context = null;
  this.os = null;
  this.osversion = null;
  this.prioritySpeaker = null;
  this.tcponly = null;
};
