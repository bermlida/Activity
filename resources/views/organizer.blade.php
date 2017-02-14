
@inject('carbon', 'Carbon\Carbon')

@extends('layouts.main')

@section('content')

    <!-- Page Content -->
    <div class="container">

        <!-- Image Header -->
        <div class="row">
            <br>
            <div class="col-lg-12">
                <img class="img-responsive" src="http://placehold.it/1200x300" alt="">
            </div>
        </div>
        <!-- /.row -->

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header" style="text-align:center;">
                    {{ $organizer->name }}
                </h1>
            </div>
        </div>
        <!-- /.row -->

        <!-- Intro Content -->
        <div class="row">
            <div class="col-lg-12">
                <ul id="myTab" class="nav nav-tabs nav-justified">
                    <li class="active">
                        <a href="#about" data-toggle="tab">
                            <i class="fa fa-tree"></i>
                            關於
                        </a>
                    </li>
                    <li class="">
                        <a href="#contact" data-toggle="tab">
                            <i class="fa fa-support"></i>
                            聯絡方式
                        </a>
                    </li>
                    <li class="">
                        <a href="#traffic" data-toggle="tab">
                            <i class="fa fa-car"></i>
                            交通方式
                        </a>
                    </li>
{{--
                    <li class="">
                        <a href="#service-four" data-toggle="tab">
                            <i class="fa fa-database"></i>
                            Service Four
                        </a>
                    </li>
--}}
                </ul>

                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade active in" id="about">
                        {{ $organizer->intro }}
                    </div>
                    <div class="tab-pane fade" id="contact">
                        <h3>住址：{{ $organizer->address }}</h3>
                        <h3>電話：{{ $organizer->phone }}</h3>
                        @if (!empty($organizer->fax))
                            <h3>傳真：{{ $organizer->fax }}</h3>
                        @endif
                        @if (!empty($organizer->mobile_phone))
                            <h3>手機：{{ $organizer->mobile_phone }}</h3>
                        @endif
                    </div>
                    <div class="tab-pane fade" id="traffic">
                        <iframe src="http://maps.google.com.tw/maps?f=q&hl=zh-TW&geocode=&q={{ $organizer->address }}&output=embed" width="100%" height="300" frameborder="0" style="border:0" allowfullscreen></iframe>
                    </div>
{{--
                    <div class="tab-pane fade" id="service-four">
                        <h4>Service Four</h4>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quae repudiandae fugiat illo cupiditate excepturi esse officiis consectetur, laudantium qui voluptatem. Ad necessitatibus velit, accusantium expedita debitis impedit rerum totam id. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Natus quibusdam recusandae illum, nesciunt, architecto, saepe facere, voluptas eum incidunt dolores magni itaque autem neque velit in. At quia quaerat asperiores.</p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quae repudiandae fugiat illo cupiditate excepturi esse officiis consectetur, laudantium qui voluptatem. Ad necessitatibus velit, accusantium expedita debitis impedit rerum totam id. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Natus quibusdam recusandae illum, nesciunt, architecto, saepe facere, voluptas eum incidunt dolores magni itaque autem neque velit in. At quia quaerat asperiores.</p>
--}}
                    </div>
                </div>

            </div>
        </div>

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