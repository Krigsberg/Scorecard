<html>
<head>
	<link rel="stylesheet" href="style.css">
	<script>
		function showAvailableCourses() {
			var hcp = document.getElementById("hcp").value;
			var course = document.getElementById("selCourse").value;
			
    		if (course == "-") {
        		document.getElementById("courseTable").innerHTML = "";
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
	</script>
</head>
<body>
	<div class="wrapper">
		<div class="scoreCardContainer group">
			<h1 class="heading">
                Score card
            </h1>
			<form id="selectCourseForm">
				<select id="selCourse" name="courseDropDown" onchange="showAvailableCourses();">
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
		
			<div id="hcpInput">
				<input id="hcp" type="number"/>
				<button onclick="showAvailableCourses()">Calc</button>
				<p id="demo"></p>
			</div>
			
			<div id="courseTable">
				
			</div>
		</div>
	</div>
</body>
</html>