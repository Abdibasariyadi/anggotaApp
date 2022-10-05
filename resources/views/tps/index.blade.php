@extends('layouts.app')

@section('content')

<div class="section-header">
    <h1>{{ $title }}</h1>
</div>

<div class="row">
    <div class="col-8">
        <div class="card">
            <div class="card-header">
                <h4>Data TPS</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-bordered data-table table-sm table-hover">
                                <thead>

                                    <tr role="row">
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-4 col-lg-4">
        <div class="card">
            <div id="headerForm" class="card-header">
                <h4>Create TPS</h4>
            </div>
            <form id="tpsForm" name="tpsForm" method="POST">
                <input type="hidden" id="tps_id" name="tps_id">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" class="form-control" id="name" name="name" onkeyup="this.value = this.value.toUpperCase()">
                    </div>
                    <button id="saveBtn" class="btn btn-primary">Create</button>
                </div>
            </form>

        </div>
    </div>
</div>

<script type="text/javascript">
    $(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('tps.index') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        })

        $('#saveBtn').click(function(e) {
            e.preventDefault();
            $(this).html('Save');

            $.ajax({
                data: $('#tpsForm').serialize(),
                url: "{{ route('tps.create') }}",
                type: "POST",
                dataType: 'json',
                success: function(data) {
                    $("#tpsForm").trigger("reset");
                    // $('#roleModal').modal('hide');
                    table.draw();
                },
                error: function(data) {
                    console.log('Error:', data);
                    $('#saveBtn').html('Save')
                }
            })
        })



        $('body').on('click', '.editTps', function() {
            var tpsId = $(this).data('id');
            $.get("{{ route('tps.index') }}" + "/" + tpsId + "/edit", function(data) {
                $('#headerForm').html("<h4>Edit TPS</h4>");
                // $('#roleModal').modal('show');
                // $(".modal-backdrop").hide();
                $("#tps_id").val(data.id);
                $('#name').val(data.name);
            })
        })


        $('body').on('click', '.deleteTps', function() {
            var tpsId = $(this).data('id');
            confirm("Are you sure want to delete!");
            var url = "tps" + '/' + tpsId + '/delete';
            $.ajax({
                type: "DELETE",
                url,
                success: function(data) {
                    table.draw();
                },
                error: function(data) {
                    console.log('Error: ', data);
                }
            })
        })
    })
</script>
@endsection