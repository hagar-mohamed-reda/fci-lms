<?php

namespace App\Imports;

use App\StudentSubject;
use Maatwebsite\Excel\Concerns\ToModel;

class StdSbjImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new StudentSubject([
            'student_id' => $row[0],
            'subject_id' => $row[1]
        ]);
    }
}
