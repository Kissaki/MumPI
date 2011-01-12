<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>MView – Mumble Channel Viewer</title>
  <style>
    .code-placeholder { text-decoration:line-through; font-style:italic; }
  </style>
</head>
<body>

<h1>MumPI standalone JS <a href="http://mumble.sourceforge.net/Channel_Viewer_Protocol" rel="external">MumbleViewerProtocol</a> Viewer</h1>
<p><strong>valid HTML, no iframe – Object Oriented JavaScript</strong></p>

<h2>How to embed:</h2>
<pre><code class="language-html">
&lt;div id="mview-container"&gt;&lt;/div&gt;
&lt;script type="text/javascript" src="mview.js"&gt;&lt;/script&gt;
&lt;script type="text/javascript"&gt;
  mv = new MView();
  mv.load(document.getElementById('mview-container'), '<span class="code-placeholder">&lt;pathto&gt;</span>/MumPI/?view=json&amp;serverId=<span class="code-placeholder">&lt;ID&gt;</span>&amp;callback=?');
&lt;/script&gt;
</code></pre>

<h2>Example:</h2>
<div id="mview-container"></div>
<script type="text/javascript" src="mview.js"></script>
<script type="text/javascript">
  mv = new MView();
  mv.load(document.getElementById('mview-container'), '../?view=json&serverId=<?php echo (!empty($_GET['serverid']) ? intval($_GET['serverid']) : 1); ?>&callback=?');

  codeEl = document.getElementsByTagName('code')[0];
  codeEl.innerHTML = codeEl.innerHTML.replace(/(&lt;\/?\w+(?: \w+="[^"]+")*&gt;)/g, '<span style="color:#448844;">$1</span>');
//  codeEl.innerHTML.indexOf(''
//  codeEl.innerHTML = codeEl.innerHTML.replace(/(&lt;script .*&gt;)((?:.|\s)*)(&lt;\/script&gt;)/g, '$1<span style="color:#dd8844;">$2</span>$3');
</script>

</body>
</html>