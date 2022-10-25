var displayImage = function(event){
    var image = document.getElementById("image-input")
    image.src = URL.createObjectURL(event.target.files[0]);
}

var audio = document.createElement('audio');

document.getElementById("fileAudio").addEventListener('change', function (event) {
    var target = event.currentTarget;
    var file = target.files[0];
    var reader = new FileReader();

    if (target.files && file) {
        var reader = new FileReader();

        reader.onload = function (e) {
            audio.src = e.target.result;
            audio.addEventListener('loadedmetadata', function () {
                var duration = audio.duration;

                // assign to hidden input
                document.getElementById("duration").value = duration;
            }, false);
        };

        reader.readAsDataURL(file);
    }
}, false); 