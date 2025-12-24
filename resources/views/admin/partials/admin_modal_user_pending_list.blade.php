{{-- Change To Card like carouselFormContainer adminSetting blade ln-64 js ln-6 --}}

<div class="modal fade" id="pendingUserModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title gabarito-regular">Pending Users</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                {{-- Table pending user --}}
                <table class="table table-hover align-middle">
                    <thead class="table-light pt-sans-bold">
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>No KP</th>
                            <th>Emel</th>
                            <th>Jabatan</th>
                            <th>No Tel</th>
                            <th>Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Ahmad Tyson</td>
                            <td> AMdmad@nfanf.cds</td>
                            <td>09240138523</td>
                            <td>Veterinar</td>   
                            <td>019240903942</td>
                            <td>
                                <button class="btn btn-success btn-sm">Approve</button>
                                <button class="btn btn-danger btn-sm">Suspend</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>