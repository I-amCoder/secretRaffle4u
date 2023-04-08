@php
    $faq_content = getContent('faq.content',true);
    if (request()->route()->getName() == 'home'){
        $faq_elements = getContent('faq.element', false, 5, true);
    } else {
        $faq_elements = getContent('faq.element', false, null, true);
    }
@endphp

<!-- faq section start -->
<section class="pt-100 pb-100 section--bg">
    <div class="container">
        <div class="row align-items-center justify-content-between">
            <div class="col-lg-7">
                <h2 class="section-title mb-4">{{ __(@$faq_content->data_values->heading) }}</h2>
                <div class="accordion custom--accordion" id="faqAccordion">

                    @forelse($faq_elements as $item)
                        <div class="accordion-item">
                            <div class="accordion-header" id="h-{{ $loop->iteration }}">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#c-{{ $loop->iteration }}" aria-expanded="false" aria-controls="c-{{ $loop->iteration }}">
                                    {{ __(@$item->data_values->question) }}
                                </button>
                            </div>
                            <div id="c-{{ $loop->iteration }}" class="accordion-collapse collapse" aria-labelledby="h-{{ $loop->iteration }}" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <p>{{ __(@$item->data_values->answer) }}</p>
                                </div>
                            </div>
                        </div><!-- accordion-item-->
                    @empty
                    @endforelse

                </div>
            </div>
            <div class="col-lg-4 d-lg-block d-none">
                <div class="faq-thumb">
                    <img src="{{ getImage('assets/images/frontend/faq/' . @$faq_content->data_values->image, '992x944') }}" alt="image">
                </div>
            </div>
        </div>
    </div>
</section>
<!-- faq section end -->
