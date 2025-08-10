;(function () {
  tinymce.create('tinymce.plugins.Sample', {
    init: function (editor) {
      editor.addButton('mce_sample_button', {
        text: 'Sample',
        cmd: 'sampleButtonCmd',
      })
      editor.addCommand('sampleButtonCmd', function () {
        var selectedText = editor.selection.getContent({ format: 'html' })
        var returnText = selectedText
        editor.execCommand('mceInsertContent', 0, returnText)
      })
    },
  })
  tinymce.PluginManager.add('mce_sample', tinymce.plugins.Sample)
})()
