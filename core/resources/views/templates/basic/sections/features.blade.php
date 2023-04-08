@php
    $features_content = getContent('features.content', true);
    $features_elements = getContent('features.element', false, null, true);
@endphp

<!-- feature section start -->
<section class="pt-100 pb-100 section--bg border-top border-bottom">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="section-header text-center">
                    <h2 class="section-title">{{ __(@$features_content->data_values->heading) }}</h2>
                </div>
            </div>
        </div><!-- row end -->
        <div class="row gy-4 justify-content-center">

            @forelse($features_elements as $item)
                <div class="col-lg-4 col-md-6">
                    <div class="icon-card">
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
<!-- feature section end -->
