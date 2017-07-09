
@inject('carbon', 'Carbon\Carbon')

@extends('layouts.main')

@section('content')

    <!-- Page Content -->
    <div class="container">

        <!-- Feature Section -->
        <div class="row">
            <div class="col-lg-12">
                <h2 class="page-header">
                    活動報名
                </h2>
            </div>
            <div class="col-md-12">
                <div class="panel-group">
                    @include('partials.apply-info-panel')
                    
                    @if (!is_null($transaction))
                        @include('partials.apply-fee-info-panel')

                        @if (!is_null($transaction->payment_result))
                            @include('partials.payment-result-panel')
                        @elseif (!is_null($transaction->payment_info))
                            @include('partials.payment-info-panel')
                        @endif
                    @endif
                </div>
                <!-- /.panel-group -->
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
