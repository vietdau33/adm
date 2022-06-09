<div class="setting--box container">
    @if(empty(user()->google2fa_secret))
        <div class="area-info-active-2fa text-center" style="display: block">
            <p class="mb-0">Two-Factor Authentication</p>
            <p class="mb-0">Google Authenticator is a third-party app provided by Google Inc.</p>
            <p>to provide you an extra layer of safety for your assets during transactions.</p>
            <div class="mt-3">
                <button class="btn btn-success btn-gradient btn-active-2fa">Active</button>
            </div>
        </div>
        <div class="area-detail-active-2fa" style="display: none">
            <p class="mb-0">Two-factor authentication increases the security of your account. All you need is a compatible app on your smartphone. for example:</p>
            <ul class="pl-4">
                <li>Google Authenticator</li>
                <li>Authy</li>
            </ul>
            <div class="img-qr-auth-2fa text-center">
                <div></div>
            </div>
            <form action="" method="POST" onsubmit="return false">
                <p class="text-center mb-0 mt-3">Or enter this secret key into your device:</p>
                <div class="input-canable-copy group-deposit-text">
                    <input type="text" class="form-control" name="serect" value="" readonly>
                    <button data-text="" onclick="Home.copyTextRaw(this, () => alertify.success('Copy Success'))">
                        <img src="{{ asset('image/adm/icon/copy-icon.png') }}" alt="Copy" class="w-100">
                    </button>
                </div>
                <div class="form-group mt-3 text-center">
                    <label for="code_2fa">Type the code created by the authentication app.</label>
                    <input type="text" id="code_2fa" name="code" class="form-control text-center number-only" placeholder="Enter code">
                </div>
                <div class="text-center">
                    <button class="btn btn-primary btn-gradient btn-enable-2fa">Enable</button>
                </div>
            </form>
        </div>
    @else
        <div class="area-info-active-2fa text-center" style="display: block">
            <p class="mb-0">Two-Factor Authentication <span class="text-success">Enabled</span></p>
            <p class="mb-0">Google Authenticator is a third-party app provided by Google Inc.</p>
            <p>to provide you an extra layer of safety for your assets during transactions.</p>
            <div class="mt-3">
                <button class="btn btn-danger btn-gradient btn-deactive-2fa">Deactive</button>
            </div>
        </div>
    @endif
</div>

<script>
    window.addEventListener('DOMContentLoaded', (event) => {
        $('.btn-active-2fa').on('click', function(){
            const areaInfo = $('.area-info-active-2fa');
            const areaDetail = $('.area-detail-active-2fa');
            Request.ajax('{{ route('generate-gg-auth') }}', function(result){
                if(result.success == false) {
                    return alert(result.message);
                }
                areaDetail.find('[name="serect"]')
                    .val(result.serect)
                    .next('button')
                    .attr('data-text', result.serect);
                areaDetail.find('.img-qr-auth-2fa div').html(result.image);
                areaInfo.hide(200);
                areaDetail.show(200);
            });
        });
        $('.btn-enable-2fa').on('click', function(){
            const form = this.closest('form');
            const formData = new FormData(form);
            Request.ajax('{{ route('enable-gg-auth') }}', formData, function (result) {
                alert(result.message);
                if(result.success) {
                    location.reload();
                }
            });
        });
        $('.btn-deactive-2fa').on('click', function(){
            if(!confirm('Are you sure deactive 2FA ?')) {
                return false;
            }
            Request.ajax('{{ route('deactive-gg-auth') }}', function (result) {
                alert(result.message);
                if(result.success) {
                    location.reload();
                }
            });
        });
    });
</script>
