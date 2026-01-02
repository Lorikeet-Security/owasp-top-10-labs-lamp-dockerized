<?php
/**
 * Abstract Controller
 * To be extended by every controller in application
 */
abstract class RestController {
    protected $request;
    protected $response;
    protected $responseStatus;
    
    public function __construct($request) {
        $this->request = $request;
    }
    
    final public function getResponseStatus() {
        return $this->responseStatus;
    }
    
    final public function getResponse() {
        return $this->response;
    }
    
    public function checkAuth() {
        return true;
    }
    
    // @codeCoverageIgnoreStart
    abstract public function get();
    abstract public function post();
    abstract public function put();
    abstract public function delete();
    // @codeCoverageIgnoreEnd
    
}
