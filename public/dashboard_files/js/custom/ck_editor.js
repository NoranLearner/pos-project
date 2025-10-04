let allTextDescription = document.querySelectorAll('.editor');

allTextDescription.forEach(desc => {
    let lang = desc.getAttribute('data-lang') || 'en'; // default en

    ClassicEditor
        .create(desc, {
            language: {
                ui: lang,
                content: lang
            }
        })
        .then(editor => {
            // ضبط الاتجاه حسب اللغة
            editor.editing.view.change(writer => {
                writer.setAttribute(
                    'dir',
                    lang === 'ar' ? 'rtl' : 'ltr',
                    editor.editing.view.document.getRoot()
                );
            });
        })
        .catch(error => {
            console.error(error);
        });
});

//         let allTextDescription = document.querySelectorAll('.editor');
//         allTextDescription.forEach(desc => {
//             ClassicEditor
//                 .create(desc)
//                 .catch(error => { console.error(error) });
//         });


// const {
//     ClassicEditor,
//     Essentials,
//     Bold,
//     Italic,
//     Font,
//     Paragraph
// } = CKEDITOR;
// const { FormatPainter } = CKEDITOR_PREMIUM_FEATURES;

// let allTextDescription = document.querySelectorAll('.editor');
// allTextDescription.forEach(desc => {
//     ClassicEditor
//         .create(desc, {
//             licenseKey: '<YOUR_LICENSE_KEY>',
//             plugins: [Essentials, Bold, Italic, Font, Paragraph, FormatPainter],
//             toolbar: [
//                 'undo', 'redo', '|', 'bold', 'italic', '|',
//                 'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', '|',
//                 'formatPainter'
//             ]
//         })
//         .then( /* ... */)
//         .catch(error => {
//             console.error(error);
//         });
// });
