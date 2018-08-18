
@inject('carbon', 'Carbon\Carbon')

@extends('layouts.main')

@section('content')

    <!-- Page Content -->
    <div class="container">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-xs-12">
                @include('partials.alert-message')

                <h1 class="page-header">掃描報到憑證</h1>
            </div>
        </div>
        <!-- /.row -->

        <!-- Register Certificate Scanner -->
        <div class="row">
            <div class="col-xs-12">
                <div class="panel-group">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">掃描</h4>
                        </div>
                        <div class="panel-body text-center">
                            <video width="100%" height="100%" id="camera" autoplay></video>
                        </div>
                    </div>
                    <!-- /.panel -->
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

@section('script')

<script src="{{ asset('components/qcode-decoder/build/qcode-decoder.min.js') }}"></script>
    
<script>

    var video = document.getElementById('camera');

    QCodeDecoder().decodeFromCamera(video, function(error, result) {
        if (type(result) == 'string') {
            $.ajax({
                url: '{{ url()->current() }}'.replace(/scan/, result + '/use'),
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                done: function (data, textStatus, jqXHR) {
                    if (data.register_status == 1) {
                        window.location.replace('{{ url()->current() }}'.replace(/scan/, result + '/info'));
                    } else {
                        alert('報到失敗，請再掃描一次。');
                    }
                },
                fail: function (jqXHR, textStatus, errorThrown) {
                    alert('無法完成報到，請再掃描一次。');
                }
            });
        } else {
            alert('讀取不到報到憑證，請再掃描一次。');
        }
    });

</script>

@endsection