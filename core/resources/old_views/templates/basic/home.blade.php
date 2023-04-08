@extends($activeTemplate.'layouts.frontend')

@section('content')
    @php
        $banner = getContent('banner.content',true);
    @endphp

    <section class="hero bg_img" style="background-image: url('{{ getImage('assets/images/frontend/banner/' . @$banner->data_values->image, '1920x961') }}');">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 col-md-6 text-md-start text-center">
                    <div class="hero__top-title text--base">{{ __(@$banner->data_values->title) }}</div>
                    <h2 class="hero__title">{{ __(@$banner->data_values->heading) }}</h2>
                    <a href="{{ @$banner->data_values->button_url }}" class="btn btn-lg btn--base btn--custom mt-4">{{ __(@$banner->data_values->button) }}</a>
                </div>
            </div>
        </div>
    </section>

    @if($sections->secs != null)
        @foreach(json_decode($sections->secs) as $sec)
            @include($activeTemplate.'sections.'.$sec)
        @endforeach
    @endif
@endsection
