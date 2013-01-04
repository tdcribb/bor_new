<?php
/**
 * class RP_that operate on table 'rp_source_note'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2011-04-07 19:07
 */
class RP_Source_Note_Mysql_Dao extends Rp_Mysql_DAO {
		/**
	 * @todo Description of function loadList
	 * @param  $sourceId
	 * @param  $sourceBatchId
	 * @return
	 */
	public function load_list( $source_id, $source_batch_id ) {
		$sql = 'SELECT * FROM rp_source_note WHERE source_id = ? AND source_batch_id = ?';
		$sql_query = new RP_Sql_Query( $sql, $this->prefix );
		$sql_query->set( $source_id );
		$sql_query->set_number( $source_batch_id );
		return $this->get_row( $sql_query );
	}


	/**
	 * @todo Description of function deleteBySrc
	 * @param  $sourceId
	 * @param  $sourceBatchId
	 * @return
	 */
	public function delete_by_src( $source_id, $source_batch_id ) {
		$sql = 'DELETE FROM rp_source_note WHERE source_id = ? AND source_batch_id = ?';
		$sql_query = new RP_Sql_Query( $sql, $this->prefix );
		$sql_query->set( $source_id );
		$sql_query->set_number( $source_batch_id );
		return $this->execute_update( $sql_query );
	}
    /**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @return RpSourceNoteMySql
	 */
	public function load( $id ) {
		$sql = 'SELECT * FROM rp_source_note WHERE id = ?';
		$sql_query = new RP_Sql_Query( $sql, $this->prefix );
		$sql_query->set_number( $id );
		return $this->get_row( $sql_query );
	}

	/**
	 * Delete record FROM table
	 * @param rpSourceNote primary key
	 */
	public function delete( $id ) {
		$sql = 'DELETE FROM rp_source_note WHERE id = ?';
		$sql_query = new RP_Sql_Query( $sql, $this->prefix );
		$sql_query->set_number( $id );
		return $this->execute_update( $sql_query );
	}
	/**
	 * Insert record to table
	 *
	 * @param RpSourceNoteMySql rpSourceNote
	 */
	public function insert( $rp_source_note ) {
		$sql = 'INSERT INTO rp_source_note (source_id, source_batch_id, note_rec_id, note, update_datetime) VALUES (?, ?, ?, ?, now())';
		$sql_query = new RP_Sql_Query( $sql, $this->prefix );
		$sql_query->set( $rp_source_note->source_id );
		$sql_query->set_number( $rp_source_note->source_batch_id );
        $sql_query->set( $rp_source_note->note_rec_id );
		$sql_query->set(  ( $rp_source_note->note ) );
		$id = $this->execute_insert( $sql_query );
		$rp_source_note->id = $id;return $id;
	}
	/**
	 * Update record in table
	 *
	 * @param RpSourceNoteMySql rpSourceNote
	 */
	public function update( $rp_source_note ) {
		$sql = 'UPDATE rp_source_note SET source_id = ?, source_batch_id = ?, note_rec_id = ?, note = ?, update_datetime = now() WHERE id = ?';
		$sql_query = new RP_Sql_Query( $sql, $this->prefix );
		$sql_query->set( $rp_source_note->source_id );
		$sql_query->set_number( $rp_source_note->source_batch_id );
        $sql_query->set( $rp_indi_note->note_rec_id );
		$sql_query->set(  ( $rp_indi_note->note ) );
		$sql_query->set_number( $rp_source_note->id );
		return $this->execute_update( $sql_query );
	}

    public function query_by_src( $src_id, $src_batch_id ) {
		$sql = 'SELECT *'
            . ' FROM rp_source_note'
            . ' WHERE source_id = ? and source_batch_id = ?';
		$sql_query = new RP_Sql_Query( $sql, $this->prefix );
		$sql_query->set( $src_id );
		$sql_query->set_number( $src_batch_id );
		$notes =  $this->get_list( $sql_query );
        if( isset( $notes ) && count($notes) > 0 ) {
            foreach( $notes as $note ) {
                if ( ( !isset( $note->note ) || empty( $note->note ))
                        && isset ( $note->note_rec_id ) ) {
                    $rec = RP_Dao_Factory::get_rp_note_dao( $this->prefix )
                            ->load($note->note_rec_id);
                    $note->note = $rec->submitter_text;
                }
            }
        }
        return $notes;
	}
	/**
	 * Read row
	 *
	 * @return RpSourceNoteMySql
	 */
	protected function read_row( $row ) {
		$rp_source_note = new RP_Source_Note();
		$rp_source_note->id = $row['id'];
		$rp_source_note->source_id = $row['source_id'];
		$rp_source_note->source_batch_id = $row['source_batch_id'];
		$rp_source_note->note_rec_id = $row['note_rec_id'];
		$rp_source_note->note = ( $row['note'] );
		return $rp_source_note;
	}

}
?>
