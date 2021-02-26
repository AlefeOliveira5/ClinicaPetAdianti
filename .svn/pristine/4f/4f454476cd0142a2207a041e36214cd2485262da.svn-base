<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Tutor
 *
 * @author Alefe
 */
class Tutor extends \Adianti\Database\TRecord{
    const TABLENAME = 'tutor';
    const PRIMARYKEY= 'id';
    const IDPOLICY =  'serial'; // {max, serial}
    
    public function get_nome_animal (){ 

        if ( empty ($this->animal ) ) {
            $this->animal = new Animal( $this->animal_id);
        }

        return $this->animal->nome_animal;
    }
    
    /**
     * Constructor method
     */

}
