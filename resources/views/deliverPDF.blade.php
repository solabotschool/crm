<!doctype html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Create PDF</title>
    <style>
        body {
            font-family: ipag !important;
        }

        td {
            text-align: center;
        }

        th {
            font-weight: bolder;
        }

        .company {
            width: 50%;
        }

        .date {
            width: 50%;
        }

        /* table, */
        th {
            border: solid 1px #000;
            padding: 6px;
        }

        td {
            border-right: solid 1px #000;
            padding: 6px;
        }

        table {
            border-collapse: collapse;
            caption-side: bottom;
        }
    </style>
</head>

<body>

    <h1 style="text-align: center;"> 領 収 書 </h1>
    <div style="display:flex; align-items: center;">
        <div class="company" style="width:75%; float:left; padding-top:25px;">
            <h4> {{ $お客様名 }} &nbsp;&nbsp;御中</h4>
        </div>
        <div class="date" style="width:25%; float:right;">
            <h5>日付: {{ $報告書日付 }}</h5>
            <h5>対象月： {{ $請求月 }}月</h5>
        </div>
    </div>

    <div style="display:flex; align-items: center; margin-top:30px;">
        <div class="company" style="width:60%; float:left; padding-top:30px;">
            <h4>下記、制作物のポスティングを<br/>完了したことを報告いたします。</h4>

            <h4 style="font-size: 20px; margin-top:50px;">合 計 金 額</h4>

            <h5
                style="font-size: 20px; margin-top:30px; font-weight:bolder; border-bottom-style:solid; border-bottom-width:1px; width:80%; ">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                ¥{{ number_format($小計2,0,'.',',') }}
            </h5>

        </div>
        <div class="date" style="width:40%; float:right;">
            <div style="width:60%; float: left;">
                <h5>{{ $自社名 }}</h5>
                <h5>代表　{{ $代表姓 }}　{{ $代表名 }}</h5>

                <h5 style="line-height:6px; font-size:10px">{{ $登録番号 }}</h5>
                <h5 style="line-height:6px; font-size:10px">{{ $自社住所 }}</h5>
                @if($登録番号13 != '')
                <h5 style="line-height:6px; font-size:10px">登録番号：{{ $登録番号13 }}</h5>
                @endif
                @if($連絡先TEL != '')
                <h5 style="line-height:6px; font-size:10px">TEL：{{ $連絡先TEL }}</h5>
                @endif
                @if($連絡先FAX != '')
                <h5 style="line-height:6px; font-size:10px">FAX：{{ $連絡先FAX }}</h5>
                @endif
                @if($連絡先EMAIL != '')
                <h5 style="line-height:6px; font-size:10px">EMAIL：{{ $連絡先EMAIL }}</h5>
                @endif
            </div>
            <div style="width:40%; float: right;">
                <img src="logo.png" alt="logo" width="70px" height="70px" style="margin-left:40px;" />
                <img src="stamp.png" alt="stamp" width="90px" height="90px" style="margin-top:30px; margin-left:25px;" />
            </div>
        </div>
    </div>

    <table style="width:100%;">
        <thead>
            <tr style="background-color:#EBF1DE;">
                <th style="width: 50%;">内容</th>
                <th>単位</th>
                <th>単価</th>
                <th>金額</th>
            </tr>
        </thead>
        <tbody>

            @foreach( $取引詳細項目 as $detail)
            <tr>
                <td style="border-left: solid 1px #000;">
                    <h5>{{ $detail['content'] }} </h5>
                </td>
                <td>
                    <h5>{{ $detail['count'] }} </h5>
                </td>
                <td>
                    <h5>{{ number_format($detail['unit'],0,'.',',') }} </h5>
                </td>
                <td style="text-align: right; background-color:lightgray;">
                    <h5>{{ number_format($detail['amount'],0,'.',',') }} </h5>
                </td>
            </tr>
            @endforeach

            <tr>
                <td colspan="3" style="border-top: solid 0.5px !important; text-align: right;">
                    <h5>小計</h5>
                </td>
                <td style="text-align: right; border: solid 1px #000; background-color:lightgray;">
                    <h5>{{ number_format($小計1,0,'.',',') }} </h5>
                </td>
            </tr>
            @if($消費税1 > 0)
            <tr>
                <td colspan="3" style="text-align: right;">
                    <h5>税率</h5>
                </td>
                <td style="text-align: right; border-bottom: solid 1px #000;">
                    <h5>10.00%</h5>
                </td>
            </tr>
            <tr>
                <td colspan="3" style="text-align: right;">
                    <h5>消費税</h5>
                </td>
                <td style="text-align: right; border-bottom: solid 1px #000; background-color:lightgray;">
                    <h5>{{ number_format($消費税1,0,'.',',') }} </h5>
                </td>
            </tr>
            @endif
            @if($消費税2 > 0)
            <tr>
                <td colspan="3" style="text-align: right;">
                    <h5>税率</h5>
                </td>
                <td style="text-align: right; border-bottom: solid 1px #000;">
                    <h5>8.00%</h5>
                </td>
            </tr>
            <tr>
                <td colspan="3" style="text-align: right;">
                    <h5>消費税</h5>
                </td>
                <td style="text-align: right; border-bottom: solid 1px #000; background-color:lightgray;">
                    <h5>{{ number_format($消費税2,0,'.',',') }} </h5>
                </td>
            </tr>
            @endif
            @if($備考補助金 > 0)
            <tr>
                <td colspan="3" style="text-align: right;">
                    <h5>備考補助金</h5>
                </td>
                <td style="text-align: right; border-bottom: solid 1px #000;">
                    <h5>{{ number_format($備考補助金,0,'.',',') }} </h5>
                </td>
            </tr>
            @endif
            <tr>
                <td colspan="3" style="text-align: right;">
                    <h5>小計</h5>
                </td>
                <td style="text-align: right; border-bottom: solid 1px #000;">
                    <h5>{{ number_format($小計2,0,'.',',') }} </h5>
                </td>
            </tr>
        </tbody>
    </table>

    <table style="width:100%; margin-top:30px;">
        <tbody>
            <tr style="background-color:#EBF1DE;">
                <th style="text-align:left;">備考</th>
            </tr>
            <tr>
                <td style="border-bottom: solid 1px #000; border-left: solid 1px #000; text-align:left;">
                    <h5 style="font-size: 12px;">
                        <?php echo nl2br($備考4); ?>
                        <br/>
                    </h5>
                </td>
            </tr>
        </tbody>
    </table>

</body>

</html>