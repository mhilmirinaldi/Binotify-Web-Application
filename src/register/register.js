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

function validate_password1(field, input){
    if(input == document.getElementById("confirm_password1").value && input != ""){
        // Buat object ajax
        var ajax = new XMLHttpRequest();
        
        // Cek kesiapan ajax
        ajax.onreadystatechange = function(){
            if(ajax.readyState == 4 && ajax.status == 200){
                document.getElementById(field).innerHTML = ajax.responseText;
            }
        }

        // Eksekusi ajax
        ajax.open("GET", "register.php?field=" + field + "&input=" + "true", false);
        ajax.send();
    } else{
        // Buat object ajax
        var ajax = new XMLHttpRequest();
        
        // Cek kesiapan ajax
        ajax.onreadystatechange = function(){
            if(ajax.readyState == 4 && ajax.status == 200){
                document.getElementById(field).innerHTML = ajax.responseText;
            }
        }

        // Eksekusi ajax
        ajax.open("GET", "register.php?field=" + field + "&input=" + "false", false);
        ajax.send();
    }
}

function validate_password2(field, input){
    if(input == document.getElementById("password1").value && input != ""){
        // Buat object ajax
        var ajax = new XMLHttpRequest();
        
        // Cek kesiapan ajax
        ajax.onreadystatechange = function(){
            if(ajax.readyState == 4 && ajax.status == 200){
                document.getElementById(field).innerHTML = ajax.responseText;
            }
        }

        // Eksekusi ajax
        ajax.open("GET", "register.php?field=" + field + "&input=" + "true", false);
        ajax.send();
    } else{
        // Buat object ajax
        var ajax = new XMLHttpRequest();
        
        // Cek kesiapan ajax
        ajax.onreadystatechange = function(){
            if(ajax.readyState == 4 && ajax.status == 200){
                document.getElementById(field).innerHTML = ajax.responseText;
            }
        }

        // Eksekusi ajax
        ajax.open("GET", "register.php?field=" + field + "&input=" + "false", false);
        ajax.send();
    }
}