<?php

class ProdutosForm extends TPage{

    private $form;

    public function __construct(){
        parent::__construct();
        $this->form = new BootstrapFormBuilder('form_produtos');
        $this->form->setFormTitle('Produtos');

        $id = new THidden('id');
        $nome_prod = new TEntry('nome_prod');
        $preco = new TEntry('preco');
        $qtd = new TEntry('quantidade');

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
        $nome_prod->addValidation("Nome Produto" , new TRequiredValidator );
        $preco->addValidation("Preço" , new TRequiredValidator );
        $qtd->addValidation("Quantidade" , new TRequiredValidator );

        /*$peso->addValidation("Peso" , new TRequiredValidator );
        $tamanho->addValidation("Tamanho" , new TRequiredValidator );
        $sexo->addValidation("Sexo" , new TRequiredValidator );
        $especie->addValidation("Especie" , new TRequiredValidator );

        $data_nascimento->setMask('dd/mm/yyyy');*/
        
        $this->form->addFields([$id]);     
        $this->form->addFields([new TLabel('Nome Produto <font color="red">*</font>')], [$nome_prod]);
        $this->form->addFields([new TLabel('Preço <font color="red">*</font>')], [$preco]); 
        $this->form->addFields([new TLabel('Quantidade <font color="red">*</font>')], [$qtd]);
        
        /*
        $this->form->addFields([new TLabel('Peso <font color="red">*</font>')], [$peso]);
        $this->form->addFields([new TLabel('Tamanho <font color="red">*</font>')], [$tamanho]);
        $this->form->addFields([new TLabel('Sexo <font color="red">*</font>')], [$sexo]);
        $this->form->addFields([new TLabel('Especie <font color="red">*</font>')], [$especie]);*/
     
        $this->form->addFields([new TLabel('')], [TElement::tag('label', '<font color="red">*</font> Campos obrigatórios' ) ]);

        //$preco->setProperty('placeholder', 'R$');
    

        $this->form->addAction('Salvar', new TAction(array($this, 'onSave')), 'fa:save')->class = 'btn btn-sm btn-primary';
        $this->form->addAction('Voltar', new TAction(array('ProdutosList', 'onReload')), 'fa:arrow-left')->class = 'btn btn-sm btn-primary';

        parent::add($this->form);
    }

    public function onEdit($param){
        try {

            if (isset($param['key'])) {
                $key = $param['key'];

                TTransaction::open('bancomysql');

                $obj = new Produtos($key);
                //$obj->data_nascimento = TDate::date2br($obj->data_nascimento);
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

            $object = $this->form->getData('Produtos');
            //$object->data_nascimento = TDate::date2us($object->data_nascimento);
            $object->store();
      
            TTransaction::close();

            $action_voltar = new TAction(array('ProdutosList', 'onReload'));

            new TMessage("info", "Registro salvo com sucesso!", $action_voltar);


        } catch (Exception $e) {
            new TMessage('error', $e->getMessage());
        }
    }
}

?>