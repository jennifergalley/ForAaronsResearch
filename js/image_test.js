    
    function showElem1 () {
        setTimeout(function() {
            var i = geti ();
            var b = getBlock();
            hide ("base"); //hide base image
            show (b+"."+i); //show
            hideElem1(); //hide
        }, 200);
    }
    
    function hideElem1 () {
        setTimeout(function(){
            var i = geti ();
            var b = getBlock();
            show ("base"); //show base image
            hide (b+"."+i); //hide 
            increment ("elem", (+i)); //increment i
            showElem2(); //show
        }, 100); //wait 100 ms, then hide elem1
    }
    
    function showElem2 () {
        setTimeout(function() {
            var i = geti ();
            var b = getBlock();
            hide ("base"); //hide base image
            show (b+"."+i); //show
            hideElem2(); //hide
        }, 900);
    }
    
    var myTimeout;
    function hideElem2 () {
       myTimeout = setTimeout(function() {
            var i = geti ();
            var b = getBlock();
            hide (b+"."+i); //hide
            showPrompt();
        }, 2000); //wait 2 sec, then hide elem2
    }
    
    function showPrompt () {
        show ("prompt"); 
        hide ("base"); //hide base image
        allowResponses(); //only allow response on response page
        setTimeout(function() { //timeout after 2 seconds, call response with null input
            timeout ();
        }, 2000);
    }

    function hidePrompt () {
        hide ("prompt");
        disallowResponses(); //disallow responses now
    }
    
    function showPause () {
        show ("pause");
        allowResponses();
    }
    
    function response (e) {
        hidePrompt ();
        clearTimeout (myTimeout); //if they interrupted the hideElem2 fxn, don't mess up other timeouts
        var keycode = getResponse ();
        var i = geti ();
        var b = getBlock();
        var pause = document.getElementById("pause");
        if (pause.offsetParent !== null && keycode == 13) {
            increment ("block", (+b));
            setCookie ("elem", 1, 1);
            hide ("pause");
        } else {
            //get index of response (goes up half as fast as i)
            var j = Math.floor(((+i)+1)/2);
            setCookie("response."+b+"."+j, keycode, 1); //save response
            if ((+b) == blocks && j == numberQuestions[blocks-1]) {
                var url = "../results/saveImageResponses.php?participant="+participant+"&testVersion="+testVersion+"&";
                var f = 1;
                for (k=1; k <= blocks; k++) {
                    alert (k);
                    for (h=1; h <= numberQuestions[k]; h++) {
                        url += f+"="+getCookie("response."+k+"."+h)+"&";
                        f++;
                    }
                }
                window.location = url;
            } else {
                if (j == numberQuestions[b-1]) {
                    showPause();
                    return;
                }
            }
            increment ("elem", (+i)); //increment i 
        }
        showElem1(); //show
    }

    setCookie ("elem", 1, 1); //set i initially to 1
    setCookie ("block", 1, 1); //set block initially to 1
    showElem1 (); //show
    
