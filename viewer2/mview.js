
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
    targetDOMElement.innerHTML = sourcePath;
    jQuery.getJSON(
      sourcePath,
      function(data) {
        console.log('#' + jQuery(data));
        if (data.error) {
          targetDOMElement.innerHTML = 'ERROR: ' + data.error + '<br/>source-url was: ' + sourcePath;
        } else {
          targetDOMElement.innerHTML = data;
        }
      }
    );
  }
};

var server = function() {
  // mandatory fields
  this.id = null;
  this.name = null;
  this.root = null;
  // optional fields
  this.x_connecturl = null;
  this.x_uptime = null;
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
  this.channel = null;
  this.deaf = null;
  this.mute = null;
  this.name = null;
  this.selfDeaf = null;
  this.selfMute = null;
  this.session = null;
  this.suppress = null;
  this.userid = null;
  //TODO add optional fields
};
















