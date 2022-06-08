@extends('layout')
@section("contents")
    <div class="content mt-3">
        <div class="text-right">
            <button class="btn btn-success btn-gradient btn-create-banner">Create Banner</button>
        </div>
        <div class="area-banner mt-2">
            <table class="table table-striped" style="background: #fff">
                <thead>
                <tr>
                    <th scope="col">No.</th>
                    <th scope="col">Image</th>
                    <th scope="col">Location</th>
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
                    <td colspan="6">Dont have any data</td>
                </tr>
                </tbody>
            </table>
            {{--{!! view('pages.pagination', ['datas' => $histories])->render() !!}--}}
        </div>
    </div>
@endsection
@section('script')
    <div class="modal fade" id="createBanner" tabindex="-1" role="dialog" aria-labelledby="createBanner" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Create Banner ADS</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST">
                        <div class="row form-group">
                            <div class="col-4">
                                <label for="location">Location</label>
                            </div>
                            <div class="col-8">
                                <select class="form-control" id="location" name="location">
                                    <option value="top">Top</option>
                                    <option value="center">Center</option>
                                </select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-4">
                                <label for="img_pc">Image for PC:</label>
                            </div>
                            <div class="col-8">
                                <input type="file" class="form-control" name="img_pc" id="img_pc">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-4">
                                <label for="img_sp">Image for Mobile:</label>
                            </div>
                            <div class="col-8">
                                <input type="file" class="form-control" name="img_sp" id="img_sp">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-4">
                                <label for="link">Link:</label>
                            </div>
                            <div class="col-8">
                                <input type="text" class="form-control" name="link" id="link" placeholder="https://example.com/image.png">
                            </div>
                        </div>
                        <hr>
                        <div class="text-center">
                            <button class="btn btn-success btn-gradient">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $('.btn-create-banner').on('click', function(){
            const $modal = $('#createBanner');
            $modal.modal();
        });
    </script>
@endsection
