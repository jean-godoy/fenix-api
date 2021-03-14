

function checkLogin() {

    const email = document.querySelector('#email').value;
    const pass = document.querySelector('#pass').value;
    let status = null;

    const data_value = {
        'email': email,
        'pass': pass
    }

    const data_string = JSON.stringify(data_value);

    fetch("http://localhost:8000/auth/login-finalizacao", {
        method: "POST",
        body: data_string
    }).then((data) => {
        if (data.status === 200) {
            window.location.assign("http://localhost:8000/home/");
        } else {
            alert('erro')
        }
    }).catch(e => {
        alert('Erro ao logar!');
    });

}

var romaneio_code = null;
var input = null;
function handleInput(id){
    romaneio_code = document.getElementById("romaneio_code")
    input = document.getElementById(id);
}

function onSubmit() {
    const data_value = {
        'status':           parseInt(input.value),
        'romaneio_code':    romaneio_code.value
    }

    const data_string = JSON.stringify(data_value);

    fetch("http://localhost:8000/api/finalizacao/set-status", {
        method: "POST",
        body: data_string
    }).then((data) => {
        if (data.status === 200) {
            alert("Status atualizado com sucesso!");
            console.log(data)
            window.location.assign("http://localhost:8000/template/finalizacao");
        } else {
            alert('erro')
        }
    }).catch(e => {
        alert('Erro ao logar!');
    });    

}



// const form = document.getElementById("form").addEventListener("submit", myFunction);
// form.preventDefault();

// function myFunction() {
//   alert("The form was submitted");
// }



// handlePost(e){
//     e.preventDefault();
//     alert('form')
// }

// const form = document.forms["registration"].submit();
// console.log(form)
// form.addEventListener('submit', function(e){
//     alert()
//     e.preventDefault();
    
//     const { status} = form;
//     console.log("Status: "+status)
// })

// const texugo = (val) => {
//     const radios = document.getElementsByName('status');
//     radios.forEach(radio => {
//         radio.checked = false;
//         if(radio.value === String(val)) {
//             radio.checked = true;
//         }
        
//     });
// }

// function texugo(val) {
    
//     const radios = document.getElementsByName('status');
//     radios.forEach(radio => {
//         console.log(radio.value)
//         radio.checked = false;
//         if(radio.value === String(val)) {
//             radio.checked = true;
//         }
        
//     });
// }

// texugo(12)