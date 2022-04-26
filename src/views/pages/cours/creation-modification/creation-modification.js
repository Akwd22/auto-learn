const pdfContainer = document.querySelector('.creation-container-pdf-container');
const lienContainer = document.querySelector('.lien-container');
const texteRadioButton = document.querySelector('#radio-format-texte');
const videoRadioButton = document.querySelector('#radio-format-video');

console.log(lienContainer);
if (document.getElementById('radio-format-video').checked === true) {
    pdfContainer.style.display = 'none';
    lienContainer.style.display = 'flex';
}

// TEXTE
texteRadioButton.addEventListener('click', () => {
    pdfContainer.style.display = 'flex';
    lienContainer.style.display = 'none';
});

// VIDEO
videoRadioButton.addEventListener('click', () => {
    pdfContainer.style.display = 'none';
    lienContainer.style.display = 'flex';
});

