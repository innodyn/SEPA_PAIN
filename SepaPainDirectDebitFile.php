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
require_once 'SepaPainFile.php';
require_once 'SepaPainPaymentInstruction.php';
require_once 'SepaPainDirectDebitPaymentInstruction.php';
require_once 'SepaPainTransaction.php';
require_once 'SepaPainDirectDebitTransaction.php';

class SepaPainDirectDebitFile extends SepaPainFile{
	/**
	 * Name of file's root node
	 * @var string
	 */
	const ROOT_NODE = 'CstmrDrctDbtInitn';
	
	/**
	 * Payment method to be used throughout the file
	 * @var string
	 */
	const PAYMENT_METHOD = 'DD'; 
	
	/**
	 * Options that are required
	 * @var array mixed
	 */
	public static $requiredOptions = array('id', 'initiatingPartyName');
	
	/**
	 * Default sequence type in all payment types (OOFF = One off)
	 * @access public
	 * @var string 'FNAL', 'FRST', 'OOFF' or 'RCUR'
	 */
	public $defaultSequenceType = 'OOFF';
	
	/**
	 * Constructor
	 * 
	 * @access public
	 * @param array mixed $options
	 */
	public function __construct($options){
		if(!array_key_exists('defaultCountry', $options)) $options['defaultCountry'] = static::DEFAULT_COUNTRY;
		parent::__construct($options);
	}
	
	/**
	 * Returns new SepaPainDirectDebitPaymentInstruction instance
	 * 
	 * @access protected
	 * @param array mixed $options
	 * @return SepaPainDirectDebitPaymentInstruction
	 */
	protected function constructPaymentInstruction(&$options){
		return new SepaPainDirectDebitPaymentInstruction($options, $this);
	}
}