<?php

namespace App\Exports;

use App\Models\StudentByAgent;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class LeadExport implements FromQuery, WithHeadings, WithChunkReading, ShouldAutoSize
{
    protected $query;

    public function __construct($query)
    {
        $this->query = $query;
    }

    public function query()
    {
        return $this->query;
    }

    public function headings(): array
    {
        $tableColumns = Schema::getColumnListing(
            (new StudentByAgent())->getTable()
        );

        return array_map(function ($column) {

            return ucwords(str_replace('_', ' ', $column));

        }, $tableColumns);
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}