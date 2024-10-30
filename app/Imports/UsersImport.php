<?php
namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\WithStartRow;

class UsersImport implements ToModel, WithStartRow
{
    public function startRow(): int
    {
        return 2;
    }
    public function model(array $row)
    {
        if (empty($row[0])) {
            return null;
        }

        $birthday = null;

        if (isset($row[2]) && is_numeric($row[2])) {
            try {
                $dateValue = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[2]);
                if ($dateValue) {
                    $birthday = $dateValue->format('Y-m-d');
                }
            } catch (\Exception $e) {
                return null;
            }
        } elseif (isset($row[2]) && !empty($row[2])) {
            try {
                $birthday = Carbon::createFromFormat('d/m/Y', trim($row[2]))->format('Y-m-d');
            } catch (\Exception $e) {
                return null;
            }
        }

        if (!$birthday) {
            return null;
        }

        return new User([
            'name'     => trim($row[0]),
            'email'    => trim($row[1]),
            'birthday' => $birthday,
            'password' => Hash::make(trim($row[3])),
            'role_id'  => intval($row[4]),
        ]);
    }
}
