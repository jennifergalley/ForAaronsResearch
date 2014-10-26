
    function playTone () {
        document.getElementById("tone").play();
    }
    
    var myTimeout;
    function showElem1 () {
        setTimeout(function() {
            var i = geti (); //get i
            show (i); //show
            start = +new Date ();
            allowResponses (); //only allow response on response page
            
            //play sound
            if (tones[i-1] != "") { //if not empty
                setTimeout(function () { //delay tone
                    playTone(); //play tone
                }, tones[i-1]); //delay in ms
            }
            
            myTimeout = setTimeout(function() { //timeout after 2 seconds, call response with null input
                timeout ();
            }, 1000); //timeout after 1 second
        }, 500); //half a second between image + tone trials - ask aaron about this delay
    }
    
    function startAgain () {
        show("base");
        setTimeout(function() {
            hide ("base"); //hide base image
            showElem1();
        }, 500); //half a second between image + tone trials - ask aaron about this delay
    }
    
    function pause () {
        setTimeout(function() {
            startAgain();
        }, 1000); //wait 1 second
    }
    
    function response (e) {
        end = +new Date();
        var response_time = end - start;
        disallowResponses (); //only allow response on response page
        clearTimeout (myTimeout);
        var keycode = getResponse ();
        var i = geti (); //get i
        hide (i); //hide elem
        setCookie("response"+i, keycode, 1); //save response
        setCookie("response_time"+i, response_time, 1); //save response time
        if (i == numberQuestions) {
            var url = "../results/saveSoundResponses.php?participant="+participant+"&testVersion="+testVersion+"&";
            for (k = 1; k <= numberQuestions; k++) {
                url += k+"="+getCookie("response"+k)+"&";
                url += k+"_time="+getCookie("response_time"+k)+"&";
            }
            window.location = url;
        } 
        increment (i); //increment i
        pause();
    }
    
    var start, end;
    setCookie ("elem", 1, 1); //set i initially to 1
    startAgain (); //show
    
