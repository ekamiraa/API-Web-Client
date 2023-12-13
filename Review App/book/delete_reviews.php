<?php

function deleteData($url, $token, $id)
{
    $curl = curl_init();

    // Set URL with the user id
    $url = $url . '/' . $id;

    // Set HTTP method to DELETE
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
    // Set URL
    curl_setopt($curl, CURLOPT_URL, $url);
    // Set headers, including Authorization with Bearer token
    curl_setopt($curl, CURLOPT_HTTPHEADER, [
        'Accept: application/json',
        'Authorization: Bearer ' . $token,
        'Content-Type: application/json',
    ]);
    // Set to return the response as a string
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($curl);

    if (curl_errno($curl)) {
        echo 'Curl error: ' . curl_error($curl);
        print_r(json_decode($response, true));
    } else {
        echo 'Data Berhasil dideleted';
    }

    curl_close($curl);

    return $response;
}

$url = "http://127.0.0.1:8000/api/review";
$token = 'jRYqQC4rPB4aVYwuLK2SleYPwYkf2Uy0hgpE43ns0210e76d';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    // Validate ID
    if (empty($_POST["id"])) {
        $idErr = "ID is required";
    }

    // If there are no errors, proceed with API call
    if (empty($idErr)) {
        // $id is now validated
        $id = $_POST['id'];

        // Send data to API
        $response = deleteData($url, $token, $id);

        //echo "Response: " . $response;
        // Output response for debugging
        // echo $response;
    }
}

header("location:../reviews.php");
?>