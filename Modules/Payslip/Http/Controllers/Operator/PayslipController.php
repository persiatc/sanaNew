<?php

namespace Modules\Payslip\Http\Controllers\Operator;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
// use Services\UploaderService;
use Hekmatinasser\Verta\Verta;
use Morilog\Jalali\CalendarUtils;
use Illuminate\Routing\Controller;
use Rap2hpoutre\FastExcel\FastExcel;
use Modules\Payslip\Entities\Payslip;
use Modules\Payslip\Entities\PayslipLog;
use Illuminate\Contracts\Support\Renderable;
use Modules\Payslip\Http\Requests\PayslipStoreRequest;

class PayslipController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $payslips = PayslipLog::all();
        return view('payslip::operator.payslipShow', compact('payslips'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('payslip::operator.payslipUpload');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(PayslipStoreRequest $request)
    {
        $date = $request->date_pay;
        // dd($date);
        $payslips = (new FastExcel)->import($request->file,function ($line) {
            return Payslip::create([
                'Code' => $line['Code'],
                'Name' => $line['Name'],
                'Family' => $line['Family'],
                'FatherName' => $line['FatherName'],
                'NationalCode' => $line['NationalCode'],
                'TotalBimeh' => $line['TotalBimeh'],
                'BimehShare' => $line['BimehShare'],
                'JameKosoor' => $line['JameKosoor'],
                'JameMazaya' => $line['JameMazaya'],
                'KarkardUdy' => $line['KarkardUdy'],
                'Mabna' => $line['Mabna'],
                'DRes1' => $line['DRes1'],
                'DRes2' => $line['DRes2'],
                'withName' => $line['withName'],
                'FactorValue' => $line['FactorValue'],
                'FSType' => $line['FSType'],
                'date_pay' => '??????????????????',
                // 'month_id' => 1,
            ]);
        });

        $path = 'PayslipFile/';
        $file = \App\Services\UploaderService::fileUploader($request->file, $path);

        $PayslipLog = PayslipLog::create([
            'name' => $request->name,
            'date_pay' => $request->date_pay,
            'file' => $file,
            'user_id' => auth()->user()->id,
        ]);

        $request->session()->flash('alert-success' , '???????????? ???????? ??????!');
        return redirect()->route('Payslip.index');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('payslip::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('payslip::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
