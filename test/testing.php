<script type="text/javascript">

(function () {
    var element = document.getElementById('element'),
        start, end;

    //On hide, start counting
    element.onmousedown = function () {
      start = +new Date(); // get unix-timestamp in milliseconds
    };

    //on response, stop counting
    element.onmouseup = function () {
      end = +new Date();

      var diff = end - start; // time difference in milliseconds
    };

})();

var tone = new Audio("tone.wav"); // buffers automatically when created
tone.play();

function playTone () {
    document.getElementById("tone").play();
}
playTone();
</script>



<audio id='tone' src="tone.wav" preload="auto"></audio>
<a href="javascript:playTone();">Play Goddamnit</a>
