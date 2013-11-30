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
require_once 'SepaPainPaymentInstruction.php';
require_once 'SepaPainTransaction.php';
require_once 'SepaPainDirectDebitTransaction.php';

class SepaPainDirectDebitPaymentInstruction extends SepaPainPaymentInstruction{
	/**
	 * Array with require options
	 * 
	 * @static
	 * @access public
	 * @var array string
	 */
	public static $requiredOptions = array('id', 'method', 'collectionDate', 'creditorName', 'creditorCountry', 'creditorAddressLines', 'creditorIBAN', 'creditorBIC', 'creditorSchemePrivateId');
	
	/**
	 * Array with options that can be used
	 * 
	 * @static
	 * @access public
	 * @var array string
	 */
	public static $allowedOptions = array('id', 'method', 'sequenceType', 'collectionDate', 'creditorName', 'creditorCountry', 'creditorAddressLines', 'creditorIBAN', 'creditorBIC', 'creditorSchemeName', 'creditorSchemePrivateId');
	
	/**
	 * Constructor
	 * 
	 * @access public
	 * @param array mixed $options
	 * @param SepaPainDirectDebitFile $file
	 */
	public function __construct($options, SepaPainDirectDebitFile &$file){
		$options['creditorIBAN'] = self::cleanIban($options['creditorIBAN']);
		if(!self::validateIban($options['creditorIBAN'])){
			throw new Exception('Invalid creditor IBAN provided in direct debit payment instruction.');
		}
		if(!self::validateBic($options['creditorBIC'])){
			throw new Exception('Invalid creditor BIC provided in direct debit payment instruction.');
		}
		if(count($options['creditorAddressLines']) > 2){
			throw new Exception('Too many creditor address lines in direct debit payment instruction. Maximum is 2.');
		}
		if(!array_key_exists('creditorName', $options)) $options['creditorName'] = $file->initiatingPartyName;
		if(!array_key_exists('method', $options)) $options['method'] = $file::PAYMENT_METHOD;
		if(!array_key_exists('creditorCountry', $options)) $options['creditorCountry'] = $file::DEFAULT_COUNTRY;
		parent::__construct($options, $file);
	}
	
	/**
	 * Creates and returns SepaPainDirectDebitTransaction
	 * 
	 * @access protected
	 * @param array mixed $options
	 * @return SepaPainDirectDebitTransaction
	 */
	protected function constructTransaction(&$options){
		return new SepaPainDirectDebitTransaction($options, $this);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see SepaPain::addXML()
	 */
	public function addXML(SimpleXMLElement &$node){
		$info = $node->addChild('PmtInf');
		$info->addChild('PmtInfId', $this->options['id']);
		$info->addChild('PmtMtd', $this->options['method']);
		if($this->optionIsSet('batchBooking')){
			$info->addChild('BtchBookg', $this->boolToString($this->options['batchBooking']));
		}else{
			$info->addChild('BtchBookg', 'true');
		}
		$info->addChild('NbOfTxs', $this->numberOfTransactions);
		$info->addChild('CtrlSum', $this->centsToCurrency($this->controlSum));

		$typeInfo = $info->addChild('PmtTpInf');
		$typeInfo->addChild('SvcLvl')->addChild('Cd', 'SEPA');
		$typeInfo->addChild('LclInstrm')->addChild('Cd', 'CORE');
		$typeInfo->addChild('SeqTp', $this->optionIsSet('sequenceType') ? $this->options['sequenceType'] : $this->file->defaultSequenceType);

		$info->addChild('ReqdColltnDt', $this->options['collectionDate']->format('Y-m-d'));
		
		$creditor = $info->addChild('Cdtr');
		$creditor->addChild('Nm', $this->cleanString($this->options['creditorName']));
		$address = $creditor->addChild('PstlAdr');
		$address->addChild('Ctry', $this->cleanString($this->options['creditorCountry']));
		if(is_string($this->options['creditorAddressLines'])){
			$this->options['creditorAddressLines'] = explode("\n", $this->cleanString($this->options['creditorAddressLines']));
		}
		foreach($this->options['creditorAddressLines'] as $line){
			$address->addChild('AdrLine', $this->cleanString($line));
		}

		$info->addChild('CdtrAcct')->addChild('Id')->addChild('IBAN', $this->options['creditorIBAN']);
		$info->addChild('CdtrAgt')->addChild('FinInstnId')->addChild('BIC', $this->options['creditorBIC']);
		$info->addChild('ChrgBr', 'SLEV');
		
		$scheme = $info->addChild('CdtrSchmeId');
		$this->setOptionalElement($scheme, 'Nm', 'creditorSchemeName');
		$other = $scheme->addChild('Id')->addChild('PrvtId')->addChild('Othr');
		$other->addChild('Id', $this->cleanString($this->options['creditorSchemePrivateId']));
		$other->addChild('SchmeNm')->addChild('Prtry', 'SEPA');
		
		foreach($this->transactions as $transaction){
			$transaction->addXML($info);
		}
		
	}
}