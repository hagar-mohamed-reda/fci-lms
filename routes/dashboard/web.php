<?php


Route::group(['prefix' => LaravelLocalization::setLocale(),'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]],
    function() {
        Route::prefix('dashboard')->name('dashboard.')->middleware(['auth'])->group(function(){

            Route::get('/index', 'WelcomeController@index')->name('index');

            //doctor routes
            Route::resource('doctors', 'DoctorController')->except(['show']);
            Route::get('doctors/export', 'DoctorController@export')->name('doctors.export');
            Route::post('doctors/import', 'DoctorController@import')->name('doctors.import');
            Route::post('doctors/data', 'DoctorController@getDocData')->name('doctors.data');

            Route::resource('doctor_courses', 'DoctorCourseController')->except(['show']);
            //Route::resource('complains', 'ComplainController')->except(['show']);

            // problem routes
            Route::resource('complains', 'dashboard\ComplainController')->except(['show']);
            Route::post("complain/store", "dashboard\ComplainController@store");

            Route::get("complains/student-problem", "ComplainController@student");
            Route::get("complains/doctor-problem", "ComplainController@doctor");
            Route::get("student-problem/data", "ComplainController@getDataStudent");
            Route::get("doctor-problem/data", "ComplainController@getDataDoctor");
            Route::post("update/{problem}", "ComplainController@update");

            //department and level routes
            Route::resource('departments', 'DepartmentController')->except(['show']);
            Route::resource('levels', 'LevelController')->except(['show']);

             // option routes
            Route::get("option/", "SettingController@index")->name('option.index');
            Route::get("option/update", "SettingController@update");
            Route::post("option/update", "SettingController@update");
            Route::post("translation/update", "SettingController@updateTranslation")->name('translation.update.post');
            Route::get("translation/update", "SettingController@updateTranslation")->name('translation.update.get');

            //student routes
            Route::resource('students', 'StudentController')->except(['show']);
            Route::resource('students.ordersRegist', 'Student\OrderRegistController')->except(['show']);
            Route::get('students/export', 'StudentController@export')->name('students.export');
            Route::get('students/datatable', 'StudentController@getData')->name('students.studentDatatable');
            Route::get('importExportView', 'StudentController@importExportView');
            Route::post('students/import', 'StudentController@import')->name('students.import');

            //user routes
            Route::resource('subjects', 'SubjectController')->except(['show']);
            Route::get('subjects/editdoc', 'SubjectController@editdoc')->name('subjects.editdoc');
            Route::post('subjects/updatedoc/{sbj_id}', 'SubjectController@updatedoc');
            Route::get('subjects/export', 'SubjectController@export')->name('subjects.export');
            Route::get('importExportView', 'SubjectController@importExportView');
            Route::post('subjects/import', 'SubjectController@import')->name('subjects.import');

            //lesson routes
            Route::resource('lessons', 'LessonController')->except(['show']);
            Route::get('lessons/index', 'LessonController@index');
            Route::get('lessons/files/create', 'LessonController@fileCreate');
            //Route::post('lessons/files', 'LessonController@fileStore');

            Route::get('lessons/pdffiles/{id}', 'LessonController@show_pdf');
            Route::get('lessons/pptxfiles/{id}', 'LessonController@show_pptx');

            Route::get('lessons/pdffile/download/{pdf_file}', 'LessonController@download_pdf');
            Route::get('lessons/pptxfile/download/{pptx_file}', 'LessonController@download_pptx');


            //lesson routes
            Route::resource('assignments', 'AssignmentController')->except(['show']);
            Route::get('assignments/pdffiles/{id}', 'AssignmentController@show_pdf');
            Route::get('assignments/pdffile/download/{pdf_file}', 'AssignmentController@download_pdf');

            //student_assignment routes
            Route::resource('student_assignments', 'StudentAssignmentController')->except(['show']);
            Route::get('student_assignments/pdffiles/{id}', 'StudentAssignmentController@show_pdf');
            Route::get('student_assignments/pdffile/download/{pdf_file}', 'StudentAssignmentController@download_pdf');
            Route::get('student_assignments/report', 'StudentAssignmentController@getReport')->name('student_assignments.getReport');

            //student with subject routes
            Route::resource('student_subjects', 'StudentSubjectController')->except(['show']);
            Route::get('student_subjects/data', 'StudentSubjectController@getData')->name('studentRegisterDatatable');
            Route::get('student_subjects/export', 'StudentSubjectController@export')->name('student_subjects.export');
            Route::get('importExportView', 'StudentSubjectController@importExportView');
            Route::post('student_subjects/import', 'StudentSubjectController@import')->name('student_subjects.import');
            /*Route::get('subjects/show-pdf/{id}', function($id) {
                $file = Subject::find($id);
                return response()->file(storage_path($file->path));
            })->name('subjects.show-pdf');*/

            //admin routes
            Route::resource('admins', 'AdminController')->except(['show']);


            //user routes
            Route::resource('users', 'UserController')->except(['show']);


            // register doctor to course
            Route::get('course/assign/{course}', 'SubjectController@assign')->name('assignDoctorToCourseView');
            Route::post('course/assign/{course}', 'SubjectController@performAssign')->name('assignDoctorToCourse');

            // register student to course
            Route::get('course/students', 'StudentSubjectController@getStudents')->name('courseStudentData');
            Route::post('course/student-assign', 'StudentSubjectController@performAssign')->name('assignStudentToCourse');



        });//end the dashboard routes


    });

       //profile updates
       Route::post('profile/changname/{id}', 'UserController@changeName');
       Route::post('profile/changpass/{id}', 'UserController@changePass');
       Route::post('profile/changemail/{id}', 'UserController@changeEmail');
       Route::post('profile/chactcode/{id}', 'UserController@chactcode');
       Route::post('profile/changphone/{id}', 'UserController@changePhone');
       Route::post('std/changeActive/{id}', 'StudentController@changeActive');
       Route::post('stdAssign/addGrade/{id}', 'StudentAssignmentController@addGrade');
       Route::get('subjects/get_by_doctor', 'LessonController@get_by_doctor')->name('subjects.get_by_doctor');
       Route::get('lessons/get_by_subject', 'AssignmentController@get_by_subject')->name('lessons.get_by_subject');
       Route::get('assigns/get_by_lesson', 'StudentAssignmentController@get_by_lesson')->name('assigns.get_by_lesson');
       Route::get('departs/get_by_level', 'StudentController@get_by_level')->name('departs.get_by_level');





