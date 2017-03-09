
@inject('carbon', 'Carbon\Carbon')

@extends('layouts.main')

@section('content')

    <!-- Page Content -->
    <div class="container">

        <!-- Page Heading/Breadcrumbs -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">參加的活動
                    <small></small>
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
                        <th>No.</th>
                        <th>活動名稱</th>
                        <th>活動時間起迄</th>
                        <th>活動地點</th>
                        <th>狀態</th>
                        <th>報名資訊</th>
                        <th>取消報名</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($activities as $key => $activity)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $activity->name }}</td>
                            <td>
                                @if ($carbon->parse($activity->start_time)->toDateString() != $carbon->parse($activity->end_time)->toDateString())
                                    {{ $carbon->parse($activity->start_time)->toDateString() }}
                                     ~ 
                                    {{ $carbon->parse($activity->end_time)->toDateString() }}
                                @else
                                    {{ $carbon->parse($activity->start_time)->toDateString() }}
                                @endif
                            </td>
                            <td>{{ $activity->venue }}</td>
                            <td>
                                @if ($activity->pivot->status == '0')
                                    報名未完成
                                @elseif ($activity->pivot->status == '1')
                                    已完成報名
                                @endif
                            </td>
                            <td>
                                <button type="button" class="btn btn-info" onclick="window.location.href='{{ url('/participate/activities/' . $activity->id) }}'">
                                    檢視
                                </button>
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger" onclick="window.location.href='{{ url('/participate/activities/' . $activity->id . '/cancel') }}'">
                                    取消
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td>
                                目前你還沒有參加任何活動，不如就此開始吧 ! 
                                <br><br><br>
                                <a href="{{ url('/activities') }}">
                                    開始找活動
                                </a>
                            </td>
                        </tr>
                    @endforelse
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