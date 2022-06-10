<div class="area-profit--list mt-3">
    <div class="form-radius">
        <form action="" method="POST" onsubmit="return SubmitSaveSettingProfit.apply(this)">
            <table class="table table-striped table-mini-size text-center">
                <thead>
                <tr>
                    <th class="border-top-0" scope="col">Name</th>
                    <th class="border-top-0" scope="col">Profit (%)</th>
                    <th class="border-top-0" scope="col">Days</th>
                    <th class="border-top-0" scope="col">Min Amout</th>
                    <th class="border-top-0" scope="col">Max Withdraw (%)</th>
                    <th class="border-top-0" scope="col">Status</th>
                </tr>
                </thead>
                <tbody>
                @foreach(['bronze', 'silver', 'gold', 'platinum'] as $type)
                    @php($setting = $settings['profit']->setting->{$type})
                    <tr>
                        <td>{{ strtoupper($type) }}</td>
                        <td>
                            <input
                                type="text"
                                class="form-control m-auto text-center number-only"
                                style="width: 60px"
                                name="{{ $type . "[profit]" }}"
                                value="{{ $setting->profit }}"
                            />
                        </td>
                        <td>
                            <input
                                type="text"
                                class="form-control m-auto text-center number-only"
                                style="width: 60px"
                                name="{{ $type . "[days]" }}"
                                value="{{ $setting->days }}"
                            />
                        </td>
                        <td>
                            <input
                                type="text"
                                class="form-control m-auto text-center number-only"
                                style="width: 60px"
                                name="{{ $type . "[min_amount]" }}"
                                value="{{ $setting->min_amount }}"
                            />
                        </td>
                        <td>
                            <input
                                type="text"
                                class="form-control m-auto text-center number-only"
                                style="width: 60px"
                                name="{{ $type . "[max_withdraw]" }}"
                                value="{{ $setting->max_withdraw }}"
                            />
                        </td>
                        <td>
                            <select name="{{ $type . "[active]" }}" class="form-control m-auto" style="width: 120px">
                                <option value="0" {{ $setting->active == '0' ? 'selected' : '' }}>Deactive</option>
                                <option value="1" {{ $setting->active == '1' ? 'selected' : '' }}>Active</option>
                            </select>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="text-center">
                <button class="btn btn-success btn-gradient">Save Setting</button>
            </div>
        </form>
    </div>
</div>
<script>
    document.querySelectorAll('.area-profit--list input').forEach(function (input) {
        input.addEventListener('input', function () {
            this.closest('td').classList.remove('error');
        });
    })
    window.SubmitSaveSettingProfit = function () {
        let error = false;
        $(this).find('input').each(function () {
            if (this.value.trim() == '') {
                $(this).closest('td').addClass('error');
                error = true;
            }
        });

        if (error) return false;

        const formData = new FormData(this);
        Request.ajax('{{ route('admin.settings.profit.save') }}', formData, function (result) {
            if (result.success) {
                alertify.success(result.message);
            } else {
                alertify.error(result.message);
            }
        });
        return false;
    }
</script>
