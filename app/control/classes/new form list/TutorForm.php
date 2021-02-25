<?php
/** 
 * @author Alefe
 *
*/
class TutorForm extends TPage{

    private $form;

    public function __construct(){
        parent::__construct();
        $this->form = new BootstrapFormBuilder('form_Tutor');
        $this->form->setFormTitle('Cadastro Tutor');

        $id = new THidden('id');
        $nome_tutor = new TEntry('nome_tutor');
        $tel = new TEntry('telefone');
        $cpf = new TEntry('cpf');
        $email = new TEntry('email');
        $animal_id = new TDBCombo('animal_id','bancomysql','Animal','id','nome_animal');
        
        //Validador
        $nome_tutor->addValidation("Nome Tutor" , new TRequiredValidator );
        $tel->addValidation("Telefone" , new TRequiredValidator );
        $cpf->addValidation("CPF" , new TRequiredValidator );
        $email->addValidation("Email" , new TRequiredValidator );
        $animal_id->addValidation("Selecione o Nome do Seu Animal" , new TRequiredValidator );
        
        $this->form->addFields([$id]);     
        $this->form->addFields([new TLabel('Nome Tutor <font color="red">*</font>')], [$nome_tutor]); 
        $this->form->addFields([new TLabel('Telefone <font color="red">*</font>')], [$tel]);
        $this->form->addFields([new TLabel('CPF <font color="red">*</font>')], [$cpf]);
        $this->form->addFields([new TLabel('Email <font color="red">*</font>')], [$email]);
        $this->form->addFields([new TLabel('Selecione o Nome do Seu Animal <font color="red">*</font>')], [$animal_id]);
        
     
        $this->form->addFields([new TLabel('')], [TElement::tag('label', '<font color="red">*</font> Campos obrigatórios' ) ]);

        $this->form->addAction('Salvar', new TAction(array($this, 'onSave')), 'fa:save')->class = 'btn btn-sm btn-primary';
        $this->form->addAction('Voltar', new TAction(array('TutorList', 'onReload')), 'fa:arrow-left')->class = 'btn btn-sm btn-primary';

        parent::add($this->form);
    }

    public function onEdit($param){
        try {

            if (isset($param['key'])) {
                $key = $param['key'];

                TTransaction::open('bancomysql');

                $obj = new Tutor($key);
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

            $object = $this->form->getData('Tutor');
            $object->store();
      
            TTransaction::close();

            $action_voltar = new TAction(array('TutorList', 'onReload'));

            new TMessage("info", "Registro salvo com sucesso!", $action_voltar);


        } catch (Exception $e) {
            new TMessage('error', $e->getMessage());
        }
    }
}

?>