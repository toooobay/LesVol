const imageInput = document.getElementById('image-input');
const selectBtn = document.getElementById('select-image-btn');
const previewImg = document.getElementById('image-preview');
const placeholderIcon = document.getElementById('placeholder-icon');

selectBtn.addEventListener('click', function() {
    imageInput.click();
});

imageInput.addEventListener('change', function() {
    const file = this.files[0];

    if (file) {
        const reader = new FileReader();

        reader.onload = function(e) {
            previewImg.src = e.target.result;
            previewImg.style.display = 'block';
            
            placeholderIcon.style.display = 'none';
        }

        reader.readAsDataURL(file);
    }
});

function openModal() {
    document.getElementById('success-modal').classList.add('open');
}

function closeModal() {
    document.getElementById('success-modal').classList.remove('open');
}