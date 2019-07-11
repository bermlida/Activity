
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
                @include('partials.alert-message')

                <h1 class="page-header">參加的活動</h1>
            </div>
        </div>
        <!-- /.row -->

        <!-- Participate Records Tabs -->
        <div class="row">
            <div class="col-xs-12">
                <ul id="myTab" class="nav nav-tabs nav-justified">
                    <li class="{{ $tab == 'registered' ? 'active' : '' }}">
                        <a href="#registered" data-toggle="tab">
                            <i class="fa fa-tree"></i>
                            已報名
                        </a>
                    </li>
                    <li class="{{ $tab == 'undone' ? 'active' : '' }}">
                        <a href="#undone" data-toggle="tab">
                            <i class="fa fa-car"></i>
                            未完成
                        </a>
                    </li>
                    <li class="{{ $tab == 'cancelled' ? 'active' : '' }}">
                        <a href="#cancelled" data-toggle="tab">
                            <i class="fa fa-exclamation-triangle"></i> 
                            已取消
                        </a>
                    </li>
                </ul>
                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade {{ $tab == 'registered' ? 'active in' : '' }}" id="registered">
                        <table class="table table-hover responsive-table">
                            <thead>
                            <tr>
                                <th>No.</th>
                                <th>活動名稱</th>
                                <th>活動時間起迄</th>
                                <th>活動地點</th>
                                <th>報名資訊</th>
                                <th>狀態</th>
                                <th>報到狀態</th>
                                <th>取消報名</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($registered_activities as $key => $activity)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $activity->name }}</td>
                                        <td>
                                            @if ($activity->start_time->toDateString() != $activity->end_time->toDateString())
                                                {{ $activity->start_time->toDateString() }}
                                                 ~ 
                                                {{ $activity->end_time->toDateString() }}
                                            @else
                                                {{ $activity->start_time->toDateString() }}
                                            @endif
                                        </td>
                                        <td>{{ $activity->venue }}</td>
                                        <td>
                                            <a class="btn btn-info" href="{{ route('participate::record::view', ['record' => $activity->pivot->serial_number]) }}">
                                                檢視
                                            </a>
                                        </td>
                                        <td>已完成報名</td>
                                        <td>
                                            @if ($activity->pivot->register_status == 0)
                                                <a class="btn btn-default" href="{{ route('participate::record::register-certificate', ['record' => $activity->pivot->serial_number]) }}">
                                                    顯示報到憑證
                                                </a>
                                            @else
                                                已完成報到
                                            @endif
                                        </td>
                                        <td>
                                            <a class="btn btn-danger" href="{{ route('participate::record::cancel::confirm', ['serial_number' => $activity->pivot->serial_number]) }}">
                                                取消
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="col-xs-12 text-center">
                            {!!
                                $registered_activities
                                    ->appends($url_query)
                                    ->appends('tab', 'registered')
                                    ->links()
                            !!}
                        </div>
                    </div>
                    <div class="tab-pane fade {{ $tab == 'undone' ? 'active in' : '' }}" id="undone">
                        <table class="table table-hover responsive-table">
                            <thead>
                            <tr>
                                <th>No.</th>
                                <th>活動名稱</th>
                                <th>活動時間起迄</th>
                                <th>活動地點</th>
                                <th>報名資訊</th>
                                <th>狀態</th>
                                <th>取消報名</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($undone_activities as $key => $activity)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $activity->name }}</td>
                                    <td>
                                    @if ($activity->start_time->toDateString() != $activity->end_time->toDateString())
                                        {{ $activity->start_time->toDateString() }}
                                        ~ 
                                        {{ $activity->end_time->toDateString() }}
                                    @else
                                        {{ $activity->start_time->toDateString() }}
                                    @endif
                                    </td>
                                    <td>{{ $activity->venue }}</td>
                                    <td>
                                        <a class="btn btn-info" href="{{ route('participate::record::view', ['serial_number' => $activity->pivot->serial_number]) }}">
                                            檢視
                                        </a>
                                    </td>
                                    <td>
                                        @php
                                            $no_interfacing = $activity->pivot->transactions()->get();

                                            $interfacing_cashflow_error = $activity->pivot
                                                ->transactions()
                                                ->whereNull('payment_info')
                                                ->whereNull('payment_result')
                                                ->get();
                                        @endphp
                                        @if ($carbon->now()->between($activity->apply_start_time, $activity->apply_end_time))
                                            @if (count($no_interfacing) == 0 || count($interfacing_cashflow_error) > 0)
                                                <a href="{{ route('sign-up::apply::edit', ['activity' => $activity->id, 'serial_number' => $activity->pivot->serial_number]) }}">
                                                    報名未完成
                                                </a>
                                            @else
                                                報名未完成 - 未繳款
                                            @endif
                                        @else
                                            @if ($carbon->now()->lessThan($activity->apply_start_time))
                                                活動尚未開放報名
                                            @elseif ($carbon->now()->greaterThan($activity->apply_end_time))
                                                活動已截止報名
                                            @else
                                                活動無法報名
                                            @endif
                                        @endif
                                    </td>
                                    <td>
                                        <a class="btn btn-danger" href="{{ route('participate::record::cancel::confirm', ['serial_number' => $activity->pivot->serial_number]) }}">
                                            取消
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="col-xs-12 text-center">
                            {!! 
                                $undone_activities
                                    ->appends($url_query)
                                    ->appends('tab', 'undone')
                                    ->links()
                            !!}
                        </div>
                    </div>
                    <div class="tab-pane fade {{ $tab == 'cancelled' ? 'active in' : '' }}" id="cancelled">
                        <table class="table table-hover responsive-table">
                            <thead>
                            <tr>
                                <th>No.</th>
                                <th>活動名稱</th>
                                <th>活動時間起迄</th>
                                <th>活動地點</th>
                                <th>報名資訊</th>
                                <th>退款</th>
                                <th>狀態</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($cancelled_activities as $key => $activity)
                                    <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $activity->name }}</td>
                                    <td>
                                        @if ($activity->start_time->toDateString() != $activity->end_time->toDateString())
                                            {{ $activity->start_time->toDateString() }}
                                             ~ 
                                            {{ $activity->end_time->toDateString() }}
                                        @else
                                            {{ $activity->start_time->toDateString() }}
                                        @endif
                                    </td>
                                    <td>{{ $activity->venue }}</td>
                                    <td>
                                        <a class="btn btn-info" href="{{ route('participate::record::view', ['serial_number' => $activity->pivot->serial_number]) }}">
                                            檢視
                                        </a>
                                    </td>
                                    <td>
                                        @if ($activity->pivot->transactions()->whereNotNull('payment_result')->ofStatus(-1)->count() > 0)                                           
                                            @if (explode('_', $activity->pivot->transactions()->whereNotNull('payment_result')->where('status', -1)->first()->payment_result->PaymentType)[0] != 'Credit')
                                                <a class="btn btn-info" href="{{ route('participate::record::refund::confirm', ['serial_number' => $activity->pivot->serial_number]) }}">
                                                    退款設定
                                                </a>
                                            @else
                                                信用卡將以退刷方式進行退款
                                            @endif
                                        @else
                                            &nbsp;
                                        @endif
                                    </td>
                                    <td>已取消報名</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="col-xs-12 text-center">
                            {!!
                                $cancelled_activities
                                    ->appends($url_query)
                                    ->appends('tab', 'cancelled')
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
                @include('partials.copyright-notice')
            </div>
        </footer>

    </div>
    <!-- /.container -->

@endsection

@section('script')

    <!-- ReStable JavaScript -->
    <script src="{{ asset('components/ReStable/jquery.restable.min.js') }}"></script>

    <script>

        function cancel(target)
        {
            var url = target;

            jQuery.ajax({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                url: url,
                type: "PUT",
                dataType: "json"
            }).done(
                function (data) {
                    alert(data.message);

                    if (data.result) {
                        window.location.href = "{{ route('participate::record::list') }}";
                    }
                }
            );
        }

        $(document).ready(function () {

            $('.responsive-table').ReStable({
                keepHtml : true,
                rowHeaders : false,
                maxWidth: 992
            });

        });

    </script>

@endsection