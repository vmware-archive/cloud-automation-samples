
<?php

// Get the request method
$method = getMethod();
// Set the header to application/json
header('Content-Type: application/json');

try {
    // Switch the base URL
    switch(getBaseUrl()){
        case "/traffic": {
            // include script to get data
            include 'getTrafficData.php';
            // Render JSON response with the result data
            renderJsonResponse($result);
            break;
        }
        default: {
            // No function found for the given base URL
            throw new \Exception("API function not found.", 404);
        }
    }
    
} catch (Exception $ex) {
    // Render JSON error response with the exception data
    renderJsonResponse(array("error" => array("message"=>$ex->getMessage(), "code" => $ex->getCode())));
}
exit(0);

/**
 * Get the request method
 * Return GET, POST, DELETE or PUT
 * 
 * @return string
 */
function getMethod() {
    return strtoupper($_SERVER['REQUEST_METHOD']);
}
/**
 * Get the base URL without the script name and jquery params
 * 
 * @return string
 */
function getBaseUrl(){
    $url = str_replace($_SERVER['SCRIPT_NAME'], "", $_SERVER['REQUEST_URI']);
    return explode("?", $url)[0];
}
/**
 * Get a JSON string from the $data array
 * 
 * @param array $data
 * @return string
 */
function renderJsonResponse(array $data = array()) {
    $data['request_time'] = time();
    echo json_encode($data);
}
