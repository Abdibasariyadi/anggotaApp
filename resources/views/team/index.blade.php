@extends('layouts.app')

@section('content')

<div class="section-header">
    <h1>{{ $title }}</h1>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>Data Anggota</h4>
            </div>
            <div class="col-6">
                <a class="btn btn-outline-primary" href="{{ route('team.create') }}" style="margin-left: 12px;">Create Team</a>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <div class="row">
                        <!-- MULAI DATE RANGE PICKER -->

                        <!-- <div class="form-group col-md-3">
                            <label for="kategori">Start</label>
                            <input type="text" name="min" id="min" class="form-control dataPicker" />
                        </div>
                        <div class="form-group col-md-3">
                            <label for="kategori">End</label>
                            <input type="text" name="max" id="max" class="form-control dataPicker" />
                        </div> -->
                        <div class="form-group col-3">
                            <label>Team Name</label>
                            <select id="team_id" name="team_id" class="form-control select2 select2-hidden-accessible" tabindex="-1" aria-hidden="true">
                                <option selected value="all">--All Team--</option>
                                @foreach($team as $tm)
                                <option value="{{ $tm->id }}">{{ $tm->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-3">
                            <label>Kelurahan/ Desa</label>
                            <select id="kelurahan" name="kelurahan" class="form-control select2 select2-hidden-accessible" tabindex="-1" aria-hidden="true">
                                <option selected value="all">--All Kelurahan--</option>
                                @foreach($kel as $kl)
                                <option value="{{ $kl->id }}">{{ $kl->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-3" style="top: 30px;">
                            <button type="button" name="filter" id="filter" class="btn btn-outline-primary">Filter</button>
                            <button type="button" name="refresh" id="refresh" class="btn btn-outline-warning">Refresh</button>
                        </div>
                        <!-- AKHIR DATE RANGE PICKER -->
                        <div class="col-sm-12">
                            <table class="table table-bordered data-table table-sm table-hover">
                                <thead>

                                    <tr role="row">
                                        <th>#</th>
                                        <th>Team</th>
                                        <th>NIK</th>
                                        <th>Nama Lengkap</th>
                                        <th>Provinsi</th>
                                        <th>Kota/Kabupaten</th>
                                        <th>Kecamatan</th>
                                        <th>Desa</th>
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
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('team.index') }}",
            dom: 'Bfrtip',
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'team_id',
                    name: 'team_id'
                },
                {
                    data: 'nik',
                    name: 'nik'
                },
                {
                    data: 'nama',
                    name: 'nama'
                },
                {
                    data: 'provinsi_id',
                    name: 'provinsi_id'
                },
                {
                    data: 'kabupaten_id',
                    name: 'kabupaten_id'
                },
                {
                    data: 'kecamatan_id',
                    name: 'kecamatan_id'
                },
                {
                    data: 'desa_id',
                    name: 'desa_id'
                },
                {
                    data: 'created_at',
                    name: 'created_at',
                    render: function(data, type, row) { //data
                        return moment(row.created_at).format('DD/MM/YYYY hh:mm:ss');
                    }
                },
                {

                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        })


        $('#refresh').click(function() {
            // $('#min').val('');
            // $('#max').val('');
            $('#kelurahan').val('');
            $('#team_id').val('');
            $('.data-table').DataTable().destroy();
            table.draw();
        });

        $('body').on('click', '.deleteAnggota', function() {
            var id = $(this).data('id');
            confirm("Are you sure want to delete!");
            var url = "team" + '/' + id + '/delete';
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

    $(".dataPicker").datepicker({
        dateFormat: 'dd-mm-yy',
        changeMonth: true,
        changeYear: true
    });

    $("#filter").click(function() {
        // var min = $("#min").val()
        // var max = $("#max").val()
        var kelurahan = $("#kelurahan").val()
        var team_id = $("#team_id").val()
        console.log('Team: ', team_id)
        console.log('Kel: ', kelurahan)
        $('.data-table').DataTable({
            "processing": true,
            "serverSide": true,
            'destroy': true,
            ajax: {
                url: "{{ url('team/filter') }}",
                data: function(d) {
                    // d.min = $('#min').val();
                    // d.max = $('#max').val();
                    d.kelurahan = $('#kelurahan').val();
                    d.team_id = $('#team_id').val();
                }
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'team_id',
                    name: 'team_id'
                },
                {
                    data: 'nik',
                    name: 'nik'
                },
                {
                    data: 'nama',
                    name: 'nama'
                },
                {
                    data: 'provinsi_id',
                    name: 'provinsi_id'
                },
                {
                    data: 'kabupaten_id',
                    name: 'kabupaten_id'
                },
                {
                    data: 'kecamatan_id',
                    name: 'kecamatan_id'
                },
                {
                    data: 'desa_id',
                    name: 'desa_id'
                },
                {
                    data: 'created_at',
                    name: 'created_at',
                    render: function(data, type, row) { //data
                        return moment(row.created_at).format('DD/MM/YYYY hh:mm:ss');
                    }
                },
                {

                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });
    });
</script>
@endsection