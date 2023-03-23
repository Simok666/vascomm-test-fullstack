<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard for admin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="container-xl">
                        <div class="table-responsive">
                            <div class="table-wrapper">
                                <div class="table-title">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <h2>Manajemen <b>Customer</b></h2>
                                        </div>
                                    </div>
                                </div>
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>No </th>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Image Profile</th>
                                            <th>Tangal Dibuat</th>
                                            <th>Tanggal Dirubah</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="showData">
                                        @if(count($data) > 0)
                                            <?php $no=1; ?>
                                            @foreach($data as $value)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td>{{ $value->name }}</td>
                                                <td>{{ $value->email }}</td>
                                                <td><img src="{{url('/imageRegisters/'.$value->profile_image)}}" width="50" height="50" alt="" title="" /></td>
                                                <td>{{ $value->created_at }}</td>
                                                <td>{{ $value->updated_at }}</td>
                                                <td><a href="#editEmployeeModal" data-toggle="modal" onClick="ShowEdit({{$value}})" class="edit"><i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a></td>
                                            </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="6" class="text-center">Data tidak ada...</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                
                            </div>
                        </div>
                    </div>
                    <!-- Edit Modal HTML -->
                    <!-- Edit Modal HTML -->
                    <div id="editEmployeeModal" class="modal fade">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form id="FormEdit">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Edit Customer</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Approval Customer</label>
                                            <select id="approval" name="is_approval" class="form-select" aria-label="Default select example">
                                                <option selected>Open this select menu</option>
                                                <option value="1">Yes</option>
                                                <option value="0">No</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                
                                        <button type="button" class="btn btn-danger" id="BtnEdit">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>

    function ShowEdit(data) {
        $("#approval").val(data.is_approval);
        $('#BtnEdit').attr('onclick', "EditData('" + data.id + "')");
    } 

    function EditData(id) {

        var data = $("#FormEdit").serialize();

        $.ajax({
            type: 'POST',
            url: '/user/update/' + id,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: data,
            success: function(data) {
                if (data.status == true) {
                    Swal.fire("data berhasil di update").then(function(){
                        location.reload();
                    });
                } else {
                    Swal.fire(data.info).then(function(){
                        location.reload();
                    });
                }

            },
            error: function() {
                Swal.fire("error").then(function(){
                        location.reload();
                });
            }
        });
    }
    </script>
</x-app-layout>
