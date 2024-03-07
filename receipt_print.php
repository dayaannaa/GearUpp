<?php
require 'connection.php'; // Include your database connection script
require 'fpdf.php'; // Include FPDF library

// Function to generate PDF
function generatePDF($userInfo) {
    // Create new FPDF instance
    $pdf = new FPDF();
    $pdf->AddPage();
    
    // Set font
    $pdf->SetFont('Arial', 'B', 16);
    
    // Title
    $pdf->Cell(0, 10, 'GEARUP', 0, 1, 'C');
    
    // User information
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, 'User Information', 0, 1, 'C');
    $pdf->Ln(); // Add a line break
    
    // Output user information
    foreach ($userInfo as $key => $value) {
        $pdf->Cell(50, 10, ucfirst(str_replace('_', ' ', $key)) . ':', 0, 0);
        $pdf->Cell(0, 10, $value, 0, 1);
    }
    
    // Save PDF to file
    $pdfFilePath = 'pdf/user_receipt.pdf'; // Define path to save the PDF file
    $pdf->Output($pdfFilePath, 'F');
    
    // Return URL to access the generated PDF
    return $pdfFilePath;
}

// Retrieve data from the request
$grandTotal = $_POST['grandTotal'];
$currentReceiptId = $_POST['currentReceiptId'];

// Fetch user information based on the current receipt ID
$query = "SELECT u.user_id, u.first_name, u.last_name, u.email, u.phone, u.address, u.city
          FROM receipt r
          INNER JOIN user_info u ON r.user_id = u.user_id
          WHERE r.receipt_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $currentReceiptId);
$stmt->execute();
$result = $stmt->get_result();
$userInfo = $result->fetch_assoc();
$stmt->close();

// Generate PDF with user information
$pdfUrl = generatePDF($userInfo);

$conn->close();

// Return URL to access the generated PDF
echo $pdfUrl;
?>
