<?php

namespace App\Livewire;

use App\Models\Safe;
use Illuminate\Support\Facades\Artisan;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Title;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class Settings extends Component
{
    use LivewireAlert;

    public $initial_balance = 0;
    public $date = '';

    public function mount()
    {
        if ($this->date == '') {
            $this->date = date('Y-m-d');
        }
        $safe = Safe::first();
        if ($safe == null) {
            Safe::create([
                'initial_balance' => 0,
                'date' => $this->date
            ]);
        } else {
            $this->initial_balance = number_format(round($safe->initial_balance));
            $this->date = $safe->date;
        }
    }

    public function editSafe()
    {
        Safe::first()->update([
            'initial_balance' => round($this->initial_balance, 2),
            'date' => $this->date
        ]);
        $this->alert('success', 'تم الحفظ بنجاح', ['timerProgressBar' => true]);
        $this->dispatch('update-balance');
    }

    public function dbBackup()
    {
        Artisan::call("backup:run  --only-db");
        $this->alert('success', 'تم النسخ الإحتياطي بنجاح', ['timerProgressBar' => true]);
    }

    public function getFromExcel()
    {
        Artisan::call("migrate:fresh --seed");
        $filePath = public_path('center.xlsx');

        $excelSpreadSheetData = Excel::toCollection(null, $filePath);
        // 15 النوع
        // 16 رقم المدرب
        // 17 اسم المدرب
        //19 رقم البرنامج
        //20 اسم البرنامج
        // 23 نوع البرنامج
        \App\Models\Trainer::where("id", "!=", 0)->delete();
        for ($i = 1; $i <= 19; $i++) {
            $row = $excelSpreadSheetData[0][$i];
            \App\Models\Trainer::create([
                'id' => $row['16'],
                'arabic_name' => $row['17'],
                'gender' => $row['15'],
                'user_id' => auth()->id(),
            ]);
        }

        \App\Models\Course::where("id", "!=", 0)->delete();
        for ($i = 1; $i <= 34; $i++) {
            $row = $excelSpreadSheetData[0][$i];
            \App\Models\Course::create([
                'id' => $row['19'],
                'arabic_name' => $row['20'],
                'type' => $row['23'],
                'user_id' => auth()->id(),
            ]);
        }

        // 9 رقم المدرب
        //10 رقم البرنامج
        \App\Models\Batch::where("id", "!=", 0)->delete();
        for ($i = 1; $i <= 1191; $i++) {
            $row = $excelSpreadSheetData[0][$i];

            $excelDate = $row[0];
            if (!is_numeric($excelDate)) {
                dd($row);
            }

            $unixTimestamp = ($excelDate - 25569) * 86400; // تحويل إلى الطابع الزمني
            $date = date('Y-m-d', $unixTimestamp);

            $count = \App\Models\Batch::where('id', $row[11])->count();
            if ($count == 0) {
                \App\Models\Batch::create([
                    'id' => $row[11],
                    'trainer_id' => $row[9],
                    'course_id' => $row[10],
                    'start_date' => $date,
                    'end_date' => $date,
                    'completed' => true,
                    'user_id' => auth()->id(),
                ]);
            }
        }
        $id = 1;
        \App\Models\Student::where("id", "!=", 0)->delete();
        for ($i = 1; $i <= 1191; $i++) {
            $row = $excelSpreadSheetData[0][$i];

            $excelDate = $row[0];

            $unixTimestamp = ($excelDate - 25569) * 86400; // تحويل إلى الطابع الزمني
            $date = date('Y-m-d', $unixTimestamp);

            $count = \App\Models\Student::where('arabic_name', $row[3])->count();
            if ($count == 0) {
                \App\Models\Student::create([
                    'id' => $id,
                    'arabic_name' => $row[3],
                    'phone' => $row[4],
                    'user_id' => auth()->id(),
                ]);
                $id++;
            }
        }

        $id = 1;
        \App\Models\BatchStudent::where("id", "!=", 0)->delete();
        for ($i = 1; $i <= 1191; $i++) {
            $row = $excelSpreadSheetData[0][$i];

            $excelDate = $row[0];

            $unixTimestamp = ($excelDate - 25569) * 86400; // تحويل إلى الطابع الزمني
            $date = date('Y-m-d', $unixTimestamp);

            $student = \App\Models\Student::where('arabic_name', $row[3])->first();

            if ($student) {
                \App\Models\BatchStudent::create([
                    'id' => $id,
                    'student_number' => $row[1],
                    'student_id' => $student->id,
                    'batch_id' => $row[11],
                    'want_certification' => $row[2] != null ? true : false,
                    'certification_id' => $row[2] != null ? $row[2] : null,
                    'date' => $date,
                    'user_id' => auth()->id(),
                ]);
                $id++;

            } else {
                dd($row);
            }
        }


        $filePath = public_path('expenses.xlsx');

        $excelSpreadSheetData = Excel::toCollection(null, $filePath);

        $row = $excelSpreadSheetData[0][1];

        $excelDate = $row[1];

        $unixTimestamp = ($excelDate - 25569) * 86400;
        $date = date('Y-m-d', $unixTimestamp);

        \App\Models\Bank::create([
            'id' => 1,
            'bank_name' => 'الخرطوم',
            'name' => 'خوله',
            'user_id' => auth()->id(),
            'initial_balance' => 0,
            'date' => $date
        ]);

        $id = 1;
        \App\Models\ExpenseOption::where("id", "!=", 0)->delete();
        for ($i = 1; $i <= 28; $i++) {
            $row = $excelSpreadSheetData[0][$i];

            $excelDate = $row[1];

            $unixTimestamp = ($excelDate - 25569) * 86400; // تحويل إلى الطابع الزمني
            $date = date('Y-m-d', $unixTimestamp);

            $count = \App\Models\ExpenseOption::where('optionName', $row[3])->count();
            if ($count == 0) {
                \App\Models\ExpenseOption::create([
                    'id' => $id,
                    'optionName' => $row[3],
                    'user_id' => auth()->id(),
                ]);
                $id++;
            }
        }

        for ($i = 1; $i <= 28; $i++) {
            $row = $excelSpreadSheetData[0][$i];

            $excelDate = $row[1];

            $unixTimestamp = ($excelDate - 25569) * 86400; // تحويل إلى الطابع الزمني
            $date = date('Y-m-d', $unixTimestamp);

            \App\Models\Expense::create([
                'id' => $row[0],
                'description' => $row[2],
                'quantity' => $row[4],
                'price' => $row[5] / $row[4],
                'date' => $date,
                'payment_method' => "bank",
                'bank_id' => 1,
                'transaction_id' => $row[6],
                'expense_option_id' => $row[8],
                'note' => $row[7],
                'user_id' => auth()->id(),
            ]);
        }

        $this->alert('success', 'تم سحب البيانات بنجاح', ['timerProgressBar' => true]);


//        $excelDate = $excelSpreadSheetData->first()[1][0];
//
//        $unixTimestamp = ($excelDate - 25569) * 86400; // تحويل إلى الطابع الزمني
//        $this->from = date('Y-m-d', $unixTimestamp);
//        dd($this->from);
    }

    #[Title('الإعدادات')]
    public function render()
    {
        if ($this->date == '') {
            $this->date = date('Y-m-d');
        }
        return view('livewire.settings');
    }
}
