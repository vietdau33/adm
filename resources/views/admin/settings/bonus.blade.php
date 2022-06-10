@php($setting = $settings['bonus']->setting)
<div class="area-bonus--list mt-3">
    <div class="form-radius">
        <form action="" method="POST" onsubmit="return SubmitSaveSettingBonus.apply(this)">
            <table class="table table-striped table-mini-size text-center">
                <thead>
                <tr>
                    <th class="border-top-0" scope="col">Name</th>
                    <th class="border-top-0" scope="col">Bonus (%)</th>
                    <th class="border-top-0" scope="col">Condition F1</th>
                </tr>
                </thead>
                <tbody>
                @for($i = 1; $i <= 5; $i++)
                    <tr>
                        <td>Level {{ $i }}</td>
                        <td>
                            <input
                                type="text"
                                class="form-control m-auto text-center number-only"
                                style="width: 60px"
                                name="{{ "level_{$i}[bonus]" }}"
                                value="{{ $setting->{"level_$i"}->bonus }}"
                            />
                        </td>
                        <td>
                            <input
                                type="text"
                                class="form-control m-auto text-center number-only"
                                style="width: 60px"
                                name="{{ "level_{$i}[condition_f1]" }}"
                                value="{{ $setting->{"level_$i"}->condition_f1 }}"
                            />
                        </td>
                    </tr>
                @endfor
                </tbody>
            </table>
            <div class="form-group d-flex align-items-center flex-wrap">
                <p class="mb-0 mr-2">The condition for receiving the bonus of the upline is that the downline must enter the minimum package:</p>
                <input
                    type="text"
                    class="form-control number-only"
                    name="minimum_to_bonus"
                    value="{{ $setting->minimum_to_bonus }}"
                    style="width: 80px"
                />
            </div>
            <div class="text-center">
                <button class="btn btn-success btn-gradient">Update</button>
            </div>
        </form>
    </div>
</div>
<script>
    document.querySelectorAll('.area-bonus--list input').forEach(function (input) {
        input.addEventListener('input', function () {
            const td = this.closest('td');
            if(td instanceof HTMLElement) {
                td.classList.remove('error');
            }else{
                this.classList.remove('error');
            }
        });
    });
    window.SubmitSaveSettingBonus = function () {
        let error = false;
        $(this).find('input').each(function () {
            if (this.value.trim() == '') {
                const td = $(this).closest('td');
                if(td.length > 0) {
                    td.addClass('error');
                }else{
                    $(this).addClass('error');
                }
                error = true;
            }
        });

        if (error) return false;

        const formData = new FormData(this);
        Request.ajax('{{ route('admin.settings.bonus.save') }}', formData, function (result) {
            if (result.success) {
                alertify.success(result.message);
            } else {
                alertify.error(result.message);
            }
        });
        return false;
    }
</script>
