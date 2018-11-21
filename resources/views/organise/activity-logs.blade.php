
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
                    活動日誌
                    <a class="btn btn-default" href="{{ route('organise::activity::log::create', [$activity]) }}" role="button">
                        <i class="glyphicon glyphicon-plus" aria-hidden="true"></i>
                        新增日誌
                    </a>
                </h1>
            </div>
        </div>
        <!-- /.row -->

        <!-- Activity Logs -->
        <div class="row">
            <div class="col-xs-12">
                <ul id="myTab" class="nav nav-tabs nav-justified">
                    <li class="{{ $tab == 'published' ? 'active' : '' }}">
                        <a href="#published" data-toggle="tab">
                            <i class="fa fa-check-square-o" aria-hidden="true"></i>
                            已發布
                        </a>
                    </li>
                    <li class="{{ $tab == 'draft' ? 'active' : '' }}">
                        <a href="#draft" data-toggle="tab">
                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                            草稿
                        </a>
                    </li>
                </ul>
                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade {{ $tab == 'published' ? 'active in' : '' }}" id="published">
                        <table class="table table-hover responsive-table">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>標題</th>
                                    <th>功能</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($published_logs as $key => $log)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $log->title }}</td>
                                        <td>
                                            <button type="button" class="btn btn-danger" onclick="update('{{ route('organise::activity::log::cancel-publish', [$log->activity, $log]) }}')">
                                                <i class="fa fa-undo" aria-hidden="true"></i>
                                                取消發布
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="col-xs-12 text-center">
                            {!!
                                $published_logs
                                    ->appends($url_query)
                                    ->appends('tab', 'published')
                                    ->links()
                            !!}
                        </div>
                    </div>
                    <div class="tab-pane fade {{ $tab == 'draft' ? 'active in' : '' }}" id="draft">
                        <table class="table table-hover responsive-table">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>標題</th>
                                    <th>功能</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($draft_logs as $key => $log)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $log->title }}</td>
                                        <td>
                                            <a class="btn btn-default" href="{{ route('organise::activity::log::modify', [$log->activity, $log]) }}"  role="button">
                                                編輯
                                            </a>
                                            <button type="button" class="btn btn-primary" onclick="update('{{ route('organise::activity::log::publish', [$log->activity, $log]) }}')">
                                                <i class="fa fa-check" aria-hidden="true"></i>
                                                發布
                                            </button>
                                            <button type="button" class="btn btn-danger" onclick="remove('{{ route('organise::activity::log::delete', [$log->activity, $log]) }}')">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                                刪除
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="col-xs-12 text-center">
                            {!! 
                                $draft_logs
                                    ->appends($url_query)
                                    ->appends('tab', 'draft')
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
                        window.location.href = "{{
                            route('organise::activity::log::list', [$activity])
                        }}";
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