/**
 * I'm using Quill as a ritch text editor
 * for documentation: https://quilljs.com/
 * example submit form: https://quilljs.com/playground/#form-submit
 */

var form = document.querySelector('#page-editor form');

if (form) {
  var content = document.querySelector('input[name=content]');

  var quill = new Quill('#editor', {
    modules: {
      toolbar: [
        [{ header: [1, 2, 3, 4, 5, false] }],
        ['bold', 'italic'],
        ['link', 'blockquote', 'code-block', 'image'],
        [{ list: 'ordered' }, { list: 'bullet' }]
      ]
    },
    placeholder: 'Write your awesome content...',
    theme: 'snow'
  });
  
  // quill.root.innerHTML = content.value;
  quill.root.innerHTML = contentFromDB;

  form.onsubmit = function () {
    //console.log("onsubmit");
    // Populate hidden form on submit
    content.value = quill.root.innerHTML;
    // return false;
  };
}


function escapeHtml(unsafe) {
  return unsafe
       .replace(/&/g, "&amp;")
       .replace(/</g, "&lt;")
       .replace(/>/g, "&gt;")
       .replace(/"/g, "&quot;")
       .replace(/'/g, "&#039;");
}

