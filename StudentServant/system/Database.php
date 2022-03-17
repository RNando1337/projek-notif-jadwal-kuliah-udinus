<?php

class Database{ 
    
    public $newArrayData = array();

    public function datamahasiswa($nim,$id){
        for($i=0;$i<sizeof($id);$i++){
            $newArrayData[$i]= $nim."-".$id[$i];
        }
        return $newArrayData;
    }
}

