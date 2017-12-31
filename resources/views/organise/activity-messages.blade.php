
@inject('carbon', 'Carbon\Carbon')

@extends('layouts.main')

@section('content')

    <!-- Page Content -->
    <div class="container">

        <!-- Page Heading/Breadcrumbs -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">活動訊息
                    <small></small>
                    <a class="btn btn-default" href="{{ route('organise::activity::message::create', [$activity]) }}" role="button">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        新增訊息
                    </a>
                </h1>
            </div>
        </div>
        <!-- /.row -->

        <!-- Content Row -->
        <div class="row">
            <div class="col-lg-12">
                <ul id="myTab" class="nav nav-tabs nav-justified">
                    <li class="{{ $tab == 'scheduled' ? 'active' : '' }}">
                        <a href="#scheduled" data-toggle="tab">
                            <i class="fa fa-envelope-open" aria-hidden="true"></i>
                            排程中
                        </a>
                    </li>
                    <li class="{{ $tab == 'draft' ? 'active' : '' }}">
                        <a href="#draft" data-toggle="tab">
                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                            草稿
                        </a>
                    </li>
                    <li class="{{ $tab == 'send' ? 'active' : '' }}">
                        <a href="#send" data-toggle="tab">
                            <i class="fa fa-paper-plane " aria-hidden="true"></i>
                            已發送
                        </a>
                    </li>
                </ul>
                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade {{ $tab == 'scheduled' ? 'active in' : '' }}" id="scheduled">
                        <table class="table table-hover">
                            <caption></caption>
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>主旨</th>
                                    <th>發送方式</th>
                                    <th>發送對象</th>
                                    <th>發送時間</th>
                                    <th class="text-center">功能</th>
                                </tr>
                            </thead>
                            <tbody>
                                @each(
                                    'partials.activity-message-row',
                                    $scheduled_messages,
                                    'message',
                                    'partials.activity-message-empty'
                                )
                            </tbody>
                        </table>
                        <div class="col-md-12 text-center">
                            {!!
                                $scheduled_messages
                                    ->appends($url_query)
                                    ->appends('tab', 'scheduled')
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
                                    <th>主旨</th>
                                    <th>發送方式</th>
                                    <th>發送對象</th>
                                    <th>發送時間</th>
                                    <th class="text-center">功能</th>
                                </tr>
                            </thead>
                            <tbody>
                                @each(
                                    'partials.activity-message-row',
                                    $draft_messages,
                                    'message',
                                    'partials.activity-message-empty'
                                )
                            </tbody>
                        </table>
                        <div class="col-md-12 text-center">
                            {!! 
                                $draft_messages
                                    ->appends($url_query)
                                    ->appends('tab', 'draft')
                                    ->links()
                            !!}
                        </div>
                    </div>
                    <div class="tab-pane fade {{ $tab == 'send' ? 'active in' : '' }}" id="send">
                        <table class="table table-hover">
                            <caption></caption>
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>主旨</th>
                                    <th>發送方式</th>
                                    <th>發送對象</th>
                                    <th>發送時間</th>
                                    <th class="text-center">功能</th>
                                </tr>
                            </thead>
                            <tbody>
                                @each(
                                    'partials.activity-message-row',
                                    $send_messages,
                                    'message',
                                    'partials.activity-message-empty'
                                )
                            </tbody>
                        </table>
                        <div class="col-md-12 text-center">
                            {!!
                                $send_messages
                                    ->appends($url_query)
                                    ->appends('tab', 'send')
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
                        route('organise::activity::message::list', [$activity])
                    }}";
                }
            }
        );
    }

    </script>

@endsection