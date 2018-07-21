
@extends('layouts.main')

@section('content')

    <div class="container">
        
        <!-- Page Heading -->
        <div class="row">
            <div class="col-xs-12">
                @include('partials.alert-message')

                <h1 class="page-header">收款設定</h1>
            </div>
        </div>
        <!-- /.row -->

        <div class="row">
            <div class="col-sm-12">
                <form class="form-horizontal" role="form" method="POST" action="{{ route('account::receipt-setting::save') }}">
                    {{ csrf_field() }}
                        
                    <div class="form-group{{ $errors->has('financial_institution_code') ? ' has-error' : '' }}">
                        <label for="financial_institution_code" class="col-sm-4 control-label">銀行代號</label>

                        <div class="col-sm-6">
                            <select id="financial_institution_code" class="form-control" name="financial_institution_code">
                                <option value="" disabled>請選擇銀行代號</option>
                                @foreach ($taiwan_bank_codes as $bank_code)
                                    @if (!is_null(old('financial_institution_code')))
                                        <option value="{{ $bank_code['code'] }}" {{ old('financial_institution_code') == $bank_code['code'] ? 'selected' : '' }}">{{ $bank_code['code'] }} {{ $bank_code['name'] }}</option>
                                    @elseif (!is_null($financial_account))
                                        <option value="{{ $bank_code['code'] }}" {{ $financial_account->financial_institution_code == $bank_code['code'] ? 'selected' : '' }}">{{ $bank_code['code'] }} {{ $bank_code['name'] }}</option>
                                    @else
                                        <option value="{{ $bank_code['code'] }}">{{ $bank_code['code'] }} {{ $bank_code['name'] }}</option>
                                    @endif
                                @endforeach
                            </select>

                            @if ($errors->has('financial_institution_code'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('financial_institution_code') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('account_number') ? ' has-error' : '' }}">
                        <label for="account_number" class="col-sm-4 control-label">帳號</label>

                        <div class="col-sm-6">
                            <input id="account_number" class="form-control" name="account_number" value="{{ !is_null(old('account_number')) ? old('account_number') : (!is_null($financial_account) ? $financial_account->account_number : '') }}">

                            @if ($errors->has('account_number'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('account_number') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-xs-6 col-sm-offset-6 col-xs-offset-4">
                            <button type="submit" class="btn btn-primary">
                                <span class="glyphicon glyphicon-check" aria-hidden="true"></span>
                                存檔
                            </button>
                        </div>
                    </div>
                </form>
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

@endsection
