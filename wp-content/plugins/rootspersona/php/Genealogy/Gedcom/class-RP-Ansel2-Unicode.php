<?php
/**
 * A class RP_that converts strings in ANSEL character set into Unicode (UTF-8).
 *
 * ANSEL is known as the American Library Association character set, and is until now
 * (2009) still the main character set used in GEDCOM files, the standard format for
 * exchanging genealogical data.
 *
 * The conversion is based on the work of Heiner Eichmann documented at his web page:
 *      http://www.heiner-eichmann.de/gedcom/charintr.htm
 * The conversion uses the mapping file that can be downloaded FROM here:
 *      http://www.heiner-eichmann.de/gedcom/ans2uni.con.zip
 *
 * You are free to use this code and edit it to suit your needs, but let my parts of the
 * commenting be intact. It is not legal to sell this piece of software.
 * This class RP_was published on my blog at http://www.gammelsaeter.com/
 *
 * @author Pål Gjerde Gammelsæter
 * @license Free to use, illegal to sell.
 * @version 2nd October 2009
 */
class RP_Ansel2_Unicode {

    private $_mapping; // The character mappings

    /**
     * Constructor of the object.
     * Generates the table for ANSEL to Unicode mapping.
     * @param String $conversionFile  The name of the mapping file made by Heiner Eichmann.
     *                                 The file can be downloaded FROM this URL:
     *                                 http://www.heiner-eichmann.de/gedcom/ans2uni.con.zip
     */
    public function __construct( $conversion_file = 'ans2uni.con' ) {
        $temp_ini_file = 'mappings.ini'; // Name of temporary ini file
        if ( File_exists( $conversion_file ) ) {
            // Load file contents, convert into well-formed ini file for later parsing.
            // This is done because the original mapping file cannot be parsed by the
            // PHP function parse_ini_file.
            $file_contents = File_get_contents( $conversion_file, 'FILE_BINARY' ); // Load contents
            $file_contents = $this->strip_comments( $file_contents, '#' ); // Strip comments
            File_put_contents( $temp_ini_file, $file_contents ); // Save contents
            // Get ini contents
            $map = Parse_ini_file( $temp_ini_file ); // Parse ini file
            // Go through map to split up the mappings that contain more characters in the key,
            // so that mappings with one character goes into $this->mapping[1], those with two
            // characters goes to $this->mapping[2] etc.
            foreach ( $map as $key => $value ) {
                $characters = explode( '+', $key ); // Split string where '+' occurrs
                $num_chars = count( $characters ); // count number of characters
                $this->_mapping[$num_chars][Strtolower( $key )] = $value; // Put mapping in right place
            }
            // Delete temporary ini file efterwards if exists
            if ( File_exists( $temp_ini_file ) ) {
                Unlink( $temp_ini_file );
            }
        } else {
            echo '<p>No mapping file with name ' . $conversion_file . ' exists. Download this file ' . 'from <a href="http://www.heiner-eichmann.de/gedcom/ans2uni.con.zip">here</a>.';
        }
    }
    /**
     * Loops through string to look for matches in the mapping table and replaces the
     * characters that has a mapping. This will convert the given string to Unicode/UTF-8.
     *
     * @param String $string    String to convert to Unicode (ÙTF-8)
     * @return String
     */
    public function convert( $string ) {
        $i = 0; // Initialize counter in loop
        $output = ''; // String to output
        // Go through string, fetch next character, next two characters and next three characters
        // to check against mapping table if mapping exist.
        while ( $i <= ( Strlen( $string ) - 1 ) ) {
            $remains = Strlen( $string ) - $i; // Characters that remains in string
            $key = array(); // Initialize array
            // Get next, next two and next three characters (if number of remaing
            // characters allow it)
            if ( $remains >= 3 ) {
                $key[3] = $this->get_key_map( $string, $i, 3 );
            }
            if ( $remains >= 2 ) {
                $key[2] = $this->get_key_map( $string, $i, 2 );
            }
            if ( $remains >= 1 ) {
                $key[1] = $this->get_key_map( $string, $i, 1 );
            }
            // Check if next three characters exist in mapping, and replace them if they do
            if ( count( $key ) == 3
            && Array_key_exists( $key[3], $this->_mapping[3] ) ) {
                $output .= Chr( Hexdec( $this->_mapping[3][$key[3]] ) );
                $i += 3; // We mapped three bytes into one char, jump three forward for next loop
            }
            // Check if next two characters exist in mapping, and replace them if they do
            elseif ( count( $key ) >= 2
            && Array_key_exists( $key[2], $this->_mapping[2] ) ) {
                $output .= Chr( Hexdec( $this->_mapping[2][$key[2]] ) );
                $i += 2;
            }
            // Check if next character exist in mapping, and replace it if it does
            elseif ( count( $key ) >= 1
            && Array_key_exists( $key[1], $this->_mapping[1] ) ) {
                $output .= Chr( Hexdec( $this->_mapping[1][$key[1]] ) );
                $i++;
            }
            // No mapping found, just return the character we have
            else {
                $output .= Chr( Hexdec( $key[1] ) );
                $i++;
            }
        }
        return Utf8_encode( $output ); // Return the string with replacements

    }
    /**
     * Format a string to same format as the keys in mapping table. The characters are
     * formatted as hexadecimal and separated with a plus sign. Example:
     * "Gon" -> "47+6f+6e"
     *
     * @param String  $string  The string witch contains the characters to convert
     * @param int     $start   Start position for the characters to convert
     * @param int     $length  Number of characters to convert
     * @return String
     */
    private function get_key_map( $string, $start, $length = 1 ) {
        $array = str_split( substr( $string, $start, $length ) );
        foreach ( $array as $key => $value ) {
            $array[$key] = Dechex( Ord( $value ) );
        }
        return implode( '+', $array );
    }
    /**
     * Strips comments off the end of each line in given string.
     *
     * @param String    $data           String where comments are being removed
     * @param String    $comment_char   The character indicating start of a comment
     * @return String[] The array of strings where comments are removed
     */
    private function strip_comments( $string, $comment_char = '#' ) {
        $array = explode( "\n", $string ); // Split each line into array
        $return = array();
        foreach ( $array as $i => $line ) {
            $pos = strpos( $line, $comment_char ); // Get postition of first '#'
            if ( $pos > 0 ) {
                $return[$i] = substr( $line, 0, $pos );
            } // Get part before '#'
            else {
                $return[$i] = $line;
            } // No '#' found
        }
        return implode( "\n", $return ); // Merge together as a string

    }
}
?>
