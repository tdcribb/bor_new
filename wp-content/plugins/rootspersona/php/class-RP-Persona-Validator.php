<?php

class Persona_Validator {

    public function validate($form, $options) {
        unset($options['errors']);
        $isSOR = ($options['is_system_of_record'] == '1'?true:false);
        $indi = new RP_Individual_Record();
        $is_update = false;
        if (isset($form['persona_page']) && !empty($form['persona_page'])) {
            $indi->page = (trim(esc_attr($form['persona_page'])));
            $is_update = true;
        }
        if (isset($form['personId']) && !empty($form['personId'])) {
            $indi->id = trim(esc_attr($form['personId']));
            $is_update = true;
        }
        if (isset($form['batchId']) && !empty($form['batchId'])) {
            $indi->batch_id = trim(esc_attr($form['batchId']));
            $is_update = true;
        } else if (isset($form['rp_batch_id']) && !empty($form['rp_batch_id'])) {
            $indi->batch_id = trim(esc_attr($form['rp_batch_id']));
            $is_update = true;
        } else {
            $options = $this->set_error('error', $options, __('Batch Id required.', 'rootspersona'));
        }

        if (isset($form['persona_page']) && !empty($form['persona_page'])) {
            $indi->page = trim(esc_attr($form['persona_page']));
            $is_update = true;
        }

        if (isset($form['privacy_grp']) && !empty($form['privacy_grp'])) {
            $indi->privacy = trim(esc_attr($form['privacy_grp']));
            $is_update = true;
        }

        if($isSOR) {
            $name = new RP_Personal_Name();
            $indi->names[] = $name;
            $isName = false;
            if (isset($form['rp_prefix']) && !empty($form['rp_prefix'])) {
                $name->rp_name->pieces->prefix = trim(esc_attr($form['rp_prefix']));
                $is_update = true;
            }
            if (isset($form['rp_first']) && !empty($form['rp_first'])) {
                $name->rp_name->pieces->given = trim(esc_attr($form['rp_first']));
                $is_update = true;
                $isName = true;
            }
            if (isset($form['rp_middle']) && !empty($form['rp_middle'])) {
                $name->rp_name->pieces->given .= " " . trim(esc_attr($form['rp_middle']));
                $is_update = true;
            }
            if (isset($form['rp_last']) && !empty($form['rp_last'])) {
                $name->rp_name->pieces->surname = trim(esc_attr($form['rp_last']));
                $is_update = true;
                $isName = true;
            }
            if (isset($form['rp_suffix']) && !empty($form['rp_suffix'])) {
                $name->rp_name->pieces->suffix = trim(esc_attr($form['rp_suffix']));
                $is_update = true;
            }
            if (isset($form['rp_full']) && !empty($form['rp_full'])) {
                $name->rp_name->full = trim(esc_attr($form['rp_full']));
                $is_update = true;
                $isName = true;
            }
            if ($isName == false) {
                $options = $this->set_error('error', $options, __('Surname and/or Given name required.', 'rootspersona'));
            }
            if (isset($form['pickgender']) && !empty($form['pickgender'])) {
                $indi->gender = trim(esc_attr($form['pickgender']));
                $is_update = true;
            }

            if (isset($form['rp_bio']) && !empty($form['rp_bio'])) {
                $note = new RP_Note();
                $indi->notes[] = $note;
                $note->text = trim(esc_attr($form['rp_bio']));
                $is_update = true;
            }
        }

        $fields = array_keys($form);
        $cnt = count($fields);
        for($i=0; $i < $cnt; $i++) {
            if(strpos($fields[$i],'rp_claimtype') === false ) continue;
            $ev = new RP_Event();
            $sfx = strrpos($fields[$i],'_');
            $sfx = substr($fields[$i],$sfx+1);
            if (isset($form['rp_claimtype_' . $sfx]) && !empty($form['rp_claimtype_' . $sfx])) {
                $ev->type = trim(esc_attr($form['rp_claimtype_' . $sfx]));
                $ev->tag = $this->my_array_val_search($ev->type,$ev->_TYPES);
                if($ev->tag === false) {
                    $fact = new RP_Fact();
                    $fact->tag = $this->my_array_val_search($ev->type,$fact->_TYPES);
                    if($fact->tag !== false) {
                        $fact->type = $ev->type;
                        $ev = $fact;
                    } else continue;
                }
                $is_update = true;
            }
            if (isset($form['rp_claimdate_' . $sfx]) && !empty($form['rp_claimdate_' . $sfx])) {
                $ev->date = trim(esc_attr($form['rp_claimdate_' . $sfx]));
                $is_update = true;
            }
            if (isset($form['rp_claimplace_' . $sfx]) && !empty($form['rp_claimplace_' . $sfx])) {
                $ev->place->name = trim(esc_attr($form['rp_claimplace_' . $sfx]));
                $is_update = true;
            }
            if (isset($form['rp_classification_' . $sfx]) && !empty($form['rp_classification_' . $sfx])) {
                $ev->cause = trim(esc_attr($form['rp_classification_' . $sfx]));
                $is_update = true;
            }
            if($ev instanceof RP_Event) {
                $indi->events[] = $ev;
            }
            else {
                $indi->attributes[] = $ev;
            }
        }

        for($i=0; $i < $cnt; $i++) {
            if(strpos($fields[$i],'img_path') === false ) continue;
            $sfx = strrpos($fields[$i],'_');
            $sfx = substr($fields[$i],$sfx+1);

            if (isset($form['img_path_' . $sfx]) && !empty($form['img_path_' . $sfx])) {
                $p = trim(esc_attr($form['img_path_' . $sfx]));
                if (strpos($p, '-silhouette.gif') !== false) continue;
                $indi->images[] = $p;
                $is_update = true;
            }

            if (isset($form['cap_' . $sfx]) && !empty($form['cap_' . $sfx])) {
                $indi->captions[] = trim(esc_attr($form['cap_' . $sfx]));
                $is_update = true;
            }
        }


        if($isSOR) {
        if (isset($form['rp_famc']) && !empty($form['rp_famc'])) {
            $famlink = new RP_Family_Link();
            $famlink->family_id = trim(esc_attr($form['rp_famc']));
            if($famlink->family_id != '-1') {
                $indi->child_family_links[] = $famlink;
                if(isset($form['rp_father_id']) && !empty($form['rp_father_id'])) {
                    $indi->parental = new RP_Family_Record();
                    $indi->parental->id = $famlink->family_id;
                    $indi->parental->husband = $form['rp_father_id'];
                } else if(isset($form['rp_mother_id']) && !empty($form['rp_mother_id'])) {
                    $indi->parental = new RP_Family_Record();
                    $indi->parental->id = $famlink->family_id;
                    $indi->parental->wife = $form['rp_mother_id'];
                }
            } else {
                $indi->parental = new RP_Family_Record();
                $indi->parental->id = '-1';
                $indi->parental->husband = $form['rp_father_id'];
                $indi->parental->wife = $form['rp_mother_id'];
            }
            $is_update = true;
        }

        for($i=0; $i < $cnt; $i++) {
            if(strpos($fields[$i],'rp_fams') === false ) continue;
            $sfx = strrpos($fields[$i],'_');
            $sfx = substr($fields[$i],$sfx+1);

            if (isset($form['rp_fams_' . $sfx]) && !empty($form['rp_fams_' . $sfx])) {
                $famlink = new RP_Family_Link();
                $famlink->family_id = trim(esc_attr($form['rp_fams_' . $sfx]));
                if($famlink->family_id == '-1') $famlink->family_id = null;
                $famlink->spouse_id = $form['rp_sid_' . $sfx];
                $famlink->spouse_seq = $form['rp_sseq_' . $sfx];
                if($famlink->spouse_seq == null) $famlink->spouse_seq  = ($indi->gender=='F'?'1':'2');
                $indi->spouse_family_links[] = $famlink;
                $is_update = true;
            }
        }

        if (isset($form['rp_child_0']) && !empty($form['rp_child_0'])) {
            $indi->offspring_id = trim(esc_attr($form['rp_child_0']));
            $indi->sseq = trim(esc_attr($form['rp_sseq_0']));
            $is_update = true;
        }
        }
        return ( isset($options['errors']) ? array(false, $options) : array($indi, $options) );
    }
    /**
     *
     * @param string $type
     * @param array $options
     * @param string $msg
     */
    private function set_error($type, $options, $msg) {
        if (!isset($options['errors'])) {
            $options['errors'] = array();
        }
        $options['errors'][$type] = $msg;
        return $options;
    }
    
    private function my_array_val_search($needle, $haystack) {
        $retCode = false;
            foreach( $haystack as $key => $val ) { 
                if ($val === $needle) {
                    $retCode = $key;
                }
            }
            return $retCode;
    }
}