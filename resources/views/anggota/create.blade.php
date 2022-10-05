@extends('layouts.app')

@section('content')

<div class="section-header">
    <h1>{{ $title }}</h1>
</div>

<div class="row">

    <div class="col-12 col-md-12 col-lg-12">
        <div class="card">
            <!-- <div id="headerForm" class="card-header">
                <h4>Create Role</h4>
            </div> -->
            <form id="anggotaForm" name="anggotaForm" method="POST" action="javascript:void(0)">
                <input type="hidden" id="anggota_id" name="anggota_id">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-8">
                            <label>NIK</label>
                            <input type="text" class="form-control" id="nik" name="nik">
                        </div>
                        <div class="form-group col-4">
                            <label>Team Name</label>
                            <select id="team_id" name="team_id" class="form-control select2 select2-hidden-accessible" tabindex="-1" aria-hidden="true">
                                <option disabled selected>--Pilih--</option>
                                @foreach($team as $tm)
                                <option value="{{ $tm->id }}">{{ $tm->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-8">
                            <label>Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" onkeyup="this.value = this.value.toUpperCase()">
                        </div>
                        <div class="form-group col-4">
                            <label>TPS</label>
                            <select id="tps_id" name="tps_id" class="form-control select2 select2-hidden-accessible" tabindex="-1" aria-hidden="true">
                                <option disabled selected>--Pilih--</option>
                                @foreach($tps as $tps)
                                <option value="{{ $tps->id }}">{{ $tps->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <label>Provinsi</label>
                            <select id="provinsi_id" name="provinsi_id" class="form-control select2 select2-hidden-accessible" tabindex="-1" aria-hidden="true">
                                <option selected>--Pilih--</option>
                                @foreach($prov as $pv)
                                <option value="{{ $pv->id }}">{{ $pv->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Kabupaten</label>
                            <select id="kabupaten_id" name="kabupaten_id" class="form-control select2 select2-hidden-accessible" tabindex="-1" aria-hidden="true">

                            </select>
                        </div>
                        <div class="form-group">
                            <label>Kecamatan</label>
                            <select id="kecamatan_id" name="kecamatan_id" class="form-control select2 select2-hidden-accessible" tabindex="-1" aria-hidden="true">

                            </select>
                        </div>
                        <div class="form-group">
                            <label>Desa</label>
                            <select id="desa_id" name="desa_id" class="form-control select2 select2-hidden-accessible" tabindex="-1" aria-hidden="true">
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="custom-switch" style="margin-left: -35px;">
                                <input type="checkbox" name="status" value="2" class="custom-switch-input">
                                <input type="hidden" name="status" value="1" class="custom-switch-input">
                                <span class="custom-switch-indicator"></span>
                                <span class="custom-switch-description">Setuju?</span>
                            </label>
                        </div>
                    </div>
                    <button id="saveBtn" class="btn btn-primary">Create</button>
                </div>
            </form>

        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.validator.setDefaults({
            submitHandler: function(form) {
                $('#saveBtn').html('Sending..');
                $.ajax({
                    url: "{{ route('anggota.create') }}",
                    type: "POST",
                    data: $('#anggotaForm').serialize(),
                    dataType: "json",
                    success: function(response) {
                        console.log(response);
                        console.log(response.success);
                        $('#saveBtn').html('Submit');
                        $('#res_message').html(response.msg);
                        $('#res_message').show();
                        $('#msg_div').removeClass('d-none');

                        document.getElementById("anggotaForm").reset();
                        setTimeout(function() {
                            $('#res_message').hide();
                            $('#msg_div').hide();
                        }, 10000);
                        location.href = "{{ route('anggota.index') }}";
                    }
                });
            }

        });
        $('#anggotaForm').validate({
            rules: {
                team_id: {
                    required: true,
                },
                nik: {
                    required: true,
                    remote: {
                        url: "{{ route('check.nik') }}",
                        type: "post"
                    },
                    digits: true,
                    min: 16,
                },
                nama: {
                    required: true,
                },
                provinsi_id: {
                    required: true,
                },
                kabupaten_id: {
                    required: true,
                },
                kecamatan_id: {
                    required: true,
                },
                desa_id: {
                    required: true,
                },
            },
            messages: {
                team_id: {
                    required: "Harap pilih Team",
                },
                nik: {
                    required: "Harap isi kolom NIK",
                    remote: "NIK sudah terdaftar!",
                    digits: "Harap inputan angka",
                    min: "NIK KTP hanya 16 digit",
                },
                nama: {
                    required: "Harap isi kolom Nama",
                },
                provinsi_id: {
                    required: "Harap pilih Porvinsi",
                },
                kabupaten_id: {
                    required: "Harap pilih Kabupaten",
                },
                kecamatan_id: {
                    required: "Harap pilih Kecamatan",
                },
                desa_id: {
                    required: "Harap piilh Desa",
                },
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });

        $('#provinsi_id').on('change', function() {
            let id_provinsi = $('#provinsi_id').val();

            $.ajax({
                type: 'POST',
                url: "{{ route('kab.create') }}",
                data: {
                    id_provinsi
                },
                cache: false,

                success: function(msg) {
                    $('#kabupaten_id').html(msg);
                },
                error: function(data) {
                    console.log('error: ', data)
                }
            })
        })

        $('#kabupaten_id').on('change', function() {
            let id_kabupaten = $('#kabupaten_id').val();

            $.ajax({
                type: 'POST',
                url: "{{ route('kec.create') }}",
                data: {
                    id_kabupaten
                },
                cache: false,

                success: function(msg) {
                    $('#kecamatan_id').html(msg);
                },
                error: function(data) {
                    console.log('error: ', data)
                }
            })
        })

        $('#kecamatan_id').on('change', function() {
            let id_kecamatan = $('#kecamatan_id').val();

            $.ajax({
                type: 'POST',
                url: "{{ route('desa.create') }}",
                data: {
                    id_kecamatan
                },
                cache: false,

                success: function(msg) {
                    $('#desa_id').html(msg);
                },
                error: function(data) {
                    console.log('error: ', data)
                }
            })
        })
    })
</script>
@endsection