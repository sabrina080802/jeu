<?php

namespace Magy\Utils;

abstract class REST
{
    const INT = 1;
    const TEXT = 2;
    const JSON = 3;

    public function execute()
    {
        $requiredParams = $this->getParams();
        $data = (object)[];
        $methodData = [];
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                $methodData = $_GET;
                break;
            case 'POST':
                $methodData = $_POST;
                break;
        }
        foreach ($requiredParams as $key => $value) {
            if (!isset($methodData[$key])) {
                return false;
            }

            switch ($value) {
                case REST::INT:
                    if (!is_numeric($methodData[$key])) {
                        return false;
                    } else {
                        $data->$key = intval($methodData[$key]);
                    }
                    break;

                case REST::TEXT:
                    $data->$key = $methodData[$key];
                    break;
            }
        }

        $this->process($data);
        $result = $this->getResponse();
        if (is_object($result) || is_array($result)) {
            $result = json_encode($result);
        }

        return $result;
    }
    public abstract function getParams();
    public abstract function process($data);
    public function getResponse()
    {
        return null;
    }
}
