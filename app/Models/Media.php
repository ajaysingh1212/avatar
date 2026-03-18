<?php

namespace App\Models;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;

class Media extends BaseModel
{

protected $table = 'media';

protected $fillable = [

'model_type',
'model_id',
'uuid',
'collection_name',
'name',
'file_name',
'mime_type',
'disk',
'size'

];

public function model()
{
return $this->morphTo(null,'model_type','model_id');
}
}
