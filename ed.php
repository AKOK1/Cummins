<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
  <head>
    <script src="http://www.wiris.net/demo/editor/editor"></script>
    <script>
    var editor;
    window.onload = function () {
      editor = com.wiris.jsEditor.JsEditor.newInstance({'language': 'en','toolbarHidden': 'true'});
            editor.insertInto(document.getElementById('editorContainer'));
		setTimeout('document.getElementsByClassName("wrs_focusElement")[0].disabled=true;',1000);
    }
    </script>
  </head>
  <body>
    <div id="editorContainer"></div>
  </body>
</html>