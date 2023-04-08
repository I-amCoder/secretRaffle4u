@extends($activeTemplate.'layouts.frontend')

@section('content')

    @php
        $address_content = getContent('address.content', true);
    @endphp

    <!-- contact section start -->
    <section>
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-6">
                    <div class="map-area">
                        <iframe src = "https://maps.google.com/maps?q={{ @$address_content->data_values->map_latitude }},{{ @$address_content->data_values->map_longitude }}&hl=es;z=14&amp;output=embed"></iframe>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="contact-area">
                        <h2 class="section-title mb-4">@lang('Get in touch').</h2>
                        <div class="row gy-3">
                            <div class="col-xxl-4 col-xl-6 col-md-4 col-sm-6">
                                <div class="contact-card">
                                    <h6 class="mb-2">@lang('Address')</h6>
                                    <p>{{ __(@$address_content->data_values->address) }}</p>
                                </div><!-- contact-card end -->
                            </div>
                            <div class="col-xxl-4 col-xl-6 col-md-4 col-sm-6">
                                <div class="contact-card">
                                    <h6 class="mb-2">Contact</h6>
                                    <p><a href="tel:{{ @$address_content->data_values->phone }}">{{ @$address_content->data_values->phone }}</a></p>
                                    <p><a href="mailto:{{ @$address_content->data_values->email }}">{{ @$address_content->data_values->email }}</a></p>
                                </div><!-- contact-card end -->
                            </div>
                        </div>
                        <h3 class="mt-5 mb-4">@lang('Have a question?')</h3>
                        <form method="post" action="">
                            @csrf

                            <div class="row">
                                <div class="form-group col-sm-6 custom--field">
                                    <input name="name" type="text" placeholder="@lang('Your Name')" autocomplete="off" class="form--control style--two" value="@if(auth()->check()) {{ auth()->user()->fullname }} @else {{ old('name') }} @endif" required @if(auth()->check()) readonly @endif>
                                    <i class="las la-user"></i>
                                </div>
                                <div class="form-group col-sm-6 custom--field">
                                    <input name="email" type="email" autocomplete="off" class="form--control style--two" placeholder="@lang('Enter E-Mail Address')" value="@if(auth()->check()) {{ auth()->user()->email }} @else {{old('email')}} @endif" required @if(auth()->check()) readonly @endif>
                                    <i class="las la-envelope"></i>
                                </div>
                                <div class="form-group col-sm-12 custom--field">
                                    <input name="subject" type="text" placeholder="@lang('Write your subject')" value="{{old('subject')}}" required autocomplete="off" class="form--control style--two">
                                    <i class="las la-pen-alt"></i>
                                </div>
                                <div class="form-group col-lg-12 custom--field">
                                    <textarea name="message" wrap="off" placeholder="@lang('Write your message')" class="form--control style--two" required>{{old('message')}}</textarea>
                                    <i class="las la-comment"></i>
                                </div>
                                <div class="col-lg-12">
                                    <button type="submit" class="btn btn--base btn--custom">@lang('Send Message')</button>
                                </div>
                            </div><!-- row end -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- contact section end -->
@endsection
