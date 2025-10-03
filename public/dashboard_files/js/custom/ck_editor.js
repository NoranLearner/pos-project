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
