<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>MView – Mumble Channel Viewer</title>
</head>
<body>

<div id="mview-container"></div>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="mview.js"></script>
<script type="text/javascript">
  var settings = {
      target: '#mview-container',
      source: '../?view=json&serverId=<?php echo (!empty($_GET['serverid']) ? intval($_GET['serverid']) : 1); ?>&callback=?',
      resurl: '',
      refreshinterval: 30
    };
  mv = new MView(settings);
  mv.load();

  var codeEl = document.getElementsByTagName('code')[0];
  codeEl.innerHTML = codeEl.innerHTML.replace(/(&lt;\/?\w+(?: \w+="[^"]+")*&gt;)/g, '<span style="color:#448844;">$1</span>');
</script>

</body>
</html>