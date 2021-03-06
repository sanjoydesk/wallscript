<?php
namespace Cygnite\Common;

use Closure;
use Cygnite\Common\CookieManager\CookieInterface;
use Cygnite\Common\Security;
use Cygnite\Proxy\StaticResolver;
use InvalidArgumentException;
use Cygnite\Common\Singleton;
use Cygnite\Common\CookieManager\Cookie;

/*
 *   Cygnite PHP Framework
 *
 *   An open source application development framework for PHP 5.3x or newer
 *
 *   License
 *
 *   This source file is subject to the MIT license that is bundled
 *   with this package in the file LICENSE.txt.
 *   http://www.cygniteframework.com/license.txt
 *   If you did not receive a copy of the license and are unable to
 *   obtain it through the world-wide-web, please send an email
 *   to sanjoy@hotmail.com so I can send you a copy immediately.
 *
 * @Package                   :  Cygnite\Common
 * @Sub Packages              :
 * @Filename                  :  Input
 * @Description               :  This class is used to handler post, get, cookies etc.
 * @Author                    :  Sanjoy Dey
 * @Copyright                 :  Copyright (c) 2013 - 2014,
 * @Link	                  :  http://www.cygniteframework.com
 * @Since	                  :  Version 1.0
 * @FileSource
 *
 */

class Input
{
    public $except;

    private $security;

    public $request = array();

    private static $instance;

    private $cookieInstance;

    private $cookie;


    /**
     *
     * @param Security $security
     */
    public function __construct(Security $security)
    {
        $this->security = $security;
        $this->request = $this->getRequest();
    }

    /**
     * @param callable $callback
     * @return object
     */
    public static function make(Closure $callback = null)
    {
        $security = new Security;

        if ($callback instanceof Closure) {
            return $callback(new self($security));
        } else {
            return new self($security);
        }
    }

    /**
     * @param $input
     * @return bool
     */
    public function hasPost($input)
    {
        return  filter_has_var(INPUT_POST, $input) ?
            true :
            false;
    }

    /**
     * @param $key
     * @return $this
     */
    public function except($key)
    {
        $this->except = $this->security->sanitize($key);
        return $this;
    }

    /**
     * @param null $key
     * @param null $value
     * @return bool|null
     * @throws \InvalidArgumentException
     */
    public function post($key = null, $value = null)
    {
        if (!is_null($this->except)) {
            unset($this->request['post'][$this->except]);
        }

        $postValue = '';

        if ($key !== null &&
            strpos($key, '.') == false &&
            is_null($value) == true
        ) {
            $key = $this->security->sanitize($key);
            $postValue = $this->security->sanitize($this->request['post'][$key]);
            $this->request['post'][$key] = $postValue;

            if (array_key_exists($key, $this->request['post'])) {
                return $this->request['post'][$key];
            }

            throw new InvalidArgumentException("Invalid $key passed to ".__METHOD__);
        }

        if ($key !== null &&
           strpos($key, '.') == true &&
           is_null($value) == true
        ) {
            $expression = explode('.', $key);
            $firstKey = $this->security->sanitize($expression[0]);
            $secondKey = $this->security->sanitize($expression[1]);

            if (isset($expression[2])) {
                throw new InvalidArgumentException('Post doesn\'t allows more than one key');
            }

            $postValue = $this->security->sanitize($this->request['post'][$firstKey][$secondKey]);
            $this->request['post'][$firstKey][$secondKey] = $postValue;

            return $this->request['post'][$firstKey][$secondKey];
        }

        if (is_null($key) ===false && is_null($value) === false) {
            try {
                 //Sets new value for given POST variable.
                 //@param string $key Post variable name
                 //@param mixed $value     New value to be set.
                $this->request['post'][$key] = $value;
            } catch (InvalidArgumentException $ex) {
                echo $ex->getMessage();
            }

            return true;
        }

        if (is_null($key)) {
            $postArray = $this->security->sanitize($this->request['post']);
            return (!empty($postArray)) ?
                $postArray :
                null;
        }
    }

    /**
     * @param $string
     * @return string
     */
    public function htmlDecode($string)
    {
        return html_entity_decode($string);
    }

    /**
     * @return bool|string
     */
    public function getMethod()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            return 'post';
        } else if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            return 'get';
        }

        return false;
    }

    /**
     * @return array
     */
    protected function getRequest()
    {
        return array(
            'get'       => $_GET,
            'post'      => $_POST,
            'cookie'    => $_COOKIE
        );
    }

    /**
     * Sets or returns the cookie variable value.
     *
     */
    public function cookie(Closure $callback = null)
    {
        if ($callback instanceof CookieInterface) {
            return Cookie::create($callback);
        }

        return Cookie::create();

    }
}