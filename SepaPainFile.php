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
require_once 'SepaPain.php';

abstract class SepaPainFile extends SepaPain{
	/**
	 * Constructs new SepaPainPaymentInstruction instance
	 * 
	 * @access protected
	 * @param array mixed $options
	 * @return object SepaPainPaymentInstruction
	 */
	abstract protected function constructPaymentInstruction(&$options);
	
	/**
	 * Array with all SepaPainPaymentInstruction instances in file
	 * 
	 * @var array SepaPainPaymentInstruction
	 */
	protected $payments = array();
	
	/**
	 * Default coutry code
	 * 
	 * @var string
	 */
	const DEFAULT_COUNTRY = 'NL';
	
	/**
	 * Constructor
	 * 
	 * @access protected
	 * @param array mixed $options
         * @param array int $maxLengths
	 */
	protected function __construct($options, $maxLengths = null){
		parent::__construct($options, $maxLengths);
		$this->numberOfTransfers = 0;
		$this->controlSum = 0;	
	}
	
	/**
	 * Returns SEPA PAIN file as XML string
	 * 
	 * @access public
	 * @return string
	 */
	public function getXML(){
		$xml = simplexml_load_string(static::INITIAL_STRING);
		$this->addXML($xml);
		return $xml->asXML();
	}
	
	/**
	 * @see SepaPain::addXML()
	 */
	public function addXML(SimpleXMLElement &$node){
		$root = $node->addChild(static::ROOT_NODE);
		$this->addGroupHeader($root);
		foreach($this->payments as $payment){
			$payment->addXML($root);
		}
	}
	
	/**
	 * Adds a payment instruction block to the file
	 * 
	 * @access public
	 * @param array mixed $options
	 * @return object SepaPainDirectDebitPaymentInstruction
	 */
	public function addPaymentInstruction($options){
		$payment = $this->constructPaymentInstruction($options);
		$this->payments[] = $payment;
		return $payment;
	}
	
	/**
	 * Collects total number of transactions in the file
	 * 
	 * @access public
	 * @return integer
	 */
	public function getNumberOfTransactions(){
		$n = 0;
		foreach($this->payments as $payment){
			$n += $payment->numberOfTransactions;
		}
		return $n;
	}
	
	/**
	 * Collects total sum of all transactions in the file in cents
	 * 
	 * @access public
	 * @return integer
	 */
	public function getControlSum(){
		$sum = 0;
		foreach($this->payments as $payment){
			$sum += $payment->controlSum;
		}
		return $sum;
	}
	
	/**
	 * Adds a group header node to $rootNode
	 * 
	 * @access protected
	 * @param SimpleXMLElement $rootNode
	 */
	protected function addGroupHeader(SimpleXMLElement &$rootNode){
		$hdr = $rootNode->addChild('GrpHdr');
		$hdr->addChild('MsgId', $this->options['id']);
		$datetime = new DateTime();
		$hdr->addChild('CreDtTm', $datetime->format('Y-m-d\TH:i:s'));
		$hdr->addChild('NbOfTxs', $this->getNumberOfTransactions());
		$hdr->addChild('CtrlSum', $this->centsToCurrency($this->getControlSum()));
		$initParty = $hdr->addChild('InitgPty');
		$initParty->addChild('Nm', $this->options['initiatingPartyName']);
	}	
}