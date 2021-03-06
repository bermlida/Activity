         
    <div class="form-group{{ $errors->has('financial_institution_code') ? ' has-error' : '' }}">
        <label for="financial_institution_code" class="col-sm-3 control-label">銀行代號</label>

        <div class="col-sm-8">
            <select id="financial_institution_code" class="form-control" name="financial_institution_code">
                @if (!is_null(old('financial_institution_code')) || isset($financial_account))
                    <option value="" disabled>請選擇銀行代號</option>
                @else
                    <option value="" disabled selected>請選擇銀行代號</option>
                @endif
                @foreach ($taiwan_bank_codes as $bank_code)
                    <option value="{{ $bank_code['code'] }}" {{ old('financial_institution_code', ($financial_account->financial_institution_code ?? '')) == $bank_code['code'] ? 'selected' : '' }}">{{ $bank_code['code'] }} {{ $bank_code['name'] }}</option>
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
        <label for="account_number" class="col-sm-3 control-label">帳號</label>

        <div class="col-sm-8">
            <input id="account_number" class="form-control" name="account_number" value="{{ old('account_number', ($financial_account->account_number ?? '')) }}">
            
            @if ($errors->has('account_number'))
                <span class="help-block">
                    <strong>{{ $errors->first('account_number') }}</strong>
                </span>
            @endif
        </div>
    </div>
