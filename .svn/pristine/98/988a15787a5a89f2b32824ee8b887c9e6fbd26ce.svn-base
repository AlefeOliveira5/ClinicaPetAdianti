<?php
/**
 * Chart
 *
 * @version    1.0
 * @package    samples
 * @subpackage provahidel
 * @author     Alefe
 * @copyright  Copyright (c) 2006 Adianti Solutions Ltd. (http://www.adianti.com.br)
 * @license    http://www.adianti.com.br/framework-license
 */
class DashboardProdutos extends TPage
{
    function __construct( $show_breadcrumb = true )
    {
        parent::__construct();
        
        $html = new THtmlRenderer('app/resources/google_bar_chart.html');
        TTransaction::open ('bancomysql');
        $criteria = new TCriteria;
        $repository = new TRepository('vw_produtosRecord');
        $produtos = $repository->load($criteria);
        $data = array();
        $data[] = ['produtos','Qtd'];

        if ($produtos){
            foreach($produtos as $row) {
                $data[] = [($row->nome_prod),(int)$row->qtd];

            }
        }
        TTransaction::close();

        $panel = new TPanelGroup('Quantidade Produtos');
        $panel->style = 'width: 100%';
        $panel->add($html);
        $html->enableSection('main', array('data'   => json_encode($data),
                                           'width'  => '100%',
                                           'height' => '300px',
                                           'title'  => 'Produtos em geral',
                                           'ytitle' => 'Produtos', 
                                           'xtitle' => 'Quantidade',
                                           'uniqid' => uniqid()));

       
        
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->add($panel);
        parent::add($container);
    }
}
