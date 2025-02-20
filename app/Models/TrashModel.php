<?php

namespace App\Models;

use CodeIgniter\Model;

class TrashModel extends Model
{
<<<<<<< HEAD
    protected $table            = 'trash_items';
=======
    protected $table            = 'trash_conversion';
>>>>>>> b140ca20ddbc9208c64652211f5f12519af1be6e
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
<<<<<<< HEAD
    protected $allowedFields    = ['trashName', 'trashType', 'trashPicture', 'points'];
=======
    protected $allowedFields    = ['trash_weight', 'points', 'rice_kilos', 'created_at'];
>>>>>>> b140ca20ddbc9208c64652211f5f12519af1be6e

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
