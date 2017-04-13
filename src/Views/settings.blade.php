@php
    $settings = Laralum\Advertisements\Models\Settings::first();
@endphp
<div uk-grid>
    <div class="uk-width-1-1@s uk-width-1-5@l"></div>
    <div class="uk-width-1-1@s uk-width-3-5@l">
        @if (\Laralum\Users\Models\User::findOrFail(Auth::id())->can('update', \Laralum\Advertisements\Models\Settings::class))
            <form class="uk-form-horizontal" method="POST" action="{{ route('laralum::advertisements.settings.update') }}">
                {{ csrf_field() }}
                <fieldset class="uk-fieldset">

                    <div class="uk-margin">
                        <label class="uk-form-label">@lang('laralum_advertisements::general.adb')</label>
                        <div class="uk-form-controls">
                            <label><input id="anti_ad_block" name="anti_ad_block" @if($settings->anti_ad_block) checked @endif class="uk-checkbox" type="checkbox"> @lang('laralum_advertisements::general.enabled')</label><br />
                            <small class="uk-text-meta">@lang('laralum_advertisements::general.adb_desc')</small>
                        </div>
                    </div>

                    <div class="uk-margin">
                        <label class="uk-form-label">@lang('laralum_advertisements::general.adb_method')</label>
                        <div class="uk-form-controls">
                            <select name="anti_ad_block_method" id="anti_ad_block_method" class="uk-select">
                                <option value="" @if(!$settings->anti_ad_block_method) selected @endif disabled>@lang('laralum_advertisements::general.psm')</option>
                                <option @if($settings->anti_ad_block_method == 'alert') selected @endif value="alert">@lang('laralum_advertisements::general.alert')</option>
                                <option @if($settings->anti_ad_block_method == 'redirect') selected @endif value="redirect">@lang('laralum_advertisements::general.redirect')</option>
                            </select>
                            <small class="uk-text-meta">@lang('laralum_advertisements::general.adb_method_desc')</small>
                        </div>
                    </div>

                    <div class="uk-margin">
                        <label id="content-name" class="uk-form-label"></label>
                        <div class="uk-form-controls">
                            <input id="content" value="{{ old('content', $settings->content ? $settings->content : '') }}" name="content" class="uk-input" type="text">
                            <small id="content-desc" class="uk-text-meta"></small>
                        </div>
                    </div>

                    <div class="uk-margin uk-align-right">
                        <button type="submit" class="uk-button uk-button-primary">
                            <span class="ion-forward"></span>&nbsp; @lang('laralum_advertisements::general.save_settings')
                        </button>
                    </div>

                </fieldset>
            </form>
        @else
            <div class="uk-alert-danger uk-text-center" uk-alert>
                <p>
                    @lang('laralum_advertisements::general.not_allowed_settings')
                </p>
            </div>
        @endif
    </div>
    <div class="uk-width-1-1@s uk-width-1-5@l"></div>
</div>

<script>
    $(function() {
        function checkStatus() {
            var method = $('#anti_ad_block_method');
            var content = $('#content');
            if ($('#anti_ad_block').is(":checked")) {
                method.prop( "disabled", false );
                content.prop( "disabled", false );
            } else {
                method.prop( "disabled", true );
                content.prop( "disabled", true );
            }
        }

        function checkContent() {
            var method = $('#anti_ad_block_method');
            var content = $('#content');
            var content_name = $('#content-name');
            var content_desc = $('#content-desc');
            if( method.val() == 'alert' ) {
                content.prop('style', '');
                content.prop('placeholder', "@lang('laralum_advertisements::general.alert_ph')");
                content_name.text("@lang('laralum_advertisements::general.alert_name')");
                content.prop('type', 'text');
                content_desc.text("@lang('laralum_advertisements::general.alert_desc')");
            } else if( method.val() == 'redirect' ) {
                content.prop('style', '');
                content.prop('placeholder', "@lang('laralum_advertisements::general.redirect_ph')");
                content_name.text("@lang('laralum_advertisements::general.redirect_name')");
                content.prop('type', 'url');
                content_desc.text("@lang('laralum_advertisements::general.redirect_desc')");
            } else {
                content.css('display', 'none');
            }
        }

        checkStatus();
        checkContent();

        $('#anti_ad_block').change(function() {
            checkStatus();
        });
        $('#anti_ad_block_method').change(function() {
            checkContent();
        })
    });
</script>
