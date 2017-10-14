
@inject('carbon', 'Carbon\Carbon')

@extends('layouts.main')

@section('content')

    <!-- Page Content -->
    <div class="container">

        <!-- Page Heading/Breadcrumbs -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    活動管理
                    <small></small>
                </h1>
{{-- 
                <ol class="breadcrumb">
                    <li><a href="index.html">我所舉辦的活動</a></li>
                    <li class="active">活動管理</li>
                </ol>
 --}}
            </div>
        </div>
        <!-- /.row -->

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-9">
                <!-- First Blog Post -->
                <a href="blog-post.html">
                    <img class="img-responsive img-hover" src="http://placehold.it/900x300" alt="">
                </a>
            </div>

            <!-- Blog Sidebar Widgets Column -->
            <div class="col-md-3">
                <!-- Side Widget Well -->
                <div class="well">
                    <h4>活動名稱</h4>
                    <p>時間</p>
                    <p>地點</p>
                </div>
            </div>
        </div>
        <!-- /.row -->

        <hr>

        <div class="row">
            <div class="col-md-3 col-xs-6">
                <div class="panel panel-default text-center">
                    <div class="panel-heading">
                        <h4>報名</h4>
                    </div>
                    <div class="panel-body">
                        <a class="btn btn-primary btn-lg btn-block" href="">
                            <i class="fa fa-calendar-plus-o" aria-hidden="true"></i>
                            掃描報到憑證
                        </a>
                        <hr>
                        <a class="btn btn-primary btn-lg btn-block" href="">
                            <i class="fa fa-calendar-plus-o" aria-hidden="true"></i>
                            報名清單
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-xs-6">
                <div class="panel panel-default text-center">
                    <div class="panel-heading">
                        <h4>互動</h4>
                    </div>
                    <div class="panel-body">
                        <a class="btn btn-primary btn-lg btn-block" href="">
                            <i class="fa fa-calendar-plus-o" aria-hidden="true"></i>
                            直播設定
                        </a>
                        <hr>
                        <a class="btn btn-primary btn-lg btn-block" href="">
                            <i class="fa fa-calendar-plus-o" aria-hidden="true"></i>
                            推送設定
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-xs-6">
                <div class="panel panel-default text-center">
                    <div class="panel-heading">
                        <h4>收退款</h4>
                    </div>
                    <div class="panel-body">
                        <a class="btn btn-primary btn-lg btn-block" href="">
                            <i class="fa fa-calendar-plus-o" aria-hidden="true"></i>
                            收款狀態
                        </a>
                        <hr>
                        <a class="btn btn-primary btn-lg btn-block" href="">
                            <i class="fa fa-calendar-plus-o" aria-hidden="true"></i>
                            退款清單
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-xs-6">
                <div class="panel panel-default text-center">
                    <div class="panel-heading">
                        <h4>紀錄</h4>
                    </div>
                    <div class="panel-body">
                        <a class="btn btn-primary btn-lg btn-block" href="">
                            <i class="fa fa-calendar-plus-o" aria-hidden="true"></i>
                            日誌管理
                        </a>
                        <hr>
                        <a class="btn btn-primary btn-lg btn-block" href="">
                            <i class="fa fa-calendar-plus-o" aria-hidden="true"></i>
                            影音管理
                        </a>
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
