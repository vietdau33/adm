<div class="modal fade" id="changeIBModal" tabindex="-1" role="dialog" aria-labelledby="changeIBModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="area-content">
                    <div class="content-header">
                        <h3>Change IB</h3>
                    </div>
                    <hr>
                    <div class="content-body">
                        <form action="{{ route('user.change-ib.post') }}" method="POST" onsubmit="return false">
                            <input type="hidden" name="username">
                            <input type="hidden" name="tree">
                            <div class="form-group">
                                <input type="text" class="form-control" name="new_ib" id="new_ib" placeholder="Enter New IB">
                            </div>
                            <div class="form-group mb-0 text-center">
                                <button class="btn btn-primary" onclick="Home.changeIB(this)">Change</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
