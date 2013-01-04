<?php
/**
 * \Genealogy\Gedcom\CharacterSet
 *
 * PHP version 5
 *
 * @category  File_Formats
 * @package   Genealogy_Gedcom_Structures
 * @author    Ed Thompson <ed4becky@gmail.com>
 * @copyright 2010 Ed Thompson
 * @license   http://www.opensource.org/licenses/Apache2.0.php Apache License
 * @version   SVN: $Id: CharacterSet.php 291 2010-03-30 19:38:34Z ed4becky $
 * @link
 */
/**
 * CharacterSet class RP_for Genealogy_Gedcom
 *
 * @category  File_Formats
 * @package   Genealogy_Gedcom_Structures
 * @author    Ed Thompson <ed4becky@gmail.com>
 * @copyright 2010 Ed Thompson
 * @license   http://www.opensource.org/licenses/Apache2.0.php Apache License
 * @link
 */
class RP_Character_Set extends RP_Entity_Abstract {
	/**
	 * ANSEL |UTF-8 | UNICODE | ASCII
	 *
	 * @var string
	 */
	var $character_set;
	/**
	 * An identifier that represents the version level assigned
	 * to the associated product. It is defined and changed by
	 * the creators of the product.
	 *
	 * @var string
	 */
	var $ver_nbr;
	/**
	 * Flattens the object into a GEDCOM compliant format
	 *
	 * This method guarantees compliance, not re-creation of
	 * the original order of the records.
	 *
	 * @param int    $lvl indicates the level at which this record
	 * should be generated
	 * @param string $ver represents the version of the GEDCOM standard
	 *
	 * @return string a return character delimited string of gedcom records
	 *
	 * @access public
	 * @since Method available since Release 0.0.1
	 */
	public function to_gedcom( $lvl, $ver ) {
		$ged_rec = '';
		if ( isset( $this->character_set )
		&& $this->character_set != '' ) {
			$ged_rec .= $lvl . ' ' . Rp_Tags::CHAR . ' ' . $this->character_set;
		}
		$lvl2 = $lvl + 1;
		if ( isset( $this->ver_nbr )
		&& $this->ver_nbr != '' ) {
			$ged_rec .= "\n" . $lvl2 . ' ' . Rp_Tags::VERSION . ' ' . $this->ver_nbr;
		}
		return $ged_rec;
	}
	/**
	 * Extracts attribute contents FROM a parent tree object
	 *
	 * @param array  $tree an array containing an array FROM which the
	 * object data should be extracted
	 * @param string $ver  represents the version of the GEDCOM standard
	 * data is being extracted from
	 *
	 * @return void
	 *
	 * @access public
	 * @since Method available since Release 0.0.1
	 */
	public function parse_tree( $tree, $ver ) {
		$this->ver = $ver;if ( ( $i1 = parent::find_tag( $tree, Rp_Tags::CHAR ) ) !== false ) {
			$this->character_set = parent::parse_text( $tree[$i1], Rp_Tags::CHAR );
		}
		if ( isset( $tree[$i1][1] ) ) {
			$sub2 = $tree[$i1][1];
			if ( ( $i2 = parent::find_tag( $sub2, Rp_Tags::VERSION ) ) !== false ) {
				$this->ver_nbr = parent::parse_text( $sub2[$i2], Rp_Tags::VERSION );
			}
		}
	}
	/**
	 * Creates a string representation of the object
	 *
	 * @return string  contains string representation of each
	 * public field in the object
	 *
	 * @access public
	 * @since Method available since Release 0.0.1
	 */
	public function __toString() {
		$str = __CLASS__ . '(CharacterSet->' . $this->character_set . ', VerNbr->' . $this->ver_nbr . ')';
		return $str;
	}
}
