<?php

function __autoload($class_name) {
    echo "Want to load $class_name.\n";
    include $class_name . '.php';
}

function writeFile($data, $dest_file) {
    $fp = @fopen($dest_file, "w");
    if (!$fp) {
        debug('problema ao escrever arquivo, confira o chmod: ' . $dest_file);
        return false;
    }
    fwrite($fp, $data);
    fclose($fp);
    return true;
}

/**
 * @param   String          $url    destino a ser buscado
 * @return  String | false          conteudo da url ou False
 */
function getUrl($url) {
    debug($url);
    $data = file_get_contents($url);
    debug($data);
    return $data;
}

/**
 * @param   String          $url    destino a ser buscado
 * @return  String | false          conteudo da url ou False
 */
function getUrlCurl($url) {
    debug($url);

    $ch = curl_init(); // create a new cURL resource
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30); // Timeout (for when Twitter is down)
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //return the transfer as a string
    $data = curl_exec($ch); // grab URL and pass it to the browser
    curl_close($ch); // close cURL resource, and free up system resources

    debug($data);

    return $data;
}

/**
 * Funcao de comparacao para ordenar array pelo nome do country
 *
 * @return array
 */
function cmpCountry($a, $b) {
    if ($a->{'country'} == $b->{'country'}) {
        return 0;
    }
    return ($a->{'country'} < $b->{'country'}) ? -1 : 1;
}

function debug() {
    if (DEBUG) {
        $argv = func_get_args ();
        if (is_array($argv)) {
            if (sizeof($argv) == 1) {
                printpre($argv[0]);
            }else{
                printpre($argv);

            }
        } else {
            echopre($argv);
        }
    }
}

function printpre($array) {
    echo "<pre>";
    print_r($array);
    echo "</pre>";
}

function echopre($param) {
    echo "<pre>";
    var_dump($param);
    echo "</pre>";
}

////////////////
// Algumas funcoes do cake uteis para essa aplicacao.
////////////////



/**
 * Core functions for including other source files, loading models and so forth.
 * CakePHP(tm) :  Rapid Development Framework (http://www.cakephp.org)
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 * @link          http://www.cakefoundation.org/projects/info/cakephp CakePHP(tm) Project
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */

/**
 * Returns true if the current HTTP request is Ajax, false otherwise
 *
 * @return boolean True if call is Ajax
 * @access public
 */
function isAjax() {
    return env('HTTP_X_REQUESTED_WITH') === "XMLHttpRequest";
}

/**
 * Returns true if the current call a POST request
 *
 * @return boolean True if call is a POST
 * @access public
 */
function isPost() {
    return (strtolower(env('REQUEST_METHOD')) == 'post');
}

/**
 * Gets an environment variable from available sources, and provides emulation
 * for unsupported or inconsistent environment variables (i.e. DOCUMENT_ROOT on
 * IIS, or SCRIPT_NAME in CGI mode).  Also exposes some additional custom
 * environment information.
 *
 * @param  string $key Environment variable name.
 * @return string Environment variable setting.
 * @link http://book.cakephp.org/view/701/env
 */
function env($key) {
    if ($key == 'HTTPS') {
        if (isset($_SERVER['HTTPS'])) {
            return (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
        }
        return (strpos(env('SCRIPT_URI'), 'https://') === 0);
    }

    if ($key == 'SCRIPT_NAME') {
        if (env('CGI_MODE') && isset($_ENV['SCRIPT_URL'])) {
            $key = 'SCRIPT_URL';
        }
    }

    $val = null;
    if (isset($_SERVER[$key])) {
        $val = $_SERVER[$key];
    } elseif (isset($_ENV[$key])) {
        $val = $_ENV[$key];
    } elseif (getenv($key) !== false) {
        $val = getenv($key);
    }

    if ($key === 'REMOTE_ADDR' && $val === env('SERVER_ADDR')) {
        $addr = env('HTTP_PC_REMOTE_ADDR');
        if ($addr !== null) {
            $val = $addr;
        }
    }

    if ($val !== null) {
        return $val;
    }

    switch ($key) {
        case 'SCRIPT_FILENAME':
            if (defined('SERVER_IIS') && SERVER_IIS === true) {
                return str_replace('\\\\', '\\', env('PATH_TRANSLATED'));
            }
            break;
        case 'DOCUMENT_ROOT':
            $name = env('SCRIPT_NAME');
            $filename = env('SCRIPT_FILENAME');
            $offset = 0;
            if (!strpos($name, '.php')) {
                $offset = 4;
            }
            return substr($filename, 0, strlen($filename) - (strlen($name) + $offset));
            break;
        case 'PHP_SELF':
            return str_replace(env('DOCUMENT_ROOT'), '', env('SCRIPT_FILENAME'));
            break;
        case 'CGI_MODE':
            return (PHP_SAPI === 'cgi');
            break;
        case 'HTTP_BASE':
            $host = env('HTTP_HOST');
            if (substr_count($host, '.') !== 1) {
                return preg_replace('/^([^.])*/i', null, env('HTTP_HOST'));
            }
            return '.' . $host;
            break;
    }
    return null;
}

