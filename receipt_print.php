<?php
require 'connection.php'; // Include your database connection script
require 'fpdf.php'; // Include FPDF library

class PDF extends FPDF {
    function Header() {
        // Logo
        $this->Image('assets/images/gearuplogo.png', 170, 10, 30); // Add image to upper right corner
    }
    
    function Table($data) {
        // Header
        $this->SetFont('Arial', 'B', 12);
        $this->SetFillColor(0, 0, 0); // Black background for header cells
        $this->SetTextColor(255, 255, 255); // White text color for header cells
        foreach ($data[0] as $key => $value) {
            // Exclude 'ProductID' and 'ServiceID' from being displayed in the table
            if ($key !== 'ProductID' && $key !== 'ServiceID') {
                $this->Cell(40, 10, $key, 1, 0, 'C', true);
            }
        }
        $this->Ln();

        // Data
        $this->SetFillColor(255, 204, 0); // Mustard yellow background for data cells
        $this->SetTextColor(0); // Black text color for data cells
        $this->SetFont('Arial', '', 12);
        foreach ($data as $row) {
            foreach ($row as $key => $value) {
                // Exclude 'ProductID' and 'ServiceID' from being displayed in the table
                if ($key !== 'ProductID' && $key !== 'ServiceID') {
                    $this->Cell(40, 10, $value, 1, 0, 'C', true);
                }
            }
            $this->Ln();
        }
    }
}


// Function to generate PDF
    function generatePDF($userInfo, $productsInfo, $servicesInfo, $grandTotal, $subtotal, $tax, $taxrate) {
        // Create new PDF instance
        $pdf = new PDF();
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
            if ($key !== 'user_id') { // Exclude 'user_id' from being displayed
                $pdf->Cell(50, 10, ucfirst(str_replace('_', ' ', $key)) . ':', 0, 0);
                $pdf->Cell(0, 10, $value, 0, 1);
            }
        }

        // Add products information
        $pdf->Ln();
        $pdf->Cell(0, 10, 'Products Information', 0, 1, 'C');
        $pdf->Table($productsInfo);

        // Add services information
        $pdf->Ln();
        $pdf->Cell(0, 10, 'Services Information', 0, 1, 'C');
        $pdf->Table($servicesInfo);

    // Add subtotal, tax, and grand total to the lower right
    $pdf->Ln();
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->SetX($pdf->GetPageWidth() - 90);
    $pdf->Cell(1, 10, 'Subtotal: Php', 0, 0);
    $pdf->SetX($pdf->GetPageWidth() - 60); // Move to the right side of the page
    $pdf->Cell(1, 10, $subtotal, 0, 1);

    $pdf->SetX($pdf->GetPageWidth() - 90);
    $pdf->Cell(1, 10, 'Tax Rate: ', 0, 0);
    $pdf->SetX($pdf->GetPageWidth() - 60); // Move to the right side of the page
    $pdf->Cell(1, 10, $taxrate, 0, 1);

    $pdf->SetX($pdf->GetPageWidth() - 90);
    $pdf->Cell(1, 10, 'Tax: Php', 0, 0);
    $pdf->SetX($pdf->GetPageWidth() - 60); // Move to the right side of the page
    $pdf->Cell(1, 10, $tax, 0, 1);

    $pdf->SetX($pdf->GetPageWidth() - 90);
    $pdf->Cell(1, 10, 'Grand Total: Php', 0, 0);
    $pdf->SetX($pdf->GetPageWidth() - 55); // Move to the right side of the page
    $pdf->Cell(1, 10, $grandTotal, 0, 1);



        // Save PDF to file
        $pdfFilePath = 'pdf/user_receipt.pdf'; // Define path to save the PDF file
        $pdf->Output($pdfFilePath, 'F');

        // Return URL to access the generated PDF
        return $pdfFilePath;
    }

// Retrieve data from the request
$grandTotal = $_POST['grandTotal'];
$subtotal = $_POST['subtotal'];
$tax = $_POST['tax'];
$taxrate = $_POST['taxrate'];

$currentReceiptId = $_POST['currentReceiptId'];

// Fetch user information based on the current receipt ID
$queryUserInfo = "SELECT u.user_id, u.first_name, u.last_name, u.email, u.phone, u.address, u.city
                  FROM receipt r
                  INNER JOIN user_info u ON r.user_id = u.user_id
                  WHERE r.receipt_id = ?";

$stmtUserInfo = $conn->prepare($queryUserInfo);
$stmtUserInfo->bind_param("i", $currentReceiptId);
$stmtUserInfo->execute();
$resultUserInfo = $stmtUserInfo->get_result();
$userInfo = $resultUserInfo->fetch_assoc();
$stmtUserInfo->close();

// Fetch products information based on the current receipt ID
$queryProductsInfo = "SELECT p.ProductID, p.ProductName, p.Price, rp.Quantity
                     FROM products p
                     INNER JOIN receipt_products rp ON p.ProductID = rp.ProductID
                     WHERE rp.receipt_id = ?";

$stmtProductsInfo = $conn->prepare($queryProductsInfo);
$stmtProductsInfo->bind_param("i", $currentReceiptId);
$stmtProductsInfo->execute();
$resultProductsInfo = $stmtProductsInfo->get_result();
$productsInfo = array();
while ($row = $resultProductsInfo->fetch_assoc()) {
    // Rearrange the data structure here
    $productsInfo[] = array(
        'Quantity' => $row['Quantity'],
        'ProductName' => $row['ProductName'],
        'Price' => $row['Price']
    );
}
$stmtProductsInfo->close();


// Fetch services information based on the current receipt ID
$queryServicesInfo = "SELECT s.ServiceID, s.ServiceName, rs.Cost
                      FROM services s
                      INNER JOIN receipt_services rs ON s.ServiceID = rs.ServiceID
                      WHERE rs.receipt_id = ?";

$stmtServicesInfo = $conn->prepare($queryServicesInfo);
$stmtServicesInfo->bind_param("i", $currentReceiptId);
$stmtServicesInfo->execute();
$resultServicesInfo = $stmtServicesInfo->get_result();
$servicesInfo = array();
while ($row = $resultServicesInfo->fetch_assoc()) {
    $servicesInfo[] = $row;
}
$stmtServicesInfo->close();

// Generate PDF with user, products, services information, and grand total
$pdfUrl = generatePDF($userInfo, $productsInfo, $servicesInfo, $grandTotal, $subtotal, $tax, $taxrate);

$conn->close();

// Return URL to access the generated PDF
echo $pdfUrl;
?>
