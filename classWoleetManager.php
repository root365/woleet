<?php
/**
 * Created by PhpStorm.
 * User: ma_sa
 * Date: 07/22/2018
 * Time: 9:36 PM
 */
require_once('config.php');
require_once('classCurlHandler.php');

/**
 * Class WoleetManager
 */
class WoleetManager {
    /*
     * This class impliments curl methods to make requests to Woleet API.
     *
     **/
    private $curlHandler = null;
    private $base_url = null;
    private $auth_username = null;
    private $auth_password = null;
    private $response_code = null;
    private $response_body = null;
    private $response_header = null;
    /**
     * @return int|null
     */
    public function getResponseCode() {
        return $this->response_code;
    }
    
    /**
     * @return null|string
     */
    public function getResponseHeader() {
        return $this->response_header;
    }
    
    /**
     * @return null|string
     */
    public function getResponseBody() {
        return $this->response_body;
    }
    
    public function __construct() {
        $this->base_url = "https://api.woleet.io/v1";
        $this->curlHandler = new CurlHandler($this->base_url);
        $this->auth_username = "youremailforwoleet";
        $this->auth_password = "yourpasswordforwoleet";
        $this->curlHandler->setAuthName($this->auth_username);
        $this->curlHandler->setAuthPass($this->auth_password);
        $this->response_code = 0;
        $this->response_header = "";
        $this->response_body = "";
    }
    
    
    /**
     * @param $name
     * @param $hash
     * @param string $signedHash
     * @param string $pubKey
     * @param string $signature
     * @param string $identityURL
     * @param bool $public
     * @param bool $notifyByEmail
     * @param array $tags
     * @param array $metadata
     * @param string $callbackURL
     * @return mixed
     */
    public function createAnchor($name, $hash, $tags = array(), $metadata = array(), $callbackURL = "", $public = true,
                                 $signedHash = "", $pubKey = "", $signature = "", $identityURL = "",
                                 $notifyByEmail = false) {
        
        
        $anchor_data = array("name" => $name, "hash" => $hash, "public" => $public, "notifyByEmail" => $notifyByEmail);
        
        if (!empty($signedHash)) {
            $anchor_data["signedHash"] = $signedHash;
        }
        if (!empty($pubKey)) {
            $anchor_data["pubKey"] = $pubKey;
        }
        if (!empty($signature)) {
            $anchor_data["signature"] = $signature;
        }
        if (!empty($identityURL)) {
            $anchor_data["identityURL"] = $identityURL;
        }
        if (!empty($tags)) {
            $anchor_data["tags"] = $tags;
        }
        if (!empty($metadata)) {
            $anchor_data["metadata"] = $metadata;
        }
        if (!empty($callbackURL)) {
            $anchor_data["callbackURL"] = $callbackURL;
        }
        
        $this->curlHandler->useAuth(true);
        $this->curlHandler->makeHTTPHeader("application/json", "application/json");
        $this->curlHandler->setIncludeHeader(true);
        /*echo "<pre>";
        print_r(json_encode($anchor_data));
        echo "</pre>";*/
        $this->curlHandler->post("/anchor", json_encode($anchor_data));
        $result = $this->curlHandler->getResponse();
        $this->response_code = $this->curlHandler->getStatus();
        $this->getHeaderAndBody($result);
        return $result;
        
    }
    
    /**
     * @param $anchor_id
     * @return mixed
     */
    public function getAnchor($anchor_id) {
        $this->curlHandler->useAuth(true);
        $this->curlHandler->makeHTTPHeader("application/json", "application/json");
        $this->curlHandler->setIncludeHeader(true);
        $this->curlHandler->get("/anchor/" . $anchor_id, null);
        $result = $this->curlHandler->getResponse();
        $this->response_code = $this->curlHandler->getStatus();
        $this->getHeaderAndBody($result);
        return $result;
    }
    
    /**
     * @param $anchor_id
     * @param $name
     * @param $hash
     * @param string $signedHash
     * @param string $pubKey
     * @param string $signature
     * @param string $identityURL
     * @param bool $public
     * @param bool $notifyByEmail
     * @param array $tags
     * @param array $metadata
     * @param string $callbackURL
     * @return mixed
     */
    public function updateAnchor($anchor_id, $name, $hash, $signedHash = "", $pubKey = "", $signature = "",
                                 $identityURL = "", $public = true, $notifyByEmail = false, $tags = array(),
                                 $metadata = array(), $callbackURL = "") {
    
        $anchor_data = array("name" => $name, "hash" => $hash, "public" => $public, "notifyByEmail" => $notifyByEmail);
        if (!empty($signedHash)) {
            $anchor_data["signedHash"] = $signedHash;
        }
        if (!empty($pubKey)) {
            $anchor_data["pubKey"] = $pubKey;
        }
        if (!empty($signature)) {
            $anchor_data["signature"] = $signature;
        }
        if (!empty($identityURL)) {
            $anchor_data["identityURL"] = $identityURL;
        }
        if (!empty($tags)) {
            $anchor_data["tags"] = $tags;
        }
        if (!empty($metadata)) {
            $anchor_data["metadata"] = $metadata;
        }
        if (!empty($callbackURL)) {
            $anchor_data["callbackURL"] = $callbackURL;
        }
    
        $this->curlHandler->useAuth(true);
        $this->curlHandler->makeHTTPHeader("application/json", "application/json");
        $this->curlHandler->setIncludeHeader(true);
        /*echo "<pre>";
        print_r(json_encode($anchor_data));
        echo "</pre>";*/
        $this->curlHandler->put("/anchor/" . $anchor_id, json_encode($anchor_data));
        $result = $this->curlHandler->getResponse();
        $this->response_code = $this->curlHandler->getStatus();
        $this->getHeaderAndBody($result);
        return $result;
    }
    
    /**
     * @param $anchor_id
     * @return mixed
     */
    public function deleteAnchor($anchor_id) {
        $this->curlHandler->useAuth(true);
        $this->curlHandler->makeHTTPHeader("application/json", "application/json");
        $this->curlHandler->setIncludeHeader(true);
        $this->curlHandler->delete("/anchor/" . $anchor_id, null);
        $result = $this->curlHandler->getResponse();
        $this->response_code = $this->curlHandler->getStatus();
        $this->getHeaderAndBody($result);
        return $result;
    }
    
    
    /**
     * @param $hash
     * @param int $page
     * @param int $per_page_results
     * @param null $signedHash
     * @return mixed
     */
    public function searchPublicAnchor($hash, $page=0, $per_page_results=20, $signedHash=null){
        /**
            This function is to search all the public anchors only. and it returns only the publich anchors id's only.
         
         */
        
        $anchor_data = array("hash"=>$hash, "page"=>$page, "size"=>$per_page_results, "signedHash"=>$signedHash);
        if($page!=0){
            $anchor_data["page"] = $page;
        }
        
        if($per_page_results!=20){
            $anchor_data["size"] = $per_page_results;
        }
        
        if(!empty($signedHash)){
            $anchor_data["signedHash"] = $signedHash;
        }
        
        $this->curlHandler->makeHTTPHeader("application/json", "application/json");
        $this->curlHandler->setIncludeHeader(true);
        
        $this->curlHandler->get("/anchorids", $anchor_data);
        $result = $this->curlHandler->getResponse();
        $this->response_code = $this->curlHandler->getStatus();
        $this->getHeaderAndBody($result);
        return $result;
    }
    
    
    /**
     * @param string $name
     * @param string $hash
     * @param array $tags
     * @param int $page
     * @param int $per_page_results
     * @param string $sort (Possible values are id, created, hash and signedHash)
     * @param string $direction (Possible values are ASC or DESC)
     * @param null $signedHash
     * @return mixed
     */
    public function searchAnchors($name="", $hash="", $sort="id", $direction="ASC", $page=0, $per_page_results=20, $tags=null, $signedHash=null){
        /**
        This function is to search all the public anchors only. and it returns anchors with all details.
         
         */
        
        $anchor_data = array("name"=>$name, "hash"=>$hash, "tags"=>$tags, "page"=>$page, "size"=>$per_page_results, "sort"=>$sort, "direction"=>$direction, "signedHash"=>$signedHash);
        if($page!=0){
            $anchor_data["page"] = $page;
        }
        
        if($per_page_results!=20){
            $anchor_data["size"] = $per_page_results;
        }
        
        if(!empty($signedHash)){
            $anchor_data["signedHash"] = $signedHash;
        }
        
        if(!empty($tags)){
            $anchor_data["tags"] = $tags;
        }
        $this->curlHandler->useAuth(true);
        $this->curlHandler->makeHTTPHeader("application/json", "application/json");
        $this->curlHandler->setIncludeHeader(true);
        
        $this->curlHandler->get("/anchors", $anchor_data);
        $result = $this->curlHandler->getResponse();
        $this->response_code = $this->curlHandler->getStatus();
        $this->getHeaderAndBody($result);
        return $result;
    }
    
    /**
     * @param $anchor_id
     * @return mixed
     */
    public function getProofReceipt($anchor_id){
        $this->curlHandler->makeHTTPHeader("application/json", "application/json");
        $this->curlHandler->setIncludeHeader(true);
        $this->curlHandler->get("/receipt/" . $anchor_id, null);
        $result = $this->curlHandler->getResponse();
        $this->response_code = $this->curlHandler->getStatus();
        $this->getHeaderAndBody($result);
        return $result;
    
    }
    
    public function verifyProofRecipt($recipt){
        $this->curlHandler->makeHTTPHeader("application/json", "application/json");
        $this->curlHandler->setIncludeHeader(true);
        
        $this->curlHandler->post("/receipt/verify", $recipt);
        $result = $this->curlHandler->getResponse();
        $this->response_code = $this->curlHandler->getStatus();
        $this->getHeaderAndBody($result);
        return $result;
    }
    
    /**
     * @return mixed
     */
    public function getUserToken(){
        $this->curlHandler->useAuth(true);
        $this->curlHandler->makeHTTPHeader("application/json", "application/json");
        $this->curlHandler->setIncludeHeader(true);
        $this->curlHandler->get("/user/credits", null);
        $result = $this->curlHandler->getResponse();
        $this->response_code = $this->curlHandler->getStatus();
        $this->getHeaderAndBody($result);
        return $result;
    }
    
    
    /**
     * @param string $response
     */
    private function getHeaderAndBody($response){
        list($header, $body) = explode("\r\n\r\n", $response, 2);
        $this->response_header = $header;
        $this->response_body = $body;
    }
    
    
}