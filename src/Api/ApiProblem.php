<?php
/**
 * Inspired by: https://knpuniversity.com/screencast/symfony-rest2/invalid-json-api-problem
 */

namespace App\Api;
/**
 * A wrapper for holding data to be used for a application/problem+json response
 */
class ApiProblem
{
    const TYPE_NOT_FOUND = 'not_found';
    const TYPE_VALIDATION_ERROR = 'validation_error';
    const TYPE_EXCEPTION = 'exception';
    const TYPE_INVALID_REQUEST_BODY_FORMAT = 'invalid_body_format';

    private static $titles = array(
        self::TYPE_NOT_FOUND => 'This resource was not found',
        self::TYPE_EXCEPTION => 'System Error',
        self::TYPE_VALIDATION_ERROR => 'There was a validation error',
        self::TYPE_INVALID_REQUEST_BODY_FORMAT => 'Invalid JSON format sent',
    );

    private $statusCode;
    private $type;
    private $title;
    private $extraData = array();

    public function __construct($statusCode, $type)
    {
        $this->statusCode = $statusCode;
        $this->type = $type;
        if (!isset(self::$titles[$type])) {
            throw new \InvalidArgumentException('No title for type '.$type);
        }
        $this->title = self::$titles[$type];
    }

    public function toArray()
    {
        return array_merge(
            $this->extraData,
            array(
                'status' => $this->statusCode,
                'type' => $this->type,
                'title' => $this->title,
            )
        );
    }

    public function set($name, $value)
    {
        $this->extraData[$name] = $value;
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function getTitle()
    {
        return $this->title;
    }

}