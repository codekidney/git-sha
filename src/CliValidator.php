<?php

namespace Gitcli;

class CliValidator 
{
    static function isOwnerRepo($str){
        $owner = '[a-z\d](?:[a-z\d]|-(?=[a-z\d])){0,38}';
        $repo  = '[a-z\d](?:[a-z\d]|-(?=[a-z\d])){0,38}';
        return (bool) preg_match('/'.$owner.'\/'.$repo.'/', $str);
    }

    static function isSha($str){
        return (bool) preg_match('/^[0-9a-f]{40}$/i', $str);
    }

    static function isAvailableService($str){
        $haystack = array (
            'github',
            'bitbucket'
        );
        return (bool) preg_grep ('/'.$str.'/i', $haystack);
    }
}