<?php
/**
 * @author Alefe
 */
use Adianti\Database\TTransaction;
use Adianti\Database\TRepository;
use Adianti\Database\TCriteria;
use Adianti\Database\TFilter;

class RelatorioEstoquePDF extends FPDF {

    function Header() {
        
        
        $this->SetFont('Arial', 'B', 10);
        $this->SetY("15");
        $this->SetX("40");
        $this->Cell(0, 5, utf8_decode("RELATÓRIO DE ESTOQUE"), 0, 1, 'L');
        $filtro = '';

        $this->SetX("40");
        $this->Cell(0, 5, $filtro, 0, 1, 'L');
        $this->Ln(8);
        $this->ColumnHeader();
    }

    function ColumnHeader() {
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(0, 0, '', 1, 1, 'L');
        $this->Cell(40, 5, utf8_decode("Nome Produto \n "), 0, 0, 'L');
        $this->Cell(40, 5, utf8_decode("Preço \n "), 0, 0, 'L');
        $this->Cell(40, 5, utf8_decode("Quantidade \n"), 0, 0, 'L');
        

        $this->Cell(0, 0, '', 1, 1);
    }

    function ColumnDetail() {


        
       
        TTransaction::open('bancomysql');
        $repository = new TRepository('Produtos');
        $criteria = new TCriteria;
        $criteria->setProperty('order', 'nome_prod', 'preco', 'quantidade');
        if(!empty($nome_prod)){
            $criteria->add(new TFilter("nome_prod", "=", $nome_prod));
        }
        if(!empty($qtd)){
            $criteria->add(new TFilter("quantidade", "=", $quantidade));
        }
        if(!empty($preco)){
            $criteria->add(new TFilter("preco", "=", $preco));
        }
      
        $rows = $repository->load($criteria);
       
        if ($rows) {
            $this->SetFont('Arial', '', 8);
			foreach ($rows as $row){
				$this->Ln(8);
				$this->SetFont('Arial', '', 8);
                $this->Cell(40, 0, utf8_decode($row->nome_prod), 0, 0, 'L');
				$this->Cell(40, 0, utf8_decode($row->preco), 0, 0, 'L');
				$this->Cell(40, 0, utf8_decode($row->quantidade), 0, 0, 'L');
               
			}
            $this->Ln(8);
			$this->SetFont('Arial', 'B', 8);
			$this->Cell(60, 0, utf8_decode(''), 0, 0, 'L');
            $this->Cell(60, 0, utf8_decode(''), 0, 0, 'L');

			
		}
        TTransaction::close();
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $data = date("d/m/Y H:i:s");
        $conteudo = "Hospital Veterinario " . $data;
        $texto = "Estoque";
        $this->Cell(0, 0, '', 1, 1, 'L');
        $this->Cell(0, 5, $texto, 0, 0, 'L');
        $this->Cell(0, 5, $conteudo, 0, 0, 'R');
        $this->Ln();
    }

}

$pdf = new RelatorioEstoquePDF("P", "mm", "A4");
$pdf->SetTitle(utf8_decode("RELATÓRIO DE Estoque"));
$pdf->SetSubject(utf8_decode("Hospital Veterinario"));
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times', '', 12);
$pdf->ColumnDetail();
$file = "app/reports/RelatorioEstoquePDF.pdf";
$pdf->Output($file);

?>