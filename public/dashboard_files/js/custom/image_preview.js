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
