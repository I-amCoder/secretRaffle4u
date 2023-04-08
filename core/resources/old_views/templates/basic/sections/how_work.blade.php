@php
    $how_works = getContent('how_work.element', false, null, true);
@endphp

<!-- how work section start -->
<section class="work-section">
    <div class="container">
        <div class="row gy-4 justify-content-center">

            @forelse($how_works as $item)
                <div class="col-md-4 col-sm-6 work-item">
                    <div class="work-card">
                        <h2 class="work-card__number">{{ $loop->iteration }}</h2>
                        <div class="work-card__content">
                            <h4 class="work-card__title">{{ __(@$item->data_values->title) }}</h4>
                            <p>{{ __(@$item->data_values->content) }}</p>
                        </div>
                    </div><!-- work-card end -->
                </div>
            @empty
            @endforelse

        </div>
    </div>
</section>
<!-- how work section end -->
