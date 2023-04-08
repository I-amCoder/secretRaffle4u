@php
    $benefit_content = getContent('benefits.content', true);
    $benefit_elements = getContent('benefits.element', false, null, true);
@endphp
<!-- why choose section start -->
<section class="pt-100 pb-100 bg_img dark--overlay-two" style="background-image: url('{{ getImage('assets/images/frontend/benefits/' . @$benefit_content->data_values->background_image, '1920x1080') }}');">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="section-header text-center">
                    <h2 class="section-title">{{ __(@$benefit_content->data_values->heading) }}</h2>
                </div>
            </div>
        </div><!-- row end -->
        <div class="row gy-4 justify-content-center">

            @forelse($benefit_elements as $item)
                <div class="col-xl-4 col-md-6">
                    <div class="icon-card style--two">
                        <div class="icon-card__icon rounded-3">
                            @php echo @$item->data_values->icon @endphp
                        </div>
                        <div class="icon-card__content">
                            <h3 class="icon-card__title mb-2">{{ __(@$item->data_values->title) }}</h3>
                            <p>{{ __(@$item->data_values->content) }}</p>
                        </div>
                    </div><!-- icon-card end -->
                </div>
            @empty
            @endforelse

        </div>
    </div>
</section>
<!-- why choose section end -->
