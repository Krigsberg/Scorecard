<html>
<head>
	<link rel="stylesheet" href="style.css">
	<script type="text/javascript">
		function showAvailableCourses() {
			var hcp = document.getElementById("hcp").value;
			var course = document.getElementById("selCourse").value;
			
    		if (course == "-") {
        		document.getElementById("courseTable").innerHTML = "";
        		hide('buttonTotPoints');
        		return;
    		} else { 
        		if (window.XMLHttpRequest) {
            		// code for IE7+, Firefox, Chrome, Opera, Safari
            		xmlhttp = new XMLHttpRequest();
        		} else {
            		// code for IE6, IE5
            		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        		}
        		xmlhttp.onreadystatechange = function() {
            		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                		document.getElementById("courseTable").innerHTML = xmlhttp.responseText;
            		}
        		};
        		xmlhttp.open("POST", "showCourseInfo.php", true);
        		xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        		xmlhttp.send("course="+course + "&hcp="+hcp);
    		}
		}
		
		function calculateTotalPoints() {
			var table = document.getElementById("scoreCardTableBody");
			var totalPoints = 0;
			var totalScore = 0;
			
			for (var i = 0; row = table.rows[i]; i++) {
				var par = parseInt(row.cells[3].innerHTML, 10);
				var extra = parseInt(row.cells[5].innerHTML, 10);
				var strokes = parseInt(row.cells[6].children[0].value, 10);
				
				var points = 0;
				var newPar = par + extra;
				var score = newPar - strokes;
				switch(score) {
    				case -1:
        				points = 1;
        				break;
    				case 0:
        				points = 2;
        				break;
    				case 1:
        				points = 3;
        				break;
    				case 2:
        				points = 4;
        				break;
    				case 3:
        				points = 5;
        				break;
    				case 4:
        				points = 6;
        				break;
    				case 5:
        				points = 7;
        				break;
    				default:
        				points = 0;
				}
				
				row.cells[7].innerHTML = points;
				totalPoints += points;
				totalScore += strokes;
			}
			
			var tableFoot = document.getElementById("scoreCardTableFoot");
			var tableFootRow = tableFoot.rows[0];
			tableFootRow.cells[7].innerHTML = totalPoints;
			tableFootRow.cells[6].innerHTML = totalScore;
		}
		
		function hide(divID) {
			var item = document.getElementById(divID);
			if (item) {
    			if (item.className=='ph-floatUnhidden') {
    				item.className = 'ph-floatHidden';
    			}
			}
		}
		
		function unhide(divID) {
			var item = document.getElementById(divID);
			if (item) {
    			if (item.className=='ph-floatHidden') {
        			item.className = 'ph-floatUnhidden';
    			}
			}
		}
	</script>
</head>
<body>
	<div class="wrapper">
		<div class="scoreCardContainer group">
			<h1 class="heading">
                Score card
            </h1>
			<form id="selectCourseForm">
				<select id="selCourse" name="courseDropDown" onchange="showAvailableCourses()">
				<?php
					include 'connection.php';

					// Add first 'blank' option
					echo "<option value='-'>-</option>";

					// Create select statement
					$sql = "SELECT DISTINCT Course FROM GolfCourse ORDER BY Course asc";
					$result = $conn->query($sql);
					while ($row = $result->fetch_array()) {
						$Course=$row["Course"];
						echo '<option value="'.$Course.'">'.$Course.'</option>'; 
					}	
				
					$conn->close();
				?>
				</select>
				<noscript><input type="submit" value="Submit"></noscript>
			</form>
			<br/>
		
			<div id="hcpInputWrapper">
				<div id="hcpInputTxt">
					<h2>Input hcp</h2>
				</div>
				<div id="hcpInput">
					<input id="hcp" type="number" min="1" max="2"/>
				</div>
				<div id="hcpInputBtn" class="ph-float">
					<button name="getStrokes" value="Get Strokes" class="ph-button ph-btn-green" type="button" onclick="showAvailableCourses(); unhide('buttonTotPoints');">Get Strokes</button>
				</div>
			</div>
			
			<form id="tableSubmit" action="" method="POST">
				<div id="courseTable">
				
				</div>
				<div id="buttonTotPoints" class="ph-floatHidden">
					<button name="calcTotals" value="Calc Totals" class="ph-button ph-btn-green" type="button" onclick="calculateTotalPoints()">Calc Totals</button>
				</div>
			</form>
		</div>
	</div>
</body>
</html>