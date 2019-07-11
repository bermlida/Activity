
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
                <h1 class="page-header">
                    舉辦的活動
                    <a class="btn btn-default" href="{{ route('organise::activity::create') }}">
                        <i class="glyphicon glyphicon-plus" aria-hidden="true"></i>
                        新增活動
                    </a>
                </h1>
            </div>
        </div>
        <!-- /.row -->

        <!-- Organise Activities -->
        <div class="row">
            <div class="col-xs-12">
                <ul id="myTab" class="nav nav-tabs nav-justified">
                    <li class="{{ $tab == 'launched' ? 'active' : '' }}">
                        <a href="#launched" data-toggle="tab">
                            <i class="fa fa-calendar-plus-o" aria-hidden="true"></i>
                            上架
                        </a>
                    </li>
                    <li class="{{ $tab == 'discontinued' ? 'active' : '' }}">
                        <a href="#discontinued" data-toggle="tab">
                            <i class="fa fa-calendar-times-o" aria-hidden="true"></i>
                            下架
                        </a>
                    </li>
                    <li class="{{ $tab == 'drafting' ? 'active' : '' }}">
                        <a href="#drafting" data-toggle="tab">
                            <i class="fa fa-calendar-minus-o" aria-hidden="true"></i>
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
                    <div class="tab-pane fade {{ $tab == 'launched' ? 'active in' : '' }}" id="launched">
                        <table class="table table-hover responsive-table">
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
                                @foreach ($launched_activities as $key => $activity)
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
                                            <a class="btn btn-primary" href="{{ route('organise::activity::info', [$activity]) }}" role="button">
                                                管理
                                            </a>
                                            <a class="btn btn-default" href="{{ route('organise::activity::preview', [$activity]) }}" role="button">
                                                預覽
                                            </a>
                                            <button type="button" class="btn btn-danger" onclick="update('{{ route('organise::activity::discontinue', [$activity]) }}')">
                                                <i class="fa fa-arrow-down" aria-hidden="true"></i>
                                                下架
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="col-xs-12 text-center">
                            {!!
                                $launched_activities
                                    ->appends($url_query)
                                    ->appends('tab', 'launched')
                                    ->links()
                            !!}
                        </div>
                    </div>
                    <div class="tab-pane fade {{ $tab == 'discontinued' ? 'active in' : '' }}" id="discontinued">
                        <table class="table table-hover responsive-table">
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
                                @foreach ($discontinued_activities as $key => $activity)
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
                                            <a class="btn btn-primary" href="{{ route('organise::activity::info', [$activity]) }}" role="button">
                                                管理
                                            </a>
                                            <a class="btn btn-default" href="{{ route('organise::activity::preview', [$activity]) }}" role="button">
                                                預覽
                                            </a>
                                            <button type="button" class="btn btn-success" onclick="update('{{ route('organise::activity::launch', [$activity]) }}')">
                                                <i class="fa fa-arrow-up" aria-hidden="true"></i>
                                                上架
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="col-xs-12 text-center">
                            {!!
                                $discontinued_activities
                                    ->appends($url_query)
                                    ->appends('tab', 'discontinued')
                                    ->links()
                            !!}
                        </div>
                    </div>
                    <div class="tab-pane fade {{ $tab == 'drafting' ? 'active in' : '' }}" id="drafting">
                        <table class="table table-hover responsive-table">
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
                                @foreach ($drafting_activities as $key => $activity)
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
                                            <a class="btn btn-primary" href="{{ route('organise::activity::info', [$activity]) }}" role="button">
                                                管理
                                            </a>
                                            <a class="btn btn-default" href="{{ route('organise::activity::preview', [$activity]) }}" role="button">
                                                預覽
                                            </a>
                                            <button type="button" class="btn btn-default" onclick="update('{{ route('organise::activity::publish', [$activity]) }}')">
                                                發布
                                            </button>
                                            <button type="button" class="btn btn-danger" onclick="remove('{{ route('organise::activity::delete', [$activity]) }}')">
                                                刪除
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="col-xs-12 text-center">
                            {!! 
                                $drafting_activities
                                    ->appends($url_query)
                                    ->appends('tab', 'drafting')
                                    ->links()
                            !!}
                        </div>
                    </div>
                    <div class="tab-pane fade {{ $tab == 'ended' ? 'active in' : '' }}" id="ended">
                        <table class="table table-hover responsive-table">
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
                                @foreach ($ended_activities as $key => $activity)
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
                                            <a class="btn btn-primary" href="{{ route('organise::activity::info', [$activity]) }}" role="button">
                                                管理
                                            </a>
                                            <a class="btn btn-success" href="{{ route('visit::activity', [$activity]) }}" role="button">
                                                預覽
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="col-xs-12 text-center">
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

        function update(target)
        {
            execAjax(target, "PUT")
        }

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
                maxWidth: 992
            });

        });

    </script>

@endsection