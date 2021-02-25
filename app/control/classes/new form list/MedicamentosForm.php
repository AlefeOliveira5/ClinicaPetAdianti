<?php

class MedicamentosForm extends TPage{

    private $form;

    public function __construct(){
        parent::__construct();
        $this->form = new BootstrapFormBuilder('form_medicamentos');
        $this->form->setFormTitle('Medicamentos');

        $id = new THidden('id');
        $nome = new TEntry('nome_medi');
        $qtd = new TEntry('quantidade');
        $validade = new TDate('validade');

        /*$peso = new TEntry('peso');
        $tamanho = new TEntry('tamanho');
        $especie = new TEntry('especie');
        $sexo= new TRadioGroup('sexo');

        $sexo_array = [];
        $sexo_array['1'] = 'Femea';
        $sexo_array['2'] = 'Macho';
        $sexo->additems($sexo_array);
        $sexo->setLayout('horizontal');
        $sexo->setValue( "1" );*/
        
        //Validador
        $nome->addValidation("Nome Medicamento" , new TRequiredValidator );
        $qtd->addValidation("Quantidade" , new TRequiredValidator );
        $validade->addValidation("Data de Validade" , new TRequiredValidator );

        $validade->setMask('dd/mm/yyyy');
        
        $this->form->addFields([$id]);     
        $this->form->addFields([new TLabel('Nome Medicamento <font color="red">*</font>')], [$nome]);
        $this->form->addFields([new TLabel('Quantidade <font color="red">*</font>')], [$qtd]); 
        $this->form->addFields([new TLabel('Data de Validade <font color="red">*</font>')], [$validade]);
        
        /*
        $this->form->addFields([new TLabel('Peso <font color="red">*</font>')], [$peso]);
        $this->form->addFields([new TLabel('Tamanho <font color="red">*</font>')], [$tamanho]);
        $this->form->addFields([new TLabel('Sexo <font color="red">*</font>')], [$sexo]);
        $this->form->addFields([new TLabel('Especie <font color="red">*</font>')], [$especie]);*/
     
        $this->form->addFields([new TLabel('')], [TElement::tag('label', '<font color="red">*</font> Campos obrigatórios' ) ]);

        //$preco->setProperty('placeholder', 'R$');
    

        $this->form->addAction('Salvar', new TAction(array($this, 'onSave')), 'fa:save')->class = 'btn btn-sm btn-primary';
        $this->form->addAction('Voltar', new TAction(array('MedicamentosList', 'onReload')), 'fa:arrow-left')->class = 'btn btn-sm btn-primary';

        parent::add($this->form);
    }

    public function onEdit($param){
        try {

            if (isset($param['key'])) {
                $key = $param['key'];

                TTransaction::open('bancomysql');

                $obj = new Medicamentos($key);
                $obj->validade = TDate::date2br($obj->validade);
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

            $object = $this->form->getData('Medicamentos');
            $object->validade = TDate::date2us($object->validade);
            $object->store();
      
            TTransaction::close();

            $action_voltar = new TAction(array('MedicamentosList', 'onReload'));

            new TMessage("info", "Registro salvo com sucesso!", $action_voltar);


        } catch (Exception $e) {
            new TMessage('error', $e->getMessage());
        }
    }
}

?>