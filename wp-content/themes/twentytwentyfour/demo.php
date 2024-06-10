<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<?php
$api_key = 'pat1Zq5bzzGK0YqIZ.2f075f0a08414f8cb2e90a02e4c4f0996219a98cdd444480aa71c2a4e7f77a5e';
$base_id = 'appqoCpjGWk1V4UiV';
$table_name = 'tblzlZld1znOjukUc';

// Set up the URL for the Airtable API endpoint
$url = "https://api.airtable.com/v0/{$base_id}/{$table_name}";

// Set up the request headers with the API key
$headers = array(
    'Authorization' => 'Bearer ' . $api_key,
);

// Make the API request to Airtable
$response = wp_remote_get( $url, array(
    'headers' => $headers,
) );
echo "<pre>";
// print_r($response);die;
// Check if the request was successful
// Make sure the response is successful
// Make sure the response is successful
if ( ! is_wp_error( $response ) && wp_remote_retrieve_response_code( $response ) === 200 ) {
    // Get the body of the response
    $body = wp_remote_retrieve_body( $response );
    // Decode the JSON string
    $data = json_decode( $body, true );
    
    // Check if decoding was successful
    if ( $data !== null ) {
        // Check if there are records in the response
        if ( ! empty( $data['records'] ) ) {
            // Loop through the records and display them
            foreach ( $data['records'] as $record ) {
                
                $fields = $record['fields'];
                if(!empty($fields)){
                    // print_r($fields);

                
                // Check if the 'Name' and 'Notes' keys exist in the record
                if (isset($fields['Name']) && isset($fields['Notes']) && isset($fields['Assignee']['email']) && isset($fields['Assignee']['name']) && isset($fields['Status'])) {
                    // Start the table row
                    echo '<div class="table-responsive">';
                    echo '<table id="custom-table"  class="table">';
                    
                    // Table headers
                    echo '<thead>';
                    echo '<tr>';
                    echo '<th scope="col">Name</th>';
                    echo '<th scope="col">Notes</th>';
                    echo '<th scope="col">Assignee Email</th>';
                    echo '<th scope="col">Assignee Name</th>';
                    echo '<th scope="col">Status</th>';
                    echo '</tr>';
                    echo '</thead>';
                    
                    // Table body
                    echo '<tbody>';
                    echo '<tr>';
                    // echo '<th scope="row">1</th>';
                    // Table data
                    echo '<td>' . esc_html($fields['Name']) . '</td>';
                    echo '<td>' . esc_html($fields['Notes']) . '</td>';
                    echo '<td>' . esc_html($fields['Assignee']['email']) . '</td>';
                    echo '<td>' . esc_html($fields['Assignee']['name']) . '</td>';
                    echo '<td>' . esc_html($fields['Status']) . '</td>';
                    
                    echo '</tr>';
                    echo '</tbody>';
                    
                    // End the table
                    echo '</table>';
                    echo '</div>';
                } else {
                    // Echo if any required field is missing
                    echo 'Name, Notes, Assignee Email, Assignee Name, or Status field is missing.';
                }
            }
            }
        } else {
            echo 'No records found.';
        }
    } else {
        echo 'Error decoding JSON.';
    }
} else {
    echo 'Error retrieving data from Airtable.';
}
?>


<!-- Include JavaScript for table sorting -->
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script>
    jQuery(document).ready(function($) {
        $('#custom-table').DataTable();
    });
</script>