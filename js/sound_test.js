   
    function setCookie(cname, cvalue, exdays) {
        var d = new Date();
        d.setTime(d.getTime() + (exdays*24*60*60*1000));
        var expires = "expires="+d.toUTCString();
        document.cookie = cname + "=" + cvalue + "; " + expires;
    }
    
    function getCookie(cname) {
        var name = cname + "=";
        var ca = document.cookie.split(';');
        for(var i=0; i<ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0)==' ') c = c.substring(1);
            if (c.indexOf(name) != -1) return c.substring(name.length,c.length);
        }
        return "";
    }
    
    function playTone () {
        document.getElementById("tone").play();
    }
    
    var myTimeout;
    function showElem1 () {
        setTimeout(function() {
            start = +new Date ();
            var i = getCookie("elem"); //get i
            document.getElementById(i).style.display = "block"; //show
            document.onkeydown = response; //only allow response on response page
            
            //play sound
            if (tones[i-1] != "") { //if not empty
                setTimeout(function () { //delay tone
                    playTone(); //play tone
                }, tones[i-1]); //delay in ms
            }
            
            myTimeout = setTimeout(function() { //timeout after 2 seconds, call response with null input
                var event; // The custom event that will be created
            
                if (document.createEvent) {
                  event = document.createEvent("HTMLEvents");
                  event.initEvent("keydown", true, true);
                } else {
                  event = document.createEventObject();
                  event.eventType = "keydown";
                }
            
                event.eventName = "keydown";
            
                if (document.createEvent) {
                  document.dispatchEvent(event);
                } else {
                  document.fireEvent("on" + event.eventType, event);
                }
            }, 2000); //timeout after 2 seconds
        }, 500);
    }
    
    function response(e){
        end = +new Date();
        var response_time = end - start;
        document.onkeydown = ""; //only allow response on response page
        clearTimeout (myTimeout);
        var evtobj = window.event ? event : e; 
        var keycode = evtobj.keyCode;
        if (keycode == undefined) {
            keycode = 0;
        }
        var i = getCookie("elem"); //get i
        i = +i; //convert to int
        document.getElementById(i).style.display = "none"; //hide elem
        setCookie("response"+i, keycode, 1); //save response
        setCookie("response_time"+i, response_time, 1); //save response time
        if (i == numberQuestions) {
            var url = "../results/saveSoundResponses.php?participant="+participant+"&testVersion="+testVersion+"&";
            for (k=1; k <= numberQuestions;k++) {
                url += k+"="+getCookie("response"+k)+"&";
                url += k+"_time="+getCookie("response_time"+k)+"&";
            }
            window.location = url;
        } 
        setCookie ("elem", i+1, 1); //increment i
        showElem1(); //show
    }
    
    var start, end;
    setCookie ("elem", 1, 1); //set i initially to 1
    showElem1 (); //show
    
