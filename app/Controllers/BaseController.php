<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

abstract class BaseController extends Controller
{
    protected $encryptionKey = '';

    public function __construct()
    {
        $this->encryptionKey = getenv('encryptionKey');
    }

    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var list<string>
     */
    protected $helpers = [];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();
    }


    public function encrypt(string $data): string
    {
        $cipher = "AES-256-CBC"; 
        $key = hash('sha256', $this->encryptionKey);
        $iv = substr(hash('sha256', $this->encryptionKey), 0, 16); 
        return base64_encode(openssl_encrypt($data, $cipher, $key, 0, $iv));
    }

    public function decrypt(string $encryptedData): string
    {
        $cipher = "AES-256-CBC";
        $key = hash('sha256', $this->encryptionKey);
        $iv = substr(hash('sha256', $this->encryptionKey), 0, 16);
        return openssl_decrypt(base64_decode($encryptedData), $cipher, $key, 0, $iv);
    }
}
