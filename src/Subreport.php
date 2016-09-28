<?php
namespace JasperPHP;
use \JasperPHP;
	/**
	* classe TLabel
	* classe para constru��o de r�tulos de texto
	*
	* @author   Rogerio Muniz de Castro <rogerio@singularsistemas.net>
	* @version  2015.03.11
	* @access   restrict
	* 
	* 2015.03.11 -- cria��o
	**/
	class Subreport extends Element
	{
		public $returnValues;


		public function generate($obj = null)
		{
			$row = is_object($obj)?$_POST:$obj[1];
			$obj = is_array($obj)?$obj[0]:$obj;
			$xmlfile = (string)$this->objElement->subreportExpression;
			//$rowArray =is_array($row)?$row:get_object_vars($row);
            switch  ($row){
                case is_array($row):
                   $rowArray = $row;
                break;
                case  (method_exists($row,'toArray')):
                    $rowArray = $row->toArray();
                break;
                case (is_object( $row )):
                    $rowArray = get_object_vars($row);
                break;
                default:
                    $rowArray = null;
                break;
            }
			$newParameters = ($rowArray)?array_merge($obj->arrayParameter,$rowArray):$obj->arrayParameter;
			$report = new JasperPHP\Report($xmlfile,$newParameters);
			//$this->children= array($report);
			$report->generate();
			foreach($this->objElement->returnValue as $r){
				$this->returnValues[] = $r; 
			}
			$obj->setReturnVariables($this,$report->arrayVariable);
		}
	}
?>