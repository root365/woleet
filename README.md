# woleet
A Repository That enables PHP developer to Work with Woleet Blockchain API. Each function of woleet api is implemented. You just need to supply the required paramenters. This solution uses PHP 5.6 and PHP-CURL to make request to woleet server. 

**USAGE:**

require ("classWoleetManager.php");

$woleetManager = new WoleetManager();

$woleetManager->createAnchor(<<supply here the parameters of the function>>);

$anchor = $woleetManager->getResponseBody();

$andhor_data = json_decode($anchor);

/* to get anchor id */
$anchor_id = $anchor->data->id;
print($anchor_id);

/* Save your anchor id to your database etc. */
