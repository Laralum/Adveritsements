
<div class="uk-container uk-container-large">
    <div uk-grid>
        <div class="uk-width-1-1@s uk-width-1-5@l uk-width-1-3@xl"></div>
        <div class="uk-width-1-1@s uk-width-3-5@l uk-width-1-3@xl">
            <div class="uk-card uk-card-default">
                <div class="uk-card-header">
                    {{ $title }}
                </div>
                <div class="uk-card-body">
                    <form class="uk-form-stacked" method="POST" action="{{ $action }}">
                        {{ csrf_field() }}
                        @if(isset($method)) {{ method_field($method) }} @endif
                        <fieldset class="uk-fieldset">


                            <div class="uk-margin">
                                <label class="uk-form-label">@lang('laralum_advertisements::general.name')</label>
                                <div class="uk-form-controls">
                                    <input value="{{ old('name', isset($ad) ? $ad->name : '') }}" name="name" class="uk-input" type="text" placeholder="@lang('laralum_advertisements::general.name')">
                                </div>
                            </div>

                            <div class="uk-margin">
                                <label class="uk-form-label">@lang('laralum_advertisements::general.slug')</label>
                                <div class="uk-form-controls">
                                    <input value="{{ old('slug', isset($ad) ? $ad->slug : '') }}" name="slug" class="uk-input" type="text" placeholder="@lang('laralum_advertisements::general.slug')">
                                </div>
                            </div>

                            <div class="uk-margin">
                                <label class="uk-form-label">@lang('laralum_advertisements::general.advertisement_code')</label>
                                <div class="uk-form-controls">
                                    <textarea name="code" class="uk-textarea" rows="5" placeholder="@lang('laralum_advertisements::general.advertisement_code')">{{ old('code', isset($ad) ? $ad->code : '') }}</textarea>
                                </div>
                            </div>

                            <div class="uk-margin">
                                <button type="submit" class="uk-button uk-button-primary">
                                    <span class="ion-forward"></span>&nbsp; {{ $button }}
                                </button>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
        <div class="uk-width-1-1@s uk-width-1-5@l uk-width-1-3@xl"></div>
    </div>
</div>
