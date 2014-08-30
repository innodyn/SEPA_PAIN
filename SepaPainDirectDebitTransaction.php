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
require_once 'SepaPainTransaction.php';

class SepaPainDirectDebitTransaction extends SepaPainTransaction{
	/**
	 * Option keys that are required
	 * 
	 * @access protected
	 * @var array string
	 */
	protected static $requiredOptions = array(
			'endToEndId', 
			'amount',
			'mandateId',
			'mandateDateOfSignature',
			'debtorIBAN', 
			'debtorBIC', 
			'debtorName'
	);
	
	/**
	 * Available option keys
	 * 
	 * @access public
	 * @var array string
	 */
	public static $allowedOptions = array(
			'instructionId', 
			'endToEndId', 
			'amount', 
			'mandateId', 
			'mandateDateOfSignature', 
			'debtorIBAN', 
			'debtorBIC', 
			'debtorName',
			'debtorCountry',
			'debtorAddressLines'
	);
        
        /**
         * Associative array with maxmimum lengths of option strings
         * @var array int
         */
        public static $optionMaxLengths = array(    'endToEndId' => 35,
                                                    'instructionId' => 35,
                                                    'mandateId' => 35,
                                                    'debtorName' => 70,
                                                    'debtorAddressLines' => 70);
	
	/**
	 * Constructor
	 *
	 * @access public
	 * @param array mixed $options
	 * @param SepaPainPaymentInstruction $instruction by reference
	 */
	public function __construct($options, SepaPainPaymentInstruction &$instruction){
		$options['debtorIBAN'] = self::cleanIban($options['debtorIBAN']);
		if(!self::validateIban($options['debtorIBAN'])){
			throw new Exception('Invalid debtor IBAN provided in direct debit transaction.');
		}
		if(!self::validateBic($options['debtorBIC'])){
			throw new Exception('Invalid debtor BIC provided in direct debit transaction.');
		}
		if(!is_numeric($options['amount'])){
			throw new Exception('Invalid (non-numeric) amount provided in direct debit transaction.');
		}
		if(count($options['debtorAddressLines']) > 2){
			throw new Exception('Too many debtor address lines in direct debit transaction. Maximum is 2.');
		}
                if(!array_key_exists($options['debtorCountry'], self::$ISO3166)){
                    throw new Exception('Debtor country is not a valid ISO 3166 country code.');
                }
                if(!is_a($options['mandateDateOfSignature'], 'DateTime')){
                    if(!self::validateDateString($options['mandateDateOfSignature'])){
                        throw new Exception('Mandate date of signature is invalid or incorrectly formatted (YYYY MM DD).');
                    }
                }
		parent::__construct($options, $instruction, $this->optionMaxLengths);
	}
	
	/**
	 * 
	 * @param SimpleXMLElement $node
	 */
	protected function addXml(SimpleXMLElement &$node){
		$txInfo = $node->addChild('DrctDbtTxInf');
		
		$id = $txInfo->addChild('PmtId');
		$id->addChild('EndToEndId', $this->options['endToEndId']);
                $this->setOptionalElement($id, 'InstrId', 'instructionId');
		$txInfo->addChild('InstdAmt', $this->centsToCurrency($this->options['amount']))->addAttribute('Ccy', 'EUR');
		
		$tx = $txInfo->addChild('DrctDbtTx');
		$mandate = $tx->addChild('MndtRltdInf');
		$this->setOptionalElement($mandate, 'MndtId', 'mandateId');
		$this->setOptionalElement($mandate, 'DtOfSgntr', 'mandateDateOfSignature');

		
		$txInfo->addChild('DbtrAgt')->addChild('FinInstnId')->addChild('BIC', $this->options['debtorBIC']);
		
		$debtor = $txInfo->addChild('Dbtr');
		$debtor->addChild('Nm', $this->options['debtorName']);
		if($this->optionIsSet('debtorAddressLines') || $this->optionIsSet('debtorCountry')){
			$address = $debtor->addChild('PstlAdr');
			$this->setOptionalElement($address, 'Ctry', 'debtorCountry');
			$addressLines = is_string($this->options['debtorAddressLines']) ? explode("\n", $this->options['debtorAddressLines']) : $this->options['debtorAddressLines'];
			$i = 0;
			foreach($addressLines as $line){
				$i++;
				if($i <= 2){
                                    $address->addChild('AdrLine', $this->cleanString($line));
                                }
			}
		}
		$txInfo->addChild('DbtrAcct')->addChild('Id')->addChild('IBAN', $this->options['debtorIBAN']);	
	}
}