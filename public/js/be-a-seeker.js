const fileInput = document.getElementById('file-input');
const dropzone = document.getElementById('dropzone');
const uploadTrigger = document.getElementById('upload-trigger');
const preview = document.getElementById('image-preview');
const placeholder = document.getElementById('upload-placeholder');


dropzone.addEventListener('click', () => fileInput.click());
uploadTrigger.addEventListener('click', (e) => {
    if(fileInput.files.length === 0) {
        e.preventDefault();
        fileInput.click();
    }
});


fileInput.addEventListener('change', function() {
  const file = this.files[0];
  if (file) {
    const reader = new FileReader();
   
    reader.onload = function(e) {
      preview.src = e.target.result;
      preview.style.display = 'block';
      placeholder.style.display = 'none';  
      dropzone.style.borderStyle = 'solid';
    }
   
    reader.readAsDataURL(file);
  }
});



