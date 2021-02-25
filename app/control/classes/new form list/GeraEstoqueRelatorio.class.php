<?php
/**
 * @author Alefe
 */
class GeraEstoqueRelatorio extends TPage{
  private $form;

  public function __construct()
  {
    parent::__construct();

    $this->form = new BootstrapFormBuilder( "form_relatorio" );
    $this->form->setFormTitle( "Relatorio Estoque" );
    $this->form->class = "tform";

    $this->form->addFields([new TLabel("Gerar Estoque")], [null]);
    $this->form->addAction("Gerar", new TAction([$this, "onGenerate"]), "fa:table blue");

    $container = new TVBox();
    $container->style = "width: 100%";
    $container->add( $this->form );
    parent::add( $container );
  }


  function onGenerate(){
    $file = "app/reports/RelatorioEstoquePDF.pdf";

    try{
      new RelatorioEstoquePDF(); 
      parent::openFile($file);
    }catch( Exception $e ){
      new TMessage( 'error', $e->getMessage() );
      TTransaction::rollback();
    }
  }

}

?>