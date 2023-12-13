<?php

function postData($url, $token, $postData)
{
    $curl = curl_init();

    // Set URL
    curl_setopt($curl, CURLOPT_URL, $url);
    // Set HTTP method to POST
    curl_setopt($curl, CURLOPT_POST, true);
    // Set headers, including Authorization with Bearer token
    curl_setopt($curl, CURLOPT_HTTPHEADER, [
        'Accept: application/json',
        'Authorization: Bearer ' . $token,
        'Content-Type: application/json',
    ]);
    // Set POST data
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($postData)); // Encode data as JSON
    // Set to return the response as a string
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($curl);

    if (curl_errno($curl)) {
        echo 'Curl error: ' . curl_error($curl);
        print_r(json_decode($response, true));
    } else {
        echo 'Data Berhasil ditambahkan';
    }

    curl_close($curl);

    return $response;
}

$url = "http://127.0.0.1:8000/api/review";
$token = 'jRYqQC4rPB4aVYwuLK2SleYPwYkf2Uy0hgpE43ns0210e76d';
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['tambah_btn'])) {
    // If there are no errors, proceed with API call

    // $nama and $alamat are now validated
    $postData = array(
        'rating' => $_POST['rating'],
        'comment' => $_POST['comment'],
        'book_id' => $_POST['book_id'],
        'reviewer_id' => $_POST['reviewer_id'],
    );

    // Send data to API
    $response = postData($url, $token, $postData);

}

header("location:../reviews.php");
?>