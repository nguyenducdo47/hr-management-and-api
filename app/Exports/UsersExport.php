<?php

namespace App\Exports;

use App\Models\User; // Đảm bảo bạn import model User
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class UsersExport implements FromCollection, WithHeadings, WithColumnWidths
{

    protected $data;
    public function collection()
    {
        $users = User::all(['name', 'email', 'birthday', 'role_id']);

        $users->transform(function ($user) {
            $user->role_id = $this->getRoleName($user->role_id);
            return $user;
        });

        return $users;
    }


    private function getRoleName($roleId)
    {
        switch ($roleId) {
            case 1:
                return 'Admin';
            case 2:
                return 'Employee';
            case 3:
                return 'Team Lead';
            default:
                return 'Unknown';
        }
    }

    public function headings(): array
    {
        return ['Tên', 'Email', 'Ngày sinh', 'Vai trò'];
    }

    public function columnWidths(): array
    {
        $widths = [
            'A' => 0,
            'B' => 0,
            'C' => 0,
            'D' => 0,
        ];

        $users = User::all(['name', 'email', 'birthday', 'role_id']);
        foreach ($users as $user) {
            $widths['A'] = max($widths['A'], strlen($user->name));
            $widths['B'] = max($widths['B'], strlen($user->email));
            $widths['C'] = max($widths['C'], strlen($user->birthday));
            $widths['D'] = max($widths['D'], strlen($this->getRoleName($user->role_id)));
        }

        $widths['A'] = max($widths['A'], strlen('Tên'));
        $widths['B'] = max($widths['B'], strlen('Email'));
        $widths['C'] = max($widths['C'], strlen('Ngày sinh'));
        $widths['D'] = max($widths['D'], strlen('Vai trò'));

        return [
            'A' => $widths['A'] + 2,
            'B' => $widths['B'] + 2,
            'C' => $widths['C'] + 2,
            'D' => $widths['D'] + 2,
        ];
    }

    public function array(): array
    {
        // Thêm BOM cho UTF-8
        return array_merge([["\xEF\xBB\xBF"]], $this->data);
    }
}
