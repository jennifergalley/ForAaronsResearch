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

var snd = new Audio("file.wav"); // buffers automatically when created
snd.play();

</script>