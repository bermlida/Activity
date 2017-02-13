
@extends('layouts.main')

@section('content')

    <!-- Page Content -->
    <div class="container">

        <!-- Page Heading/Breadcrumbs -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">舉辦的活動
                    <small></small>
                    <button type="button" class="btn btn-default" aria-label="Left Align" onclick="window.location.href='{{ url('/account/organise/activity')}}'">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        新增活動
                    </button>
                </h1>
            </div>
        </div>
        <!-- /.row -->

        <!-- Content Row -->
        <div class="row">
            <table class="table table-hover">
                <caption></caption>
                <thead>
                    <tr>
                        <th>名称</th>
                        <th>城市</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Tanmay</td>
                        <td>Bangalore</td>
                    </tr>
                    <tr>
                        <td>Sachin</td>
                        <td>Mumbai</td>
                    </tr>
                </tbody>
            </table>
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