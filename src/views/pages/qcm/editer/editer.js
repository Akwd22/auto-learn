console.log('hello');
const list_item_container = document.querySelector('.cours-recommande-list');
const cours_recomande_item = document.querySelector('cours-recomande-list-item');
const btn_ajoute = document.querySelector("#submit-btn-recommandation");

const add_item_to_list = function (){
    let input_hiden = document.querySelector(".item-container-hidden");

    btn_ajoute.addEventListener("click", () => {
        input_hiden.value++;

        const div = document.createElement("div");
        div.className = "cours-recomande-list-item";
        div.innerHTML = `<label for='min-${input_hiden.value}'>Entre</label>`;
        div.innerHTML += `<input min='0' max='20'type="number" class='input m input-moyenne' name='min-${input_hiden.value}' placeholder='0'/>`;
        div.innerHTML += `<label for='max-${input_hiden.value}'>et</label>`;
        div.innerHTML += `<input min='0' max='20' type="number" class='input m input-moyenne' name='max-${input_hiden.value}' placeholder='20'/>`;
        div.innerHTML += `<label for='id-${input_hiden.value}'>:</label>`
        div.innerHTML += `<input type="number" class='input m input-id' name='id-${input_hiden.value}' placeholder='Identifiant du cours'/>`;


    list_item_container.appendChild(div);
    })
}



add_item_to_list();