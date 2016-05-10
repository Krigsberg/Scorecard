<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<?php
		include 'connection.php';
		$course = $_POST["course"];
		$hcp = $_POST["hcp"];
	
		$sql = "SELECT * FROM GolfCourse WHERE Course = '" .$course. "'";
		$result = $conn->query($sql);

		if ($result->num_rows > 0) {
     		echo("<table id='scoreCardTable'>");
			// TABLE HEAD
			echo "<thead>";
     		echo "	<tr>
     					<th>Hole</th>
     					<th>Par</th>
     					<th>Index</th>
     					<th>Length (Red)</th>
     					<th>Length (Yellow)</th>
     					<th>Extra strokes</th>
     					<th>Strokes</th>
     					<th>Points</th>
     				</tr>";
			echo "</thead>";
			
			// TABLE BODY
			echo "<tbody>";
     		while ($row = $result->fetch_assoc()) {
         		echo "
         			<tr>
         				<td>" . $row["Hole"]. "</td>
         				<td>" . $row["Par"]. "</td>
         				<td>" . $row["Index"]. "</td>
         				<td>" . $row["LengthRed"]. "</td>
         				<td>" . $row["LengthYellow"]. "</td>
         				<td>" . 'ES' . "</td>
         				<td>" . '<input type="number" name="strokes" min="1" max="20" maxlength="2" size="3" value="0">' . "</td>
         				<td>" . $hcp . "</td>
         			</tr>";
     		}
			echo "</tbody>";
			
			// TABLE FOOTER
			echo "<tfoot>";
			echo "	<tr>
     					<td>" . '' . "</td>
     					<td>" . '72' . "</td>
     					<td>" . '' . "</td>
     					<td>" . '9500' . "</td>
     					<td>" . '9850' . "</td>
     					<td>" . '18' . "</td>
     					<td>" . 'SUM' . "</td>
     					<td>" . 'SUM' . "M</td>
     				</tr>";
			echo "</tfoot>";
     		echo "</table>";
		} else {
			echo "$course";
			echo "$sql";
     		echo "0 results";
		}
		
		$conn->close();
	?>
</body>
</html>