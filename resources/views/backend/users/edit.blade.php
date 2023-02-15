@extends('layouts.app')

@section('content')
<h2 class="card-title d-none">{{ _lang('Edit') }}</h2>
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <form method="post" autocomplete="off" action="{{ route('users.update', $user->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">

                        <div class="col-md-12">
            <div class="form-group">
                <label class="form-control-label">{{ _lang('Name') }}</label>
                <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label class="form-control-label">{{ _lang('Email') }}</label>
                <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label">{{ _lang('Password') }}</label>
                <input type="password" class="form-control" name="password">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label">{{ _lang('Confirm Password') }}</label>
                <input type="password" class="form-control" name="password_confirmation">
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label class="control-label">{{ _lang('Status') }}</label>
                <select class="form-control select2" name="status" data-selected="{{ $user->status }}" required>
                    <option value="1">{{ _lang('Active') }}</option>
                    <option value="0">{{ _lang('In-Active') }}</option>
                </select>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label class="control-label">{{ _lang('Image') }}</label>
                <input type="file" class="form-control dropify" name="image" data-allowed-file-extensions="png jpg jpeg PNG JPG JPEG" data-default-file="{{ asset($user->image) }}">
            </div>
        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <button type="reset" class="btn btn-danger btn-sm">{{ _lang('Reset') }}</button>
                                <button type="submit" class="btn btn-primary btn-sm">{{ _lang('Save') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
