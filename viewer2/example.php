<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>MView – Mumble Channel Viewer</title>
  <style>
    pre.code { background-color:#dddddd; padding:4px 6px; }
    .code-placeholder { font-style:italic; color:#000044; }
  </style>
</head>
<body>

<h1>MumPI standalone JS <a href="http://mumble.sourceforge.net/Channel_Viewer_Protocol" rel="external">MumbleViewerProtocol</a> Viewer</h1>
<p><strong>valid HTML, no iframe – Object Oriented JavaScript</strong></p>

<h2>How to embed:</h2>
<pre class="code"><code class="language-html">&lt;div id="mview-container"&gt;&lt;/div&gt;
&lt;script type="text/javascript" src="mview.js"&gt;&lt;/script&gt;
&lt;script type="text/javascript"&gt;
  var settings = {
    target: '#mview-container',
    source: '<span class="code-placeholder">&lt;pathto&gt;</span>/MumPI/?view=json&amp;serverId=<span class="code-placeholder">&lt;ID&gt;</span>&amp;callback=?',
    resurl: '',           // for url to folder with css file and img folder.
    refreshinterval: 30   <span style="color:#666666;">// in seconds, 0 for no automatic refresh</span>
  };
  mv = new MView(settings);
  mv.load();
&lt;/script&gt;
</code></pre>
<p>
  You’ll have to provide the path to your JSON-data source which provides the server data. If you’re using MumPI just add the correct URL to MumPI with the corresponding parameters (see above).<br/>
  Adding <code>callback=?</code> as a parameter allows for JSONP callbacks.
</p>
<p>
  As a further example to make it clear: A different but valid source may be <code>source: 'http://demo.mumble-django.org/mumble-django/mumble/1.json?callback=?'</code>.
</p>

<h2>Example:</h2>
<div id="mview-container"></div>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="mview.js"></script>
<script type="text/javascript">
  var settings = {
      target: '#mview-container',
      source: '../?view=json&serverId=<?php echo (!empty($_GET['serverid']) ? intval($_GET['serverid']) : 1); ?>&callback=?',
      resurl: '',    // for url to folder with css file and img folder; WITH trailing slash. Example: http://example.com/MumPI/viewer2/
      //source: 'http://demo.mumble-django.org/mumble-django/mumble/1.json?callback=?',
      refreshinterval: 30
    };
  mv = new MView(settings);
  mv.load();

  var codeEl = document.getElementsByTagName('code')[0];
  codeEl.innerHTML = codeEl.innerHTML.replace(/(&lt;\/?\w+(?: \w+="[^"]+")*&gt;)/g, '<span style="color:#448844;">$1</span>');
//  codeEl.innerHTML.indexOf(''
//  codeEl.innerHTML = codeEl.innerHTML.replace(/(&lt;script .*&gt;)((?:.|\s)*)(&lt;\/script&gt;)/g, '$1<span style="color:#dd8844;">$2</span>$3');
</script>

</body>
</html>