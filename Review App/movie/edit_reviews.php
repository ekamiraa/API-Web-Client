<?php

function putData($url, $token, $putData)
{
    $curl = curl_init();

    // Set URL with the book id
    $url = $url . '/' . $putData['id'];

    // Set HTTP method to PUT
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
    // Set URL
    curl_setopt($curl, CURLOPT_URL, $url);
    // Set headers, including Authorization with Bearer token
    curl_setopt($curl, CURLOPT_HTTPHEADER, [
        'Accept: application/json',
        'Authorization: Bearer ' . $token,
        'Content-Type: application/json',
    ]);
    // Set PUT data
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($putData)); // Encode data as JSON
    // Set to return the response as a string
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($curl);

    if (curl_errno($curl)) {
        echo 'Curl error: ' . curl_error($curl);
        print_r(json_decode($response, true));
    } else {
        echo 'Data Berhasil diupdate';
    }

    curl_close($curl);

    return $response;
}

$url = "http://127.0.0.1:8001/api/review";
$token = '2bgBeDWTmwOtRD85MFuf1OFjFC2hR3MofVEk24Rc5e1c7f4c';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_btn'])) {

    $putData = array(
        'id' => $_POST['id'],
        'rating' => $_POST['rating'],
        'comment' => $_POST['comment'],
        'movie_id' => $_POST['movie_id'],
        'reviewer_id' => $_POST['reviewer_id'],
    );

    // Send data to API
    $response = putData($url, $token, $putData);

    // Output response for debugging
    // echo $response;

}
header("location:../reviews_movie.php");
?>