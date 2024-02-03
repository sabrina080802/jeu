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
        if ($requiredParams != null) {
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
        }

        $this->process($data);
        $result = $this->getResponse();

        if($result instanceof ArrayExtension){
            $result = $result->toJSON();
        }
        else if (is_object($result) || is_array($result)) {
            $result = json_encode($result);
        }

        return $result;
    }
    public function getParams()
    {
        return null;
    }
    public abstract function process($data);
    public function getResponse()
    {
        return null;
    }
}
