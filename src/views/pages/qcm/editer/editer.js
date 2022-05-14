const add_item_to_list = () => {
  const list_item_container = document.querySelector(".cours-recommande-list");
  const btn_ajoute = document.querySelector("#submit-btn-recommandation");

  let input_hiden = document.querySelector(".item-container-hidden");

  btn_ajoute.addEventListener("click", () => {
    input_hiden.value++;

    const div = document.createElement("div");
    div.className = "cours-recomande-list-item";
    div.innerHTML = `<label for='min-${input_hiden.value}'>Entre</label>`;
    div.innerHTML += `<input min='0' max='20'type="number" class='input m input-moyenne' name='min-${input_hiden.value}' placeholder='0'/>`;
    div.innerHTML += `<label for='max-${input_hiden.value}'>et</label>`;
    div.innerHTML += `<input min='0' max='20' type="number" class='input m input-moyenne' name='max-${input_hiden.value}' placeholder='20'/>`;
    div.innerHTML += `<label for='id-${input_hiden.value}'>:</label>`;
    div.innerHTML += `<input type="texte" class='input m input-id' name='id-${input_hiden.value}' list='liste-cours' placeholder='Identifiant du cours'/>`;

    list_item_container.appendChild(div);
  });
};

const insert_list_cours = (tab_cours) => {
  const datalist = document.getElementById("liste-cours");

  for (const { titre, id } of tab_cours) {
    const option = document.createElement("option");
    option.label = titre;
    option.value = id;

    datalist.appendChild(option);
  }
};

const api_fetch_list_cours = () => {
  xhr = new XMLHttpRequest();
  xhr.open("GET", "/api/cours");
  xhr.responseType = "json";

  xhr.onload = () => {
    if (xhr.status === 200) {
      insert_list_cours(xhr.response);
    } else {
      console.error("Erreur lors du chargement de la liste des cours :", xhr.statusText);
    }
  };

  xhr.onerror = () => {
    console.error("Erreur lors du chargement de la liste des cours :", xhr.statusText);
  };

  xhr.send(null);
};

window.addEventListener("load", () => {
  add_item_to_list();
  api_fetch_list_cours();
});
