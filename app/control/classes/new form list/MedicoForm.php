<?php

class MedicoForm extends TPage{

    private $form;

    public function __construct(){
        parent::__construct();
        $this->form = new BootstrapFormBuilder('form_Medico');
        $this->form->setFormTitle('Médico');

        $id = new THidden('id');
        $espec= new TDBCombo('espec_id','bancomysql','Especialidade','id','nome_espec');
        $nome_medico = new TEntry('nome_medico');
        $crmv = new TEntry('CRMV');
        $cpf = new TEntry('cpf');

        
        //Validador
        $nome_medico->addValidation("Nome Médico" , new TRequiredValidator );
        $espec->addValidation("Especialidade" , new TRequiredValidator );
        $crmv->addValidation("CRMV" , new TRequiredValidator );
        $cpf->addValidation("CPF" , new TRequiredValidator );

        
        $this->form->addFields([$id]);     
        $this->form->addFields([new TLabel('Nome Médico <font color="red">*</font>')], [$nome_medico]);
        $this->form->addFields([new TLabel('Especialidade <font color="red">*</font>')], [$espec]); 
        $this->form->addFields([new TLabel('CRMV <font color="red">*</font>')], [$crmv]);
        $this->form->addFields([new TLabel('CPF <font color="red">*</font>')], [$cpf]);
     
        $this->form->addFields([new TLabel('')], [TElement::tag('label', '<font color="red">*</font> Campos obrigatórios' ) ]);
    
        $this->form->addAction('Salvar', new TAction(array($this, 'onSave')), 'fa:save')->class = 'btn btn-sm btn-primary';
        $this->form->addAction('Voltar', new TAction(array('MedicoList', 'onReload')), 'fa:arrow-left')->class = 'btn btn-sm btn-primary';

        parent::add($this->form);
    }

    public function onEdit($param){
        try {

            if (isset($param['key'])) {
                $key = $param['key'];

                TTransaction::open('bancomysql');

                $obj = new Medico($key);
                $this->form->setData($obj);

                TTransaction::close();
            }

        } catch (Exception $e) {

            new TMessage('error', '<b>Error</b> ' . $e->getMessage() . "<br/>");

            TTransaction::rollback();
        }
    }

    public function onSave($param){
        try {
            TTransaction::open('bancomysql');

            $this->form->validate();

            $object = $this->form->getData('Medico');
            $object->store();
      
            TTransaction::close();

            $action_voltar = new TAction(array('MedicoList', 'onReload'));

            new TMessage("info", "Registro salvo com sucesso!", $action_voltar);


        } catch (Exception $e) {
            new TMessage('error', $e->getMessage());
        }
    }
}

?>