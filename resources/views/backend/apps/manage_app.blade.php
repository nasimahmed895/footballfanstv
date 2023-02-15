@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12 mb-2 text-right">
            <h4 class="card-title d-none">{{ _lang('Manage App') }}</h4>
        </div>

        <!-- Notification Type  -->
        <div class="col-md-12 mb-3">
            <div class="card">
                <div class="card-body">
                    <form method="POST" autocomplete="off" action="{{ route('store_settings') }}">
                        @csrf
                        @method('POST')
                        <div class="row">

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">{{ _lang('Notification Type') }}</label>
                                    <select class="form-control select2" name="notification_type" required
                                        data-selected="{{ get_option('notification_type', 'onesignal') }}">
                                        <option value="onesignal">{{ _lang('One Signal') }}</option>
                                        <option value="fcm">{{ _lang('FCM') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 onesignal {{ get_option('notification_type') == 'fcm' ? 'd-none' : '' }}">
                                <div class="form-group">
                                    <label class="form-control-label">{{ _lang('One Signal App ID') }}</label>
                                    <input type="text" name="onesignal_app_id" class="form-control"
                                        value="{{ get_option('onesignal_app_id') }}">
                                </div>
                            </div>
                            <div class="col-md-6 onesignal {{ get_option('notification_type') == 'fcm' ? 'd-none' : '' }}">
                                <div class="form-group">
                                    <label class="form-control-label">{{ _lang('One Signal Api Key') }}</label>
                                    <input type="text" name="onesignal_api_key" class="form-control"
                                        value="{{ get_option('onesignal_api_key') }}">
                                </div>
                            </div>
                            <div class="col-md-6 fcm d-none">
                                <div class="form-group">
                                    <label class="form-control-label">{{ _lang('Firebase Server Key') }}</label>
                                    <input type="text" name="firebase_server_key" class="form-control"
                                        value="{{ get_option('firebase_server_key') }}">
                                </div>
                            </div>
                            <div class="col-md-6 fcm d-none">
                                <div class="form-group">
                                    <label class="form-control-label">{{ _lang('Firebase Topics') }}</label>
                                    <input type="text" name="firebase_topics" class="form-control"
                                        value="{{ get_option('firebase_topics') }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group text-right">
                                <button type="submit" class="btn btn-primary btn-sm">
                                    {{ _lang('Update') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="col-md-12">
                        <ul class="nav nav-pills nav-secondary  nav-pills-no-bd nav-pills-icons justify-content-center app-tabs"
                            id="pills-tab-with-icon" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="pills-android-tab-icon" data-toggle="pill"
                                    href="#pills-android-icon" role="tab" aria-controls="pills-android-icon"
                                    aria-selected="true">
                                    <i class="fab fa-android"></i>
                                    Android
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-ios-tab-icon" data-toggle="pill" href="#pills-ios-icon"
                                    role="tab" aria-controls="pills-ios-icon" aria-selected="false">
                                    <i class="fab fa-apple"></i>
                                    IOS
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Android -->
                    <div class="col-md-12">
                        <div class="tab-content mt-2 mb-3" id="pills-with-icon-tabContent">
                            <div class="tab-pane fade show active" id="pills-android-icon" role="tabpanel"
                                aria-labelledby="pills-android-tab-icon">
                                <div class="card">
                                    <div class="card-body">
                                        <h3 class="mb-3 header-title card-title">{{ _lang('General Settings') }}</h3>
                                        <form method="post" class="ajax-submit2 params-card" autocomplete="off"
                                            action="{{ route('store_settings', 'android') }}">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label">{{ _lang('Privacy Policy') }}</label>
                                                        <input type="text" class="form-control"
                                                            name="android_privacy_policy"
                                                            value="{{ get_option('android_privacy_policy') }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label
                                                            class="control-label">{{ _lang('Terms And Condition') }}</label>
                                                        <input type="text" class="form-control"
                                                            name="android_terms_and_condition"
                                                            value="{{ get_option('android_terms_and_condition') }}"
                                                            required>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label">{{ _lang('App Share Link') }}</label>
                                                        <input type="text" class="form-control"
                                                            name="android_app_share_link"
                                                            value="{{ get_option('android_app_share_link') }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label
                                                            class="control-label">{{ _lang('App Default Page') }}</label>
                                                        <select class="form-control select2" name="android_default_page"
                                                            data-selected="{{ get_option('android_default_page', '0') }}"
                                                            required>
                                                            <option value="0">{{ _lang('Live') }}</option>
                                                            <option value="2">{{ _lang('Home') }}</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group text-right">
                                                        <button type="submit" class="btn btn-primary btn-sm">
                                                            {{ _lang('Update') }}
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <h3 class="mb-3 header-title card-title">{{ _lang('Live Control') }}</h3>
                                        <form method="post" class="ajax-submit2 params-card" autocomplete="off"
                                            action="{{ route('store_settings', 'android') }}">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label
                                                            class="control-label">{{ _lang('App Publishing Control') }}</label>
                                                        <select class="form-control select2"
                                                            name="android_app_publishing_control"
                                                            data-selected="{{ get_option('android_app_publishing_control', 'on') }}"
                                                            required>
                                                            <option value="on">{{ _lang('On') }}</option>
                                                            <option value="off">{{ _lang('Off') }}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label
                                                            class="control-label">{{ _lang('Hide Live by Version Code') }}</label>
                                                        <input type="number" class="form-control"
                                                            name="android_live_version_code"
                                                            value="{{ get_option('android_live_version_code', '0') }}"
                                                            min="0" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group text-right">
                                                        <button type="submit" class="btn btn-primary btn-sm">
                                                            {{ _lang('Update') }}
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <h3 class="mb-3 header-title card-title">{{ _lang('Ads Settings') }}</h3>
                                        <form method="post" class="ajax-submit2 params-card my-2" autocomplete="off"
                                            action="{{ route('store_settings', 'android') }}">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label">{{ _lang('Ads Type') }}</label>
                                                        <select class="form-control select2" name="android_ads_type"
                                                            data-selected="{{ get_option('android_ads_type', 'google') }}"
                                                            required>
                                                            <option value="google">{{ _lang('Google') }}</option>
                                                            <option value="startapp">{{ _lang('Startapp') }}</option>
                                                            <option value="facebook">{{ _lang('Facebook') }}</option>
                                                            <option value="adcolony">{{ _lang('AdColony') }}</option>
                                                            <option value="valueimpression">{{ _lang('ValueImpression') }}
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label">{{ _lang('Click Control') }}</label>
                                                        <select class="form-control select2" name="android_click_control"
                                                            data-selected="{{ get_option('android_click_control', 'off') }}"
                                                            required>
                                                            <option value="off">{{ _lang('Off') }}</option>
                                                            @for ($i = 1; $i <= 10; $i++)
                                                                <option value="{{ $i }}">{{ $i }}
                                                                </option>
                                                            @endfor
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group text-right">
                                                        <button type="submit" class="btn btn-primary btn-sm">
                                                            {{ _lang('Update') }}
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        <form method="post" class="ajax-submit2 params-card my-2" autocomplete="off"
                                            action="{{ route('store_settings', 'android') }}">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <h4 class="b">{{ _lang('Google') }}</h4>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label">{{ _lang('Google App Id') }}</label>
                                                        <input type="text" class="form-control" name="android_gapp_id"
                                                            value="{{ get_option('android_gapp_id') }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label
                                                            class="control-label">{{ _lang('Google AppOpen Ads Code') }}</label>
                                                        <input type="text" class="form-control"
                                                            name="android_gappopen_ads_code"
                                                            value="{{ get_option('android_gappopen_ads_code') }}"
                                                            required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label
                                                            class="control-label">{{ _lang('Google Banner Ads Code') }}</label>
                                                        <input type="text" class="form-control"
                                                            name="android_gbanner_ads_code"
                                                            value="{{ get_option('android_gbanner_ads_code') }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label
                                                            class="control-label">{{ _lang('Google Interstitial Ads Code') }}</label>
                                                        <input type="text" class="form-control"
                                                            name="android_ginterstitial_ads_code"
                                                            value="{{ get_option('android_ginterstitial_ads_code') }}"
                                                            required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label
                                                            class="control-label">{{ _lang('Google Native Ads Code') }}</label>
                                                        <input type="text" class="form-control"
                                                            name="android_gnative_ads_code"
                                                            value="{{ get_option('android_gnative_ads_code') }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label
                                                            class="control-label">{{ _lang('Google Rewarded Ads Code') }}</label>
                                                        <input type="text" class="form-control"
                                                            name="android_grewarded_ads_code"
                                                            value="{{ get_option('android_grewarded_ads_code') }}"
                                                            required>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group text-right">
                                                        <button type="submit" class="btn btn-primary btn-sm">
                                                            {{ _lang('Update') }}
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <h3 class="mb-3 header-title card-title">{{ _lang('Version Control') }}</h3>
                                        <form method="post" class="ajax-submit2 params-card" autocomplete="off"
                                            action="{{ route('store_settings', 'android') }}">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label">{{ _lang('Version Name') }}</label>
                                                        <input type="text" class="form-control"
                                                            name="android_version_name"
                                                            value="{{ get_option('android_version_name', '1.0.0') }}"
                                                            required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label">{{ _lang('Version Code') }}</label>
                                                        <input type="number" class="form-control"
                                                            name="android_version_code"
                                                            value="{{ get_option('android_version_code', '1') }}"
                                                            min="0" required>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label">{{ _lang('Force Update') }}</label>
                                                        <select class="form-control select2" name="android_force_update"
                                                            data-selected="{{ get_option('android_force_update', 'no') }}"
                                                            required>
                                                            <option value="no">{{ _lang('NO') }}</option>
                                                            <option value="yes">{{ _lang('Yes') }}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label">{{ _lang('App Url') }}</label>
                                                        <input type="text" class="form-control" name="android_app_url"
                                                            value="{{ get_option('android_app_url') }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label">{{ _lang('Button Text') }}</label>
                                                        <input type="text" class="form-control"
                                                            name="android_button_text"
                                                            value="{{ get_option('android_button_text') }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label">{{ _lang('Description') }}</label>
                                                        <textarea class="form-control" name="android_description">{{ get_option('android_description') }}</textarea>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group text-right">
                                                        <button type="submit" class="btn btn-primary btn-sm">
                                                            {{ _lang('Update') }}
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- IOS -->
                            <div class="tab-pane fade" id="pills-ios-icon" role="tabpanel"
                                aria-labelledby="pills-ios-tab-icon">

                                <div class="card">
                                    <div class="card-body">
                                        <h3 class="mb-3 header-title card-title">{{ _lang('IOS Settings') }}</h3>
                                        <form method="post" class="ajax-submit2 params-card" autocomplete="off"
                                            action="{{ route('store_settings', 'ios') }}">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label">{{ _lang('Privacy Policy') }}</label>
                                                        <input type="text" class="form-control"
                                                            name="ios_privacy_policy"
                                                            value="{{ get_option('ios_privacy_policy') }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label
                                                            class="control-label">{{ _lang('Terms And Condition') }}</label>
                                                        <input type="text" class="form-control"
                                                            name="ios_terms_and_condition"
                                                            value="{{ get_option('ios_terms_and_condition') }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label">{{ _lang('App Share Link') }}</label>
                                                        <input type="text" class="form-control"
                                                            name="ios_app_share_link"
                                                            value="{{ get_option('ios_app_share_link') }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label
                                                            class="control-label">{{ _lang('App Rating Link') }}</label>
                                                        <input type="text" class="form-control"
                                                            name="ios_app_rating_link"
                                                            value="{{ get_option('ios_app_rating_link') }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label
                                                            class="control-label">{{ _lang('App Default Page') }}</label>
                                                        <select class="form-control select2" name="ios_default_page"
                                                            data-selected="{{ get_option('ios_default_page', '0') }}"
                                                            required>
                                                            <option value="0">{{ _lang('Live') }}</option>
                                                            <option value="2">{{ _lang('Home') }}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group text-right">
                                                        <button type="submit" class="btn btn-primary btn-sm">
                                                            {{ _lang('Update') }}
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-body">
                                        <h3 class="mb-3 header-title card-title">{{ _lang('Live Control') }}</h3>
                                        <form method="post" class="ajax-submit2 params-card" autocomplete="off"
                                            action="{{ route('store_settings', 'ios') }}">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label
                                                            class="control-label">{{ _lang('App Publishing Control') }}</label>
                                                        <select class="form-control select2"
                                                            name="ios_app_publishing_control"
                                                            data-selected="{{ get_option('ios_app_publishing_control') }}"
                                                            required>
                                                            <option value="on">{{ _lang('On') }}</option>
                                                            <option value="off">{{ _lang('Off') }}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label
                                                            class="control-label">{{ _lang('Hide Live by Version Code') }}</label>
                                                        <input type="number" class="form-control"
                                                            name="ios_live_version_code"
                                                            value="{{ get_option('ios_live_version_code') }}"
                                                            min="0" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group text-right">
                                                        <button type="submit" class="btn btn-primary btn-sm">
                                                            {{ _lang('Update') }}
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-body">
                                        <h3 class="mb-3 header-title card-title">{{ _lang('Ads Settings') }}</h3>
                                        <form method="post" class="ajax-submit2 params-card" autocomplete="off"
                                            action="{{ route('store_settings', 'ios') }}">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label">{{ _lang('Ads Type') }}</label>
                                                        <select class="form-control select2" name="ios_ads_type"
                                                            data-selected="{{ get_option('ios_ads_type', 'google') }}"
                                                            required>
                                                            <option value="google">{{ _lang('Google') }}</option>
                                                            <option value="startapp">{{ _lang('Startapp') }}</option>
                                                            <option value="facebook">{{ _lang('Facebook') }}</option>
                                                            <option value="adcolony">{{ _lang('AdColony') }}</option>
                                                            <option value="valueimpression">
                                                                {{ _lang('ValueImpression') }}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label">{{ _lang('Click Control') }}</label>
                                                        <select class="form-control select2" name="ios_click_control"
                                                            data-selected="{{ get_option('ios_click_control', 'off') }}"
                                                            required>
                                                            <option value="off">{{ _lang('Off') }}</option>
                                                            @for ($i = 1; $i <= 10; $i++)
                                                                <option value="{{ $i }}">{{ $i }}
                                                                </option>
                                                            @endfor
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group text-right">
                                                        <button type="submit" class="btn btn-primary btn-sm">
                                                            {{ _lang('Update') }}
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        <form method="post" class="ajax-submit2 params-card my-2" autocomplete="off"
                                            action="{{ route('store_settings', 'ios') }}">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <h4 class="b">{{ _lang('Google') }}</h4>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label">{{ _lang('Google App Id') }}</label>
                                                        <input type="text" class="form-control" name="ios_gapp_id"
                                                            value="{{ get_option('ios_gapp_id') }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label
                                                            class="control-label">{{ _lang('Google AppOpen Ads Code') }}</label>
                                                        <input type="text" class="form-control"
                                                            name="ios_gappopen_ads_code"
                                                            value="{{ get_option('ios_gappopen_ads_code') }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label
                                                            class="control-label">{{ _lang('Google Banner Ads Code') }}</label>
                                                        <input type="text" class="form-control"
                                                            name="ios_gbanner_ads_code"
                                                            value="{{ get_option('ios_gbanner_ads_code') }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label
                                                            class="control-label">{{ _lang('Google Interstitial Ads Code') }}</label>
                                                        <input type="text" class="form-control"
                                                            name="ios_ginterstitial_ads_code"
                                                            value="{{ get_option('ios_ginterstitial_ads_code') }}"
                                                            required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label
                                                            class="control-label">{{ _lang('Google Native Ads Code') }}</label>
                                                        <input type="text" class="form-control"
                                                            name="ios_gnative_ads_code"
                                                            value="{{ get_option('ios_gnative_ads_code') }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label
                                                            class="control-label">{{ _lang('Google Rewarded Ads Code') }}</label>
                                                        <input type="text" class="form-control"
                                                            name="ios_grewarded_ads_code"
                                                            value="{{ get_option('ios_grewarded_ads_code') }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group text-right">
                                                        <button type="submit" class="btn btn-primary btn-sm">
                                                            {{ _lang('Update') }}
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-body">
                                        <h3 class="mb-3 header-title card-title">{{ _lang('Version Control') }}</h3>
                                        <form method="post" class="ajax-submit2 params-card" autocomplete="off"
                                            action="{{ route('store_settings', 'ios') }}">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label">{{ _lang('Version Name') }}</label>
                                                        <input type="text" class="form-control"
                                                            name="ios_version_name"
                                                            value="{{ get_option('ios_version_name', '1.0.0') }}"
                                                            required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label">{{ _lang('Version Code') }}</label>
                                                        <input type="number" class="form-control"
                                                            name="ios_version_code"
                                                            value="{{ get_option('ios_version_code', '1') }}"
                                                            min="0" required>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label">{{ _lang('Force Update') }}</label>
                                                        <select class="form-control select2" name="ios_force_update"
                                                            data-selected="{{ get_option('ios_force_update', 'no') }}"
                                                            required>
                                                            <option value="no">{{ _lang('NO') }}</option>
                                                            <option value="yes">{{ _lang('Yes') }}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label">{{ _lang('App Url') }}</label>
                                                        <input type="text" class="form-control" name="ios_app_url"
                                                            value="{{ get_option('ios_app_url') }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label">{{ _lang('Button Text') }}</label>
                                                        <input type="text" class="form-control" name="ios_button_text"
                                                            value="{{ get_option('ios_button_text') }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label">{{ _lang('Description') }}</label>
                                                        <textarea class="form-control" name="ios_description">{{ get_option('ios_description') }}</textarea>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group text-right">
                                                        <button type="submit" class="btn btn-primary btn-sm">
                                                            {{ _lang('Update') }}
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('js-script')
    <script>
        @if (get_option('notification_type') === 'fcm')
            $('.fcm').removeClass('d-none').find('input').prop('required', true);
        @else
            $('.onesignal').removeClass('d-none').find('input').prop('required', true);
        @endif

        $('select[name=notification_type]').on('change', function() {
            if ($(this).val() == 'onesignal') {
                $('.onesignal').removeClass('d-none').find('input').prop('required', true);
                $('.fcm').addClass('d-none').find('input').prop('required', false);
            } else {
                $('.fcm').removeClass('d-none').find('input').prop('required', true);
                $('.onesignal').addClass('d-none').find('input').prop('required', false);
            }
        });
        $('[name=app_name]').on('keyup', function() {
            $('[name=firebase_topics]').val($(this).val().replace(/\s/g, ''));
        });
    </script>
@endsection
