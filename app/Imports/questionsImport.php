<?php

namespace App\Imports;

use App\Models\questionbank;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class questionsImport implements ToModel, WithStartRow
{
    protected $skill_attr;
    protected $aid;
    protected $Controller_id;
    protected $Controller_admin_id;

    /**
     * Constructor to initialize the variables.
     * 
     * @param mixed $skill_attr
     * @param mixed $aid
     * @param mixed $Controller_id
     * @param mixed $Controller_admin_id
     */
    public function __construct($skill_attr, $aid, $Controller_id = 0, $Controller_admin_id = 0)
    {
        $this->skill_attr = $skill_attr;
        $this->aid = $aid;
        $this->Controller_id = $Controller_id ?: 0; // Default to 0 if Controller_id is not set
        $this->Controller_admin_id = $Controller_admin_id ?: 0; // Default to 0 if Controller_admin_id is not set
    }
    
    /**
     * Return the starting row for the import.
     * 
     * @return int
     */
    public function startRow(): int
    {
        return 2;
    }

    /**
     * Map the row data to the questionbank model.
     * 
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Debugging the passed data
        // dd($this->Controller_id, $this->Controller_admin_id);  // Check values of Controller_ID and Controller_ADMIN_ID
        
        return new questionbank([
            'aid' => $this->aid,
            'Controller_ID' => $this->Controller_id,  // Ensure Controller_ID is set
            'Controller_ADMIN_ID' => $this->Controller_admin_id,  // Ensure Controller_ADMIN_ID is set
            'skillattribute' => $this->skill_attr,
            'qtype' => (string) $row[0],
            'qtext' => (string) $row[1],
            'choice1' => (string) $row[2],
            'choice2' => (string) $row[3],
            'choice3' => (string) $row[4],
            'choice4' => (string) $row[5],
            'RightChoices' => (string) $row[6],
            'difficultylevel' => (string) $row[7],
        ]);
    }
    

}
