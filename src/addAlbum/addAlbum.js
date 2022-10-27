var displayImage = function(event){
    var image = document.getElementById("image-input")
    image.src = URL.createObjectURL(event.target.files[0]);
}
// function generateSong(penyanyi) {
//     const xhttp = new XMLHttpRequest();
//     xhttp.onreadystatechange = function () {
//         if (this.readyState == 4 && this.status == 200) {
//             document.getElementById("daftarlagu").innerHTML = this.responseText;
//         }
//     };
//     xhttp.open("GET", "getSong.php/?penyanyi=" + penyanyi, true);
//     xhttp.send();
// }