<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script type="text/javascript" class="init">
        // JavaScript
        // Wrap the native DOM audio element play function and handle any autoplay errors
        Audio.prototype.play = (function(play) {
        return function () {
        var audio = this,
            args = arguments,
            promise = play.apply(audio, args);
        if (promise !== undefined) {
            promise.catch(_ => {
            // Autoplay was prevented. This is optional, but add a button to start playing.
            var el = document.createElement("button");
            el.innerHTML = "Play";
            el.addEventListener("click", function(){play.apply(audio, args);});
            this.parentNode.insertBefore(el, this.nextSibling)
            });
        }
        };
        })(Audio.prototype.play);

        // Try automatically playing our audio via script. This would normally trigger and error.
        document.getElementById('MyAudioElement').play()
    </script>
</head>
<body>
<audio id="MyAudioElement" autoplay>
  <source src="https://www.w3schools.com/html/horse.ogg" type="audio/ogg">
  <source src="https://www.w3schools.com/html/horse.mp3" type="audio/mpeg">
  Your browser does not support the audio element.
</audio>
</body>
</html>