let select = document.getElementById('user_roles');
let options = document.querySelectorAll('option');
let fieldset = document.querySelector('fieldset');
// console.log(options);
fieldset.classList.add('d-none');

for( let option of options){
    let valeur = option.value;
    // console.log(valeur);

    option.addEventListener("click", ()=>{
        
        console.log(valeur);

        if(valeur === "ROLE_ETUDIANT"){
                fieldset.classList.add('d-block');
                fieldset.classList.remove('d-none');
        }
        else if(valeur === "ROLE_FORMATEUR"){
            fieldset.classList.add('d-none');
        }
    })

}

