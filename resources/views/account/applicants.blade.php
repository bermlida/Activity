
@inject('carbon', 'Carbon\Carbon')

@extends('layouts.main')

@section('content')

    <!-- Page Content -->
    <div class="container">

        <!-- Page Heading/Breadcrumbs -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    報名清單
                    <small></small>
                </h1>
            </div>
        </div>
        <!-- /.row -->

        <!-- Content Row -->
        <div class="row">
            <div class="col-lg-12">
                <ul id="myTab" class="nav nav-tabs nav-justified">
                    <li class="{{ $tab == 'completed' ? 'active' : '' }}">
                        <a href="#completed" data-toggle="tab">
                            <i class="fa fa-spinner" aria-hidden="true"></i>
                            已完成
                        </a>
                    </li>
                    <li class="{{ $tab == 'undone' ? 'active' : '' }}">
                        <a href="#undone" data-toggle="tab">
                            <i class="fa fa-file" aria-hidden="true"></i>
                            未完成
                        </a>
                    </li>
                    <li class="{{ $tab == 'unpaid' ? 'active' : '' }}">
                        <a href="#unpaid" data-toggle="tab">
                            <i class="fa fa-calendar-check-o" aria-hidden="true"></i>
                            未付款
                        </a>
                    </li>
                </ul>
                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade {{ $tab == 'completed' ? 'active in' : '' }}" id="completed">
                        <table class="table table-hover">
                            <caption></caption>
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>姓名</th>
                                    <th>電子郵件</th>
                                    <th>手機</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($completed_orders as $key => $order)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $order->user->name }}</td>
                                        <td>{{ $order->user->account->first()->email }}</td>
                                        <td>{{ $order->user->mobile_phone }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="col-md-12 text-center">
                            {!!
                                $completed_orders
                                    ->appends($url_query)
                                    ->appends('tab', 'completed')
                                    ->links()
                            !!}
                        </div>
                    </div>
                    <div class="tab-pane fade {{ $tab == 'undone' ? 'active in' : '' }}" id="undone">
                        <table class="table table-hover">
                            <caption></caption>
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>姓名</th>
                                    <th>電子郵件</th>
                                    <th>手機</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($undone_orders as $key => $order)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $order->user->name }}</td>
                                        <td>{{ $order->user->account->first()->email }}</td>
                                        <td>{{ $order->user->mobile_phone }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="col-md-12 text-center">
                            {!! 
                                $undone_orders
                                    ->appends($url_query)
                                    ->appends('tab', 'undone')
                                    ->links()
                            !!}
                        </div>
                    </div>
                    <div class="tab-pane fade {{ $tab == 'unpaid' ? 'active in' : '' }}" id="unpaid">
                        <table class="table table-hover">
                            <caption></caption>
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>姓名</th>
                                    <th>電子郵件</th>
                                    <th>手機</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($unpaid_orders as $key => $order)
                                    <tr>
                                        <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $order->user->name }}</td>
                                        <td>{{ $order->user->account->first()->email }}</td>
                                        <td>{{ $order->user->mobile_phone }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="col-md-12 text-center">
                            {!!
                                $unpaid_orders
                                    ->appends($url_query)
                                    ->appends('tab', 'unpaid')
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

    </script>

@endsection