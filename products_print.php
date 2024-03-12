<?php
require('fpdf.php');
include "connection.php";

class PDF extends FPDF {
    function Header() {
        // Set header background color to black
        $this->SetFillColor(0, 0, 0);
        // Set text color to white
        $this->SetTextColor(0, 0, 0); // Change text color to black
        $this->Image('assets/images/gearuplogo.png', 170, 10, 30);
        $this->SetFont('Arial', 'B', 16);
        $this->Cell(190, 10, "GEARUP", 0, 1, 'C');
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(190, 10, "", 0, 1, 'C');
        $this->Cell(190, 10, 'Products List', 0, 1, 'C');
    
        // Set header background color to black
        $this->SetFillColor(0, 0, 0);
        // Set text color to white
        $this->SetTextColor(255, 255, 255);
        $this->Cell(70, 8, 'Product Name', 1, 0, 'C', true);
        $this->Cell(40, 8, 'Price', 1, 0, 'C', true);
        $this->Cell(80, 8, 'Description', 1, 1, 'C', true);
    }
    
}

$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 10);
$pdf->SetAutoPageBreak(true, 10);

$sql = "SELECT ProductName, Description, Price FROM Products";
$result = mysqli_query($conn, $sql);

// Set body background color to gray for all rows
$pdf->SetFillColor(211, 211, 211);
$pdf->SetTextColor(0);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $pdf->Cell(70, 8, $row["ProductName"], 1, 0, 'L', true);
        $pdf->Cell(40, 8, $row["Price"], 1, 0, 'R', true);
        $pdf->MultiCell(80, 8, $row["Description"], 1, 'L', true);
    }
    $pdf->SetY($pdf->GetY() + 10);
} else {
    $pdf->Cell(190, 8, 'No Products found', 1, 1, 'C');
}

mysqli_close($conn);

$pdf->Output();
?>
