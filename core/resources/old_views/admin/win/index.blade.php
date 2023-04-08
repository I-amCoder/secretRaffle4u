@extends('admin.layouts.app')

@section('panel')
<div class="row">

    <div class="col-lg-12">
        <div class="card b-radius--10">
              <div class="card-body p-0">
                  <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                            <tr>
                                <th scope="col">@lang('Game Name')</th>
                                <th scope="col">@lang('Draw Date')</th>
                                <th scope="col">@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody class="list">
                            @forelse($phases as $phase)
                            <tr>
                                <td data-label="Game Name">{{ $phase->game->name }}</td>
                                <td data-label="Draw Date">{{ $phase->end_date }}</td>
                                <td data-label="Action"><a href="{{ route('admin.win.makeWinner',$phase->id) }}" class="icon-btn btn--primary"><i class="la la-trophy"></i></a></td>
                            </tr>
                            @empty
                            <tr>
                                <td class="text-muted text-center" colspan="100%">{{ $empty_message }}</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <nav aria-label="...">
                    {{ $phases->links('admin.partials.paginate') }}
                </nav>
            </div>
        </div>
    </div>
</div>
@endsection
@push('script')
