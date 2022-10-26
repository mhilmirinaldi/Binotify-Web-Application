var container = document.getElementById("container");
var username = document.getElementById("username");
var email = document.getElementById("email");
var password = document.getElementById("password");
var confirm_password = document.getElementById("confirm_password");

function check_form(){
    if(username.innerHTML == "Username sudah terdaftar!" || username.innerHTML == "Username tidak valid!" || email.innerHTML == "Email tidak valid!" || email.innerHTML == "Email sudah terdaftar!" || confirm_password.innerHTML == "Password tidak sesuai!"){
        alert("Form tidak valid!");
    } else {
    }
}

function validate(field, input){
    // Buat object ajax
    var ajax = new XMLHttpRequest();
    
    // Cek kesiapan ajax
    ajax.onreadystatechange = function(){
        if(ajax.readyState == 4 && ajax.status == 200){
            document.getElementById(field).innerHTML = ajax.responseText;
        }
    }

    // Eksekusi ajax
    ajax.open("GET", "register.php?field=" + field + "&input=" + input, false);
    ajax.send();
}