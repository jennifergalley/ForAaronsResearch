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
    
    function justHide (elem) {
        document.getElementById(elem).style.display = "none"; //hide
    }

    function hideElem1 () {
        setTimeout(function(){
            var i = getCookie("elem"); //get i
            document.getElementById("base").style.display = "block"; //show base image
            document.getElementById(i).style.display = "none"; //hide
            i = +i; //convert to int
            setCookie ("elem", i+1, 1); //increment i
            showElem2(); //show
        }, 100); //wait 100 ms, then hide elem1
    }
    
    var myTimeout;
    function hideElem2 () {
       myTimeout = setTimeout(function() {
            var i = getCookie("elem"); //get i
            i = +i; //convert to int
            document.getElementById(i).style.display = "none"; //hide
            showPrompt();
        }, 2000); //wait 2 sec, then hide elem2
    }

    function showElem1 () {
        setTimeout(function() {
            var i = getCookie("elem"); //get i
            i = +i; //convert to int
            document.getElementById("base").style.display = "none"; //hide base image
            document.getElementById(i).style.display = "block"; //show
            hideElem1(); //hide
        }, 200);
    }
    
    function showPrompt () {
        document.getElementById("prompt").style.display = "block";
        document.getElementById("base").style.display = "none"; //hide base image
        document.onkeydown = response; //only allow response on response page
        
        setTimeout(function() { //timeout after 2 seconds, call response with null input
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
            
        }, 2000);
    }

    function hidePrompt () {
        document.getElementById("prompt").style.display = "none";
        document.onkeydown = ""; //disallow responses now
    }
    
    function showElem2 () {
        setTimeout(function() {
            var i = getCookie("elem"); //get i
            i = +i; //convert to int
            document.getElementById("base").style.display = "none"; //hide base image
            document.getElementById(i).style.display = "block"; //show
            hideElem2(); //hide
        }, 900);
    }

    function response(e){
        hidePrompt ();
        clearTimeout (myTimeout); //if they interrupted the hideElem2 fxn, don't mess up other timeouts
        var evtobj = window.event ? event : e; 
        var keycode = evtobj.keyCode;
        if (keycode == undefined) {
            keycode = 0;
        }
        var i = getCookie("elem"); //get i
        i = +i; //convert to int
        justHide (i); //hide element 2 in case they jump the gun
        //get index of response (goes up half as fast as i)
        var j = Math.floor((i+1)/2);
        setCookie("response"+j, keycode, 1); //save response
        if (j == numberQuestions) {
            var url = "../results/saveResponses.php?participant="+participant+"&testVersion="+testVersion+"&";
            for (k=1; k<=numberQuestions;k++) {
                url += k+"="+getCookie("response"+k)+"&";
            }
            window.location = url;
        } 
        setCookie ("elem", i+1, 1); //increment i
        showElem1(); //show
    }

    setCookie ("elem", 1, 1); //set i initially to 1
    showElem1 (); //show
    
