@extends('layout')
@section("contents")
    <div class="content mt-3">
        <div class="text-right">
            <button class="btn btn-success btn-gradient btn-create-link">Create Link</button>
        </div>
        <div class="area-link form-radius mt-2">
            <table class="table table-responsive-md table-mini-size text-center">
                <thead>
                <tr>
                    <th class="border-top-0" scope="col">No.</th>
                    <th class="border-top-0" scope="col">Link</th>
                    <th class="border-top-0" scope="col">Display</th>
                    <th class="border-top-0" scope="col">Action</th>
                </tr>
                </thead>
                <tbody>
                @php($count = 1)
                @foreach($links->items() as $link)
                    <tr>
                        <td>{{ $count++ }}</td>
                        <td style="max-width: 550px;min-width:250px;word-break: break-word">{{ $link->link }}</td>
                        <td>
                            <select class="form-control status_link m-auto" style="width: 85px;" data-id="{{ $link->id }}">
                                <option value="0" {{ $link->active === 0 ? 'selected' : '' }}>Off</option>
                                <option value="1" {{ $link->active === 1 ? 'selected' : '' }}>On</option>
                            </select>
                        </td>
                        <td>
                            <button class="btn btn-danger btn-gradient btn-delete-link" data-id="{{ $link->id }}">Delete</button>
                        </td>
                    </tr>
                @endforeach
                @if($links->count() <= 0)
                    <tr class="text-center">
                        <td colspan="4">Dont have any data</td>
                    </tr>
                @endif
                </tbody>
            </table>
            {!! $links->links('vendor.pagination.bootstrap') !!}
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
                    <form action="" method="POST" onsubmit="return false">
                        <div class="form-group d-flex align-items-center">
                            <label for="link" class="mr-2">Link:</label>
                            <input type="text" class="form-control" name="link" id="link">
                        </div>
                        <hr>
                        <div class="text-center">
                            <button class="btn btn-success btn-gradient btn-submit-create-link">Create Link</button>
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
        $(".btn-submit-create-link").on('click', function () {
            const $form = $(this).closest('form');
            const formData = new FormData($form[0]);

            Request.ajax('{{ route('admin.link-mission.create') }}', formData, function (result) {
                if (result.success) {
                    alertify.alertSuccess('Success', result.message, () => location.reload());
                } else {
                    alertify.alertDanger("Error", result.message);
                }
            });
        });
        $('.status_link').on('change', function(){
            const id = $(this).attr('data-id');
            const status = $(this).val();
            Request.requestHidden().ajax('{{ route('admin.link-mission.active') }}', { id, status }, function (result) {
                if (!result.success) {
                    alertify.alertDanger("Error", result.message);
                }
            });
        });
        $('.btn-delete-link').on('click', function(){
            if(!confirm('Are you sure delete this link mission?')) {
                return false;
            }
            const id = $(this).attr('data-id');
            Request.ajax('{{ route('admin.link-mission.delete') }}', { id }, function (result) {
                if (result.success) {
                    alertify.alertSuccess('Success', result.message, () => location.reload());
                } else {
                    alertify.alertDanger("Error", result.message);
                }
            });
        });
    </script>
@endsection
