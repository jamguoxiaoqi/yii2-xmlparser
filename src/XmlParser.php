<?php

/**
 * @link https://github.com/jamguozhijun/yii2-xmlparser
 * @license BSD-3-Clause
 */

namespace jamguozhijun\yii\web;

use yii\web\BadRequestHttpException;
use yii\web\RequestParserInterface;

/**
 * Parses a raw HTTP request using SimpleXML https://www.php.net/manual/en/book.simplexml.php
 *
 * To enable parsing for XML requests you can configure [[Request::parsers]] using this class:
 *
 * ```php
 * 'request' => [
 *     'parsers' => [
 *         'application/xml' => 'jamguozhijun\yii\web\XmlParser',
 *         'text/xml' => 'jamguozhijun\yii\web\XmlParser',
 *     ]
 * ]
 * ```
 *
 * @author James GUO Zhijun <jamguo@gmail.com>
 */
class XmlParser implements RequestParserInterface
{
    /**
     * @var bool whether to return objects in terms of associative arrays.
     */
    public $asArray = true;
    /**
     * @var bool whether to throw a [[BadRequestHttpException]] if the body is invalid XML
     */
    public $throwException = true;
    /**
     * @var string You may use this optional parameter so that load_string() will return an object of the specified class. That class should extend the SimpleXMLElement class.
     * @see https://www.php.net/manual/en/function.simplexml-load-string.php
     */
    public $loadClassName = 'SimpleXMLElement';
    /**
     * @var int Since Libxml 2.6.0, you may also use the options parameter to specify additional Libxml parameters.
     * @see https://www.php.net/manual/en/function.simplexml-load-string.php
     */
    public $loadOptions = LIBXML_NOCDATA;
    /**
     * @var string Namespace prefix or URI.
     * @see https://www.php.net/manual/en/function.simplexml-load-string.php
     */
    public $loadNamespaceOrPrefix = '';
    /**
     * @var bool true if namespace_or_prefix is a prefix, false if it's a URI; defaults to false.
     * @see https://www.php.net/manual/en/function.simplexml-load-string.php
     */
    public $loadIsPrefix = false;

    /**
     * Parses a HTTP request body.
     * @param string $rawBody the raw HTTP request body.
     * @param string $contentType the content type specified for the request body.
     * @return parameters parsed from the request body
     * @throws BadRequestHttpException if the body contains invalid XML and [[throwException]] is `true`.
     */
    public function parse($rawBody, $contentType)
    {
        libxml_use_internal_errors(true);
        libxml_clear_errors();

        $parameters = simplexml_load_string(
            $rawBody,
            $this->loadClassName,
            $this->loadOptions,
            $this->loadNamespaceOrPrefix,
            $this->loadIsPrefix
        );

        if ($parameters === false) {
            if ($this->throwException) {
                $e = libxml_get_last_error();
                throw new BadRequestHttpException('Invalid XML data in request body: ' . $e->message);
            }
            return [];
        }

        if ($this->asArray) {
            $parameters = json_decode(json_encode($parameters), true);
        }

        return $parameters;
    }
}
