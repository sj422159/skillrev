<?php
namespace App\Imports;

use App\Models\Distance;
use Maatwebsite\Excel\Concerns\ToModel;

class DistanceImport implements ToModel
{
    protected $aid;
    protected $controller_id;
    protected $busrouteid;

    public function __construct($aid, $controller_id, $busrouteid)
    {
        $this->aid = $aid;
        $this->controller_id = $controller_id;
        $this->busrouteid = $busrouteid;
    }

    public function model(array $row)
    {
        // Ensure aid and controller_id are available
        $aid = $this->aid;
        $controller_id = $this->controller_id;

        // If controller_id is not available, set it to 0
        if (empty($controller_id)) {
            $controller_id = 0;
        }

        // If the required data is available in the row, return the model instance
        if (isset($row[0]) && isset($row[1])) {
            return new Distance([
                'aid' => $aid,  // Use the aid passed from the constructor
                'Controller_ID' => $controller_id,  // Use the controller_id passed from the constructor (or 0 if not available)
                'busrouteid' => $this->busrouteid,
                'location' => (string) $row[0],
                'distance' => (string) $row[1],
                'disstatus' => 1,
            ]);
        }
    }
}
