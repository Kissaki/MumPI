
// load jQuery if not loaded yet
if (typeof(jQuery) == 'undefined') {
console.debug('Loading jQuery.');
  var fileref = document.createElement('script');
  fileref.setAttribute("type","text/javascript");
  fileref.setAttribute("src", 'http://code.jquery.com/jquery-1.4.4.min.js');
  document.getElementsByTagName('body')[0].appendChild(fileref);
  //TODO jQuery.noConflict();
}

var MView = function(){
  this.load = function(targetDOMElement, sourcePath) {
    //TODO server id as param, add to ID
    html = jQuery(targetDOMElement);
    jQuery.getJSON(
      sourcePath,
      function(data) {
        if (data.error) {
          targetDOMElement.innerHTML = 'ERROR: ' + data.error + '<br/>source-url was: ' + sourcePath;
        } else {
          html.append(MView.getServerHTMLCodeFor(data));
          console.debug('#loadEND');
        }
      }
    );
  }
  
};
// static methods
MView.getServerHTMLCodeFor = function(json) {
  var html = jQuery('<div id="mv-s' + json.id + '" class="mv-s"/>');
  html.append('<div class="mv-s-name">' + json.name + '</div>');
console.log('#');
console.log(MView.getChanHTMLCodeFor(json.root));
  html.append(MView.getChanHTMLCodeFor(json.root));
console.log(html);
  return html;
}
MView.getChansHTMLCodeFor = function(json) {
console.debug('^getChansHTMLCodeFor' + json);
  var html = jQuery('<div/>').addClass('mv-chans');
  for (i in json) {
    html.append(MView.getChanHTMLCodeFor(json[i]));
  }
console.log(html);
  return html;
}
MView.getChanHTMLCodeFor = function(json) {
console.debug('^getChanHTMLCodeFor' + json);
  var html = jQuery('<div/>').addClass("mv-c");
  html.append('<div class="mv-c-name">' + json.name + '</div>');
  html.append(MView.getChansHTMLCodeFor(json.channels));
  html.append(MView.getUsersHTMLCodeFor(json.users));
console.log(html);
  return html;
}
MView.getUsersHTMLCodeFor = function(json) {
console.debug('^getUsersHTMLCodeFor' + json);
  var html = jQuery('<div/>').attr('class', 'mv-users');
  for (i in json) {
    html.append(MView.getUserHTMLCodeFor(json[i]));
  }
  return html;
}
MView.getUserHTMLCodeFor = function(json) {
console.debug('^getUserHTMLCodeFor' + json);
  return '<div class="mv-u">' + json.name + '</div>';
}


var Server = function(json) {
  // mandatory fields
  this.id = json.id;
  this.name = json.name;
  this.root = json.root;
  // optional fields
  this.x_connecturl = json.x_connecturl;
  this.x_uptime = json.x_uptime;
};
chan = function() {
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
user = function() {
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
  //TODO add optional fields
};
















