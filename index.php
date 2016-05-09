<html>
<head>
	<style>
		#course-select {
			font-family: Helvetica;
			width: 350px;
			margin-left: 140px;
			margin-bottom: 2px;
		}	
		#hcpInput {
			font-family: Helvetica;
			width: 350px;
			margin-left: 140px;
			margin-bottom: 5px;
		}	
	</style>
	<script>
		function showAvailableCourses(str) {
    		if (str.value == "-") {
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
        		xmlhttp.send("course="+str.value);
    		}
		}
		
		function calculatePoints() {
			var hcp = document.getElementById("hcp").value;
			document.getElementById("demo").innerHTML = hcp;
		}
	</script>
</head>
<body>
	<div id="course-select">
		<form id="selectCourseForm">
			<select name="courseDropDown" onchange="showAvailableCourses(this);">
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
			<button onclick="calculatePoints()">Calc</button>
			<p id="demo"></p>
		</div>
		
		<div id="courseTable">
			
		</div>
	</div>
</body>
</html>