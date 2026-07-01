        var countDownDate = new Date("April 24, 2022 17:50:20").getTime();
        var x = setInterval(function()
        {
            var now = new Date().getTime();
            var distance = countDownDate - now;
            
            
            var hours = Math.floor((distance%(1000*60*60*24))/(1000*60*60));
            var minute = Math.floor((distance%(1000*60*60))/(1000*60));
            var seconds = Math.floor((distance%(1000*60))/1000);
            
            document.getElementById("Timer").innerHTML = hours + ":" +  minute + ":" + seconds ;
            
            if(distance<0)
            {
                clearInterval(x);
                
                document.getElementById("Timer").innerHTML = "Expird";
            }
        },1000);
