var displayImage = function(event){
    var image = document.getElementById("image-input")
    image.src = URL.createObjectURL(event.target.files[0]);
}