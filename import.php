<?php # index.php
// SQLite database file path
$dbFile = 'system.sqlite'; // Change this if necessary

try {
	// Connect to SQLite
	$pdo = new PDO("sqlite:$dbFile");
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	// Open the CSV file
	$csvFile = 'posts.csv'; // Change this to your actual CSV file
	$handle = fopen($csvFile, 'r');

	if ($handle === false) {
		die("Error opening CSV file.");
	}

	// Read the header row to get column names
	$headers = fgetcsv($handle);

	if (!$headers) {
		die("Error reading CSV headers.");
	}

	// Prepare the INSERT statement
	$stmt = $pdo->prepare("
		INSERT INTO contents (content_title, content_text, content_slug, date_published, date_created, created_by, date_updated, updated_by, content_type) 
		VALUES (:title, :text, :slug, :published_date, :created_date, 'admin', :updated_date, 'admin', 'post')
	");

	// Loop through the CSV rows
	while (($data = fgetcsv($handle, 1000, ',')) !== false) {
		// Combine headers with row values
		$row = array_combine($headers, $data);

		if ($row === false) {
			continue; // Skip invalid rows
		}

		// Map CSV columns to DB columns using header names
		$params = [
			':title'          => $row['post_title'] ?? null,          // post_title -> content_title
			':text'           => $row['post_content'] ?? null,        // post_content -> content_text
			':slug'           => $row['post_url'] ?? null,            // post_url -> content_slug
			':published_date' => $row['post_published_date'] ?? null, // post_published_date -> date_published
			':created_date'   => $row['post_cdate'] ?? null,          // post_cdate -> date_created
			':updated_date'   => $row['post_mdate'] ?? null,          // post_mdate -> date_updated
		];

		// Execute the query
		$stmt->execute($params);
	}

	// Close the CSV file
	fclose($handle);

	echo "CSV import completed successfully.";

} catch (PDOException $e) {
	die("Database error: " . $e->getMessage());
}
?>