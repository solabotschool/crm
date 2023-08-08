@extends('layouts.page')

@section('content')
<div class="page-wrapper">
    <!-- -------------------------------------------------------------- -->
    <!-- Container fluid  -->
    <!-- -------------------------------------------------------------- -->
    <div class="container-fluid">
        <div class="row mb-3">
            <div class="row col-md-8 col-12 search-bar">
                <h4 class="text-themecolor col-4" style="text-align: right; font-weight:bold;">顧客検索</h4>
                <form class="row col-8" action="{{route('search')}}" method="POST">
                    @csrf
                    <!-- keyword -->
                    <div class="form-group row">
                        <div class="btn-group">
                            <input class="form-control" type="text" name="keyword" placeholder="２文字" value="{{ isset($keyword) ? $keyword : '' }}">
                            <button class="btn waves-effect waves-light btn-secondary" type="submit"><i class="ti-search"></i></button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-4 col-12 align-self-center d-none d-md-block">
                <div class="d-flex mt-2 justify-content-end">
                    <div class="d-flex ms-2">
                        <button type="button" class="justify-content-center w-100 btn btn-info d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#Sharemodel" onclick="initModal();">
                            <i data-feather="plus" class="feather-sm fill-white me-2"></i> 新規登録
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card card-body" style="max-height:80vh;">
            <div class="table-responsive">
                <table class="table search-table v-middle">
                    <thead class="header-item">
                        <th style="min-width:90px; text-align:center;">会社名</th>
                        <th style="min-width:90px; text-align:center;">対象月</th>
                        <th style="min-width:150px; text-align:center;">内容</th>
                        <th style="min-width:90px; text-align:center;">合計金額</th>
                        <th style="min-width:150px; text-align:center;">備考補助金など</th>
                        <th style="min-width:150px; text-align:center;">入金予定日</th>
                        <th style="min-width:150px; text-align:center;">超過日入金遅れ</th>
                        <th style="min-width:90px; text-align:center;">見積書</th>
                        <th style="min-width:90px; text-align:center;">請求書</th>
                        <th style="min-width:90px; text-align:center;">納品書</th>
                        <th style="min-width:90px; text-align:center;">領収書</th>
                        <th style="min-width:150px; text-align:center;">更新</th>
                    </thead>
                    <tbody>
                        <!-- row -->
                        @foreach($result as $invoice)
                        <?php
                        $jsonString  = $invoice->取引詳細項目;
                        $array = json_decode($jsonString, true);

                        $cost = explode(',', $array['cost']);
                        $count = explode(',', $array['count']);
                        $unit = explode(',', $array['unit']);

                        $amount = floatval($invoice->備考補助金);
                        for ($index = 0; $index < 10; $index++) {

                            if ($count[$index] == '' || $unit[$index] == '') continue;
                            $amount += (1 + floatval($cost[$index])) * floatval($count[$index]) * floatval($unit[$index]);
                        }

                        $date_str_arr = explode('-', $invoice->支払い予定日);

                        $year = intval($date_str_arr[0]) + 2018;
                        $month = intval($date_str_arr[1]);
                        $day = intval($date_str_arr[2]);

                        $dateString = $year . '-' . $month . '-' . $day;
                        $timestamp = strtotime($dateString);
                        $expectedDay = date('Y年m月d日', $timestamp);

                        $date1 = new DateTime();
                        $date2 = new DateTime($dateString);
                        $interval = $date1->diff($date2);
                        $daysDiff = $interval->days;
                        ?>

                        <tr class="search-items {{ ( $date1 > $date2 && $invoice->status == 0) ? 'text-danger' : 'text-info' }}">
                            <td>{{ $invoice->お客様名 }}</td>
                            <td>{{ $invoice->請求月 }}月</td>
                            <td>{{ $invoice->案件名 }}</td>
                            <td>¥{{ $amount }}</td>
                            <td>¥{{ $invoice->備考補助金 }}</td>
                            <td>{{ $expectedDay }}</td>
                            <td>{{ $daysDiff }}日</td>
                            <td><a href="{{route('quotePDF', ['id'=>$invoice->id])}}" target="_blank"><img src="pdf-download.png" alt="pdf-download" width="32"></a></td>
                            <td><a href="{{route('requestPDF', ['id'=>$invoice->id])}}" target="_blank"><img src="pdf-download.png" alt="pdf-download" width="32"></a></td>
                            <td><a href="{{route('receiptPDF', ['id'=>$invoice->id])}}" target="_blank"><img src="pdf-download.png" alt="pdf-download" width="32"></a></td>
                            <td><a href="{{route('deliverPDF', ['id'=>$invoice->id])}}" target="_blank"><img src="pdf-download.png" alt="pdf-download" width="32"></a></td>
                            <td>
                                <div class="action-btn">
                                    <a href="javascript:void(0)" class="text-info edit" onclick="updateInv('{{$invoice->id}}')"><i data-feather="edit" class="feather-sm fill-white"></i></a>
                                    <a href="javascript:void(0)" class="text-info edit" onclick="addInv('{{$invoice->id}}')" style="margin-left:10px;"><i class="fa fa-clone"></i></a>
                                    <a href="javascript:void(0)" class="text-dark delete ms-2" data-bs-toggle="modal" data-bs-target="#Deletemodel" onclick="getDelId('{{$invoice->id}}')"><i data-feather="trash-2" class="feather-sm fill-white"></i></a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        <!-- /.row -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Share Modal -->
    <div class="modal fade" id="Sharemodel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="post" action="{{route('invoice')}}">
                    @csrf
                    <input name="id" type="hidden" value="0" />
                    <div class="modal-header d-flex align-items-center">
                        <h5 class="modal-title" id="exampleModalLabel">
                            <i class="mdi mdi-auto-fix me-2"></i>
                            新規登録
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row align-items-center mb-4">
                            <div class="col-md-2">
                                <label class="col-form-label">日付</label>
                            </div>                            
                            <div class="col-md-6 form-date">見積書 :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;令和
                                <input required type="number" class="form-control" name="year1">年
                                <input required type="number" class="form-control" name="month1">月
                                <input required type="number" class="form-control" name="day1">日
                            </div>
                            <div class="col-md-2"></div>
                            <div class="col-md-2">
                                <select class="form-control" name="status">
                                    <option value="0">入金未定</option>
                                    <option value="1">入金確定</option>
                                </select>
                            </div>

                        </div>
                        <div class="row align-items-center mb-4">
                            <div class="col-md-2"></div>                            
                            <div class="col-md-6 form-date">請求書 :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;令和
                                <input required type="number" class="form-control" name="year2">年
                                <input required type="number" class="form-control" name="month2">月
                                <input required type="number" class="form-control" name="day2">日
                            </div>
                            <div class="col-md-2"></div>
                            <div class="col-md-2"></div>

                        </div>
                        <div class="row align-items-center mb-4">
                            <div class="col-md-2"></div>                            
                            <div class="col-md-6 form-date">納品書 :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;令和
                                <input required type="number" class="form-control" name="year3">年
                                <input required type="number" class="form-control" name="month3">月
                                <input required type="number" class="form-control" name="day3">日
                            </div>
                            <div class="col-md-2"></div>
                            <div class="col-md-2"></div>

                        </div>
                        <div class="row align-items-center mb-4">
                            <div class="col-md-2"></div>                            
                            <div class="col-md-6 form-date">領収書 :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;令和
                                <input required type="number" class="form-control" name="year4">年
                                <input required type="number" class="form-control" name="month4">月
                                <input required type="number" class="form-control" name="day4">日
                            </div>
                            <div class="col-md-2"></div>
                            <div class="col-md-2"></div>

                        </div>

                        <div class="row align-items-center mb-4">
                            <div class="col-md-3">
                                <label class="col-form-label">自社名</label>
                            </div>
                            <div class="col-md-9 form-customer">
                                <input required_ type="text" class="form-control" name="ComName" placeholder="自社名">
                            </div>
                        </div>

                        <div class="row align-items-center mb-4">
                            <div class="col-md-3">
                                <label class="col-form-label">登録番号</label>
                            </div>
                            <div class="col-md-9 form-customer">
                                <input required_ type="text" class="form-control" name="RegNumber13" placeholder="T⚪︎⚪︎⚪︎⚪︎（１３桁の数字）">
                            </div>
                        </div>

                        <div class="row align-items-center mb-4">
                            <div class="col-md-3">
                                <label class="col-form-label">代表（姓/名）</label>
                            </div>
                            <div class="col-md-9 form-name">
                                <input required_ type="text" class="form-control" name="RepFamily" placeholder="姓"> /
                                <input required_ type="text" class="form-control" name="RepName" placeholder="名">
                            </div>
                        </div>
			<div class="row align-items-center mb-4">
                            <div class="col-md-3">
                                <label class="col-form-label">郵便番号</label>
                            </div>
                            <div class="col-md-9 form-customer">
                                <input required_ type="text" class="form-control" name="RegNumber" placeholder="〒⚪︎⚪︎⚪︎-⚪︎⚪︎⚪︎⚪︎">
                            </div>
                        </div>

                        <div class="row align-items-center mb-4">
                            <div class="col-md-3">
                                <label class="col-form-label">自社住所/連絡先<small style="font-size: 10px;">（TEL、FAX、EMAIL）</small></label>
                            </div>
                            <div class="col-md-9 form-name">
                                <input required_ type="text" class="form-control" name="ComAddress" placeholder="住所"> /
                                <input required_ type="text" class="form-control" name="ComTEL" placeholder="TEL">
                            </div>
                            <div class="col-md-3"></div>
                            <div class="col-md-9 form-name" style="margin-top:10px;">
                                <input required_ type="text" class="form-control" name="ComFAX" placeholder="FAX"> /
                                <input required_ type="text" class="form-control" name="ComEMAIL" placeholder="メールアドレス">
                            </div>
                        </div>

                        <div class="row align-items-center mb-4">
                            <div class="col-md-3">
                                <label class="col-form-label">お客様名</label>
                            </div>
                            <div class="col-md-9 form-customer">
                                <input required_ type="text" class="form-control" name="VIPName" placeholder="お客様名">
                            </div>
                        </div>

                        <div class="row align-items-center mb-4">
                            <div class="col-md-3">
                                <label class="col-form-label">お客様住所/連絡先など</label>
                            </div>
                            <div class="col-md-9 form-name">
                                <input required_ type="text" class="form-control" name="VIPAddress" placeholder="お客様住所">
                                /
                                <input required_ type="text" class="form-control" name="VIPEmail" placeholder="お客様連絡先TELやメールアドレス">
                            </div>
                        </div>

                        <div class="row align-items-center mb-4">
                            <div class="col-md-3">
                                <label class="col-form-label">取引名（案件名）</label>
                            </div>
                            <div class="col-md-9 form-customer">
                                <input required_ type="text" class="form-control" name="IssueName" placeholder="案件名">
                            </div>
                        </div>

                        <div class="row align-items-center mb-4">
                            <div class="col-md-3">
                                <label class="col-form-label">請求月/支払い予定日</label>
                            </div>
                            <div class="col-md-4 form-name">
                                <input required_ type="number" class="form-control" name="ReqMonth" placeholder="請求月">月
                                &NonBreakingSpace;&NonBreakingSpace;/ &NonBreakingSpace;&NonBreakingSpace;支払い予定日
                            </div>
                            <div class="col-md-5 form-date">令和
                                <input required type="number" class="form-control" name="year5">年
                                <input required type="number" class="form-control" name="month5">月
                                <input required type="number" class="form-control" name="day5">日
                            </div>
                        </div>

                        <div class="row align-items-center mb-4">
                            <div class="col-md-6 form-date">
                                税率A<input required_ type="number" class="form-control" name="APercent" value="10" disabled>%&NonBreakingSpace;
                                &NonBreakingSpace;&NonBreakingSpace;&NonBreakingSpace;&NonBreakingSpace;&NonBreakingSpace;
                                税率B<input required_ type="number" class="form-control" name="BPercent" value="8" disabled>%&NonBreakingSpace;
                            </div>
                        </div>
                        <h4 class="trans-details">
                            ◆取引詳細項目 <span style="text-decoration: underline;">総額 ¥<span class="calculatedTotalAmount">0</span></span>
                        </h4>

                        <div class="table-responsive">
                            <table class="table search-table v-middle">
                                <thead class="header-item">
                                    <th>内容</th>
                                    <th>費目(A,B選択)</th>
                                    <th>単位</th>
                                    <th>単価</th>
                                    <th>金額</th>
                                </thead>
                                <tbody class="details">
                                    <!-- row -->
                                    <tr class="search-items">
                                        <td><input required_ type="text" class="form-control" name="content[]"></td>
                                        <td>
                                            <select class="form-control" name="cost[]" onchange="calculate(this)">
                                                <option value="0.1">A</option>
                                                <option value="0.08">B</option>
                                            </select>
                                        </td>
                                        <td><input required_ type="number" class="form-control" name="count[]" style="width:150px;" onchange="calculate(this)"></td>
                                        <td><input required_ type="number" class="form-control" name="unit[]" style="width:150px;" onchange="calculate(this)"></td>
                                        <td><input required_ type="number" class="form-control" name="amount[]" style="width:150px;" disabled></td>
                                    </tr>
                                    <tr class="search-items">
                                        <td><input type="text" class="form-control" name="content[]"></td>
                                        <td>
                                            <select class="form-control" name="cost[]" onchange="calculate(this)">
                                                <option value="0.1">A</option>
                                                <option value="0.08">B</option>
                                            </select>
                                        </td>
                                        <td><input type="number" class="form-control" name="count[]" style="width:150px;" onchange="calculate(this)"></td>
                                        <td><input type="number" class="form-control" name="unit[]" style="width:150px;" onchange="calculate(this)"></td>
                                        <td><input type="number" class="form-control" name="amount[]" style="width:150px;" disabled></td>
                                    </tr>
                                    <tr class="search-items">
                                        <td><input type="text" class="form-control" name="content[]"></td>
                                        <td>
                                            <select class="form-control" name="cost[]" onchange="calculate(this)">
                                                <option value="0.1">A</option>
                                                <option value="0.08">B</option>
                                            </select>
                                        </td>
                                        <td><input type="number" class="form-control" name="count[]" style="width:150px;" onchange="calculate(this)"></td>
                                        <td><input type="number" class="form-control" name="unit[]" style="width:150px;" onchange="calculate(this)"></td>
                                        <td><input type="number" class="form-control" name="amount[]" style="width:150px;" disabled></td>
                                    </tr>
                                    <tr class="search-items">
                                        <td><input type="text" class="form-control" name="content[]"></td>
                                        <td>
                                            <select class="form-control" name="cost[]" onchange="calculate(this)">
                                                <option value="0.1">A</option>
                                                <option value="0.08">B</option>
                                            </select>
                                        </td>
                                        <td><input type="number" class="form-control" name="count[]" style="width:150px;" onchange="calculate(this)"></td>
                                        <td><input type="number" class="form-control" name="unit[]" style="width:150px;" onchange="calculate(this)"></td>
                                        <td><input type="number" class="form-control" name="amount[]" style="width:150px;" disabled></td>
                                    </tr>
                                    <tr class="search-items">
                                        <td><input type="text" class="form-control" name="content[]"></td>
                                        <td>
                                            <select class="form-control" name="cost[]" onchange="calculate(this)">
                                                <option value="0.1">A</option>
                                                <option value="0.08">B</option>
                                            </select>
                                        </td>
                                        <td><input type="number" class="form-control" name="count[]" style="width:150px;" onchange="calculate(this)"></td>
                                        <td><input type="number" class="form-control" name="unit[]" style="width:150px;" onchange="calculate(this)"></td>
                                        <td><input type="number" class="form-control" name="amount[]" style="width:150px;" disabled></td>
                                    </tr>
                                    <tr class="search-items">
                                        <td><input type="text" class="form-control" name="content[]"></td>
                                        <td>
                                            <select class="form-control" name="cost[]" onchange="calculate(this)">
                                                <option value="0.1">A</option>
                                                <option value="0.08">B</option>
                                            </select>
                                        </td>
                                        <td><input type="number" class="form-control" name="count[]" style="width:150px;" onchange="calculate(this)"></td>
                                        <td><input type="number" class="form-control" name="unit[]" style="width:150px;" onchange="calculate(this)"></td>
                                        <td><input type="number" class="form-control" name="amount[]" style="width:150px;" disabled></td>
                                    </tr>
                                    <tr class="search-items">
                                        <td><input type="text" class="form-control" name="content[]"></td>
                                        <td>
                                            <select class="form-control" name="cost[]" onchange="calculate(this)">
                                                <option value="0.1">A</option>
                                                <option value="0.08">B</option>
                                            </select>
                                        </td>
                                        <td><input type="number" class="form-control" name="count[]" style="width:150px;" onchange="calculate(this)"></td>
                                        <td><input type="number" class="form-control" name="unit[]" style="width:150px;" onchange="calculate(this)"></td>
                                        <td><input type="number" class="form-control" name="amount[]" style="width:150px;" disabled></td>
                                    </tr>
                                    <tr class="search-items">
                                        <td><input type="text" class="form-control" name="content[]"></td>
                                        <td>
                                            <select class="form-control" name="cost[]" onchange="calculate(this)">
                                                <option value="0.1">A</option>
                                                <option value="0.08">B</option>
                                            </select>
                                        </td>
                                        <td><input type="number" class="form-control" name="count[]" style="width:150px;" onchange="calculate(this)"></td>
                                        <td><input type="number" class="form-control" name="unit[]" style="width:150px;" onchange="calculate(this)"></td>
                                        <td><input type="number" class="form-control" name="amount[]" style="width:150px;" disabled></td>
                                    </tr>
                                    <tr class="search-items">
                                        <td><input type="text" class="form-control" name="content[]"></td>
                                        <td>
                                            <select class="form-control" name="cost[]" onchange="calculate(this)">
                                                <option value="0.1">A</option>
                                                <option value="0.08">B</option>
                                            </select>
                                        </td>
                                        <td><input type="number" class="form-control" name="count[]" style="width:150px;" onchange="calculate(this)"></td>
                                        <td><input type="number" class="form-control" name="unit[]" style="width:150px;" onchange="calculate(this)"></td>
                                        <td><input type="number" class="form-control" name="amount[]" style="width:150px;" disabled></td>
                                    </tr>
                                    <tr class="search-items">
                                        <td><input type="text" class="form-control" name="content[]"></td>
                                        <td>
                                            <select class="form-control" name="cost[]" onchange="calculate(this)">
                                                <option value="0.1">A</option>
                                                <option value="0.08">B</option>
                                            </select>
                                        </td>
                                        <td><input type="number" class="form-control" name="count[]" style="width:150px;" onchange="calculate(this)"></td>
                                        <td><input type="number" class="form-control" name="unit[]" style="width:150px;" onchange="calculate(this)"></td>
                                        <td><input type="number" class="form-control" name="amount[]" style="width:150px;" disabled></td>
                                    </tr>


                                    <!-- details -->

                                    <tr class="search-items">
                                        <td colspan="2" style="text-align: right; font-weight:bold;">小計</td>
                                        <td colspan="3" style="text-align: right; font-weight:bold;">¥<span class="totalAmount">0</span></td>
                                    </tr>

                                    <tr class="search-items">
                                        <td colspan="2" style="font-weight:bold;">10%対象　　¥<span class="ATotalAmount">0</span></td>
                                        <td colspan="3" style="font-weight:bold;">10%消費税　¥<span class="ACalculatedTotalAmount">0</span></td>
                                    </tr>
                                    <tr class="search-items">
                                        <td colspan="2" style="font-weight:bold;">8%対象　　¥<span class="BTotalAmount">0</span></td>
                                        <td colspan="3" style="font-weight:bold;">8%消費税　¥<span class="BCalculatedTotalAmount">0</span></td>
                                    </tr>
                                    <tr class="search-items">
                                        <td colspan="2" style="text-align: right; font-weight:bold;">備考補助金</td>
                                        <td colspan="3" style="text-align: right; font-weight:bold;">
                                            <input type="number" class="form-control" name="subsidy" style="width:150px; float:right;" onchange="calculate(this)" value="0">
                                        </td>
                                    </tr>

                                    <tr class="search-items">
                                        <td colspan="5" style="text-align: left; font-weight:bold; background:lightblue;">諸項目</td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" style="text-align: right; font-weight:bold;">
                                            <textarea class="form-control" name="conditions" rows="5" style="border:none;" required_></textarea>
                                        </td>
                                    </tr>
                                    <tr class="search-items">
                                        <td colspan="5" style="text-align: left; font-weight:bold; background:lightblue;">お振込先</td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" style="text-align: right; font-weight:bold;">
                                            <textarea class="form-control" name="bankAddress" rows="5" style="border:none;" wrap="hard" required_></textarea>
                                        </td>
                                    </tr>
                                    <tr class="search-items">
                                        <td colspan="5" style="text-align: left; font-weight:bold; background:lightblue;">備考（見積書）</td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" style="text-align: right; font-weight:bold;">
                                            <textarea class="form-control" name="remark1" rows="3" style="border:none;"></textarea>
                                        </td>
                                    </tr>
                                    <tr class="search-items">
                                        <td colspan="5" style="text-align: left; font-weight:bold; background:lightblue;">備考（請求書）</td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" style="text-align: right; font-weight:bold;">
                                            <textarea class="form-control" name="remark2" rows="3" style="border:none;"></textarea>
                                        </td>
                                    </tr>
                                    <tr class="search-items">
                                        <td colspan="5" style="text-align: left; font-weight:bold; background:lightblue;">備考（納品書）</td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" style="text-align: right; font-weight:bold;">
                                            <textarea class="form-control" name="remark3" rows="3" style="border:none;"></textarea>
                                        </td>
                                    </tr>
                                    <tr class="search-items">
                                        <td colspan="5" style="text-align: left; font-weight:bold; background:lightblue;">備考（領収書）</td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" style="text-align: right; font-weight:bold;">
                                            <textarea class="form-control" name="remark4" rows="3" style="border:none;"></textarea>
                                        </td>
                                    </tr>
                                    <!-- /.row -->
                                </tbody>
                            </table>
                            Aは10％対象でBは8％対象
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success"><i class="fas fa-save"></i>
                            更新（一時保存）</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- -------------------------------------------------------------- -->
    <div class="modal fade" id="Deletemodel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header d-flex align-items-center">
                    <h5 class="modal-title" id="exampleModalLabel"><i data-feather="trash-2" class="feather-sm fill-white"></i>
                        削除しますか？</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">いいえ</button>
                    <button type="button" class="btn btn-success" onclick="deleteInv()"><i class="fas fa-trash"></i>
                        はい</button>
                </div>

            </div>
        </div>
    </div>
    <!-- End Container fluid  -->

</div>
@endsection