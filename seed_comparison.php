<?php
include 'config/db.php';

$title = "Top 3 Futuristic Gadgets 2026";
$cat = "gadgets";
$p1 = 44; // Eye Massager
$p2 = 42; // Smart Ring
$p3 = 41; // Crossbody Sling Bag (let's assume it was 41)
// Wait, I saw 41 was Crossbody Sling Bag in the screenshot.

$features = [
    ['name' => 'Innovation Level', 'p1' => 'High', 'p2' => 'Advanced', 'p3' => 'Standard'],
    ['name' => 'Daily Utility', 'p1' => 'Daily Relax', 'p2' => 'Health Tracking', 'p3' => 'Travel'],
    ['name' => 'Value for Money', 'p1' => '9/10', 'p2' => '8/10', 'p3' => '10/10'],
    ['name' => 'Warranty', 'p1' => '1 Year', 'p2' => '6 Months', 'p3' => 'No Warranty']
];
$data = mysqli_real_escape_string($conn, json_encode($features));

$q = "INSERT INTO comparison_tables (title, category, p1_id, p1_label, p2_id, p2_label, p3_id, p3_label, comparison_data, status) 
      VALUES ('$title', '$cat', 44, 'Best for Stress', 42, 'Health Choice', 41, 'Budget Gadget', '$data', 'active')";

if(mysqli_query($conn, $q)){
    echo "Sample comparison table created!";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
