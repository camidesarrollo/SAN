<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;


class DocPaf extends Model{
	protected $table = 'ai_doc_paf';
	
	protected $primaryKey = 'doc_paf_id';
	
	public $timestamps = false;
	
	protected $fillable = [
		'cas_id',
		'doc_paf_arch',
		'doc_fec'
	];
		
}
