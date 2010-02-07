/*
 * jQuery EZ Tip plugin
 * Version 0.1  (12/06/2008)
 * @requires jQuery v1.2.6+
 * @author Karl Swedberg
 *
 * Dual licensed under the MIT and GPL licenses:
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
 *
 * @method :
 * .eztip(target, options)
 *
 * @arguments : 
 * 
 **  @target (selector string) mandatory
 **     
 **  @options (object) optional
 **     opacity: 1,  // float. number between 0.1 and 1.0. level of opacity of the tooltip
 **     xOffset: 10, // integer. pixels to the right of the mouse that the left edge tooltip will be displayed
 **     yOffset: 20, // integer.  pixels above or below the mouse that the top of the tooltip will be displayed
 **     contentAttrs: ['title'], // array. attribute(s) from which the tooltip contents will be pulled
 **     glue: '<br>' // string. if more than one attribute is used for contentAttrs, this will be placed between them. 
 * 
 * @example $('table').eztip('a', contentAttrs: ['title', 'href']);
 * @description This example shows a tooltip for every link ('a') inside a table. The contents of the tooltip come from the link's title attribute.
 * 
 */

;(function($) {
$.fn.eztip = function(selector, options) {
  var opts = $.extend({}, $.fn.eztip.defaults, options);

  var $vsTip = $('<div class="simple-tip"></div>')
    .css('opacity', opts.opacity)
    .hide()
    .appendTo('body');

  var tgt,
  tip = {
    link: function(e) {
      var t = $(e.target).is(selector) && e.target || $(e.target).parents(selector)[0] || false;
      return t;
    }
  };

  return this.each(function() {
    var $this = $(this),
    tipContents = '';
    var o = $.meta ? $.extend({}, opts, $this.data()) : opts;

    $this.mouseover(function(event) {
     if (tip.link(event)) {
       tgt = tip.link(event);
       $this.data('title', tgt.title);
       o.contents = [];
       for (i=0,j = o.contentAttrs.length;i<j;i++) {
         o.contents.push(tgt[o.contentAttrs[i]]);
       }
       tgt.title = '';

       $vsTip.css({
         left: event.pageX + o.xOffset,
         top: event.pageY + o.yOffset
       }).html(o.contents.join(o.glue)).show();
     }
    }).mouseout(function(event) {
      if (tip.link(event)) {
        tgt = tip.link(event);
        tgt.title = $this.data('title');
        $vsTip.hide();
      }
    }).mousemove(function(event) {
      if (tip.link(event)) {
        $vsTip.css({
          left: event.pageX + o.xOffset,
          top: event.pageY + o.yOffset
        });
      }        
    });

  });

};

// default options
$.fn.eztip.defaults = {
  opacity: 1,
  xOffset: 10,
  yOffset: 20,
  contentAttrs: ['title'],
  glue: '<br>'
};

})(jQuery);

