@extends('layout')
@section("contents")
    <div class="content mt-3">
        <div class="text-right">
            <button class="btn btn-success btn-gradient btn-create-banner">Create Banner</button>
        </div>
        <div class="area-banner form-radius mt-2">
            <table class="table table-mini-size text-center">
                <thead>
                <tr>
                    <th class="border-top-0" scope="col">No.</th>
                    <th class="border-top-0" scope="col">Device</th>
                    <th class="border-top-0" scope="col">Image</th>
                    <th class="border-top-0" scope="col">Location</th>
                    <th class="border-top-0" scope="col">Display</th>
                    <th class="border-top-0" scope="col">Action</th>
                </tr>
                </thead>
                <tbody>
                @php($count = 1)
                @foreach($banners->items() as $banner)
                    <tr>
                        <td rowspan="2">{{ $count++ }}</td>
                        <td>PC</td>
                        <td>
                            <div class="img-pc m-auto" style="width: 350px">
                                <img src="{{ asset('storage/banner/' . $banner->pc_path) }}" class="w-100">
                            </div>
                        </td>
                        <td rowspan="2">{{ strtoupper($banner->position) }}</td>
                        <td rowspan="2">
                            <select class="form-control status_banner m-auto" style="width: 65px;" data-id="{{ $banner->id }}">
                                <option value="0" {{ $banner->active === 0 ? 'selected' : '' }}>Off</option>
                                <option value="1" {{ $banner->active === 1 ? 'selected' : '' }}>On</option>
                            </select>
                        </td>
                        <td rowspan="2">
                            <button class="btn btn-danger btn-gradient btn-delete-banner" data-id="{{ $banner->id }}">Delete</button>
                        </td>
                    </tr>
                    <tr>
                        <td>Mobile</td>
                        <td>
                            <div class="img-sp m-auto" style="width: 250px">
                                <img src="{{ asset('storage/banner/' . $banner->sp_path) }}" class="w-100">
                            </div>
                        </td>
                    </tr>
                @endforeach
                @if($banners->count() <= 0)
                    <tr class="text-center">
                        <td colspan="5">Dont have any data</td>
                    </tr>
                @endif
                </tbody>
            </table>
            {!! $banners->links('vendor.pagination.bootstrap') !!}
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
                    <form action="" method="POST" onsubmit="return false">
                        <div class="alert alert-warning text-center">If you only upload 1 image, that image will be applied to both PC and Mobile.</div>
                        <div class="row form-group">
                            <div class="col-4">
                                <label>Location</label>
                            </div>
                            <div class="col-8">
                                <select class="form-control" name="location">
                                    <option value="top">Top</option>
                                    <option value="center">Center</option>
                                </select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-4">
                                <label>Image for PC:</label>
                            </div>
                            <div class="col-8">
                                <input type="file" class="form-control" name="img_pc">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-4">
                                <label>Image for Mobile:</label>
                            </div>
                            <div class="col-8">
                                <input type="file" class="form-control" name="img_sp">
                            </div>
                        </div>
                        <hr>
                        <div class="text-center">
                            <button class="btn btn-success btn-gradient btn-submit-create-banner">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $('.btn-create-banner').on('click', function () {
            const $modal = $('#createBanner');
            $modal.modal();
        });
        $(".btn-submit-create-banner").on('click', function () {
            const $form = $(this).closest('form');
            const formData = new FormData($form[0]);

            Request.ajax('{{ route('admin.banner.create') }}', formData, function (result) {
                alert(result.message);
                if (result.success) {
                    location.reload();
                }
            });
        });
        $('.btn-delete-banner').on('click', function(){
            if(!confirm('Are you sure delete this banner?')) {
                return false;
            }
            const id = $(this).attr('data-id');
            Request.ajax('{{ route('admin.banner.delete') }}', { id }, function (result) {
                alert(result.message);
                if (result.success) {
                    location.reload();
                }
            });
        });
        $('.status_banner').on('change', function(){
            const id = $(this).attr('data-id');
            const status = $(this).val();
            Request.requestHidden().ajax('{{ route('admin.banner.active') }}', { id, status }, function (result) {
                if (!result.success) {
                    alert(result.message);
                }
            });
        });
    </script>
@endsection
