<?php
/**
 * 	Copyright 2013 Innodyn (www.innodyn.nl)
 *
 *    This file is part of the INNODYN SEPA PAIN LIBRARY
 *
 *    This library is free software: you can redistribute it and/or modify
 *    it under the terms of the GNU Lesser General Public License as published
 *    by the Free Software Foundationeither version 3 of the License, or
 *    (at your option) any later version.
 *
 *    This program is distributed in the hope that it will be useful,
 *    but WITHOUT ANY WARRANTY; without even the implied warranty of
 *    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *    GNU Lesser General Public License for more details.
 *
 *    You should have received a copy of the GNU Lesser General Public License
 *    License along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 *	@author Leon Gilles Faber
 *  For more information about this software visit http://innodyn.nl
 */
abstract class SepaPainPaymentInstruction extends SepaPain{
	/**
	 * (non-PHPdoc)
	 * @see SepaPain::addXML()
	 */
	protected function addXML(SimpleXMLElement &$node){}
	
	/**
	 * Constructs and returns the correct type of SepaPainTransaction instance
	 * 
	 * @access protected
	 * @param array mixed $options
	 * @return SepaPainTransaction
	 */
	abstract protected function constructTransaction(&$options);
	
	/**
	 * Number of transactions inside the instance
	 * 
	 * @access public
	 * @var integer
	 */
	public $numberOfTransactions = 0;
	
	/**
	 * Total sum of amounts of the transactions inside the instance
	 * 
	 * @access public
	 * @var integer
	 */
	public $controlSum = 0;
	
	/**
	 * Array of all child SepaPainTransaction instances
	 * 
	 * @access private
	 * @var array SepaPainTransaction
	 */
	protected $transactions = array();
	
	
	/**
	 * parent SepaPainFile instance
	 * 
	 * @access private
	 * @var SepaPainDirectDebitFile
	 */
	protected $file;
	
	/**
	 * Constructor
	 * 
	 * @access public
	 * @param array mixed $options
	 * @param SepaPainFile $file
	 */
	public function __construct($options, SepaPainFile &$file){
		parent::__construct($options);
		$this->file = &$file;
	}
	
	/**
	 * Adds a transaction to this instance
	 * 
	 * @access public
	 * @param array mixed $options
	 * @throws Exception
	 * @return SepaPainTransaction
	 */
	public function addTransaction($options){
		if(!array_key_exists('amount', $options)) throw new Exception('Amount is missing');
		$transaction = $this->constructTransaction($options);
		$this->transactions[] = $transaction;
		$this->controlSum += $options['amount'];
		$this->numberOfTransactions += 1;
		return $transaction;
	}
}