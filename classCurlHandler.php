<?php
/**
 * Created by PhpStorm.
 * User: ma_sa
 * Date: 07/21/2018
 * Time: 5:35 PM
 */

class CurlHandler {
    private $_url;
    private $_response;
    private $_includeHeader;
    private $_noBody;
    private $_status;
    private $_binaryTransfer;
    private $_curl_error;
    private $_curl_info;
    private $authentication = 0;
    private $auth_name = '';
    private $auth_pass = '';
    
    private $_header_accept_encoding="";
    private $_header_accept_language="";
    private $_header_accept="";
    private $_header_content_type = "";
    private $_header_referer = "";
    private $_header_cache_control = "";
    private $_header_user_agent ="";
    private $_header_host = "";
    
    private $headers = [];
    
    public function useAuth($use){
        $this->authentication = 0;
        if($use == true) $this->authentication = 1;
    }
    
    
    
    /**
     * @return array
     */
    public function getHeaders() {
        return $this->headers;
    }
    
    public function __construct($url) {
        $this->_url = $url;
        $this->_header_accept_encoding="Accept-Encoding: gzip, deflate";
        $this->_header_accept_language="Accept-Language: en-US,en;q=0.5";
        $this->_header_accept="Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8";
        $this->_header_content_type="Content-Type: application/x-www-form-urlencoded; charset=utf-8";
        $this->_header_referer = "Referer: http://www.blockchainhuissieray.com/index.php";
        $this->_header_cache_control = "Cache-Control: no-cache";
        $this->_header_user_agent = "User-Agent: Mozilla/5.0 (X11; Ubuntu; Linux i686; rv:28.0) Gecko/20100101 Firefox/28.0";
        $this->_header_host = "Host: www.example.com";
        $this->_curl_error = null;
        $this->_curl_info = null;
    }
    
    /**
     * @param string $auth_name
     */
    public function setAuthName($auth_name) {
        $this->auth_name = $auth_name;
    }
    
    /**
     * @param string $auth_pass
     */
    public function setAuthPass($auth_pass) {
        $this->auth_pass = $auth_pass;
    }
    
    /**
     * @return mixed
     */
    public function getStatus() {
        return $this->_status;
    }
    
    /**
     * @return mixed
     */
    public function getResponse() {
        return $this->_response;
    }
    
    /**
     * @return null
     */
    public function getCurlError() {
        return $this->_curl_error;
    }
    
    /**
     * @return null
     */
    public function getCurlInfo() {
        return $this->_curl_info;
    }
    /**
     * @param mixed $includeHeader
     */
    public function setIncludeHeader($includeHeader) {
        $this->_includeHeader = $includeHeader;
    }
    
    /**
     * @return mixed
     */
    public function getIncludeHeader() {
        return $this->_includeHeader;
    }
    
    
    
    public function makeHTTPHeader($accept=null, $conent_type=null, $encoding=null, $language=null, $referer=null,
                                   $host=null, $agent=null, $cache_control=null){
        if($accept!=null){
            $this->_header_accept = "Accept: ".$accept;
        }
        if($encoding!=null){
            $this->_header_accept_encoding = "Accept-Encoding: ".$encoding;
            $this->headers[] = $this->_header_accept_encoding;
        }
        if($language!=null){
            $this->_header_accept_language = "Accept-Language: ".$language;
            $this->headers[] = $this->_header_accept_language;
        }
        if($conent_type!=null){
            $this->_header_content_type = "Content-Type: ".$conent_type;
        }
        if($referer != null){
            $this->_header_referer = "Referer: ".$referer;
            $this->headers[] = $this->_header_referer;
        }
        if($host!=null){
            $this->_header_host = "Host: ".$host;
            $this->headers[] = $this->_header_host;
        }
        if($agent!=null){
            $this->_header_user_agent = "User-Agent: ".$agent;
            $this->headers[] = $this->_header_user_agent;
        }
        if($cache_control!=null){
            $this->_header_cache_control = "Cache-Control:".$cache_control;
            $this->headers[] = $this->_header_cache_control;
        }
    
        $this->headers[] = $this->_header_accept;
        $this->headers[] = $this->_header_content_type;
    }
    
    public function extraHeader ($headerValue){
        $this->headers[] = $headerValue;
    }
    
    
    
    
    public function post($url, $data=null){
        $url = $this->_url.$url;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_POST, 1);
        if ($data!=null){
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        if($this->authentication){
            curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($curl, CURLOPT_USERPWD, $this->auth_name.":".$this->auth_pass);
        }
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        if($this->_includeHeader){
            curl_setopt($curl, CURLOPT_HEADER,true);
            curl_setopt($curl, CURLINFO_HEADER_OUT, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $this->headers);
        }
        curl_setopt($curl, CURLOPT_VERBOSE, 1);
        $this->_response = curl_exec($curl);
        $this->_curl_error = curl_error($curl);
        $this->_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $this->_curl_info = curl_getinfo($curl);
       
        
        curl_close($curl);
    }
    
    public function put($url, $data){
        $url = $this->_url.$url;
        print($url);
        $curl = curl_init();
        /*curl_setopt($curl, CURLOPT_PUT, 1);*/
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
        if ($data!=null){
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        if($this->authentication){
            curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($curl, CURLOPT_USERPWD, $this->auth_name.":".$this->auth_pass);
        }
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        if($this->_includeHeader){
            curl_setopt($curl, CURLOPT_HEADER,true);
            curl_setopt($curl, CURLINFO_HEADER_OUT, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $this->headers);
        }
        curl_setopt($curl, CURLOPT_VERBOSE, 1);
        $this->_response = curl_exec($curl);
        $this->_curl_error = curl_error($curl);
        $this->_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $this->_curl_info = curl_getinfo($curl);
        
        
        curl_close($curl);
        
    }
    
    public function delete($url, $data){
        $url = $this->_url.$url;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
        if($data!=null){
            $url = sprintf("%s?%s", $url, http_build_query($data));
        }
        if($this->authentication){
            curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($curl, CURLOPT_USERPWD, $this->auth_name.":".$this->auth_pass);
        }
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        if($this->_includeHeader){
            curl_setopt($curl, CURLOPT_HEADER,true);
            curl_setopt($curl, CURLINFO_HEADER_OUT, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $this->headers);
        }
        curl_setopt($curl, CURLOPT_VERBOSE, 1);
        $this->_response = curl_exec($curl);
        $this->_curl_error = curl_error($curl);
        $this->_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $this->_curl_info = curl_getinfo($curl);
        
        
        curl_close($curl);
    }
    
    public function get($url, $data=null){
        $url = $this->_url.$url;
        $curl = curl_init();
        if($data!=null){
            $url = sprintf("%s?%s", $url, http_build_query($data));
        }
        if($this->authentication){
            curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($curl, CURLOPT_USERPWD, $this->auth_name.":".$this->auth_pass);
        }
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        if($this->_includeHeader){
            curl_setopt($curl, CURLOPT_HEADER,true);
            curl_setopt($curl, CURLINFO_HEADER_OUT, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $this->headers);
        }
        curl_setopt($curl, CURLOPT_VERBOSE, 1);
        $this->_response = curl_exec($curl);
        $this->_curl_error = curl_error($curl);
        $this->_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $this->_curl_info = curl_getinfo($curl);
        
        /*$header_size = $this->_curl_info['header_size'];
        $this->_response_header = substr($this->_response, 0, $header_size);
        $this->_response_body = substr($this->_response, $header_size);*/
        
        
        curl_close($curl);
    }
}








