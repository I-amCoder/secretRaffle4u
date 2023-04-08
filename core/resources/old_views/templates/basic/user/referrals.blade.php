@extends($activeTemplate .'layouts.master')
@section('content')

    <section class="pt-100 pb-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" class="form--control" id="referralURL" value="{{ route('home', ['reference' => auth()->user()->username]) }}" readonly>
                            <span class="input-group-text copytext">@lang('Copy')</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">

                    <div class="table-responsive--md">
                        <table class="table custom--table">
                            <thead>
                            <tr>
                                <th scope="col">@lang('Username')</th>
                                <th scope="col">@lang('Email')</th>
                                <th scope="col">@lang('Balance')</th>
                            </tr>
                            </thead>
                            <tbody class="list">
                            @forelse($refs as $log)
                                <tr>
                                    <td data-label="@lang('Username')">{{ __($log->username) }}</td>
                                    <td data-label="@lang('Email')">{{ $log->email }}</td>
                                    <td data-label="@lang('Balance')">{{ $log->balance + 0 }} {{ __($general->cur_sym) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center" colspan="100%">{{ __($empty_message) }}</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{ $refs->links() }}
                </div>
            </div>
        </div>
    </section>
@endsection

@push('style')
    <style>
        .copytext{
            cursor: pointer;
        }
    </style>
@endpush

@push('script')
    <script>
        (function($){
            "use strict";

            $('.copytext').on('click',function(){
                var copyText = document.getElementById("referralURL");
                copyText.select();
                copyText.setSelectionRange(0, 99999);
                document.execCommand("copy");
                iziToast.success({message: "Copied: " + copyText.value, position: "topRight"});
            });
        })(jQuery);
    </script>
@endpush
