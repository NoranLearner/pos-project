// image preview
function showPreview(event) {
    if (event.target.files.length > 0) {
        let src = URL.createObjectURL(event.target.files[0]);
        let pv = document.getElementById('image-prv');
        pv.src = src;
    }
}

// $(".image").change(function () {

//     if (this.files && this.files[0]) {
//         var reader = new FileReader();

//         reader.onload = function (e) {
//             $('.image-preview').attr('src', e.target.result);
//         }

//         reader.readAsDataURL(this.files[0]);
//     }

// });

function showPreviews(event) {
    const previewContainer = document.getElementById('preview-container');
    previewContainer.innerHTML = ''; // نحذف الصور القديمة

    const files = event.target.files;

    if (files.length > 0) {
        Array.from(files).forEach(file => {
            const src = URL.createObjectURL(file);
            const img = document.createElement('img');
            img.src = src;
            img.style.width = '130px';
            img.classList.add('img-thumbnail', 'image-preview');
            previewContainer.appendChild(img);
        });
    }
}
