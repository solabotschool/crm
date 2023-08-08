<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use PDF;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $result = DB::table('invoice')->get();
        $result = json_decode($result);
        return view('home', compact('result'));
    }

    public function invoice(Request $request)
    {

        $temp = $request->all();

        $id = $temp['id'];

        $data = array(
            '見積書日付' => $temp['year1'] . '-' . $temp['month1'] . '-' . $temp['day1'],
            '請求書日付' => $temp['year2'] . '-' . $temp['month2'] . '-' . $temp['day2'],
            '納品書日付' => $temp['year3'] . '-' . $temp['month3'] . '-' . $temp['day3'],
            '報告書日付' => $temp['year4'] . '-' . $temp['month4'] . '-' . $temp['day4'],
            '自社名' => $temp['ComName'],
            '代表姓' => $temp['RepFamily'],
            '代表名' => $temp['RepName'],
            '登録番号' => $temp['RegNumber'],
            '登録番号13' => $temp['RegNumber13'],
            '自社住所' => $temp['ComAddress'],
            '連絡先TEL' => $temp['ComTEL'],
            '連絡先FAX' => $temp['ComFAX'],
            '連絡先EMAIL' => $temp['ComEMAIL'],
            'お客様名' => $temp['VIPName'],
            'お客様住所' => $temp['VIPAddress'],
            'お客様連絡先' => $temp['VIPEmail'],
            '案件名' => $temp['IssueName'],
            '請求月' => $temp['ReqMonth'],
            '支払い予定日' => $temp['year5'] . '-' . $temp['month5'] . '-' . $temp['day5'],
            // '税率A' => $temp['APercent'],
            // '税率B' => $temp['BPercent'],
            '取引詳細項目' => json_encode(
                array(
                    'content' => implode(',', $temp['content']),
                    'cost' => implode(',', $temp['cost']),
                    'count' => implode(',', $temp['count']),
                    'unit' => implode(',', $temp['unit']),
                    // 'amount' => implode(',', $temp['amount']),
                )
            ),
            
            '備考補助金' => $temp['subsidy'],
            '諸項目' => $temp['conditions'],
            'お振込先' => $temp['bankAddress'],
            
            '備考1' => $temp['remark1'],
            '備考2' => $temp['remark2'],
            '備考3' => $temp['remark3'],
            '備考4' => $temp['remark4'],
            
            'status' => $temp['status'],

            'created_by_userid' => Auth::id(),
        );

        if ($id == 0) {

            $result = DB::table('invoice')->insert($data);
            return redirect()->route('home', ['message' => 'created']);
        } else {

            $result = DB::table('invoice')->where('id', $id)->update($data);
            return redirect()->route('home', ['message' => 'updated']);
        }
    }

    public function delInv($id)
    {
        if ($id == 0) return false;
        else {
            DB::table('invoice')->where('id', $id)->delete();
            return true;
        }
    }

    public function addInv($id)
    {
        if ($id == 0) return false;
        else {
            $originalRecord = DB::table('invoice')->where('id', $id)->first();
            $clonedAttributes = (array) $originalRecord;
            unset($clonedAttributes['id']);

            return DB::table('invoice')->insert($clonedAttributes);

        }
    }

    public function getInv($id)
    {
        if ($id == 0) return false;
        else {
            return DB::table('invoice')->where('id', $id)->get();
        }
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        $result = DB::table('invoice')->where('お客様名', 'like', '%'.$keyword.'%')->get();
        return view('home', compact('result','keyword'));
    }

    public function getPDFInfo($id){
        $invoice = DB::table('invoice')->where('id', $id)->get();

        //日付
        $date_str_arr = explode('-', $invoice[0]->見積書日付);

        $year = intval($date_str_arr[0]) + 2018;
        $month = intval($date_str_arr[1]);
        $day = intval($date_str_arr[2]);

        $dateString = $year . '-' . $month . '-' . $day;
        $timestamp = strtotime($dateString);
        $formattedDate1 = date("Y年n月j日", $timestamp);


        $date_str_arr = explode('-', $invoice[0]->請求書日付);

        $year = intval($date_str_arr[0]) + 2018;
        $month = intval($date_str_arr[1]);
        $day = intval($date_str_arr[2]);

        $dateString = $year . '-' . $month . '-' . $day;
        $timestamp = strtotime($dateString);
        $formattedDate2 = date("Y年n月j日", $timestamp);


        $date_str_arr = explode('-', $invoice[0]->納品書日付);

        $year = intval($date_str_arr[0]) + 2018;
        $month = intval($date_str_arr[1]);
        $day = intval($date_str_arr[2]);

        $dateString = $year . '-' . $month . '-' . $day;
        $timestamp = strtotime($dateString);
        $formattedDate3 = date("Y年n月j日", $timestamp);


        $date_str_arr = explode('-', $invoice[0]->報告書日付);

        $year = intval($date_str_arr[0]) + 2018;
        $month = intval($date_str_arr[1]);
        $day = intval($date_str_arr[2]);

        $dateString = $year . '-' . $month . '-' . $day;
        $timestamp = strtotime($dateString);
        $formattedDate4 = date("Y年n月j日", $timestamp);

        //支払い予定日
        $date_str_arr = explode('-', $invoice[0]->支払い予定日);

        $year = intval($date_str_arr[0]) + 2018;
        $month = intval($date_str_arr[1]);
        $day = intval($date_str_arr[2]);

        $dateString = $year . '-' . $month . '-' . $day;
        $timestamp = strtotime($dateString);
        $expectedDate= date("n/j/Y", $timestamp);

        //取引詳細項目
        $deails = json_decode($invoice[0]->取引詳細項目);
        $content = explode(',', $deails->content);
        $cost = explode(',', $deails->cost);
        $count = explode(',', $deails->count);
        $unit = explode(',', $deails->unit);

        $details = [];
        $sumOfDetails = $invoice[0]->備考補助金;

        $tenPercentAmount = 0;
        $eightPercentAmount = 0;

        for ($i = 0; $i < 10; $i++) {
            if ($content[$i] != '' && $cost[$i] != '' && $count[$i] != '' && $unit[$i] != '') {
                array_push(
                    $details,
                    array(
                        'content' => $content[$i],
                        'count' => $count[$i],
                        'unit' => $unit[$i],
                        'amount' => $count[$i] * $unit[$i],
                    )
                );

                $sumOfDetails += $count[$i] * $unit[$i];

                if ($cost[$i] == 0.1) $tenPercentAmount += $count[$i] * $unit[$i] * $cost[$i];
                else $eightPercentAmount += $count[$i] * $unit[$i] * $cost[$i];
            }
        }

        $data = [
            '見積書日付' => $formattedDate1,
            '請求書日付' => $formattedDate2,
            '納品書日付' => $formattedDate3,
            '報告書日付' => $formattedDate4,
            '自社名' => $invoice[0]->自社名,
            '登録番号' => $invoice[0]->登録番号,
            '登録番号13' => $invoice[0]->登録番号13,
            '代表姓' => $invoice[0]->代表姓,
            '代表名' => $invoice[0]->代表名,
            '自社住所' => $invoice[0]->自社住所,
            '連絡先TEL' => $invoice[0]->連絡先TEL,
            '連絡先FAX' => $invoice[0]->連絡先FAX,
            '連絡先EMAIL' => $invoice[0]->連絡先EMAIL,
            'お客様名' => $invoice[0]->お客様名,
            'お客様住所' => $invoice[0]->お客様住所,
            'お客様連絡先' => $invoice[0]->お客様連絡先,
            '案件名' => $invoice[0]->案件名,
            '請求月' => $invoice[0]->請求月,
            '支払い予定日' => $expectedDate,
            '税率A' => $invoice[0]->税率A,
            '税率B' => $invoice[0]->税率B,

            '取引詳細項目' => $details,
            '小計1' => $sumOfDetails,
            '消費税1' => $tenPercentAmount,            
            '消費税2' => $eightPercentAmount,            
            '備考補助金' => $invoice[0]->備考補助金,

            '小計2' => $sumOfDetails + $tenPercentAmount + $eightPercentAmount,
            
            '諸項目' => $invoice[0]->諸項目,
            'お振込先' => $invoice[0]->お振込先,
            
            '備考1' => $invoice[0]->備考1,
            '備考2' => $invoice[0]->備考2,
            '備考3' => $invoice[0]->備考3,
            '備考4' => $invoice[0]->備考4,
        ];

        return $data;
    }
    public function quotePDF($id)
    {
        $data = $this->getPDFInfo($id);
        $pdf = PDF::loadView('quotePDF', $data);
        // return $pdf->download('見積書.pdf');
        return $pdf->stream('見積書.pdf');
    }
    public function requestPDF($id)
    {
        $data = $this->getPDFInfo($id);
        $pdf = PDF::loadView('requestPDF', $data);
        // return $pdf->download('請求書.pdf');
        return $pdf->stream('請求書.pdf');
    }

    public function receiptPDF($id)
    {
        $data = $this->getPDFInfo($id);
        $pdf = PDF::loadView('receiptPDF', $data);
        // return $pdf->download('領収書.pdf');
        return $pdf->stream('領収書.pdf');
    }

    public function deliverPDF($id)
    {
        $data = $this->getPDFInfo($id);
        $pdf = PDF::loadView('deliverPDF', $data);
        // return $pdf->download('納品書.pdf');
        return $pdf->stream('納品書.pdf');
    }
}
