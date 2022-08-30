<?php

namespace App\Exports;

use App\Models\Mahasiswa;
// use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromView;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class RankExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
  
        public function view(): View
        {
            $mahasiswas = Mahasiswa::where('user_id', Auth::id())->orderBy('id', 'ASC')->get();
        if (count($mahasiswas) < 1) {
            return view('error.oops', ['msg' => 'Please add mahasiswa']);
        }


        $arrRangking = [];
        $arrTemp = [];
        $totalTemp = 0;
        foreach ($mahasiswas as $key => $value) {
            $totalTemp = 0;
            foreach ($value->alternativeData as $key => $item) {
                if (count($value->alternativeData) < 1) {
                    $totalTemp = 0;
                } else {

                    $totalTemp += ((float) $item->subcategory->final_score * (float)$item->subcategory->category->final_score);
                }
            }
            array_push($arrRangking, ['mahasiswa' => $value, 'total_score' => $totalTemp]);
            array_push($arrTemp, $totalTemp);
        }
        $arrSortedTemp = $arrTemp;
        sort($arrSortedTemp);
        $arrSortedTemp = array_reverse($arrSortedTemp);
      
        $arrRanknull = [];
        
        foreach ($arrRangking as $key => $value) {
            if ($arrRangking[$key]['total_score'] == 0) {
                array_push($arrRanknull, $arrRangking[$key]);
            }
        }

        $arrRankingFilter = [];
        foreach ($arrSortedTemp as $key => $value) {


            $key2 = array_search($value, $arrTemp);

            $arrRankingFilter[$key] = $arrRangking[$key2];
            unset($arrTemp[$key2]);
            unset($arrRangking[$key2]);
         
        }


        foreach ($arrRankingFilter as $key => $value) {
            if ($arrRankingFilter[$key]['total_score'] == 0) {
                unset($arrRankingFilter[$key]);
            }
        }

        array_push($arrRankingFilter, ...$arrRanknull);
        $result = [];
        foreach ($arrRankingFilter as $key => $value) {
            array_push($result,$value);
        }

            return view('export.rangking_mhs', [
                'result' => $result
            ]);
        }
    
}
