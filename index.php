<?php
	$getdataURL = 'getdata.php';
	$PARTY_ID = 0;
	$STEP_ID = 0;
?>
<!DOCTYPE html>
<HTML>
	<head>
		<style>
			body
			{
				width: 95vw;
				height: 95vh;
				margin: 5px;
			}
			.mainblock
			{
				background-color: green;
			}
			
			.hidden
			{
				display: none;
			}
			
			#preloader
			{
				position: static;
				margin-left: 40%;
				margin-top: 10%;
				display: none;
			}
		</style>
	</head>
	<body>
		<div id="preloader">
			<img src="img/preloader.gif">
		</div>
		<div id="div_0" class="mainblock">
			<label>Введите код приглашения <input type="text" name="partyid"></label><br>
			<button id="connect_to">Присоедениться</button>
			<br>
			<br>
			<label>Или <button id="create_new">Создайте свою партию</button></label>
		</div>
		<div id="div_1" class="mainblock">
			<label>Размер пули <input type="number" name="bullet" value="3"></label><br>
			<label>Имя первого игрока (Ваше) <input type="text" name="first"></label><br>
			<label>Имя второго игрока <input type="text" name="second"></label><br>
			<label>Имя третьего игрока (гусарика не гоняем ;-) ) <input type="text" name="third"></label><br>
			<label>Имя четвертого игрока (или пусто, если на троих) <input type="text" name="fourth"></label><br>
			<button id="connect_to">Создать пулю</button>
		</div>
		<div id="div_2" class="mainblock">
			Здесь будет основной контент!
		</div>
	</body>
	<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
	<script>
		var PARTY_ID = <?=$PARTY_ID?>;
		var getdataURL = '<?=$getdataURL?>';
		var STEP_ID = <?=$STEP_ID?>;
		
		$(document).ready(
			function ()
			{
				$("button").on("click",
					function ()
					{
						let elem = $(this);
						let commandID = elem.attr("id");
						switch(commandID)
						{
							case "connect_to":
									let sendData = new Object();
									sendData.command = commandID;
									sendData.partyid = $("#partyid").val();
									SendIt(sendData);
								break;
							case "create_new":
									shiftTab(STEP_ID);
								break;
							default:
								alert("Это какая-то новая кнопка. Разработчик не в курсе про неё!");
								break;
						}
					}
				);

				$(".mainblock").addClass("hidden");	
				shiftTab(STEP_ID);
				
			}
		);
		
		function shiftTab(newTabID)
		{
			$('#div_' + STEP_ID).addClass("hidden");
			STEP_ID = newTabID;
			$('#div_' + STEP_ID).removeClass("hidden");
		}
		
		function fadeTab(inout,delay)
		{
			if (inout == "in")
				$('#div_' + STEP_ID).fadeIn(delay);
			else
				$('#div_' + STEP_ID).fadeOut(delay);
		}
		
		function SendIt(dataObject, successCallBack)
		{
			$.ajax(
			{
				method: "post",
				dataType: 'json',
				data: encodeURIComponent(JSON.stringify(dataObject)),
				url: getdataURL,
				beforeSend: function () { 
						event.stopImmediatePropagation();
						fadeTab("out",1);
						$("#preloader").css("display","block");
					},
				complete: function () { 
						fadeTab("in",1000);
						$("#preloader").css("display","none");
					},
				success: function(msg)
					{
						let cbf = window[successCallBack];
						if (cbf != null && typeof(cbf) == 'function')
							cbf(msg);
					}
			});
		}
	</script>
</HTML>