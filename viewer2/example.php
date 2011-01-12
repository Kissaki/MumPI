<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <style>
    .code-placeholder { text-decoration:line-through; font-style:italic; }
  </style>
</head>
<body>

<h1>MumPI standalone JS <a href="http://mumble.sourceforge.net/Channel_Viewer_Protocol" rel="external">MumbleViewerProtocol</a> Viewer</h1>
<p><strong>valid HTML, no iframe – Object Oriented JavaScript</strong></p>

<h2>How to embed:</h2>
<pre><code class="language-html">
&lt;div id="mview-container">&lt;/div>
&lt;script type="text/javascript" src="mview.js">&lt/script>
&lt;script type="text/javascript">
  mv = new MView();
  mv.load(document.getElementById('mview-container'), '<span class="code-placeholder">&lt;pathto&gt;</span>/MumPI/?view=json&amp;serverId=<span class="code-placeholder">&lt;ID&gt;</span>&amp;callback=?');
&lt/script>
</code></pre>

<h2>Example:</h2>
<div id="mview-container"></div>
<script type="text/javascript" src="mview.js"></script>
<script type="text/javascript">
  mv = new MView();
  mv.load(document.getElementById('mview-container'), '../?view=json&serverId=<?php echo (!empty($_GET['serverid']) ? intval($_GET['serverid']) : 1); ?>&callback=?');


  m = {
		  html: { 
      _match: /(\&lt\;div)/
    , _style: 'color: red;'
}
, ml_comment: { 
          _match: /\/\*[^*]*\*+(?:[^\/][^*]*\*+)*\//
        , _style: 'color: gray;'
    }
    , sl_comment: { 
          _match: /\/\/.*/
        , _style: 'color: green;'
    }
    , string: { 
          _match: /(?:\'[^\'\\\n]*(?:\\.[^\'\\\n]*)*\')|(?:\"[^\"\\\n]*(?:\\.[^\"\\\n]*)*\")/
        , _style: 'color: teal;'
    }
    , num: { 
          _match: /\b[+-]?(?:\d*\.?\d+|\d+\.?\d*)(?:[eE][+-]?\d+)?\b/
        , _style: 'color: red;'
    }
    , reg_not: { //this prevents "a / b / c" to be interpreted as a reg_exp
          _match: /(?:\w+\s*)\/[^\/\\\n]*(?:\\.[^\/\\\n]*)*\/[gim]*(?:\s*\w+)/
        , _replace: function( all ) {
            return this.x( all, '//num' );
        }
    }
    , brace: { 
          _match: /[\{\}]/
        , _style: 'color: red; font-weight: bold;'
    }
    , statement: { 
          _match: /\b(with|while|var|try|throw|switch|return|if|for|finally|else|do|default|continue|const|catch|case|break)\b/
        , _style: 'color: navy; font-weight: bold;'
    }
    , error: { 
          _match: /\b(URIError|TypeError|SyntaxError|ReferenceError|RangeError|EvalError|Error)\b/
        , _style: 'color: Coral;'
    }
    , object: { 
          _match: /\b(String|RegExp|Object|Number|Math|Function|Date|Boolean|Array)\b/
        , _style: 'color: DeepPink;'
    }
    , property: { 
          _match: /\b(undefined|arguments|NaN|Infinity)\b/
        , _style: 'color: Purple; font-weight: bold;'
    }
    , 'function': { 
          _match: /\b(parseInt|parseFloat|isNaN|isFinite|eval|encodeURIComponent|encodeURI|decodeURIComponent|decodeURI)\b/
        , _style: 'color: olive;'
    }
    , operator: {
          _match: /\b(void|typeof|this|new|instanceof|in|function|delete)\b/
        , _style: 'color: RoyalBlue; font-weight: bold;'
    }
    , liveconnect: {
          _match: /\b(sun|netscape|java|Packages|JavaPackage|JavaObject|JavaClass|JavaArray|JSObject|JSException)\b/
        , _style: 'text-decoration: overline;'
    }
};
  jQuery('code').each(function(iC, el){
      for (i in m) {
          jQuery(el).html(jQuery(el).html().replace(m[i]._match, '<span style="' + m[i]._style + '">$1</span>'));
        }
	    });
</script>

</body>
</html>