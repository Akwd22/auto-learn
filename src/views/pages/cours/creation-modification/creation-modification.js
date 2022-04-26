const pdfContainer = document.querySelector('.creation-container-pdf-container');
const lienContainer = document.querySelector('.lien-container-form');
const texteRadioButton = document.querySelector('#radio-format-texte');
const videoRadioButton = document.querySelector('#radio-format-video');

console.log(lienContainer);
if (document.getElementById('radio-format-video').checked === true) {
    pdfContainer.style.display = 'none';
}

// TEXTE
texteRadioButton.addEventListener('click', () => {
    pdfContainer.style.display = 'flex';
    lienContainer.style.display = 'none';
});

// VIDEO
videoRadioButton.addEventListener('click', () => {
    pdfContainer.style.display = 'none';

    document.getElementById('radio-format-video').checked = true;
    lienContainer.style.display = 'flex';

});

console.log(videoRadioButton.checked);

function test() {
    console.log("gegzgezg");
}