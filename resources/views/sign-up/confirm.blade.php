
@inject('carbon', 'Carbon\Carbon')

@extends('layouts.main')

@section('content')

    <!-- Page Content -->
    <div class="container">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-xs-12">
                <h1 class="page-header">
                    活動報名
                    <small>完成及確認</small>
                </h1>
            </div>
        </div>
        <!-- /.row -->

        <div class="row">
            <div class="col-xs-12">
                <div class="panel-group">
                    @include('partials.apply-info-panel')

                    @if (isset($transaction))
                        @include('partials.apply-fee-info-panel')
                    
                        @if (!is_null($transaction->payment_result))
                            @include('partials.payment-result-panel')
                        @elseif (!is_null($transaction->payment_info))
                            @include('partials.payment-info-panel')
                        @endif
                    @endif
                </div>
            </div>
        </div>
        <!-- /.row -->

        <div class="row">
            <div class="col-xs-12">
                <h3>看看現在報名了那些活動</h3>
                <a href="{{ route('participate::record::list') }}" class="btn btn-primary">
                    <i class="glyphicon glyphicon-list-alt" aria-hidden="true"></i>
                    立刻查看
                </a>
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