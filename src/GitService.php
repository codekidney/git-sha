<?php

namespace Gitcli;

class GitService
{
    protected $service;
    protected $owner;
    protected $repo;
    protected $branch;

    function __construct($owner, $repo, $branch = 'master', $service = 'github') {
        $this->owner   = $owner;
        $this->repo    = $repo;
        $this->service = $service;
        $this->branch  = $branch;
    }

    function getSha(){
        $result = false;
        switch ($this->service){
            case 'bitbucket' : 
                $result = $this->getShaBitbucket();
            break;
            case 'github' : 
                $result = $this->getShaGithub();
                break;
            default:
                $result = false;
        }
        return $result;
    }

    function getShaGithub() {
        $objCurl = curl_init();
        $sha = false;
        curl_setopt($objCurl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($objCurl, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-Type: application/json'));        
        curl_setopt($objCurl, CURLOPT_URL, 'https://api.github.com/repos/'.$this->owner.'/'.$this->repo.'/commits/'.$this->branch);
        curl_setopt($objCurl, CURLOPT_USERAGENT, "StackOverflow-29845346"); 
        curl_setopt($objCurl, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($objCurl);
        curl_close($objCurl);

        $results = json_decode($response);

        if( (json_last_error() == JSON_ERROR_NONE) ){
            if(isset($results->sha) && CliValidator::isSha($results->sha)){
                $sha = $results->sha;
            }
        }
        return $sha;
    }

    function getShaBitbucket() {
        $objCurl = curl_init();
        $sha = false;
        curl_setopt($objCurl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($objCurl, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-Type: application/json'));        
        curl_setopt($objCurl, CURLOPT_URL, 'https://api.bitbucket.org/2.0/repositories/'.$this->owner.'/'.$this->repo.'/commits/'.$this->branch);
        curl_setopt($objCurl, CURLOPT_USERAGENT, "StackOverflow-29845346"); 
        curl_setopt($objCurl, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($objCurl);
        curl_close($objCurl);

        $results = json_decode($response);
        if( (json_last_error() == JSON_ERROR_NONE) ){
            if(isset($results->values[0]) && CliValidator::isSha($results->values[0]->hash)){
                $sha = $results->values[0]->hash;
            }
        }
        return $sha;
    }
}