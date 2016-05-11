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
		
		// Init. sum variables
		$totalPar = 0;
		$totalLengthRed = 0;
		$totalLengthYellow = 0;
		$numOfHoles = 0;
		$strokes = 0;
		$slopeArray = array();
	
		// Create and execute SQL to get course info
		$sql = "SELECT * FROM GolfCourse WHERE Course = '" .$course. "'";
		$result = $conn->query($sql);
		$numOfHoles = $result->num_rows;

		$extraStrokePerHoleArray = array_fill(1, $numOfHoles, 0);
		
		if (isset($hcp)) {
			$strokesSql = "SELECT * FROM Slope WHERE Course = '" .$course. "' AND HcpFrom <= '" .$hcp. "' AND HcpTo >= '" .$hcp. "'";
			$strokesResult = $conn->query($strokesSql);


			// Get number of strokes
			if ($strokesResult->num_rows > 0) {
				while ($row = $strokesResult->fetch_assoc()) {
					$strokes = $row["Strokes"];
					break;
				}
			}
			
			// Create another SQL to get index/hole relation
			$arraySql = "SELECT Hole, `Index` FROM GolfCourse WHERE Course = '" .$course. "' ORDER BY `Index` ASC";
			$arrayResult = $conn->query($arraySql);
			while ($row = $arrayResult->fetch_assoc()) {
				$slopeArray[$row["Hole"]] = $row["Index"];
			}
			
			// Calculate strokes per hole
			$count = 1;
			foreach ($slopeArray as $key => $value) {
				if ($count <= $strokes) {
					$extraStrokePerHoleArray[$key] += 1;
				}
				$count++;
			}
			if ($count <= $strokes) {
				foreach ($slopeArray as $key => $value) {
					if ($count <= $strokes) {
						$extraStrokePerHoleArray[$key] += 1;
					}
					$count++;
				}
			}
			if ($count <= $strokes) {
				foreach ($slopeArray as $key => $value) {
					if ($count <= $strokes) {
						$extraStrokePerHoleArray[$key] += 1;
					}
					$count++;
				}
			}
		}

		// CREATE TABLE
		if ($result->num_rows > 0) {
     		echo("<table id='scoreCardTable'>");
			// TABLE HEAD
			echo "<thead>";
     		echo "	<tr>
     					<th>Hole</th>
     					<th>Length (Red)</th>
     					<th>Length (Yellow)</th>
     					<th>Par</th>
     					<th>Index</th>
     					<th>Extra strokes</th>
     					<th>Strokes</th>
     					<th>Points</th>
     				</tr>";
			echo "</thead>";
			
			// TABLE BODY
			echo "<tbody id ='scoreCardTableBody'>";
     		while ($row = $result->fetch_assoc()) {
     			$totalPar += $row["Par"];
				$totalLengthRed += $row["LengthRed"];
				$totalLengthYellow += $row["LengthYellow"];
				
         		echo "
         			<tr>
         				<td>" . $row["Hole"]. "</td>
         				<td>" . $row["LengthRed"]. "</td>
         				<td>" . $row["LengthYellow"]. "</td>
         				<td>" . $row["Par"]. "</td>
         				<td>" . $row["Index"]. "</td>
         				<td>" . $extraStrokePerHoleArray[$row["Hole"]] . "</td>
         				<td>" . '<input type="number" name="strokes" min="1" max="20" maxlength="2" size="3" value="5">' . "</td>
         				<td>" . 0 . "</td>
         			</tr>";
     		}
			echo "</tbody>";
			
			// TABLE FOOTER
			echo "<tfoot id ='scoreCardTableFoot'>";
			echo "	<tr>
     					<td>" . '' . "</td>
     					<td>" . $totalLengthRed . "</td>
     					<td>" . $totalLengthYellow . "</td>
     					<td>" . $totalPar . "</td>
     					<td>" . '' . "</td>
     					<td>" . $strokes . "</td>
     					<td>" . '0' . "</td>
     					<td>" . '0' . "M</td>
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