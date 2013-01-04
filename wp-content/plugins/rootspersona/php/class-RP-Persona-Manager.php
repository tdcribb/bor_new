<?php
class Persona_Manager {
    private $transaction = null;

    function process_getfamilies($credentials, $like, $options) {
        $this->transaction = new RP_Transaction( $credentials );
        $list =  RP_Dao_Factory::get_rp_persona_dao( $credentials->prefix )
                                ->get_family_list( $like, $options );
        $this->transaction->close();
        return $list;
    }

    function process_getspouses($credentials, $like, $options) {
        $this->transaction = new RP_Transaction( $credentials );
        $list =  RP_Dao_Factory::get_rp_persona_dao( $credentials->prefix )
                                ->get_spouses_list( $like, $options );
        $this->transaction->close();
        return $list;
    }

    function process_getfamily($credentials, $datastr, $options) {

    }

 	function process_form( $credentials, $parms, $options) {

        $isSOR = ($options['is_system_of_record'] == '1'?true:false);
        $validator = new Persona_Validator();
        $ret = $validator->validate( $parms, $options );
        $options = $ret[1];
        if($ret[0] !== false ) {
            if($isSOR) {
                $handler = new RP_Gedcom_Loader();
                $handler->credentials = $credentials;
                $handler->batch_id = $ret[0]->batch_id;
                $options['editMode'] = 1;
                $indi = $handler->process_individual( $ret[0], $options );
            } else {
                $indi = $ret[0];
            }
            if( $indi instanceof RP_Individual_Record ) {
                if( isset( $indi->id ) && !empty( $indi->id ) ) {
                    $page = $indi->page;
                    if( (!isset( $page ) || empty( $page )) ) {
                        $name = $indi->names[0];
                        $title =   $name->rp_name->pieces->surname
                                . ', ' . $name->rp_name->pieces->given;
                        $content = "[rootsPersona   personid='$indi->id' batchId='$indi->batch_id'";
                        for ( $i = 1;$i <= 7;    $i++ ) {
                            $pf = 'picfile' . $i;
                            if ( isset( $indi->images[$i-1] ) ) {
                                $content = $content . ' ' . $pf . "='" . $indi->images[$i-1] . "'";
                                $pc = 'piccap' . $i;
                                if ( isset( $indi->captions[$i-1] )) {
                                    $content = $content . ' ' . $pc . "='" . $indi->captions[$i-1] . "'";
                                }
                            }
                        }

                        $content = $content . "/]";
                        $page_id = RP_Persona_Helper::add_page( null, $title, $options, null, $content );
                        $indi->page = $page_id;
                        if ( $page_id != false ) {
                            $this->transaction = new RP_Transaction( $credentials );
                            RP_Dao_Factory::get_rp_indi_dao( $credentials->prefix )
                                    ->update_page( $indi->id, $indi->batch_id, $page_id );

                            RP_Dao_Factory::get_rp_persona_dao( $credentials->prefix )
                                ->update_persona_privacy( $indi->id, $indi->batch_id, $indi->privacy, '' );

                            $this->transaction->commit();
                        }
                    } else if ($indi->privacy != 'Exc') {
                        $my_post = array();
                        $my_post['ID'] = $page;

                        if($isSOR) {
                            $name = $indi->names[0];
                            $title =   $name->rp_name->pieces->surname
                                    . ', ' . $name->rp_name->pieces->given;
                            $my_post['post_title'] = $title;
                        }
                        $content = "[rootsPersona   personid='$indi->id' batchId='$indi->batch_id'";
                        for ( $i = 1;$i <= 7;    $i++ ) {
                            $pf = 'picfile' . $i;
                            if ( isset( $indi->images[$i-1] ) ) {
                                $content = $content . ' ' . $pf . "='" . $indi->images[$i-1] . "'";
                                $pc = 'piccap' . $i;
                                if ( isset( $indi->captions[$i-1] )) {
                                    $content = $content . ' ' . $pc . "='" . $indi->captions[$i-1] . "'";
                                }
                            }
                        }
                        $content = $content . "/]";
                        $my_post['post_content'] = $content;
                        wp_update_post( $my_post );
                        $this->transaction = new RP_Transaction( $credentials );
                        RP_Dao_Factory::get_rp_persona_dao( $credentials->prefix )
                            ->update_persona_privacy( $indi->id, $indi->batch_id, $indi->privacy, '' );
                        $this->transaction->commit();
                    } else {
                        wp_delete_post( $page );
                        RP_Dao_Factory::get_rp_persona_dao( $this->credentials->prefix )
                                ->delete_persona( $indi->id, $indi->batch_id );
                        $r = array();
                        $r['error'] = 'Persona deleted.';
                        return $r;
                    }
                }
            } else {
                $r = array();
                $r['error'] = 'Error saving record.';
                return $r;
            }
        } else {
            return $ret[1]['errors'];
        }
        $r = array();
        $r['rp_id'] = $indi->id;
        $r['rp_page'] = $indi->page;
        if(isset($indi->parental->id) && !empty($indi->parental->id)) {
            $r['rp_famc'] = $indi->parental->id;
        }
        if(isset($indi->newFams) && !empty($indi->newFams)) {
            $r['rp_fams'] = $indi->newFams;
        }
        return $r;
	}
}
