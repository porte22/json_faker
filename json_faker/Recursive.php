<?php
class Recursive{
    private $data = [
        0 => 'parent1',
        1 => 'parent2',
        2 => 'parent3',
        3 => 'parent4',
        4 => 'parent5',
    ];
    
    private $counter = 0;
    private $maxElement = 5;
    
    public function __construct(){
        $this->generateRecursive($this);
        echo "<pre>";
        print_r($this);
        echo "</pre>";
    }
        
    
    public function generateRecursive(&$current){
        if ($this->counter<$this->maxElement){
            $section = $this->data[$this->counter];
            $this->counter++;
            $current->$section=$this->generateRecursive($current->$section);  
        } else {
            $current = 'END';
        }
        return $current;
    }
    
}

$recursiveTest = new Recursive();
