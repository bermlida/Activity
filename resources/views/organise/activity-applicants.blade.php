
@inject('carbon', 'Carbon\Carbon')

@extends('layouts.main')

@section('style')
    
    <!-- ReStable CSS -->
    <link href="{{ asset('components/ReStable/jquery.restable.min.css') }}" rel="stylesheet">

@endsection

@section('content')

    <!-- Page Content -->
    <div class="container">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-xs-12">
                <h1 class="page-header">報名清單</h1>
            </div>
        </div>
        <!-- /.row -->

        <!-- Applicants -->
        <div class="row">
            <div class="col-xs-12">
                <ul id="myTab" class="nav nav-tabs nav-justified">
                    <li class="{{ $tab == 'completed' ? 'active' : '' }}">
                        <a href="#completed" data-toggle="tab">
                            <i class="fa fa-check" aria-hidden="true"></i>
                            已完成
                        </a>
                    </li>
                    <li class="{{ $tab == 'paid' ? 'active' : '' }}">
                        <a href="#paid" data-toggle="tab">
                            <i class="fa fa-usd" aria-hidden="true"></i>
                            已付款
                        </a>
                    </li>
                    <li class="{{ $tab == 'refunding' ? 'active' : '' }}">
                        <a href="#refunding" data-toggle="tab">
                            <i class="fa fa-times" aria-hidden="true"></i>
                            須退款
                        </a>
                    </li>
                </ul>
                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade {{ $tab == 'completed' ? 'active in' : '' }}" id="completed">
                        <table class="table table-hover responsive-table">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>姓名</th>
                                    <th>電子郵件</th>
                                    <th>手機</th>
                                    <th>報名費用</th>
                                    <th>贊助金額</th>
                                    <th>支付費用總額</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $completed_orders->setCollection(
                                        $completed_orders->getCollection()->load([
                                            'user.account',
                                            'transactions' => function ($query) {
                                                $query->where('status', 1);
                                            }
                                        ])
                                    );
                                @endphp
                                @foreach ($completed_orders as $key => $order)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $order->user->name }}</td>
                                        <td>{{ $order->user->account->email }}</td>
                                        <td>{{ $order->user->mobile_phone }}</td>
                                        @if (!is_null($transaction = $order->transactions->first()))
                                            <td>{{ $transaction->apply_fee }}</td>
                                            <td>{{ $transaction->sponsorship_amount }}</td>
                                            <td>{{ $transaction->apply_fee + $transaction->sponsorship_amount }}</td>
                                        @else
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="col-xs-12 text-center">
                            {!!
                                $completed_orders
                                    ->appends($url_query)
                                    ->appends('tab', 'completed')
                                    ->links()
                            !!}
                        </div>
                    </div>
                    <div class="tab-pane fade {{ $tab == 'paid' ? 'active in' : '' }}" id="paid">
                        <table class="table table-hover responsive-table">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>姓名</th>
                                    <th>電子郵件</th>
                                    <th>手機</th>
                                    <th>報名費用</th>
                                    <th>贊助金額</th>
                                    <th>支付費用總額</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $paid_orders->setCollection(
                                        $paid_orders->getCollection()->load([
                                            'user.account',
                                            'transactions' => function ($query) {
                                                $query->where('status', 1);
                                            }
                                        ])
                                    );
                                @endphp
                                @foreach ($paid_orders as $key => $order)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $order->user->name }}</td>
                                        <td>{{ $order->user->account->email }}</td>
                                        <td>{{ $order->user->mobile_phone }}</td>
                                        @if (!is_null($transaction = $order->transactions->first()))
                                            <td>{{ $transaction->apply_fee }}</td>
                                            <td>{{ $transaction->sponsorship_amount }}</td>
                                            <td>{{ $transaction->apply_fee + $transaction->sponsorship_amount }}</td>
                                        @else
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="col-xs-12 text-center">
                            {!!
                                $paid_orders
                                    ->appends($url_query)
                                    ->appends('tab', 'paid')
                                    ->links()
                            !!}
                        </div>
                    </div>
                    <div class="tab-pane fade {{ $tab == 'refunding' ? 'active in' : '' }}" id="refunding">
                        <table class="table table-hover responsive-table">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>姓名</th>
                                    <th>電子郵件</th>
                                    <th>手機</th>
                                    <th>報名費用</th>
                                    <th>贊助金額</th>
                                    <th>支付費用總額</th>
                                    <th>退款帳號</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $refunding_orders->setCollection(
                                        $refunding_orders->getCollection()->load([
                                            'user.account',
                                            'transactions' => function ($query) {
                                                $query
                                                    ->where('status', -1)
                                                    ->whereNotNull('payment_result');
                                            }
                                        ])
                                    );
                                @endphp
                                @foreach ($refunding_orders as $key => $order)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $order->user->name }}</td>
                                        <td>{{ $order->user->account->email }}</td>
                                        <td>{{ $order->user->mobile_phone }}</td>
                                        @if (!is_null($transaction = $order->transactions->first()))
                                            <td>{{ $transaction->apply_fee }}</td>
                                            <td>{{ $transaction->sponsorship_amount }}</td>
                                            <td>{{ $transaction->apply_fee + $transaction->sponsorship_amount }}</td>
                                            <td>
                                                @if (explode('_', $transaction->payment_result->PaymentType)[0] != 'Credit')
                                                    @if (!empty($transaction->financial_account->financial_institution_code . $transaction->financial_account->account_number))
                                                        {{ $transaction->financial_account->financial_institution_code }}
                                                        &nbsp;
                                                        {{ $transaction->financial_account->account_number }}
                                                    @else
                                                        請聯繫報名者填寫退款帳號以進行退款
                                                    @endif
                                                @else
                                                    信用卡將以退刷方式進行退款
                                                @endif
                                            </td>
                                        @else
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="col-xs-12 text-center">
                            {!! 
                                $refunding_orders
                                    ->appends($url_query)
                                    ->appends('tab', 'refunding')
                                    ->links()
                            !!}
                        </div>
                    </div>
                </div>
            </div>

            
        </div>
        <!-- /.row -->

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

@section('script')

    <!-- ReStable JavaScript -->
    <script src="{{ asset('components/ReStable/jquery.restable.min.js') }}"></script>

    <script>

        function remove(target)
        {
            execAjax(target, "DELETE")
        }

        function execAjax(url, method)
        {
            jQuery.ajax({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                url: url,
                type: method,
                dataType: "json"
            }).done(
                function (data) {
                    alert(data.message);

                    if (data.result) {
                        window.location.href = "{{ route('organise::activity::list') }}";
                    }
                }
            );
        }

        $(document).ready(function () {

            $('.responsive-table').ReStable({
                keepHtml : true,
                rowHeaders : false,
                maxWidth: 768
            });

        });

    </script>

@endsection