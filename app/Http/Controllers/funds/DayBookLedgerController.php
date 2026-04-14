<?php

namespace App\Http\Controllers\funds;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DayBookLedgerController extends BasefunctionController
{

    public function dayBook()
    {
      $data['dayBook'] = DB::table('tblpaymentTransaction')
      ->leftJoin('tblcontractor','tblcontractor.id','=','tblpaymentTransaction.companyID')
      //->where('tblpaymentTransaction.voucher_status', '=', 1)
      ->where('tblpaymentTransaction.WHTValue', '>', 0)
      ->where('tblpaymentTransaction.VATValue', '>', 0)
      ->orderBy('datePrepared', 'desc')
      ->paginate(50);
       return view('funds.ledgerBook.daybook', $data);
    }
    public function postDayBook(Request $request)
    {
        $datefrom = date('Y-m-d', strtotime(trim($request['getFrom'])));
        $dateTo   = date('Y-m-d', strtotime(trim($request['getTo'])));

        $request->session()->flash('retain_from',$request['getFrom']);
        $request->session()->flash('retain_to',$request['getTo']);

        //$datefrom = trim($request['getFrom']);
        //$dateTo   = trim($request['getTo']);

      $data['dayBook'] = DB::table('tblpaymentTransaction')
          ->leftJoin('tblcontractor','tblcontractor.id','=','tblpaymentTransaction.companyID')
          //->where('tblpaymentTransaction.voucher_status', '=', 1)
          ->where('tblpaymentTransaction.WHTValue', '>', 0)
          ->where('tblpaymentTransaction.VATValue', '>', 0)
          ->whereBetween('datePrepared', [$datefrom, $dateTo])
          ->orderBy('datePrepared', 'desc')
          ->get();
      //dd($data['dayBook']);
       return view('funds.ledgerBook.daybook', $data);
    }


    public function ledger()
    {
    $date = date('F');
    /*$data['ledger'] = DB::table('tblpaymentTransaction')
        ->Join('tblcontractor','tblcontractor.id','=','tblpaymentTransaction.companyID')
        //->where('tblpaymentTransaction.voucher_status', '=', 1)
        ->where('tblpaymentTransaction.WHTValue', '>', 0)
        ->where('tblpaymentTransaction.VATValue', '>', 0)
        ->select('*','tblpaymentTransaction.status as payStatus')
        ->paginate(50);*/

        $data['ledger'] = DB::table('tblpaymentTransaction')
            ->Join('tblcontractor','tblcontractor.id','=','tblpaymentTransaction.companyID')
            ->where('tblpaymentTransaction.WHTValue', '>', 0)
            ->where('tblpaymentTransaction.VATValue', '>', 0)
            ->select('*','tblpaymentTransaction.status as payStatus')
            ->get();
        foreach ($data['ledger'] as $key => $value) {
            $lis = (array) $value;
            $lis['balance'] = $this->VoucherFinancialInfo($value->ID);
            $value = (object) $lis;
            $data['ledger'][$key]  = $value;
        }
        //dd($data['ledger']);

    return view('funds.ledgerBook.ledger', $data);
    }

    public function postLedger(Request $request)
    {

        $status = trim($request['voucherStatus']);
        $datefrom = date('Y-m-d', strtotime(trim($request['getFrom'])));
        $dateTo   = date('Y-m-d', strtotime(trim($request['getTo'])));

        $request->session()->flash('date_from',$request['getFrom']);
        $request->session()->flash('date_to',$request['getTo']);
        $request->session()->flash('paystatus',$request['voucherStatus']);
      if($status == '') {
          $data['ledger'] = DB::table('tblpaymentTransaction')
              ->Join('tblcontractor', 'tblcontractor.id', '=', 'tblpaymentTransaction.companyID')
              ->where('tblpaymentTransaction.WHTValue', '>', 0)
              ->where('tblpaymentTransaction.VATValue', '>', 0)
              ->whereBetween('dateprepared', [$datefrom, $dateTo])
              ->select('*', 'tblpaymentTransaction.status as payStatus')
              ->get();
          foreach ($data['ledger'] as $key => $value) {
              $lis = (array)$value;
              $lis['balance'] = $this->VoucherFinancialInfo($value->ID);
              $value = (object)$lis;
              $data['ledger'][$key] = $value;
          }
          return view('funds.ledgerBook.ledger', $data);
      }
      elseif($status == 6){
          $data['ledger'] = DB::table('tblpaymentTransaction')
              ->Join('tblcontractor', 'tblcontractor.id', '=', 'tblpaymentTransaction.companyID')
              ->where('tblpaymentTransaction.WHTValue', '>', 0)
              ->where('tblpaymentTransaction.VATValue', '>', 0)
              ->whereBetween('dateprepared', [$datefrom, $dateTo])
              ->where('tblpaymentTransaction.status', '=', 6)
              ->select('*', 'tblpaymentTransaction.status as payStatus')
              ->get();
          foreach ($data['ledger'] as $key => $value) {
              $lis = (array)$value;
              $lis['balance'] = $this->VoucherFinancialInfo($value->ID);
              $value = (object)$lis;
              $data['ledger'][$key] = $value;
          }
          return view('funds.ledgerBook.ledger', $data);
      }

      elseif($status == 2){
          $data['ledger'] = DB::table('tblpaymentTransaction')
              ->Join('tblcontractor', 'tblcontractor.id', '=', 'tblpaymentTransaction.companyID')
              ->where('tblpaymentTransaction.WHTValue', '>', 0)
              ->where('tblpaymentTransaction.VATValue', '>', 0)
              ->whereBetween('dateprepared', [$datefrom, $dateTo])
              ->where('tblpaymentTransaction.status', '<', 6)
              ->select('*', 'tblpaymentTransaction.status as payStatus')
              ->get();
          foreach ($data['ledger'] as $key => $value) {
              $lis = (array)$value;
              $lis['balance'] = $this->VoucherFinancialInfo($value->ID);
              $value = (object)$lis;
              $data['ledger'][$key] = $value;
          }
          return view('funds.ledgerBook.ledger', $data);
      }
    }


}
