
@inject('carbon', 'Carbon\Carbon')

@extends('layouts.main')

@section('content')

    <!-- Page Content -->
    <div class="container">

        <!-- Page Heading/Breadcrumbs -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    活動報名
                    <small>確認付款資料</small>
                </h1>
            </div>
        </div>
        <!-- /.row -->

        <div class="row">
            <div class="col-lg-12">
                <div class="panel-group" id="accordion">
                    <!-- /.panel -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                報名資訊
                            </h4>
                        </div>
                        <div class="panel-body">
                            <p>活動名稱：{{ $activity->name }}</p>
                            <p>活動時間：
                                @if ($carbon->parse($activity->start_time)->toDateString() != $carbon->parse($activity->end_time)->toDateString())
                                    {{ $carbon->parse($activity->start_time)->toDateString() }}
                                     ~ 
                                    {{ $carbon->parse($activity->end_time)->toDateString() }}
                                @else
                                    {{ $carbon->parse($activity->start_time)->toDateString() }}
                                @endif
                            </p>
                            <p>活動地點：{{ $activity->venue }}</p>
                            <p>報名者姓名：{{ $user_profile->name }}</p>
                            <p>報名者電子郵件：{{ $user_account->email }}</p>
                            <p>報名者手機：{{ $user_profile->mobile_phone }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->

        <div class="row">
            <div class="col-lg-12">
                <div class="panel-group" id="accordion">
                    <!-- /.panel -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                付款資訊
                            </h4>
                        </div>
                        <div class="panel-body">
                            @if (isset($apply_fee))
                                <p>報名費用：{{ $apply_fee }}</p>
                            @endif
                            @if (isset($sponsorship_amount))
                                <p>贊助金額：{{ $sponsorship_amount }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->

        <div class="row">
            <div class="col-md-6 col-xs-6">
                <a href="" class="btn btn-danger">
                    <i class="glyphicon glyphicon-pencil"></i>
                    上一步
                </a>
            </div>
            <div class="col-md-6 col-xs-6">
                <a href="javascript::void(0)" class="btn btn-primary" onClick="$('#__paymentButton').click();">
                    <i class="glyphicon glyphicon-usd"></i>
                    付款
                </a>
            </div>
            {!! $post_form !!}
        </div>
                        

        <hr>

        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright &copy; Your Website 2014</p>
                </div>
            </div>
        </footer>

    </div>
    <!-- /.container -->

@endsection