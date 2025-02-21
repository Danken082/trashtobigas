<?php

namespace App\Models;

use CodeIgniter\Model;

class ClientModel extends Model
{
    protected $table            = 'registrationdb';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['firstName', 'lastName', 'address', 'email', 'contactNo', 'gender', 'qrcode', 'totalPoints', 'birthdate', 'idNumber'];

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
    protected $beforeInsert   = ['addUUID'];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];



    protected function addUUID(array $data)
    {
        if(!isset($data['data']['uuid']))
        {
            $data['data']['uuid'] = $this->generateUUIDv4();
        }

        return $data;
    }

    private function generateUUIDv4()
    {// Generate 16 random bytes
        $data = random_bytes(16);
        // Set version to 0100
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        // Set bits 6-7 to 10
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
        // Format the bytes into a UUID string
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));   
    }

    public function generateId()
    {
        // Get the last inserted user
        $lastUser = $this->orderBy('id', 'DESC')->first();
        
        // Extract the last idNumber and increment
        if ($lastUser && isset($lastUser['idNumber'])) {
            $lastIdNumber = intval($lastUser['idNumber']);
            $newIdNumber = str_pad($lastIdNumber + 1, 5, '0', STR_PAD_LEFT);
        } else {
            $newIdNumber = '00001';
        }
        
        return $newIdNumber;
    }
}
