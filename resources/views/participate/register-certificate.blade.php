
@inject('carbon', 'Carbon\Carbon')

@extends('layouts.main')

@section('content')

    <!-- Page Content -->
    <div class="container">

        <!-- Feature Section -->
        <div class="row">
            <div class="col-lg-12">
                <h2 class="page-header">
                    報到憑證
                </h2>
            </div>
            <div class="col-md-12">
                <div class="panel-group">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">報到憑證</h4>
                        </div>
                        <div class="panel-body text-center">
                            @if ($order->register_status != 1)
                                <img src="{{ $qr_code }}">
                            @else
                                報到已完成
                            @endif
                        </div>
                    </div>
                    <!-- /.register-certificate-panel -->

                    @include('partials.apply-info-panel')
                    
                    @if (!is_null($transaction))
                        @include('partials.apply-fee-info-panel')
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
