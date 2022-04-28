// CONTAINER DE GAUCHE
const pdfContainer = document.querySelector(".creation-container-pdf-container");
const lienContainer = document.querySelector(".lien-container");
const texteRadioButton = document.querySelector("#radio-format-texte");
const videoRadioButton = document.querySelector("#radio-format-video");

// CONTAINER DE DROITE
const lienVideoContainer = document.querySelector(".lien-container-input-container");
const btnLienVideo = document.querySelector("#submit-btn-lien");
const listLiensContainer = document.querySelector(".lien-container-list-lien");

//Si le bouton radio "vidéo" est activé
if (document.getElementById("radio-format-video").checked == true) {
  if (pdfContainer) pdfContainer.style.display = "none";
  lienContainer.style.display = "flex";
}

// TEXTE
texteRadioButton.addEventListener("click", () => {
  if (pdfContainer) pdfContainer.style.display = "flex";
  lienContainer.style.display = "none";
});

// VIDEO
videoRadioButton.addEventListener("click", () => {
  if (pdfContainer) pdfContainer.style.display = "none";
  lienContainer.style.display = "flex";
});

const addLienVideo = function () {
  let nbLiens = document.querySelector(".lien-container-hidden");

  btnLienVideo.addEventListener("click", () => {
    nbLiens.value++;

    const div = document.createElement("div");
    div.className = "lien-container-input-container";

    div.innerHTML = `<label for='input-lien-${nbLiens.value}'>${nbLiens.value}</label>`;
    div.innerHTML += `<input class="input m" type="text" id="input-lien-${nbLiens.value}" name="lien${nbLiens.value}" placeholder="Lien de la vidéo YouTube"></input>`;

    listLiensContainer.appendChild(div);
  });
};

addLienVideo();
