<?php 	
class ModelFaqDocument extends Model {

    public function getDocuments() {

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "faq_description a LEFT JOIN " . DB_PREFIX . "faq b ON a.faq_id = b.faq_id ORDER BY b.sort_order  ASC");

        return $query->rows;
    }

	public function getDocumentById($document_id) {

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "faq_description WHERE faq_id = ".(int)$document_id);


		return $query->rows;
	}
	
}
