@extends('layout')
@section("contents")
    <div class="content mt-3">
        <div class="text-right">
            <button class="btn btn-success btn-gradient btn-create-link">Create Link</button>
        </div>
        <div class="area-link mt-2">
            <table class="table table-striped" style="background: #fff">
                <thead>
                <tr>
                    <th scope="col">No.</th>
                    <th scope="col">Link</th>
                    <th scope="col">Display</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody>
                {{--@php($count = 1)--}}
                {{--@foreach($histories->items() as $history)--}}
                {{--    <tr>--}}
                {{--        <td>{{ $count++ }}</td>--}}
                {{--        <td>{{ $history->amount }}</td>--}}
                {{--        <td>{{ $history->note }}</td>--}}
                {{--        <td>{{ $history->status }}</td>--}}
                {{--        <td>{{ __d($user->created_at) }}</td>--}}
                {{--    </tr>--}}
                {{--@endforeach--}}
                {{--@if($histories->count() <= 0)--}}
                {{--    <tr>--}}
                {{--        <td colspan="5">No User</td>--}}
                {{--    </tr>--}}
                {{--@endif--}}
                <tr class="text-center">
                    <td colspan="4">Dont have any data</td>
                </tr>
                </tbody>
            </table>
            {{--{!! view('pages.pagination', ['datas' => $histories])->render() !!}--}}
        </div>
    </div>
@endsection
@section('script')
    <div class="modal fade" id="createLink" tabindex="-1" role="dialog" aria-labelledby="createLink" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Create Link Mission</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST">
                        <div class="form-group d-flex align-items-center">
                            <label for="link" class="mr-2">Link:</label>
                            <input type="text" class="form-control" name="link" id="link">
                        </div>
                        <hr>
                        <div class="text-center">
                            <button class="btn btn-success btn-gradient">Create Link</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $('.btn-create-link').on('click', function(){
            const $modal = $('#createLink');
            $modal.modal();
        });
    </script>
@endsection
