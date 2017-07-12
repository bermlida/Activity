
@inject('carbon', 'Carbon\Carbon')

@extends('layouts.main')

@section('content')

    <!-- Page Content -->
    <div class="container">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    參加的活動
                    <small></small>
                </h1>
            </div>
        </div>
        <!-- /.row -->

        <!-- Service Tabs -->
        <div class="row">
            <div class="col-lg-12">
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
                    <li class="">
                        <a href="#service-four" data-toggle="tab">
                            <i class="fa fa-money"></i>
                            已退款
                        </a>
                    </li>
                </ul>
                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade {{ $tab == 'registered' ? 'active in' : '' }}" id="registered">
                        <table class="table table-hover">
                            <caption></caption>
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
                            @forelse ($registered_activities as $key => $activity)
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
                                <td>已完成報名</td>
                                <td>
                                    <a class="btn btn-danger" href="{{ route('participate::record::cancel::confirm', ['serial_number' => $activity->pivot->serial_number]) }}">
                                        取消
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td>
                                    目前你還沒有參加任何活動，不如就此開始吧 ! 
                                    <br><br><br>
                                    <a href="{{ route('visit::activities') }}">
                                        開始找活動
                                    </a>
                                </td>
                            </tr>
                            @endforelse
                            </tbody>
                        </table>
                        <div class="col-md-12 text-center">
                            {!!
                                $registered_activities
                                    ->appends($url_query)
                                    ->appends('tab', 'registered')
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
                                    @if (count($no_interfacing) == 0 || count($interfacing_cashflow_error) > 0)
                                        <a href="{{ route('sign-up::apply::edit', ['activity' => $activity->id, 'serial_number' => $activity->pivot->serial_number]) }}">
                                            報名未完成
                                        </a>
                                    @else
                                        報名未完成 - 未繳款
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
                        <div class="col-md-12 text-center">
                            {!! 
                                $undone_activities
                                    ->appends($url_query)
                                    ->appends('tab', 'undone')
                                    ->links()
                            !!}
                        </div>
                    </div>
                    <div class="tab-pane fade {{ $tab == 'cancelled' ? 'active in' : '' }}" id="cancelled">
                        <table class="table table-hover">
                            <caption></caption>
                            <thead>
                            <tr>
                                <th>No.</th>
                                <th>活動名稱</th>
                                <th>活動時間起迄</th>
                                <th>活動地點</th>
                                <th>報名資訊</th>
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
                                    @if ($activity->pivot->transactions()->whereNotNull('payment_result')->where('apply_fee', '>', 0)->count() > 0)
                                        <a class="btn btn-info" href="{{ route('participate::record::refund::confirm', ['serial_number' => $activity->pivot->serial_number]) }}">
                                            退款設定
                                        </a>
                                    @endif
                                </td>
                                <td>已取消報名</td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="col-md-12 text-center">
                            {!!
                                $cancelled_activities
                                    ->appends($url_query)
                                    ->appends('tab', 'cancelled')
                                    ->links()
                            !!}
                        </div>
                    </div>
                    <div class="tab-pane fade" id="service-four">
                        <h4>Service Four</h4>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quae repudiandae fugiat illo cupiditate excepturi esse officiis consectetur, laudantium qui voluptatem. Ad necessitatibus velit, accusantium expedita debitis impedit rerum totam id. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Natus quibusdam recusandae illum, nesciunt, architecto, saepe facere, voluptas eum incidunt dolores magni itaque autem neque velit in. At quia quaerat asperiores.</p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quae repudiandae fugiat illo cupiditate excepturi esse officiis consectetur, laudantium qui voluptatem. Ad necessitatibus velit, accusantium expedita debitis impedit rerum totam id. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Natus quibusdam recusandae illum, nesciunt, architecto, saepe facere, voluptas eum incidunt dolores magni itaque autem neque velit in. At quia quaerat asperiores.</p>
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

    </script>

@endsection