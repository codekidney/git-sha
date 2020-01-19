<?php

namespace Gitcli;

class App
{
    protected $printer;

    protected $registry = [];

    public function __construct()
    {
        $this->printer = new CliPrinter();
    }

    public function getPrinter()
    {
        return $this->printer;
    }

    public function runCommand($argv)
    {
        $input = new CliInput($argv);
        
        if( $input->getParam('owner') && $input->getParam('repo') ){

            $service = $input->getOption('service');
            if(!CliValidator::isAvailableService($service)){
                $this->getPrinter()->display("Unknown service: {red}$service{end}");
                return false;
            } 

            if($service){
                // with option
                $git = new GitService($input->getParam('owner'), $input->getParam('repo'), $input->getParam('branch'), $input->getOption('service'));
            } else {
                // without option
                $git = new GitService($input->getParam('owner'), $input->getParam('repo'), $input->getParam('branch') );
            }
            $sha = $git->getSha();
            
            $this->getPrinter()->display("$sha");
        } else {
            // display hint
            $this->getPrinter()->displayHint();
        }
        
    }
}