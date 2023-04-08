@extends($activeTemplate.'layouts.frontend')

@section('content')
    <!-- privacy section start -->
    <section class="pt-100 pb-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="cotent-wrapper">

                        @php echo @$link->data_values->content @endphp

                    </div><!-- cotent-wrapper end -->
                </div>
            </div>
        </div>
    </section>
    <!-- privacy section end -->
@endsection
