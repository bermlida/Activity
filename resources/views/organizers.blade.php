
@extends('layouts.main')

@section('content')

    <!-- Page Content -->
    <div class="container">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-xs-12">
                <h1 class="page-header">找主辦單位</h1>
            </div>
        </div>
        <!-- /.row -->

        <!-- Organizers -->
        <div class="row">
            @forelse ($organizers as $organizer)
                <div class="col-md-6 img-portfolio">
                    <a href="{{ route('visit::organizer', [$organizer]) }}">
                        @php
                            $banner = $organizer->attachments->first(function ($key, $value) {
                                return $value->category == 'banner';
                            });

                            $banner_path = !is_null($banner)
                                ? asset('storage/banners/' . $banner->name)
                                : 'http://placehold.it/750x450';
                        @endphp
                        <img class="img-responsive img-hover" src="{{ $banner_path }}" alt="{{ $organizer->name }}">
                    </a>
                    <h3>
                        <a href="{{ route('visit::organizer', [$organizer]) }}">
                            {{ $organizer->name }}
                        </a>
                    </h3>
                    <p>
                        市話：
                        <a href="tel:{{ $organizer->phone }}">
                            {{ $organizer->phone }}
                        </a>
                    </p>
                    <p>
                        手機：
                        <a href="tel:{{ $organizer->mobile_phone }}">
                            {{ $organizer->mobile_phone }}
                        </a>
                    </p>
                    <p>
                        電子郵件：
                        <a href="mailto:{{ $organizer->account->email }}">
                            {{ $organizer->account->email }}
                        </a>
                    </p>
                    <p>
                        住址：
                        <a href="http://maps.google.com.tw/maps?f=q&hl=zh-TW&geocode=&q={{ $organizer->address }}" target="view_window">
                            {{ $organizer->address }}
                        </a>
                    </p>
                </div>
            @empty
                <div class="col-xs-12 text-center">
                    <h2>目前無主辦單位可供查詢</h2>
                </div>
            @endforelse
        </div>
        <!-- /.row -->

        <hr>

        <!-- Pagination -->
        <div class="row text-center">
            <div class="col-xs-12">
                {!! $organizers->links() !!}
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
