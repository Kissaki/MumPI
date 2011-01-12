
// load jQuery if not loaded yet
if (typeof(jQuery) == 'undefined') {
console.log('##');
  var fileref = document.createElement('script');
  fileref.setAttribute("type","text/javascript");
  fileref.setAttribute("src", 'http://code.jquery.com/jquery-1.4.4.min.js');
  document.getElementsByTagName('body')[0].appendChild(fileref);
  //TODO jQuery.noConflict();
}

mview = {};

mview.load = function(targetDOMElement, sourcePath) {
  targetDOMElement.innerHTML = sourcePath;
  jQuery.getJSON(
    sourcePath,
    function(data) {
      console.log('#' + jQuery(data));
      if (data.error) {
        targetDOMElement.innerHTML = 'ERROR: ' + data.error;
      } else {
        targetDOMElement.innerHTML = data;
      }
    }
  );
}

server = {
  this.id = null;
  this.name = null;
  this.root = 
};
chan = {
  this.parent = null;
  temporary
  position
  name
  description
  channels
};