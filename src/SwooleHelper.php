<?php
namespace Fgsl\Swoole;
/**
 * 
 * @author Flávio Gomes da Silva Lisboa <flavio.lisboa@fgsl.eti.br>
 * @copyright FGSL 2020
 *  
 * Swoole Request attribute $request 
 * [request_method]  
 * [request_uri]
 * [path_info] 
 * [request_time] 
 * [request_time_float] 
 * [server_protocol] 
 * [server_port]
 * [remote_port] 
 * [remote_addr] 
 * [master_time]
 *  
 * Swoole Request attribute $header
 * [host]
 * [user-agent]
 * [accept]
 * [accept-language]
 * [accept-encoding]
 * [connection]
 * [upgrade-insecure-requests]
 * [cache-control]
 */
class SwooleHelper
{
    private $requestIsFile = false;
    /**
     * @var Swoole\Http\Request
     */
    private $response;
    /**
     * @var array
     */
    private $uriTokens;
    /**
     * @var string
     */
    private $file;
    
    public function __construct(\Swoole\Http\Request $request, \Swoole\Http\Response $response)
    {
        $uri = $request->server['request_uri'];
        $_SERVER['REQUEST_METHOD'] = $request->server['request_method'];
        $_SERVER['REQUEST_URI'] = $uri;
        $_SERVER['REQUEST_TIME'] = $request->server['request_time'];
        $_SERVER['SERVER_PROTOCOL'] = $request->server['server_protocol'];
        $_SERVER['SERVER_PORT'] = $request->server['server_port'];
        $_SERVER['REMOTE_PORT'] = $request->server['remote_port'];
        $_SERVER['REMOTE_ADDR'] = $request->server['remote_addr'];
        $_SERVER['HTTP_HOST'] = $request->header['host'];
        $_SERVER['HTTP_USER_AGENT'] = $request->header['user-agent'];
        $_SERVER['HTTP_ACCEPT'] = $request->header['accept'];
        $_SERVER['HTTP_ACCEPT_LANGUAGE'] = $request->header['accept-language'];
        $_SERVER['HTTP_ACCEPT_ENCODING'] = $request->header['accept-encoding'];
        $_SERVER['HTTP_CONNECTION'] = $request->header['connection'];
        $this->uriTokens = explode('/', $uri);
        $this->file = end($this->uriTokens);
        if (strpos($this->file, '.css') !== false){
            $this->requestIsFile = true;
            $response->header("Content-Type", "text/css");
        }
        if (strpos($this->file, '.js')  !== false) {
            $this->isFile = true;
            $response->header("Content-Type", "text/javascript");
        }
        if (strpos($this->file, '.ico') !== false) {
            $this->requestIsFile = true;
        }
        if (strpos($this->file, '.jpg') !== false) {
            $this->requestIsFile = true;
            $response->header("Content-Type", "image/jpeg");
        }
        if (strpos($this->file, '.png') !== false) {
            $this->requestIsFile = true;
            $response->header("Content-Type", "image/png");
        }
        if (strpos($this->file, '.svg') !== false) {
            $this->requestIsFile = true;
        }
        $this->response = $response;
    }
    
    public function requestIsFile()
    {
        return $this->requestIsFile;
    }
    
    /**
     * @return \Swoole\Http\Response
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @return string
     */
    public function getFolder()
    {
        return $this->uriTokens[count($this->uriTokens)-2]; 
    }
    
    /**
     * @return string
     */
    public function getFile()
    {
        return $this->file;
    }
}
