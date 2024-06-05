function validar(event){
    let email = document.getElementById("email")
    let cemail = document.getElementById("cemail")
    let pass = document.getElementById("pass")
    let cpass = document.getElementById("cpass")
    if((email.value != cemail.value)){
        event.preventDefault()
        alert("Los correos deben ser igaules")
    }else if((pass.value != cpass.value)){
        event.preventDefault()
        alert("Las contraseñas deben ser igaules")
    }
}