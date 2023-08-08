<!DOCTYPE html>
<html dir="ltr" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="Luna, video monitoring, camera surveillance, cloud solution">
    <meta name="description" content="Luna is a powerful monitoring system.">
    <meta name="robots" content="noindex,nofollow">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="luna/src/assets/images/favicon.png">
    <!-- Custom CSS -->
    <link href="luna/style.css" rel="stylesheet">
    <link href="luna/dist/css/style.min.css" rel="stylesheet">
    <link href="luna/src/assets/extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body>
    <div class="main-wrapper">

        <!-- -------------------------------------------------------------- -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- -------------------------------------------------------------- -->
        <div class="preloader">
            <svg class="tea lds-ripple" width="37" height="48" viewbox="0 0 37 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M27.0819 17H3.02508C1.91076 17 1.01376 17.9059 1.0485 19.0197C1.15761 22.5177 1.49703 29.7374 2.5 34C4.07125 40.6778 7.18553 44.8868 8.44856 46.3845C8.79051 46.79 9.29799 47 9.82843 47H20.0218C20.639 47 21.2193 46.7159 21.5659 46.2052C22.6765 44.5687 25.2312 40.4282 27.5 34C28.9757 29.8188 29.084 22.4043 29.0441 18.9156C29.0319 17.8436 28.1539 17 27.0819 17Z" stroke="#1e88e5" stroke-width="2"></path>
                <path d="M29 23.5C29 23.5 34.5 20.5 35.5 25.4999C36.0986 28.4926 34.2033 31.5383 32 32.8713C29.4555 34.4108 28 34 28 34" stroke="#1e88e5" stroke-width="2"></path>
                <path id="teabag" fill="#1e88e5" fill-rule="evenodd" clip-rule="evenodd" d="M16 25V17H14V25H12C10.3431 25 9 26.3431 9 28V34C9 35.6569 10.3431 37 12 37H18C19.6569 37 21 35.6569 21 34V28C21 26.3431 19.6569 25 18 25H16ZM11 28C11 27.4477 11.4477 27 12 27H18C18.5523 27 19 27.4477 19 28V34C19 34.5523 18.5523 35 18 35H12C11.4477 35 11 34.5523 11 34V28Z">
                </path>
                <path id="steamL" d="M17 1C17 1 17 4.5 14 6.5C11 8.5 11 12 11 12" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke="#1e88e5"></path>
                <path id="steamR" d="M21 6C21 6 21 8.22727 19 9.5C17 10.7727 17 13 17 13" stroke="#1e88e5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
        </div>
        <!-- -------------------------------------------------------------- -->
        <div id="main-wrapper">
            <!-- -------------------------------------------------------------- -->
            <!-- Topbar header - style you can find in pages.scss -->
            <!-- -------------------------------------------------------------- -->
            <header class="topbar">
                <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                    <div class="navbar-header">
                        <!-- This is for the sidebar toggle which is visible on mobile only -->
                        <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i class="ti-menu ti-close"></i></a>
                        <!-- ============================================================== -->
                        <!-- Logo -->
                        <!-- ============================================================== -->
                        <a class="navbar-brand" href="{{ route('index') }}">
                            <!-- Logo icon -->
                            <b class="logo-icon">
                                <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                                <!-- Dark Logo icon -->
                                <img src="luna/src/assets/images/logo-icon.png" alt="homepage" class="dark-logo" />
                                <!-- Light Logo icon -->
                                <img src="luna/src/assets/images/logo-light-icon.png" alt="homepage" class="light-logo" />
                            </b>
                            <!--End Logo icon -->
                            <!-- Logo text -->
                            <span class="logo-text">
                                <!-- dark Logo text -->
                                <img src="luna/src/assets/images/logo-text.png" alt="homepage" class="dark-logo" />
                                <!-- Light Logo text -->
                                <img src="luna/src/assets/images/logo-light-text.png" class="light-logo" alt="homepage" />
                            </span>
                        </a>
                        <!-- ============================================================== -->
                        <!-- End Logo -->
                        <!-- ============================================================== -->
                        <!-- ============================================================== -->
                        <!-- Toggle which is visible on mobile only -->
                        <!-- ============================================================== -->
                        <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i class="ti-more"></i></a>
                    </div>
                    <!-- ============================================================== -->
                    <!-- End Logo -->
                    <!-- ============================================================== -->
                    <div class="navbar-collapse collapse" id="navbarSupportedContent">
                        <!-- ============================================================== -->
                        <!-- toggle and nav items -->
                        <!-- ============================================================== -->
                        <ul class="navbar-nav me-auto">
                            <!-- This is  -->
                            <li class="nav-item"> <a class="nav-link sidebartoggler d-none d-md-block waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
                            <!-- ============================================================== -->
                            <!-- Search -->
                            <!-- ============================================================== -->
                            <!-- <li class="nav-item d-none d-md-block search-box"> <a class="nav-link d-none d-md-block waves-effect waves-dark" href="javascript:void(0)"><i class="ti-search"></i></a>
                        <form class="app-search">
                            <input type="text" class="form-control" placeholder="Search & enter">
                            <a class="srh-btn"><i class="ti-close"></i></a>
                            <a class="form-control text-center" href="search.html">
                                <i class="ti-search"></i> Search by image</a>
                        </form>
                    </li> -->
                        </ul>
                        <!-- ============================================================== -->
                        <!-- Right side toggle and nav items -->
                        <!-- ============================================================== -->
                        <ul class="navbar-nav">
                            <!-- ============================================================== -->
                            <!-- Comment -->
                            <!-- ============================================================== -->
                            <li class="nav-item dropdown">
                                <div class="nav-link waves-effect waves-dark">
                                    <i class="mdi mdi-account-circle"></i>
                                    <span style="font-size: 17px;">管理者</span>
                                    <a href="{{route('logout')}}" style="margin-left:10px; color: white;" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();"><i class="mdi mdi-logout"></i></a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>

                            </li>
                            <!-- ============================================================== -->
                            <!-- End Comment -->
                            <!-- ============================================================== -->
                            <!-- ============================================================== -->
                            <!-- Profile -->
                            <!-- ============================================================== -->
                            <li class="nav-item">

                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <!-- -------------------------------------------------------------- -->
            <!-- End Topbar header -->
            <!-- -------------------------------------------------------------- -->
            <!-- -------------------------------------------------------------- -->
            <!-- Left Sidebar - style you can find in sidebar.scss  -->
            <!-- -------------------------------------------------------------- -->
            <aside class="left-sidebar">
                <!-- Sidebar scroll-->
                <div class="scroll-sidebar">
                    <!-- Sidebar navigation-->
                    <nav class="sidebar-nav">
                        <ul id="sidebarnav">
                            <li class="sidebar-item">
                                <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{route('home')}}" aria-expanded="false">
                                    <i class="mdi mdi-account-multiple"></i><span class="hide-menu">顧客管理一覧</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                    <!-- End Sidebar navigation -->
                </div>
                <!-- End Sidebar scroll-->
            </aside>
            <!-- -------------------------------------------------------------- -->
            <!-- End Left Sidebar - style you can find in sidebar.scss  -->
            <!-- -------------------------------------------------------------- -->
            <!-- -------------------------------------------------------------- -->
            <!-- Page wrapper  -->
            <!-- -------------------------------------------------------------- -->
            @yield('content')
            <!-- -------------------------------------------------------------- -->
            <!-- End Page wrapper  -->
            <!-- -------------------------------------------------------------- -->
        </div>
        <!-- -------------------------------------------------------------- -->
        <!-- Login box.scss -->
        <!-- -------------------------------------------------------------- -->
    </div>
    <!-- -------------------------------------------------------------- -->
    <!-- All Required js -->
    <!-- -------------------------------------------------------------- -->

    <script src="luna/src/assets/libs/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="luna/src/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

    <!-- -------------------------------------------------------------- -->
    <!-- apps -->
    <script src="luna/dist/js/app.min.js"></script>
    <script src="luna/dist/js/app.init.js"></script>
    <script src="luna/dist/js/app-style-switcher.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="luna/src/assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
    <script src="luna/src/assets/extra-libs/sparkline/sparkline.js"></script>
    <!--Wave Effects -->
    <script src="luna/dist/js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="luna/dist/js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="luna/dist/js/feather.min.js"></script>
    <script src="luna/dist/js/custom.min.js"></script>
    <!--This page plugins -->
    <!-- <script src="luna/dist/js/pages/contact/contact.js"></script> -->
    <!-- This page plugin js -->
    <!-- -------------------------------------------------------------- -->

    <script>
        $(".preloader").fadeOut();
        // ==============================================================
        // Login and Recover Password
        // ==============================================================
        $('#to-recover').on("click", function() {
            $("#loginform").slideUp();
            $("#recoverform").fadeIn();
        });

        function initModal() {
            $("[name='id']").val(0);

            $("[name='year1']").val('');
            $("[name='month1']").val('');
            $("[name='day1']").val('');

            $("[name='ComName']").val('');
            $("[name='RegNumber']").val('');

            $("[name='ComAddress']").val('');
            $("[name='ComEmail']").val('');

            $("[name='VIPName']").val('');
            $("[name='VIPAddress']").val('');
            $("[name='VIPEmail']").val('');

            $("[name='IssueName']").val('');
            $("[name='ReqMonth']").val('');

            $("[name='year2']").val('');
            $("[name='month2']").val('');
            $("[name='day2']").val('');

            $(".details").find('tr').each(function(index) {
                $(this).find('input').eq(0).val('');
                $(this).find('select').val(0.1);
                $(this).find('input').eq(1).val('');
                $(this).find('input').eq(2).val('');
                $(this).find('input').eq(3).val('');
            });


            $(".totalAmount").text(0);

            $(".ATotalAmount").text(0);
            $(".ACalculatedTotalAmount").text(0);

            $(".BTotalAmount").text(0);
            $(".BCalculatedTotalAmount").text(0);

            $("[name='subsidy']").val(0);
            $("[name='bankAddress']").val('');
            $("[name='remark']").val('');

            $(".calculatedTotalAmount").text(0);
        }

        function updateInv(id) {

            $.get('/get/' + id, function(res) {

                $("[name='id']").val(res[0]['id']);
                $("[name='status']").val(res[0]['status']);

                見積書日付 = res[0]['見積書日付'].split('-');
                $("[name='year1']").val(見積書日付[0]);
                $("[name='month1']").val(見積書日付[1]);
                $("[name='day1']").val(見積書日付[2]);

                請求書日付 = res[0]['請求書日付'].split('-');
                $("[name='year2']").val(請求書日付[0]);
                $("[name='month2']").val(請求書日付[1]);
                $("[name='day2']").val(請求書日付[2]);

                納品書日付 = res[0]['納品書日付'].split('-');
                $("[name='year3']").val(納品書日付[0]);
                $("[name='month3']").val(納品書日付[1]);
                $("[name='day3']").val(納品書日付[2]);

                報告書日付 = res[0]['報告書日付'].split('-');
                $("[name='year4']").val(報告書日付[0]);
                $("[name='month4']").val(報告書日付[1]);
                $("[name='day4']").val(報告書日付[2]);

                $("[name='ComName']").val(res[0]['自社名']);
                $("[name='RegNumber']").val(res[0]['登録番号']);
                $("[name='RegNumber13']").val(res[0]['登録番号13']);

                $("[name='RepFamily']").val(res[0]['代表姓']);
                $("[name='RepName']").val(res[0]['代表名']);

                $("[name='ComAddress']").val(res[0]['自社住所']);
                $("[name='ComTEL']").val(res[0]['連絡先TEL']);
                $("[name='ComFAX']").val(res[0]['連絡先FAX']);
                $("[name='ComEmail']").val(res[0]['連絡先EMAIL']);

                $("[name='VIPName']").val(res[0]['お客様名']);
                $("[name='VIPAddress']").val(res[0]['お客様住所']);
                $("[name='VIPEmail']").val(res[0]['お客様連絡先']);

                $("[name='IssueName']").val(res[0]['案件名']);
                $("[name='ReqMonth']").val(res[0]['請求月']);

                支払い予定日 = res[0]['支払い予定日'].split('-');
                $("[name='year5']").val(支払い予定日[0]);
                $("[name='month5']").val(支払い予定日[1]);
                $("[name='day5']").val(支払い予定日[2]);

                取引詳細項目 = res[0]['取引詳細項目'];
                details = JSON.parse(取引詳細項目)
                contents = details['content'].split(',');
                costs = details['cost'].split(',');
                counts = details['count'].split(',');
                units = details['unit'].split(',');

                totalAmount = 0
                ATotalAmount = 0
                BTotalAmount = 0
                $(".details").find('tr').each(function(index) {

                    if (contents[index] != '') {

                        $(this).find('input').eq(0).val(contents[index]);
                        $(this).find('select').val(costs[index]);
                        $(this).find('input').eq(1).val(counts[index]);
                        $(this).find('input').eq(2).val(units[index]);

                        amount = counts[index] * units[index];
                        $(this).find('input').eq(3).val(amount);

                        var numericValue = parseFloat(amount);
                        if (!isNaN(numericValue)) {
                            totalAmount += amount;
                            if (costs[index] == 0.1) ATotalAmount += amount;
                            else BTotalAmount += amount;
                        }
                    }
                });

                totalAmount = totalAmount + ATotalAmount * 0.1 + BTotalAmount * 0.08
                totalAmount = Math.round(totalAmount * 100) / 100
                $(".totalAmount").text(totalAmount);

                $(".ATotalAmount").text(ATotalAmount);
                $(".ACalculatedTotalAmount").text(Math.round(ATotalAmount * 0.1 * 100) / 100);

                $(".BTotalAmount").text(BTotalAmount);
                $(".BCalculatedTotalAmount").text(Math.round(BTotalAmount * 0.08 * 100) / 100);

                $("[name='subsidy']").val(res[0]['備考補助金']);
                $("[name='conditions']").val(res[0]['諸項目']);
                $("[name='bankAddress']").val(res[0]['お振込先']);

                $("[name='remark1']").val(res[0]['備考1']);
                $("[name='remark2']").val(res[0]['備考2']);
                $("[name='remark3']").val(res[0]['備考3']);
                $("[name='remark4']").val(res[0]['備考4']);

                $(".calculatedTotalAmount").text(totalAmount + parseFloat(res[0]['備考補助金']));

            });

            $('#Sharemodel').modal('show');
        }

        var id = 0;

        function getDelId(arg) {
            id = arg;
            console.log('delete id:', id);
        }

        function deleteInv() {

            $.get('/del/' + id)
                .then(function(res) {
                    console.log(res)
                    window.location.href = '/home';
                })
                .fail(function(err) {
                    alert('予期しないエラー');
                })
        }

        function addInv(id) {

            $.get('/add/' + id)
                .then(function(res) {
                    console.log(res)
                    window.location.href = '/home';
                })
                .fail(function(err) {
                    alert('予期しないエラー');
                })
        }

        function calculate(ele) {
            tr = $(ele).parents('tr');
            // rate = tr.find('select').val();
            // console.log(rate);
            count = tr.find('input').eq(1).val()
            // console.log(count)
            unit = tr.find('input').eq(2).val()
            // console.log(unit)
            tr.find('input').eq(3).val(count * unit);



            var tbody = $(ele).parents('tbody');
            var totalAmount = 0;
            var ATotalAmount = 0;
            var BTotalAmount = 0;

            tbody.find('tr').each(function() {
                var inputValue = $(this).find('input').eq(3).val();
                console.log('inputValue', inputValue);

                var numericValue = parseFloat(inputValue);
                if (!isNaN(numericValue)) {
                    totalAmount += numericValue;
                    rate = $(this).find('select').val();
                    if (rate == 0.1) ATotalAmount += numericValue;
                    else BTotalAmount += numericValue;
                }
            });


            totalAmount = totalAmount + ATotalAmount * 0.1 + BTotalAmount * 0.08
            totalAmount = Math.round(totalAmount * 100) / 100
            $('.totalAmount').text(totalAmount);

            $(".ATotalAmount").text(ATotalAmount);
            $(".ACalculatedTotalAmount").text(Math.round(ATotalAmount * 0.1 * 100) / 100);

            $(".BTotalAmount").text(BTotalAmount);
            $(".BCalculatedTotalAmount").text(Math.round(BTotalAmount * 0.08 * 100) / 100);

            subsidy = $("[name='subsidy']").val();
            $('.calculatedTotalAmount').text(totalAmount + parseFloat(subsidy));

        }
    </script>
</body>

</html>