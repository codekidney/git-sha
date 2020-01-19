<?php

namespace Gitcli;

class CliInput
{
    protected $options;
    protected $params;

    function __construct($argArr){
        $this->options = $this->setOptionsInp($argArr);
        $this->params  = $this->setParamsInp($argArr);
    }

    function setOptionsInp($arr){
        $options = new \stdClass();
        foreach($arr as $row){
            $pattern = '/--service=([a-z]*)/i';
            if(preg_match($pattern, $row)){
                preg_match($pattern, $row, $matches);
                $options->service = $matches[1];

                break;
            }
        }
        return $options;
    }

    function setParamsInp($arr){
        $params = new \stdClass();
        $i = 0;
        foreach($arr as $row){
            $i++;
            if(CliValidator::isOwnerRepo($row)){
                $rowArr = explode('/', $row);
                $params->owner  = $rowArr[0];
                $params->repo   = $rowArr[1];
                
                $params->branch = 'master';
                if(isset($arr[$i])){
                    $nextRow = $arr[$i];
                    if(isset($nextRow) && preg_match('/[a-z]*/',$nextRow)){
                        $params->branch = $nextRow;
                    }
                }

                break;
            }
        }
        return $params;
    }

    function getOption($str){
        return ( isset($this->options->$str) ) ? $this->options->$str : false;
    }

    function getOptions(){
        return $this->options;
    }

    function getParam($str){
        return ( isset($this->params->$str) ) ? $this->params->$str : false;
    }
    function getParams(){
        return $this->params;
    }
}