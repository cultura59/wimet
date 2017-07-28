<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Wimet.co</title>
	<meta content="width=device-width, initial-scale=1.0, user-scalable=no" name="viewport">
	<style>
		html {
		  box-sizing: border-box;
		}

		*, *:before, *:after {
		  box-sizing: inherit;
		}

		html,
		body {
		  background: url(https://res.cloudinary.com/wimet/image/upload/wimet_inspiring_venue_startup_gqsbqg.jpg);
		  width: 100%;
		  height: 100%;
		  margin:0;
		}

		#countdown {
		  position: relative;
		  top: 50%;
		  transform: translateY(-50%);
		  width: 50%;
		  margin: 0 auto;
		  padding: 15px 0 20px 0;
		  color: #fff;
		  border: 1px solid #fff;
		  border-width: 1px 0;
		  overflow: hidden;
		  font-family: 'Arial Narrow', Arial, sans-serif;
		  font-weight: bold;
		}
		#countdown > .container-img {
			display: flex;
			justify-content: center;
			align-items: center;
		}
		#countdown > .container-img > img {
			width: 350px;
			margin-top: 20px;
		}
		#countdown ul > li {
		  margin: 0 -3px 0 0;
		  padding: 0;
		  display: inline-block;
		  width: 24%;
		  font-size: 72px;
		  font-size: 6vw;
		  text-align: center;
		}
		#countdown ul > li .label {
		  color: #fff;
		  font-size: 18px;
		  font-size: 1.5vw;
		  text-transform: uppercase;
		}
	</style>
</head>
<body>
	<div id="countdown">
		<div class="container-img">
			<img src="/img/wimet_footer_logo_light.svg" alt="Wimet">
		</div>
		<ul>
			<li id="days">
				<div class="number">00</div>
				<div class="label">DÍAS</div>
			</li>
			<li id="hours">
				<div class="number">00</div>
				<div class="label">HORAS</div>
			</li>
			<li id="minutes">
				<div class="number">00</div>
				<div class="label">MINUTOS</div>
			</li>
			<li id="seconds">
				<div class="number">00</div>
				<div class="label">SEGUNDOS</div>
			</li>
		</ul>
	</div>
	<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
	<script>
		/* --------------------------
		 * GLOBAL VARS
		 * -------------------------- */
		// The date you want to count down to
		var targetDate = new Date("2017/08/01 11:00:00");   

		// Other date related variables
		var days;
		var hrs;
		var min;
		var sec;

		/* --------------------------
		 * ON DOCUMENT LOAD
		 * -------------------------- */
		$(function() {
		   // Calculate time until launch date
		   timeToLaunch();
		  // Transition the current countdown from 0 
		  numberTransition('#days .number', days, 1000, 'easeOutQuad');
		  numberTransition('#hours .number', hrs, 1000, 'easeOutQuad');
		  numberTransition('#minutes .number', min, 1000, 'easeOutQuad');
		  numberTransition('#seconds .number', sec, 1000, 'easeOutQuad');
		  // Begin Countdown
		  setTimeout(countDownTimer,1001);
		});

		/* --------------------------
		 * FIGURE OUT THE AMOUNT OF 
		   TIME LEFT BEFORE LAUNCH
		 * -------------------------- */
		function timeToLaunch(){
		    // Get the current date
		    var currentDate = new Date();

		    // Find the difference between dates
		    var diff = (currentDate - targetDate)/1000;
		    var diff = Math.abs(Math.floor(diff));  

		    // Check number of days until target
		    days = Math.floor(diff/(24*60*60));
		    sec = diff - days * 24*60*60;

		    // Check number of hours until target
		    hrs = Math.floor(sec/(60*60));
		    sec = sec - hrs * 60*60;

		    // Check number of minutes until target
		    min = Math.floor(sec/(60));
		    sec = sec - min * 60;
		}

		/* --------------------------
		 * DISPLAY THE CURRENT 
		   COUNT TO LAUNCH
		 * -------------------------- */
		function countDownTimer(){ 
		    
		    // Figure out the time to launch
		    timeToLaunch();
		    
		    // Write to countdown component
		    $( "#days .number" ).text(days);
		    $( "#hours .number" ).text(hrs);
		    $( "#minutes .number" ).text(min);
		    $( "#seconds .number" ).text(sec);
		    
		    // Repeat the check every second
		    setTimeout(countDownTimer,1000);
		}

		/* --------------------------
		 * TRANSITION NUMBERS FROM 0
		   TO CURRENT TIME UNTIL LAUNCH
		 * -------------------------- */
		function numberTransition(id, endPoint, transitionDuration, transitionEase){
		  // Transition numbers from 0 to the final number
		  $({numberCount: $(id).text()}).animate({numberCount: endPoint}, {
		      duration: transitionDuration,
		      easing:transitionEase,
		      step: function() {
		        $(id).text(Math.floor(this.numberCount));
		      },
		      complete: function() {
		        $(id).text(this.numberCount);
		      }
		   }); 
		};
	</script>
</body>
</html>