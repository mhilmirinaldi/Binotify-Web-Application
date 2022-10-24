var audio = document.createElement('audio');

// Add a change event listener to the file input
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