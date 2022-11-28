<?php
namespace App\Exports;

use App\Models\DeletedUser;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class DeletedExport implements FromCollection, WithHeadings, ShouldAutoSize, WithMapping
{
    use Exportable;

    /**
     * @return \Illuminate\Support\Collection
     */
    // Fetch deleted users data 
    public function collection()
    {
        $deleted = DeletedUser::get();
        return $deleted;
    }

    public function map($deleted): array
    {
        return [
            $deleted->name,
            $deleted->reason,
            Date('y/m/d', $deleted->created_at),
        ];
    }
   
    public function headings(): array
    {
        return [
            'Name', 'Reason to deleted', 'Deleted at',
        ];
    }
}
