<?php

namespace Gitcli;

class CliPrinter
{
    protected $colors = ['green' => 32, 'yellow' => 93, 'grey' => 90, 'end' => 0];

    public function out($message)
    {
        echo $message;
    }

    public function outColor($str)
    {
        $colors = $this->colors;
        $search = array_map(function($v){ return "{".$v."}"; },array_keys($this->colors) );
        $replace =  array_map(function($v){ return "\033[".$v."m"; }, array_values($this->colors) );
        echo str_replace($search, $replace, $str);
    }

    public function newline($n = 1)
    {
        for( $i=0; $i<$n; $i++){
            $this->out("\n");
        }
    }

    public function display($message)
    {
        $this->out($message);
    }

    public function displayHint()
    {
        $this->newline();
        $this->out('Command app, version: 0.0.1-dev');
        $this->newline(2);
        $this->outColor('{grey}Get last commit sha from repository{end}');
        $this->newline(2);
        $this->outColor("Usage: {yellow}./app [OPTIONS] [OWNER]/[REPOSITORY] [BRANCH]{end}");
        $this->outColor(' {grey}E.g.: --service=bitbucket php-fig/log master{end}');
        $this->newline(2);
        $this->outColor('{green}Options:{end}');
        $this->newline();
        $this->outColor('  [--service] {grey}Name of service. Available services: github, bitbucket{end}');
        $this->newline(2);
    }
}