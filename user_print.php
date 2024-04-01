<?php
include "connection.php";
require 'fpdf.php';

class PDF extends FPDF
{
    // Page header
    function Header()
    {
        // Logo at the upper right corner
        $this->Image('assets/images/gearuplogo.png', 260, 10, 30); // Add image to upper right corner
        
        // Title
        $this->SetFont('Arial', 'B', 16);
        $this->Cell(0, 10, 'GEARUP', 0, 1, 'C');
        
        // Line break
        $this->Ln(10);
    
        // Title for the table
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'User Accounts', 0, 1, 'C');
    }

    // Load data
    function LoadData($conn)
    {
        $data = array();
        $sql = "SELECT * FROM user_info";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
        }

        return $data;
    }

// Table
function BasicTable($header, $data)
{
    // Set header colors
    $this->SetFillColor(0);
    $this->SetTextColor(255);

    // Header
    foreach ($header as $col)
        $this->Cell(30, 7, $col, 1, 0, 'C', true); // Fill header cells with black color
    $this->Ln();
    
    // Reset colors
    $this->SetFillColor(255);
    $this->SetTextColor(0);

    // Data
    $fill = false;
    foreach ($data as $row) {
        foreach ($row as $col) {
            // Check if cell has a value
            if (!empty($col)) {
                // Set light gray fill color for cells with values
                $this->SetFillColor(211, 211, 211); // Light gray color
                $fill = true;
            } else {
                // Reset fill color for empty cells
                $this->SetFillColor(255);
                $fill = false;
            }
            $this->Cell(30, 6, $col, 1, 0, 'C', $fill);
        }
        $this->Ln();
    }
}

}

// Instanciation of inherited class with 'L' parameter for landscape orientation
$pdf = new PDF('L');
$pdf->AddPage();

// Column headings
$header = array('Customer ID', 'First Name', 'Last Name', 'Phone Number', 'Home Address', 'City', 'Email', 'Password', 'Image');

// Data loading
$data = $pdf->LoadData($conn);

// Printing table
$pdf->SetFont('Arial', '', 10);
$pdf->BasicTable($header, $data);

mysqli_close($conn);
$pdf->Output();
?>
