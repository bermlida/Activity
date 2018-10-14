
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
                    <li class="{{ $tab == 'launched' ? 'active' : '' }}">
                        <a href="#launched" data-toggle="tab">
                            <i class="fa fa-envelope-open" aria-hidden="true"></i>
                            上架中
                        </a>
                    </li>
                    <li class="{{ $tab == 'postponed' ? 'active' : '' }}">
                        <a href="#postponed" data-toggle="tab">
                            <i class="fa fa-paper-plane " aria-hidden="true"></i>
                            已下架
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
                    <div class="tab-pane fade {{ $tab == 'launched' ? 'active in' : '' }}" id="launched">
                        <table class="table table-hover responsive-table">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>標題</th>
                                    <th>功能</th>
                                </tr>
                            </thead>
                            <tbody>
                                @each(
                                    'partials.activity-log-row',
                                    $launched_logs,
                                    'log',
                                    'partials.activity-log-empty'
                                )
                            </tbody>
                        </table>
                        <div class="col-xs-12 text-center">
                            {!!
                                $launched_logs
                                    ->appends($url_query)
                                    ->appends('tab', 'launched')
                                    ->links()
                            !!}
                        </div>
                    </div>
                    <div class="tab-pane fade {{ $tab == 'postponed' ? 'active in' : '' }}" id="postponed">
                        <table class="table table-hover responsive-table">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>標題</th>
                                    <th>功能</th>
                                </tr>
                            </thead>
                            <tbody>
                                @each(
                                    'partials.activity-log-row',
                                    $postponed_logs,
                                    'log',
                                    'partials.activity-log-empty'
                                )
                            </tbody>
                        </table>
                        <div class="col-xs-12 text-center">
                            {!!
                                $postponed_logs
                                    ->appends($url_query)
                                    ->appends('tab', 'postponed')
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
                                @each(
                                    'partials.activity-log-row',
                                    $draft_logs,
                                    'log',
                                    'partials.activity-log-empty'
                                )
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