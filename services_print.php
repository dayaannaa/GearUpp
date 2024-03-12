<?php
require('fpdf.php');
include "connection.php";

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->SetAutoPageBreak(true, 10);
$pdf->Image('assets/images/gearuplogo.png', 170, 10, 30);
$pdf->Cell(190, 10, "GEARUP", 0, 1, 'C');
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(190, 10, "", 0, 1, 'C');

$pdf->Cell(190, 10, 'Services List', 0, 1, 'C');

// Set header background color to black
$pdf->SetFillColor(0, 0, 0);
$pdf->SetTextColor(255, 255, 255); // Set text color to white
$pdf->Cell(30, 8, 'Service ID', 1, 0, 'C', true);
$pdf->Cell(50, 8, 'Service Name', 1, 0, 'C', true);
$pdf->Cell(30, 8, 'Price', 1, 0, 'C', true);
$pdf->Cell(80, 8, 'Description', 1, 1, 'C', true);

// Reset text color to black for the body
$pdf->SetTextColor(0, 0, 0);
$sql = "SELECT ServiceID, ServiceName, Price, Description FROM Services";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $pdf->SetFont('Arial', '', 10);
        // Set body background color to light gray (instead of mustard yellow)
        $pdf->SetFillColor(211, 211, 211);
        $pdf->Cell(30, 8, $row["ServiceID"], 1, 0, 'C', true);
        $pdf->Cell(50, 8, $row["ServiceName"], 1, 0, 'C', true);
        $pdf->Cell(30, 8, $row["Price"], 1, 0, 'C', true);
        $pdf->MultiCell(80, 8, $row["Description"], 1, 'C', true);
    }
} else {
    // Set body background color to light gray (instead of mustard yellow)
    $pdf->SetFillColor(211, 211, 211);
    $pdf->Cell(190, 8, 'No Services found', 1, 1, 'C', true);
}

mysqli_close($conn);

$pdf->Output();
?>
