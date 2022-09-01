<?php

namespace App\Http\Controllers;

use App\Exports\RankExport;
use App\Http\Requests\MahasiswaAdd;
use App\Http\Requests\MahasiswaChoose;
use App\Http\Requests\MahasiswaEdit;
use App\Models\AlternativeData;
use App\Models\Category;
use App\Models\Mahasiswa;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
class AlternativeDataController extends Controller
{
    public function addMahasiswaV()
    {
        return view('user.data.mahasiswa_add');
    }
    public function addMahasiswa(MahasiswaAdd $request)
    {
        $validated = $request->validated();

        Mahasiswa::create([
            'name' => $validated['mahasiswa_name'],
            'nim' => $validated['mahasiswa_nim'],
            'user_id' => Auth::id()
        ]);

        return redirect()->back()->with('success', 'Successfully Add Mahasisswa');
    }
    public function listMahasiswaV()
    {
        $mahasiswas = Mahasiswa::where('user_id', Auth::id())->get();
        return view('user.data.mahasiswa_list', ['mahasiswas' => $mahasiswas]);
    }
    public function editMahasiswaV(Request $request)
    {
        if ($request->get('mahasiswa_id')) {

            $mahasiswa = Mahasiswa::where([['user_id', '=', Auth::id()], ['id', '=', $request->get('mahasiswa_id')]])->get()->first();
            return view('user.data.mahasiswa_edit', ['mahasiswa' => $mahasiswa]);
        }
    }
    public function editMahasiswa(MahasiswaEdit $request)
    {
        $validated = $request->validated();

        Mahasiswa::where([['user_id', '=', Auth::id()], ['id', '=', $request->post('mahasiswa_id')]])->update(['name' => $validated['mahasiswa_name'], 'nim' => $validated['mahasiswa_nim']]);

        return redirect()->to('/mahasiswa')->with('success', 'Successfully Edit Mahasiswa');
    }

    public function deleteMahasiswa(Request $request)
    {

        if ($request->post('mahasiswa_id')) {
            AlternativeData::where('mahasiswa_id',$request->post('mahasiswa_id'))->delete();
            Mahasiswa::where('id', '=', $request->post('mahasiswa_id'))->delete();
        }

        return redirect()->back()->with('success', 'Successfully Delete Mahasiswa');
    }
    public function doChooseV($id)
    {
        $categories =  Category::get();
        if (count($categories) < 2) {
            return view('error.oops', ['msg' => 'Please Add Category Before !  at least make 2 category']);
        }
        $arrFilterCategory = [];
        foreach ($categories as $key => $value) {
            if (count($value->subcategory) >= 2) {
                array_push($arrFilterCategory, $value);
            }
        }

        if (count($arrFilterCategory)  == 0) {
            return view('error.oops', ['msg' => 'Please Add SubCategory Before ! at least make 2 subcategory even category']);
        }

        foreach ($arrFilterCategory as $value) {
            if (count($value->categoryMA) < 2) {
              $key = array_search($value, $arrFilterCategory);
                    unset($arrFilterCategory[$key]);
                
            }
        }

        if (count($arrFilterCategory)  == 0) {
            return view('error.oops', ['msg' => 'Please compare category before']);
        }

        foreach ($arrFilterCategory as $value) {
            $subc = SubCategory::where([['category_id', '=', $value->id], ['is_compare', '=', '1']])->get();
          
            if (count($subc) < 2) {
                $key = array_search($value, $arrFilterCategory);
                unset($arrFilterCategory[$key]);
            }
        }
       
        if (count($arrFilterCategory)  == 0) {
            return view('error.oops', ['msg' => 'Please compare subcategory before']);
        }

        return view('user.data.mahasiswa_choose', ['mahasiswa' => Mahasiswa::where('id', $id)->first(), 'categories' => $arrFilterCategory]);
    }

    public function doChoose(MahasiswaChoose $request)
    {
        AlternativeData::where('mahasiswa_id', $request->post('mahasiswa_id'))->delete();
        foreach ($request->post() as $key => $value) {
            if (preg_match("/category_id_[0-9]/", $key)) {

                AlternativeData::create(['subcategory_id' => $value, 'mahasiswa_id' => $request->post('mahasiswa_id')]);
            }
        }

        return redirect()->to('/alternative-data')->with('success', 'Successfully Choose Criteria');
    }

    public function alternativeDataV()
    {
        $mahasiswas = Mahasiswa::where('user_id', Auth::id())->orderBy('id', 'ASC')->get();
        if (count($mahasiswas) < 1) {
            return view('error.oops', ['msg' => 'Please add mahasiswa']);
        }
        return view('user.data.alternative_data', ['mahasiswas' => $mahasiswas]);
    }
    public function rankingMahasiswaV()
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
       
        return view('user.data.mahasiswa_ranking', ['result' => $result]);
    }
    public function deleteChoose(Request $request)
    {

        if ($request->post('alternative_id')) {
            AlternativeData::where('id', $request->post('alternative_id'))->delete();
        }


        return redirect()->back()->with('success', 'Successfully delete data');
    }

    public function exportMahasiswaRank(){
        
        return Excel::download(new RankExport, 'invoices.xlsx');
    }

    public function toPdfMahasiswaRank(){
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


        $pdf = PDF::loadview('export.rangking_mhs_pdf',['result' => $result]);
       return $pdf->download('rank_mhs.pdf');
    }
}
