"use strict"

const URL = "api/champs/";

let champs = [];

let form = document.querySelector('#champ-form');
form.addEventListener('submit', insertChamp)


/**
 * Obtiene todos los champ de la API REST
 */
async function getAll() {
    try {
        let response = await fetch(URL);
        if (!response.ok) {
            throw new Error('Recurso no existe');
        }
        champs = await response.json();

        showChamps();
    } catch(e) {
        console.log(e);
    }
}

/**
 * Inserta el champ via API REST
 */
async function insertChamp(e) {
    e.preventDefault();
    
    let data = new FormData(form);
    let champ = {
        nombre: data.get('nombre'),
        rol: data.get('rol'),
        precio: data.get('precio'),
    };

    try {
        let response = await fetch(URL, {
            method: "POST",
            headers: { 'Content-Type': 'application/json'},
            body: JSON.stringify(champ)
        });
        if (!response.ok) {
            throw new Error('Error del servidor');
        }

        let nChamp = await response.json();

        // inserto el champ nuevo
        champ.push(nChamp);
        showChamps();

        form.reset();
    } catch(e) {
        console.log(e);
    }
} 

async function deleteChamp(e) {
    e.preventDefault();
    try {
        let id = e.target.dataset.Champ;
        let response = await fetch(URL + id, {method: 'DELETE'});
        if (!response.ok) {
            throw new Error('Recurso no existe');
        }

        // eliminar el champ  del arreglo global
        Champ = Champ.filter(Champ => Champ.Champion_id != Champion_id);
        showChamps();
    } catch(e) {
        console.log(e);
    }
}



function showChamps() {
    let ul = document.querySelector("#champ-list");
    ul.innerHTML = "";
    for (const champ of champs) {

        let html = `
            <li class='
                    list-group-item d-flex justify-content-between align-items-center
                 
                '>
                <span> <b>${champ.nombre}</b> - ${champ.rol} (prioridad ${champ.precio}) </span>
                <div class="ml-auto">
                   
                    <a href='#' data-task="${task.id}" type='button' class='btn btn-danger btn-delete'>Borrar</a>
                </div>
            </li>
        `;

        ul.innerHTML += html;
    }

    // asigno event listener para los botones
    const btnsDelete = document.querySelectorAll('a.btn-delete');
    for (const btnDelete of btnsDelete) {
        btnDelete.addEventListener('click', deleteChamp);
    }

    
}

getAll();
