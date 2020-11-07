<?php

namespace App\Imports;

use App\Student;
use App\User;
use Maatwebsite\Excel\Concerns\ToModel;

class StudentsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $stds = Student::create([
            'name' => $row[0],
            'username' => $row[1],
            'level_id' => $row[2],
            'department_id' => $row[3],
            'code' => $row[4],
            'email' => $row[5],
            'password' => bcrypt($row[6]),
            'phone' => $row[7],
            'set_number' => $row[8],
            'national_id' => $row[9],
            'active' => $row[10],
            'account_confirm' => $row[11],
            'graduated' => $row[12],
            'can_see_result' => $row[13],
        ]);

        $stds->attachRole('student');
        $stdref = $stds->refresh();

        $stduser = User::create([
            'name' => $row[0],
            'username' => $row[1],
            'email' => $row[5],
            'password' => bcrypt($row[6]),
            'phone' => $row[7],
            'active' => $row[10],
            'account_confirm' => $row[11],
            'type' =>'student',
            'fid' => $stdref->id
        ]);

        $stduser->attachRole('student');


        return $stds;




    }



}
