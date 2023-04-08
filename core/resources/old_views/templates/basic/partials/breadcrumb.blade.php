@php
    $breadcrumb_content = getContent('breadcrumb.content', true);
@endphp
<!-- inner hero start -->
<section class="inner-hero bg_img overlay--one" style="background-image: url('{{ getImage('assets/images/frontend/breadcrumb/' . @$breadcrumb_content->data_values->background_image, '1920x961') }}');">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 text-center">
                <h2 class="page-title text-white">@lang($pageTitle)</h2>
                <ul class="page-breadcrumb justify-content-center">
                    <li><a href="{{ route('home') }}">@lang('Home')</a></li>
                    <li>@lang($pageTitle)</li>
                </ul>
            </div>
        </div>
    </div>
</section>
<!-- inner hero end -->
