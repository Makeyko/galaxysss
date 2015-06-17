<?php

namespace cs\models;


class Response
{
    /** @var boolean $status результат операции */
    public $status;
    /** @var mixed $data возвращаемые данные */
    public $data;
    public $error;
    public $errorId;
    public $errorMessage;

    public static function success($data = null)
    {
        $object = new self();
        $object->status = true;
        $object->data = $data;

        return $object;
    }

    public static function error($data = null)
    {
        $object = new self();
        $object->status = false;
        $object->data = $data;
        $object->error = $data;

        return $object;
    }

    public static function errorId($id, $message)
    {
        $ret = self::error([
            'id'      => $id,
            'message' => $message,
        ]);
        $ret->errorId = $id;
        $ret->errorMessage = $message;

        return $ret;
    }

    public function __toString()
    {
        return print_r([
            'status' => ($this->status) ? 'true' : 'false',
            'data'   => print_r($this->data, true)
        ], true);
    }
}