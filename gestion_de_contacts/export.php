<?php
session_start();
// Check if user is logged in
if(!isset($_SESSION['user_id'])){  exit; }

require_once './classes/contacts.class.php';
$con = new Contacts($_SESSION['user_id']);
$contacts = $con->getContacts();

// Handle CSV export request
if(isset($_POST['export_csv'])){
 
    $filename = "contacts_" . date('Y-m-d') . ".csv";
    
    // Set headers to force download the file as CSV
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=' . $filename);

    // Open output stream
    $output = fopen('php://output', 'w');

    // Add column headers to the CSV file
    fputcsv($output, array('Nom et Prenom', 'Telephone', 'Email', 'Adresse'));

    // Loop through contacts and add them to the CSV
    foreach($contacts as $contact) {
        fputcsv($output, array(
            $contact['name'],
            $contact['telephone'],
            $contact['email'],
            $contact['adresse']
        ));
    }
    
    fclose($output);
    exit;
}
?>