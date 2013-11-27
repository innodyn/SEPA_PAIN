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
abstract class SepaPainTransaction extends SepaPain{
	/**
	 * (non-PHPdoc)
	 * @see SepaPain::addXML()
	 */
//	abstract protected function addXML(SimpleXMLElement &$node);
	
	/**
	 * Parent SepaPainPaymentInstruction instance
	 * 
	 * @access private
	 * @var SepaPainPaymentInstruction
	 */
	private $instruction;
	
	/**
	 * Constructor
	 * 
	 * @access public
	 * @param array mixed $options
	 * @param SepaPainPaymentInstruction $instruction
	 */
	public function __construct($options, SepaPainPaymentInstruction &$instruction){
		parent::__construct($options);
		$this->instruction = &$instruction;
	}
}