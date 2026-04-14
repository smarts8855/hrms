<?php

namespace App\Exports;

use App\Models\TblmarketSurvey;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use DB;
use \Excel;


class ExportTblmarketSurvey implements FromCollection, WithHeadings, ShouldAutoSize
{

    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct()
    {
    
    }

    public function collection()
    {
            
            return    \DB::table('tblmarket_survey')->select('marketId','item',  'category', 'specification', 'price', 'marketPrice', 'survey_date',)
            ->orderby('marketID', 'asc')
            ->leftJoin('tblitems', 'tblitems.itemID', '=', 'tblmarket_survey.items')
            ->leftJoin('tblcategories', 'tblcategories.categoryID', '=', 'tblmarket_survey.categoryID')
            ->leftJoin('tblspecifications', 'tblspecifications.specificationID', '=', 'tblmarket_survey.specificationID')
            ->where('tblmarket_survey.status', 1)
            ->get();

    }


    public function headings(): array
    {
        return [
            'S/No', 
            'ITEM NAME',
            'CATEGORY',
            'SPECIFICATION',
            'CONTRACT PRICE',
            'MARKET PRICE',
            'SURVEY DATE'
        ];
    }
}
