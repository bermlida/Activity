
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
                    <li class="{{ $tab == 'unrefund' ? 'active' : '' }}">
                        <a href="#unrefund" data-toggle="tab">
                            <i class="fa fa-times" aria-hidden="true"></i>
                            未退款
                        </a>
                    </li>
                    <li class="{{ $tab == 'refunded' ? 'active' : '' }}">
                        <a href="#refunded" data-toggle="tab">
                            <i class="fa fa-usd" aria-hidden="true"></i>
                            已退款
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
                                            <td colspan="3"></td>
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
                    <div class="tab-pane fade {{ $tab == 'unrefund' ? 'active in' : '' }}" id="unrefund">
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
                                    $unrefund_orders->setCollection(
                                        $unrefund_orders->getCollection()->load([
                                            'user.account',
                                            'transactions' => function ($query) {
                                                $query->where('status', 1);
                                            }
                                        ])
                                    );
                                @endphp
                                @foreach ($unrefund_orders as $key => $order)
                                    <tr>
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
                                            <td colspan="3"></td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="col-xs-12 text-center">
                            {!!
                                $unrefund_orders
                                    ->appends($url_query)
                                    ->appends('tab', 'unrefund')
                                    ->links()
                            !!}
                        </div>
                    </div>
                    <div class="tab-pane fade {{ $tab == 'refunded' ? 'active in' : '' }}" id="refunded">
                        <table class="table table-hover responsive-table">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>姓名</th>
                                    <th>電子郵件</th>
                                    <th>手機</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($refunded_orders as $key => $order)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $order->user->name }}</td>
                                        <td>{{ $order->user->account->email }}</td>
                                        <td>{{ $order->user->mobile_phone }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="col-xs-12 text-center">
                            {!! 
                                $refunded_orders
                                    ->appends($url_query)
                                    ->appends('tab', 'refunded')
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