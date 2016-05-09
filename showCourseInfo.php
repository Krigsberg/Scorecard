<!DOCTYPE html>
<html>
<head>
<style>
	table, th, td {
		border-radius: 10px;
		background: #ECEBBD;
		border-collapse: collapse;
	}
			
	tr {
		padding-top: 3px;
		padding-left: 3px;
	}
			
	th, td {
		padding: 5px;
		font-family: Helvetica;
		text-align: center;
	}
</style>
</head>
<body>
	<?php
		include 'connection.php';
		$course = $_POST["course"];
	
		// Create select statement
		$sql = "SELECT * FROM GolfCourse WHERE Course = '" .$course. "'";
		$result = $conn->query($sql);

		// Loop through result array
		if ($result->num_rows > 0) {
     		echo("<table>");
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
					
     		// Output data of each row
     		while ($row = $result->fetch_assoc()) {
         		echo "
         			<tr>
         				<td>" . $row["Hole"]. "</td>
         				<td>" . $row["Par"]. "</td>
         				<td>" . $row["Index"]. "</td>
         				<td>" . $row["LengthRed"]. "</td>
         				<td>" . $row["LengthYellow"]. "</td>
         				<td>" . ES . "</td>
         				<td>" . S . "</td>
         				<td>" . P . "</td>
         			</tr>";
     		}
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