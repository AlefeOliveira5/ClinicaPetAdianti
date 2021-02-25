<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Consulta
 *
 * @author Alefe
 */
class Consulta extends \Adianti\Database\TRecord{
    const TABLENAME = 'consulta';
    const PRIMARYKEY= 'id';
    const IDPOLICY =  'serial'; // {max, serial}
    
    public function get_nome_animal (){ 

        if ( empty ($this->animal ) ) {
            $this->animal = new Animal( $this->animalid);
        }

        return $this->animal->nome_animal;
    }
    public function get_nome_medico (){ 

        if ( empty ($this->medico ) ) {
            $this->medico = new Medico( $this->medico_id);
        }

        return $this->medico->nome_medico;
    }
    /**
     * Constructor method
     */
    /*public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('medico_id');
        parent::addAttribute('animalid');
        parent::addAttribute('exame_id');
        parent::addAttribute('diagnostico');
        parent::addAttribute('data_consulta');
    }*/
}
