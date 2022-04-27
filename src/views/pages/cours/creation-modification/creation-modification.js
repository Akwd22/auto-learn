// CONTAINER DE GAUCHE
const pdfContainer = document.querySelector('.creation-container-pdf-container');
const lienContainer = document.querySelector('.lien-container');
const texteRadioButton = document.querySelector('#radio-format-texte');
const videoRadioButton = document.querySelector('#radio-format-video');

// CONTAINER DE DROITE 
const lienVideoContainer = document.querySelector('.lien-container-input-container');
const btnLienVideo = document.querySelector('#submit-btn-lien');
const listLiensContainer = document.querySelector('.lien-container-list-lien');

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


const addLienVideo = function(){
    let node = document.querySelector(".lien-container-hidden");
    let nbLiens = node.value ;
    console.log(node.value);


    btnLienVideo.addEventListener('click', ()=>{
        
        
        console.log(nbLiens);

        const div = document.createElement('div');
        div.className ='lien-container-input-container';

        div.innerHTML = "<label for='input-lien'>"+ nbLiens +"</label>"
        div.innerHTML +='<input class="input m" type="text" id="input-lien"></input>'
        
    
        listLiensContainer.appendChild(div);
        
        node.value = +node.value +1 ;
        nbLiens++;
    })
};

addLienVideo();