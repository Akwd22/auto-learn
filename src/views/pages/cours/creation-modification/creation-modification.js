const pdfContainer = document.querySelector('.creation-container-pdf-container');
const lienContainer = document.querySelector('.lien-container');
const texteRadioButton = document.querySelector('#radio-format-texte');
const videoRadioButton = document.querySelector('#radio-format-video');



//Si le bouton radio "vidéo" est activé
if (document.getElementById('radio-format-video').checked == true) {
    if(pdfContainer)
        pdfContainer.style.display = 'none';
    lienContainer.style.display = 'flex';
}

// TEXTE
texteRadioButton.addEventListener('click', () => {
    if(pdfContainer)
        pdfContainer.style.display = 'flex';
    lienContainer.style.display = 'none';
});

// VIDEO
videoRadioButton.addEventListener('click', () => {
    if(pdfContainer)
        pdfContainer.style.display = 'none';
    lienContainer.style.display = 'flex';
});

