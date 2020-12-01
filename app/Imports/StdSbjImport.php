<?php

namespace App\Imports;

use App\Student;
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
        $std = Student::where("code", $row[0])->first();

        $countOfAssign = StudentSubject::where("course_id", $row[1])->where("student_id", $std['id'])->count();

        /*$assign = StudentSubject::create([
            'student_id' => $std['id'],
            'course_id' => $row[1]
        ]);
        return $assign;*/

        if ($countOfAssign > 0) {
            return null;
        } else {
            $assign = StudentSubject::create([
                "student_id" => $std['id'],
                "course_id" => $row[1],
            ]);
            return $assign;
        }

        /*return new StudentSubject([
            'student_id' => $row[0],
            'subject_id' => $row[1]
        ]);*/
    }
}
