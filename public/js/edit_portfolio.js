document.addEventListener('DOMContentLoaded', function() {
    const uploadTrigger = document.getElementById('upload-trigger');
    const imageInput = document.getElementById('portfolio-image');
    const preview = document.getElementById('portfolio-preview');
    const uploadText = document.getElementById('upload-text');

    uploadTrigger.addEventListener('click', () => imageInput.click());

    imageInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
                uploadText.style.display = 'none';
            }
            reader.readAsDataURL(file);
        }
    });
});