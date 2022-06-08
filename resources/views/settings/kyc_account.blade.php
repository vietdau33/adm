<div class="setting--box container">
    <form action="" method="POST" class="d-block w-75 m-auto">
        <div class="form-group">
            <label for="fullname">Fullname</label>
            <input type="text" class="form-control" name="fullname" id="fullname">
        </div>
        <div class="form-group">
            <label for="cccd_id">ID/Passport Number</label>
            <input type="text" class="form-control" name="cccd_id" id="cccd_id">
        </div>
        <div class="text-center">
            <button class="btn btn-primary btn-gradient">Update</button>
        </div>
    </form>
    <form action="" method="POST" class="mt-4">
        <div class="row-upload-image">
            <div class="box-upload">
                <h4>Front ID/Passport Image</h4>
                <img class="w-100" src="{{ asset('image/adm/kyc-front.png') }}" alt="KYC Front">
            </div>
            <div class="box-upload">
                <h4>Backside ID/Passport Image</h4>
                <img class="w-100" src="{{ asset('image/adm/kyc-back.png') }}" alt="KYC Backside">
            </div>
        </div>
        <div class="text-center mt-2">
            <button class="btn btn-primary btn-gradient">Upload</button>
        </div>
    </form>
</div>
