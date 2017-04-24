
@inject('carbon', 'Carbon\Carbon')

@extends('layouts.main')

@section('content')

    <!-- Page Content -->
    <div class="container">

        <!-- Page Heading/Breadcrumbs -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">舉辦的活動
                    <small></small>
                    <a class="btn btn-default" href="{{ route('organise::activity::create') }}">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        新增活動
                    </a>
                </h1>
            </div>
        </div>
        <!-- /.row -->

        <!-- Content Row -->
        <div class="row">
            <div class="col-lg-12">
                <ul id="myTab" class="nav nav-tabs nav-justified">
                    <li class="{{ $tab == 'going' ? 'active' : '' }}">
                        <a href="#going" data-toggle="tab">
                            <i class="fa fa-spinner" aria-hidden="true"></i>
                            進行中
                        </a>
                    </li>
                    <li class="{{ $tab == 'draft' ? 'active' : '' }}">
                        <a href="#draft" data-toggle="tab">
                            <i class="fa fa-file" aria-hidden="true"></i>
                            草稿
                        </a>
                    </li>
                    <li class="{{ $tab == 'ended' ? 'active' : '' }}">
                        <a href="#ended" data-toggle="tab">
                            <i class="fa fa-calendar-check-o" aria-hidden="true"></i>
                            已結束
                        </a>
                    </li>
                </ul>
                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade {{ $tab == 'going' ? 'active in' : '' }}" id="going">
                        <table class="table table-hover">
                            <caption></caption>
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>活動名稱</th>
                                    <th>活動時間</th>
                                    <th>活動地點</th>
                                    <th>功能</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($going_activities as $key => $activity)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $activity->name }}</td>
                                        <td>
                                            @if ($activity->start_time->toDateString() != $activity->end_time->toDateString())
                                                {{ $activity->start_time->format('Y-m-d H:i') }}
                                                 ~ 
                                                {{ $activity->end_time->format('Y-m-d H:i') }}
                                            @else
                                                {{ $activity->start_time->toDateString() }}
                                                {{ $activity->start_time->format('H:i') }}
                                                 ~ 
                                                {{ $activity->end_time->format('H:i') }}
                                            @endif
                                        </td>
                                        <td>{{ $activity->venue }}</td>
                                        <td>
                                            <a class="btn btn-info" href="{{ route('organise::activity::modify', ['activity' => $activity->id]) }}">
                                                變更
                                            </a>
                                            <a class="btn btn-info" href="{{ route('organise::activity::applicants', ['activity' => $activity->id]) }}">
                                                報名清單
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td>
                                            目前這裡沒有活動，不如開始辦一個吧 ! 
                                            <br><br><br>
                                            <a href="{{ route('organise::activity::create') }}">
                                                立刻新增活動
                                            </a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="col-md-12 text-center">
                            {!!
                                $going_activities
                                    ->appends($url_query)
                                    ->appends('tab', 'going')
                                    ->links()
                            !!}
                        </div>
                    </div>
                    <div class="tab-pane fade {{ $tab == 'draft' ? 'active in' : '' }}" id="draft">
                        <table class="table table-hover">
                            <caption></caption>
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>活動名稱</th>
                                    <th>活動時間</th>
                                    <th>活動地點</th>
                                    <th>功能</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse ($draft_activities as $key => $activity)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $activity->name }}</td>
                                    <td>
                                        @if ($activity->start_time->toDateString() != $activity->end_time->toDateString())
                                            {{ $activity->start_time->format('Y-m-d H:i') }}
                                             ~ 
                                            {{ $activity->end_time->format('Y-m-d H:i') }}
                                        @else
                                                {{ $activity->start_time->toDateString() }}
                                                {{ $activity->start_time->format('H:i') }}
                                                 ~ 
                                                {{ $activity->end_time->format('H:i') }}
                                        @endif
                                    </td>
                                    <td>{{ $activity->venue }}</td>
                                    <td>
                                        <a class="btn btn-info" href="{{ route('organise::activity::modify', ['activity' => $activity->id]) }}">
                                            編輯
                                        </a>
                                        <button type="button" class="btn btn-danger" onclick="remove('{{ route('organise::activity::delete', ['activity' => $activity->id]) }}')">
                                            刪除
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td>
                                        目前這裡沒有活動，不如開始辦一個吧 ! 
                                        <br><br><br>
                                        <a href="{{ route('organise::activity::create') }}">
                                            立刻新增活動
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                        <div class="col-md-12 text-center">
                            {!! 
                                $draft_activities
                                    ->appends($url_query)
                                    ->appends('tab', 'draft')
                                    ->links()
                            !!}
                        </div>
                    </div>
                    <div class="tab-pane fade {{ $tab == 'ended' ? 'active in' : '' }}" id="ended">
                        <table class="table table-hover">
                            <caption></caption>
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>活動名稱</th>
                                    <th>活動時間</th>
                                    <th>活動地點</th>
                                    <th>功能</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($ended_activities as $key => $activity)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $activity->name }}</td>
                                        <td>
                                            @if ($activity->start_time->toDateString() != $activity->end_time->toDateString())
                                                {{ $activity->start_time->format('Y-m-d H:i') }}
                                                 ~ 
                                                {{ $activity->end_time->format('Y-m-d H:i') }}
                                            @else
                                                {{ $activity->start_time->toDateString() }}
                                                {{ $activity->start_time->format('H:i') }}
                                                 ~ 
                                                {{ $activity->end_time->format('H:i') }}
                                            @endif
                                        </td>
                                        <td>{{ $activity->venue }}</td>
                                        <td>
                                            <a class="btn btn-info" href="{{ route('organise::activity::applicants', ['activity' => $activity->id]) }}">
                                                報名清單
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td>
                                            目前這裡沒有活動，不如開始辦一個吧 ! 
                                            <br><br><br>
                                            <a href="{{ route('organise::activity::create') }}">
                                                立刻新增活動
                                            </a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="col-md-12 text-center">
                            {!!
                                $ended_activities
                                    ->appends($url_query)
                                    ->appends('tab', 'ended')
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